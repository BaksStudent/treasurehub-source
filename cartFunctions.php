<?php
session_start();
include "connect.php";

if (!isset($_SESSION['email'])) {
    echo "You must be logged in to update the cart.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = intval($_POST['product_id']);
    $newQuantity = intval($_POST['quantity']);

    if ($newQuantity < 1) {
        echo "Quantity must be at least 1.";
        exit();
    }

    $email = $_SESSION['email'];

    $userQuery = mysqli_query($conn, "SELECT UserID FROM user WHERE Email = '$email'");
    if ($userQuery && mysqli_num_rows($userQuery) > 0) {
        $user = mysqli_fetch_assoc($userQuery);
        $userId = $user['UserID'];

        
        $productQuery = mysqli_query($conn, "SELECT Quantity FROM product WHERE ProductID = '$productId'");
        if ($productQuery && mysqli_num_rows($productQuery) > 0) {
            $product = mysqli_fetch_assoc($productQuery);
            $maxStock = intval($product['Quantity']);

            if ($newQuantity <= $maxStock) {
                
                $updateQuery = "UPDATE cart SET Quantity = '$newQuantity' WHERE UserID = '$userId' AND ProductID = '$productId'";
                if (mysqli_query($conn, $updateQuery)) {
                    echo "Cart updated successfully.";
                    header("Location: treasure hub cart section.php"); 
                    exit();
                } else {
                    echo "Error updating cart: " . mysqli_error($conn);
                }
            } else {
                echo "Cannot add more than available stock: $maxStock.";
            }
        } else {
            echo "Product not found.";
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid request.";
}




if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);
    $email = $_SESSION['email'];

    // Get user ID
    $userQuery = mysqli_query($conn, "SELECT UserID FROM user WHERE Email = '$email'");
    if ($userQuery && mysqli_num_rows($userQuery) > 0) {
        $user = mysqli_fetch_assoc($userQuery);
        $userId = $user['UserID'];

        // Delete product from cart
        $deleteQuery = "DELETE FROM cart WHERE UserID = '$userId' AND ProductID = '$productId'";
        if (mysqli_query($conn, $deleteQuery)) {
            // Redirect back to the cart page
            header("Location: treasure hub cart section.php");
            exit();
        } else {
            echo "Error deleting item from cart: " . mysqli_error($conn);
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid request.";
}

?>