<?php
session_start();
include "connect.php";

if (isset($_POST['submitReport'])) 
{
   $category = $_POST['category'];
    $userid = $_POST['UserID'];
    $sellerid = $_POST['Seller_ID'];
    $description = $_POST['description'];


    $date = date("Y-m-d");

    
    $stmt = $conn->prepare("INSERT INTO queries (SellerID, UserID, Reason, UserDescription, isResolved, dateCreated) VALUES (?, ?, ?, ?, 0, ?)");

    if ($stmt) {
        $stmt->bind_param("iisss", $sellerid, $userid, $category, $description, $date);
        if ($stmt->execute()) {
           header("Location: treasure hub seller display page.php?log=review");
        } else {
            echo "Failed to submit report: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Statement preparation failed: " . $conn->error;
    }
}

if (isset($_POST['foodsubmitReport'])) 
{
   $category = $_POST['category'];
    $userid = $_POST['UserID'];
    $sellerid = $_POST['Seller_ID'];
    $description = $_POST['description'];


    $date = date("Y-m-d");

    
    $stmt = $conn->prepare("INSERT INTO queries (SellerID, UserID, Reason, UserDescription, isResolved, dateCreated) VALUES (?, ?, ?, ?, 0, ?)");

    if ($stmt) {
        $stmt->bind_param("iisss", $sellerid, $userid, $category, $description, $date);
        if ($stmt->execute()) {
           header("Location: treasure hub seller display page.php?log=review");
        } else {
            echo "Failed to submit report: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Statement preparation failed: " . $conn->error;
    }
}
?>