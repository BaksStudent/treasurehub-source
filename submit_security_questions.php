<?php
    session_start();
    include 'connect.php';

    if (isset($_POST['saveBuyer']))
    {
        $q1 = mysqli_real_escape_string($conn, $_POST['question1']);
        $a1 = mysqli_real_escape_string($conn, $_POST['answer1']);
        $q2 = mysqli_real_escape_string($conn, $_POST['question2']);
        $a2 = mysqli_real_escape_string($conn, $_POST['answer2']);

        // MD5 hash for questions and answers
        $hashed_a1 = md5($a1);
        $hashed_a2 = md5($a2);

        $userID = $_POST['getID'];

        $checkQuery = "SELECT * FROM verify_user WHERE UserID = '$userID'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Update existing record
            $updateQuery = "UPDATE verify_user SET 
                Question1 = '$q1', 
                Answer1 = '$hashed_a1', 
                Question2 = '$q2', 
                Answer2 = '$hashed_a2' 
                WHERE UserID = '$userID'";
            
            if (mysqli_query($conn, $updateQuery)) {
                header("Location: treasure_hub_signup_or_login.php");
            } else {
                echo "Error updating security questions: " . mysqli_error($conn);
            }

        } 
        else 
        {
            // Insert new record
            $insertQuery = "INSERT INTO verify_user (UserID, Question1, Answer1, Question2, Answer2) 
                            VALUES ('$userID', '$q1', '$hashed_a1', '$q2', '$hashed_a2')";
            
            if (mysqli_query($conn, $insertQuery)) {
                header("Location: treasure_hub_signup_or_login.php");
            } else {
                echo "Error saving security questions: " . mysqli_error($conn);
            }
        }

    } 

    if (isset($_POST['saveSeller']))
    {
        $q1 = mysqli_real_escape_string($conn, $_POST['question1']);
        $a1 = mysqli_real_escape_string($conn, $_POST['answer1']);
        $q2 = mysqli_real_escape_string($conn, $_POST['question2']);
        $a2 = mysqli_real_escape_string($conn, $_POST['answer2']);

        // MD5 hash for questions and answers
        $hashed_a1 = md5($a1);
        $hashed_a2 = md5($a2);

        $sellerID = $_POST['getID'];

        $checkQuery = "SELECT * FROM verify_seller WHERE SellerID = '$sellerID'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Update existing record
            $updateQuery = "UPDATE verify_seller SET 
                Question1 = '$q1', 
                Answer1 = '$hashed_a1', 
                Question2 = '$q2', 
                Answer2 = '$hashed_a2' 
                WHERE SellerID = '$sellerID'";
            
            if (mysqli_query($conn, $updateQuery)) {
                header("Location: treasure_hub_signup_or_login.php");
            } else {
                echo "Error updating security questions: " . mysqli_error($conn);
            }

        } 
        else 
        {
            // Insert new record
            $insertQuery = "INSERT INTO verify_seller (SellerID, Question1, Answer1, Question2, Answer2) 
                            VALUES ('$sellerID', '$q1', '$hashed_a1', '$q2', '$hashed_a2')";
            
            if (mysqli_query($conn, $insertQuery)) {
                header("Location: treasure_hub_signup_or_login.php");
            } else {
                echo "Error saving security questions: " . mysqli_error($conn);
            }
        }

    } 

    if (isset($_POST['saveAdmin']))
    {
        $q1 = mysqli_real_escape_string($conn, $_POST['question1']);
        $a1 = mysqli_real_escape_string($conn, $_POST['answer1']);
        $q2 = mysqli_real_escape_string($conn, $_POST['question2']);
        $a2 = mysqli_real_escape_string($conn, $_POST['answer2']);

        // MD5 hash for questions and answers
        $hashed_a1 = md5($a1);
        $hashed_a2 = md5($a2);

        $adminID = $_POST['getID'];

        $checkQuery = "SELECT * FROM verify_admin WHERE AdminID = '$adminID'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Update existing record
            $updateQuery = "UPDATE verify_admin SET 
                Question1 = '$q1', 
                Answer1 = '$hashed_a1', 
                Question2 = '$q2', 
                Answer2 = '$hashed_a2' 
                WHERE AdminID= '$adminID'";
            
            if (mysqli_query($conn, $updateQuery)) {
                header("Location: treasure_hub_signup_or_login.php?log=reported");
            } else {
                echo "Error updating security questions: " . mysqli_error($conn);
            }

        } 
        else 
        {
            // Insert new record
            $insertQuery = "INSERT INTO verify_admin (AdminID, Question1, Answer1, Question2, Answer2) 
                            VALUES ('$adminID', '$q1', '$hashed_a1', '$q2', '$hashed_a2')";
            
            if (mysqli_query($conn, $insertQuery)) {
                header("Location: treasure_hub_signup_or_login.php?log=reported");
            } else {
                echo "Error saving security questions: " . mysqli_error($conn);
            }
        }

    } 
?>
    