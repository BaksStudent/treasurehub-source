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
                SELECT c.ProductID, c.Quantity, p.Price ,c.SpecialNotes
                FROM foodcart c 
                JOIN foodproduct p ON c.ProductID = p.ProductID 
                WHERE c.UserID = ?");
            $cartStmt->bind_param("i", $userID);
            $cartStmt->execute();
            $cartResult = $cartStmt->get_result();

            while ($item = $cartResult->fetch_assoc()) {
                $totalPrice += $item['Quantity'] * $item['Price'];
                $cartItems[] = $item;
            }

            // Insert order
            $currentTime = time();
            $timeNowFormatted = date("Y-m-d H:i:s", $currentTime);
            $insertOrder = $conn->prepare("INSERT INTO foodorders (UserID, OrderDate, TotalAmount, AddressID, OrderTime, OrderStatus) VALUES (?, ?, ?, ?,?,'Pending')");
            $insertOrder->bind_param("isdis", $userID, $date, $totalPrice, $addressId,$timeNowFormatted );
            if ($insertOrder->execute()) {
                $orderID = $conn->insert_id;

                
                foreach ($cartItems as $item) 
                {
                    $insertDetails = $conn->prepare("INSERT INTO foodorder_details (OrderID, ProductID, Quantity, Price, SpecialNotes) VALUES (?, ?, ?, ?,?)");
                    $insertDetails->bind_param("iiids", $orderID, $item['ProductID'], $item['Quantity'], $item['Price'], $item['SpecialNotes']);
                    if (!$insertDetails->execute()) {
                        echo "Failed to insert order detail.";
                        exit();
                    }
                }

                $clearCart = $conn->prepare("DELETE FROM foodcart WHERE UserID = ?");
                $clearCart->bind_param("i", $userID);
                $clearCart->execute();

                header("Location: foodsorder_list.php");
                exit();
            } else {
                echo "Failed to create order.";
                exit();
            }
        } else {
            header("Location: payment_failed.php?div=foods");
            exit();
        }
    } else {
        header("Location: payment_failed.php?div=foods");
        exit();
    }
} else {
    header("Location: payment_failed.php?div=foods");
    exit();
}
?>