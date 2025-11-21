<?php
session_start();
include 'connect.php';

if (isset($_POST['resetbuyer']))
{
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
        exit;
    }

    if (strlen($newPassword) < 6) {
        echo "<script>alert('Password should be at least 6 characters.'); window.history.back();</script>";
        exit;
    }

    $hashedPassword = md5($newPassword);
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $update = mysqli_query($conn, "UPDATE user SET Password = '$hashedPassword' WHERE Email = '$email'");
        
        if ($update) {
            echo "<script>alert('Password reset successful.'); window.location.href = 'treasure_hub_signup_or_login.php?log=pass';</script>";
        } else {
            echo "<script>alert('Failed to reset password. Try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Session expired. Please log in again.'); window.location.href = 'treasure_hub_signup_or_login.php?log=pass';</script>";
    }
}

if (isset($_POST['resetseller']))
{
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
        exit;
    }

    if (strlen($newPassword) < 6) {
        echo "<script>alert('Password should be at least 6 characters.'); window.history.back();</script>";
        exit;
    }

    $hashedPassword = md5($newPassword);
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $update = mysqli_query($conn, "UPDATE seller SET Password = '$hashedPassword' WHERE Email = '$email'");
        
        if ($update) {
            echo "<script>alert('Password reset successful.'); window.location.href = 'treasure_hub_signup_or_login.php?log=pass';</script>";
        } else {
            echo "<script>alert('Failed to reset password. Try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Session expired. Please log in again.'); window.location.href = 'treasure_hub_signup_or_login.php?log=pass';</script>";
    }
}

if (isset($_POST['resetAdmin']))
{
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
        exit;
    }

    if (strlen($newPassword) < 6) {
        echo "<script>alert('Password should be at least 6 characters.'); window.history.back();</script>";
        exit;
    }

    $hashedPassword = md5($newPassword);
    if (isset($_SESSION['adminEmail'])) {
        $email = $_SESSION['adminEmail'];
        $update = mysqli_query($conn, "UPDATE `admin` SET Password = '$hashedPassword' WHERE Email = '$email'");
        
        if ($update) {
            echo "<script>alert('Password reset successful.'); window.location.href = 'treasure_hub_signup_or_login.php?log=pass';</script>";
        } else {
            echo "<script>alert('Failed to reset password. Try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Session expired. Please log in again.'); window.location.href = 'treasure_hub_signup_or_login.php?log=pass';</script>";
    }
}