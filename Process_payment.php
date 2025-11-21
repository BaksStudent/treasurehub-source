<?php
session_start();
include "connect.php";

// Sanitize inputs
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$card = preg_replace('/\D/', '', $_POST['card'] ?? ''); // Strip non-digits
$expiry = $_POST['expiry'] ?? '';
$cvv = preg_replace('/\D/', '', $_POST['cvv'] ?? '');


$addressId = $_POST['address_id'] ?? null;

// Helper: Validate using Luhn Algorithm
function isValidCardNumber($number) {
    $sum = 0;
    $numDigits = strlen($number);
    $parity = $numDigits % 2;

    for ($i = 0; $i < $numDigits; $i++) {
        $digit = $number[$i];
        if ($i % 2 == $parity) {
            $digit *= 2;
            if ($digit > 9) $digit -= 9;
        }
        $sum += $digit;
    }

    return ($sum % 10) === 0;
}

// Helper: Validate expiry
function isValidExpiry($expiry) {
    if (!preg_match('/^(0[1-9]|1[0-2])\/?([0-9]{2})$/', $expiry, $matches)) {
        return false;
    }
    $month = (int)$matches[1];
    $year = (int)("20" . $matches[2]);
    $now = new DateTime();
    $expiryDate = DateTime::createFromFormat('Y-m', "$year-$month");
    return $expiryDate >= $now;
}

if (!$addressId) {
    header("Location: checkout.php?error=missing_address");
    exit();
}

// Main validation
if (
    $name &&
    strlen($cvv) === 3 &&
    strlen($card) >= 13 && strlen($card) <= 19 &&
    isValidCardNumber($card) &&
    isValidExpiry($expiry)
) 
{
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        // Get user info
        $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $userResult = $stmt->get_result();

        if ($userResult && $userResult->num_rows > 0) {
            $user = $userResult->fetch_assoc();
            $userID = $user['UserID'];
            $date = date("Y-m-d");

            // Get cart items and total
            $totalPrice = 0;
            $cartItems = [];
            $cartStmt = $conn->prepare("
                SELECT c.ProductID, c.Quantity, p.Price 
                FROM cart c 
                JOIN product p ON c.ProductID = p.ProductID 
                WHERE c.UserID = ?");
            $cartStmt->bind_param("i", $userID);
            $cartStmt->execute();
            $cartResult = $cartStmt->get_result();

            while ($item = $cartResult->fetch_assoc()) {
                $totalPrice += $item['Quantity'] * $item['Price'];
                $cartItems[] = $item;
            }

            // Insert order
            $insertOrder = $conn->prepare("INSERT INTO orders (UserID, OrderDate, TotalAmount, AddressID, OrderStatus) VALUES (?, ?, ?, ?,'Pending')");
            $insertOrder->bind_param("isdi", $userID, $date, $totalPrice, $addressId );
            if ($insertOrder->execute()) {
                $orderID = $conn->insert_id;

                
                foreach ($cartItems as $item) {
                    $insertDetails = $conn->prepare("INSERT INTO order_details (OrderID, ProductID, Quantity, Price) VALUES (?, ?, ?, ?)");
                    $insertDetails->bind_param("iiid", $orderID, $item['ProductID'], $item['Quantity'], $item['Price']);
                    if (!$insertDetails->execute()) {
                        echo "Failed to insert order detail.";
                        exit();
                    }
                }

                
                foreach ($cartItems as $item) {
                    $productID = $item['ProductID'];
                    $orderedQty = $item['Quantity'];

                    $qtyStmt = $conn->prepare("SELECT Quantity FROM product WHERE ProductID = ?");
                    $qtyStmt->bind_param("i", $productID);
                    $qtyStmt->execute();
                    $qtyResult = $qtyStmt->get_result();

                    if ($qtyResult && $qtyRow = $qtyResult->fetch_assoc()) {
                        $newQty = $qtyRow['Quantity'] - $orderedQty;

                        if ($newQty < 0) {
                            echo "Not enough stock for product ID $productID.";
                            exit();
                        }

                    
                        $updateQty = $conn->prepare("UPDATE product SET Quantity = ? WHERE ProductID = ?");
                        $updateQty->bind_param("ii", $newQty, $productID);
                        $updateQty->execute();

        
                        if ($newQty <= 0) {
                            $markSold = $conn->prepare("UPDATE product SET isSold = 1 WHERE ProductID = ?");
                            $markSold->bind_param("i", $productID);
                            $markSold->execute();
                        }
                    }
                }

                $clearCart = $conn->prepare("DELETE FROM cart WHERE UserID = ?");
                $clearCart->bind_param("i", $userID);
                $clearCart->execute();

                header("Location: order_list.php");
                exit();
            } else {
                echo "Failed to create order.";
                exit();
            }
        } else {
            header("Location: payment_failed.php");
            exit();
        }
    } else {
        header("Location: payment_failed.php");
        exit();
    }
} else {
    header("Location: payment_failed.php");
    exit();
}
?>