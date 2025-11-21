<?php
session_start();
include "connect.php";

if (!isset($_SESSION['email'])) {
    echo "You must be logged in to update the cart.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);
    $email = $_SESSION['email'];

    
    $userQuery = mysqli_query($conn, "SELECT UserID FROM user WHERE Email = '$email'");
    if ($userQuery && mysqli_num_rows($userQuery) > 0) {
        $user = mysqli_fetch_assoc($userQuery);
        $userId = $user['UserID'];

        $deleteQuery = "DELETE FROM foodcart WHERE UserID = '$userId' AND ProductID = '$productId'";
        if (mysqli_query($conn, $deleteQuery)) {
            // Redirect back to the cart page
            header("Location: treasure hub foods cart section.php");
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