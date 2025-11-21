<?php
session_start();
include 'connect.php';
if (isset($_POST['Upload'])) {
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];    
        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        
        if ($query && mysqli_num_rows($query) > 0) {
            $file_name = $_FILES['profilePic']['name'];
            $tempname = $_FILES['profilePic']['tmp_name'];
            $folder = 'Images/' . $file_name;

            // Move the uploaded file first
            if (move_uploaded_file($tempname, $folder)) {
                // Then update the DB record
                $update = "UPDATE seller SET ProfilePicFile = '$file_name' WHERE Email = '$email'";
                if (mysqli_query($conn, $update)) {
                    header("Location: treasure hub settings page.php?action=sell");
                } else {
                    echo "Database update failed: " . mysqli_error($conn);
                }
            } else {
                echo "Failed to upload file.";
            }
        } else {
             header("Location: treasure_hub_signup_or_login.php");
        }
    } else {
         header("Location: treasure_hub_signup_or_login.php");
    }
}

if (isset($_POST['bannerUpload'])) {
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];    
        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        
        if ($query && mysqli_num_rows($query) > 0) {
            $file_name = $_FILES['bannerPic']['name'];
            $tempname = $_FILES['bannerPic']['tmp_name'];
            $folder = 'Images/' . $file_name;

            // Move the uploaded file first
            if (move_uploaded_file($tempname, $folder)) {
                // Then update the DB record
                $update = "UPDATE seller SET BannerImage = '$file_name' WHERE Email = '$email'";
                if (mysqli_query($conn, $update)) {
                    header("Location: treasure hub settings page.php?action=sell");
                } else {
                    echo "Database update failed: " . mysqli_error($conn);
                }
            } else {
                echo "Failed to upload file.";
            }
        } else {
            header("Location: treasure_hub_signup_or_login.php");
        }
    } else {
       header("Location: treasure_hub_signup_or_login.php");
    }
}




if (isset($_POST['UploadImg1'])) 
{
    if (isset($_SESSION['email'])) 
    {
        $email = $_SESSION['email'];    
        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        $n = $_SESSION['Temporary_image_ID'];
        
        if ($query && mysqli_num_rows($query) > 0) 
        {
            $file_name = $_FILES['productimg1']['name'];
            $tempname = $_FILES['productimg1']['tmp_name'];
            $folder = 'Images/' . $file_name;
            $altText = $_POST["pic1alt"];
            if (isset($_SESSION['edit_product_id'])) 
            {
                $productId = $_SESSION['edit_product_id'];

                $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '$productId'");
                
                if ($productQuery && mysqli_num_rows($productQuery) > 0) 
                {
                    $imageQuery = mysqli_query($conn, "SELECT * FROM productimages WHERE ImageID = '$n'");
                
                    if ($imageQuery && mysqli_num_rows($imageQuery) > 0) 
                    {
                        if (move_uploaded_file($tempname, $folder)) 
                        {
                        // Then update the DB record
                            $update = "UPDATE productimages SET ImagePath = '$file_name',
                                                            altText = '$altText'
                                                             WHERE ImageID = '$n'";
                            if (mysqli_query($conn, $update)) {
                                 echo "Profile picture updated successfully.";
                            } else {
                                echo "Database update failed: " . mysqli_error($conn);
                             }
                        } 
                        else 
                        {
                             echo "Failed to upload file.";
                        }
                    }
                }
            
                
            }
        }
    }
}

      


?>