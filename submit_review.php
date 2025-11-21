<?php
session_start();
include "connect.php";

if (isset($_POST['Submit-Review'])) 
{
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $sellerid = $_POST['seller_id'];
    $product_id = $_POST['product_id'];
    $date = date("Y-m-d");

    if(isset($_SESSION['email']))
    {
        $email = $_SESSION['email'];
        $query = mysqli_query($conn, "SELECT user.* FROM user WHERE user.Email ='$email'");
        while($row = mysqli_fetch_array($query))
        {
            $userID = $row['UserID'];
        }
    }
    $stmt = $conn->prepare("INSERT INTO review (UserID, ProductID, SellerID, rating, comment, reviewDate) VALUES (?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("iiiiss", $userID,$product_id,$sellerid,$rating,$comment,$date);
        if ($stmt->execute()) {
           header("Location: Treasure hub product page.php?log=reported");
        } else {
            echo "Failed to submit report: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Statement preparation failed: " . $conn->error;
    }
}

?>