<?php 
session_start();
include "connect.php";

if (isset($_POST['addtoCartBtn']))
{
    if (isset($_SESSION['email'])) 
    {
        $email = $_SESSION['email'];  
        $userid = 0;

        $query = mysqli_query($conn, "SELECT * FROM user WHERE Email = '$email'");
        
        if ($query && mysqli_num_rows($query) > 0) 
        {
            $row = mysqli_fetch_assoc($query);
            $userid = $row['UserID'];
            $productid = $_POST['product_id'];
            $quantity = intval($_POST['P_quantity']); // Make sure it's an integer

            // Check if product already in cart
            $checkCart = mysqli_query($conn, "SELECT * FROM cart WHERE UserID = '$userid' AND ProductID = '$productid'");

            if ($checkCart && mysqli_num_rows($checkCart) > 0) {
                // Update existing quantity
                $update = "UPDATE cart SET Quantity = Quantity + $quantity WHERE UserID = '$userid' AND ProductID = '$productid'";
                if ($conn->query($update) === TRUE) {
                    header("Location: treasure hub cart section.php");   
                    exit();
                } else {
                    echo "Update Error: " . $conn->error;
                }
            } else {
                // Insert new cart item
                $insert = "INSERT INTO cart (UserID, ProductID, Quantity) VALUES ('$userid', '$productid', '$quantity')";
                if ($conn->query($insert) === TRUE) {
                    header("Location: treasure hub cart section.php");   
                    exit();
                } else {
                    echo "Insert Error: " . $conn->error;
                }
            }

        } 
        else 
        {
            echo "User not found";
        }
    } 
    else 
    {
        echo "User not logged in";
    }
}

if (isset($_POST['addtofoodCartBtn']))
{
    if (isset($_SESSION['email'])) 
    {
        $email = $_SESSION['email'];  
        $userid = 0;

        $query = mysqli_query($conn, "SELECT * FROM user WHERE Email = '$email'");
        
        if ($query && mysqli_num_rows($query) > 0) 
        {
            $row = mysqli_fetch_assoc($query);
            $userid = $row['UserID'];
            $productid = $_POST['product_id'];
            $quantity = "1";
            $specialNotes = $_POST['specialNotes'];
            

            $insert = "INSERT INTO foodcart (UserID, ProductID, Quantity, SpecialNotes) VALUES ('$userid', '$productid', '$quantity', '$specialNotes')";
            if ($conn->query($insert) === TRUE) {
                header("Location: treasure hub foods cart section.php");   
                exit();
            } else {
                echo "Insert Error: " . $conn->error;
            }
        } 
        else 
        {
            echo "User not found";
        }
    } 
    else 
    {
        echo "User not logged in";
    }
}
if (isset($_POST['alreadyInCart']))
{
    header("Location: treasure hub cart section.php");
}

if (isset($_POST['cartBtnLogin']))
{
    header("Location: treasure_hub_signup_or_login.php");
}





?>