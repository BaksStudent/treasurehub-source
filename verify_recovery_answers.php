<?php
session_start();
include 'connect.php';

if (isset($_POST['verifybuyer']))
{
    $userID = $_POST['getID'];
    $answer1 = md5(trim($_POST['answer1']));
    $answer2 = md5(trim($_POST['answer2']));

    $query = mysqli_query($conn, "SELECT * FROM verify_user WHERE UserID = '$userID'");

    if ($row = mysqli_fetch_assoc($query)) {
        if ($row['Answer1'] === $answer1 && $row['Answer2'] === $answer2) {
            // Correct answers
            echo "<script>alert('Verification successful. Redirecting to reset password...');</script>";
            echo "<meta http-equiv='refresh' content='2; url=reset_password.php'>";
        } else {
            // Incorrect
            echo "<script>alert('One or both answers are incorrect. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "User recovery questions not found.";
    }
}
if (isset($_POST['verifyseller']))
{
    $sellerID = $_POST['getID'];
    $answer1 = md5(trim($_POST['answer1']));
    $answer2 = md5(trim($_POST['answer2']));

    $query = mysqli_query($conn, "SELECT * FROM verify_seller WHERE SellerID  = '$sellerID'");

    if ($row = mysqli_fetch_assoc($query)) {
        if ($row['Answer1'] === $answer1 && $row['Answer2'] === $answer2) {
            // Correct answers
            echo "<script>alert('Verification successful. Redirecting to reset password...');</script>";
            echo "<meta http-equiv='refresh' content='2; url=reset_password.php'>";
        } else {
            // Incorrect
            echo "<script>alert('One or both answers are incorrect. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "User recovery questions not found.";
    }
}
if (isset($_POST['verifyadmin']))
{
    $adminID = $_POST['getID'];
    $answer1 = md5(trim($_POST['answer1']));
    $answer2 = md5(trim($_POST['answer2']));

    $query = mysqli_query($conn, "SELECT * FROM verify_admin WHERE AdminID ='$adminID'");

    if ($row = mysqli_fetch_assoc($query)) {
        if ($row['Answer1'] === $answer1 && $row['Answer2'] === $answer2) {
            // Correct answers
            echo "<script>alert('Verification successful. Redirecting to reset password...');</script>";
            echo "<meta http-equiv='refresh' content='2; url=reset_password.php'>";
        } else {
            // Incorrect
            echo "<script>alert('One or both answers are incorrect. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "User recovery questions not found.";
    }
}
