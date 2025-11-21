<?php
session_start();
include 'connect.php';


if (isset($_POST['SignUp'])) {
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); 
    $date = date("Y-m-d");

    $check = "SELECT * FROM user WHERE Email = '$email'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        echo "Email already exists!";
    } else {
        $insert = "INSERT INTO user (FirstName, LastName, Email, Password, dateJoined)
                   VALUES ('$firstName', '$lastName', '$email', '$password', '$date')";
        if ($conn->query($insert) === TRUE) {
            $_SESSION['email'] = $email;
            header("Location: protectAccountPage.php");
            exit();
        } else {
            echo "Insert Error: " . $conn->error;
        }
    }
}



if (isset($_POST['SellerSignUp'])) {
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); 
    $username = $_POST['uName'];
    $verified = 0;
    $date = date("Y-m-d");

    $check = "SELECT * FROM seller WHERE Email = '$email'";
    $result = $conn->query($check);

   

    if ($result->num_rows > 0) {
        echo "Email already exists!";
    } else {

        $checkUserName = "SELECT * FROM seller WHERE UserName = '$username'";
        $result = $conn->query($checkUserName);
        if($result -> num_rows > 0)
        {
           
        }
        else
        {
            $insert = "INSERT INTO seller (FirstName, LastName, Email, Password, UserName,Verified, dateJoined)
            VALUES ('$firstName','$lastName','$email','$password','$username','$verified','$date')";
            if ($conn->query($insert) === TRUE) {
                $_SESSION['email'] = $email;
                header("Location: protectAccountPage.php");
                exit();
            } else 
            {
                echo "Insert Error: " . $conn->error;
            }      
        }
        
    }
}

if(isset($_POST['Login']))
{
    /*
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $sql = "SELECT * FROM user WHERE Email ='$email' and Password = '$password'";
    $result = $conn -> query($sql);
    if($result -> num_rows >0)
    {
        session_start();
        $row = $result -> fetch_assoc();
        $_SESSION["email"]=$row["email"];
        $test = $row["email"];
        echo ($test);
       // header("Location: treasure_hub_welcome.php");
        exit();
    }
    else{
        echo "Not found, Incorrect Email or Password"; 
    }
    */
      // Sanitize input
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);
  
      
      $hashedPassword = md5($password); 
  

      $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ? AND Password = ?");
      $stmt->bind_param("ss", $email, $hashedPassword);
      $stmt->execute();
      $result = $stmt->get_result();
  
      if ($result && $result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $_SESSION['email'] = $row['Email']; 

          header("Location: treasure_hub_welcome.php");
          exit();
      } else 
      {
        $stmt = $conn->prepare("SELECT * FROM seller WHERE Email = ? AND Password = ?");
        $stmt->bind_param("ss", $email, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['email'] = $row['Email']; 
  
            header("Location:  treasure hub seller page home.php");
            exit();
        }
        else
        {
            $stmt = $conn->prepare("SELECT * FROM admin WHERE Email = ? AND Password = ?");
            $stmt->bind_param("ss", $email, $hashedPassword);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['adminEmail'] = $row['Email']; 
  
                header("Location: treasure hub developer page home.php");
                exit();
            }
            else
            {
                echo "Not found, Incorrect Email or Password"; 
            }
            
         
        }
          
      }
  
      $stmt->close();
      $conn->close();
  
}


if(isset($_POST['RecoverPassword']))
{
    $email = trim($_POST['email']);
    $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
  
    if ($result && $result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['Email'];
        header("Location: get_recovery_questions.php");
        exit(); 
    }
    else 
    {
        $stmt = $conn->prepare("SELECT * FROM seller WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['email'] = $row['Email']; 
            header("Location: get_recovery_questions.php");
            exit();
        }
        else
        {
            $stmt = $conn->prepare("SELECT * FROM admin WHERE Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['adminEmail'] = $row['Email']; 
                header("Location: get_recovery_questions.php");
                exit();
            }
            else
            {
                echo "Not found, Incorrect Email or Password"; 
            }
            
        }
    }
  
      $stmt->close();
      $conn->close();
}
$externalProductValue;

if (isset($_POST['SellerListing'])) {
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];  
        $sellerid = 0;

        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        if ($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $sellerid = $row['SellerID'];
        }

        $productName = $_POST['Pname'];
        $isSold = 0;
        $listingDate = date("Y-m-d");
        $Pcondition = $_POST['Pcondition'];
        $Categoryid = $_POST['CategoryDropDown'];
        $Price = $_POST['Pprice'];
        $Quantity = $_POST['Pquantity'];
        $shortDescription = mysqli_real_escape_string($conn, $_POST['sDescription']);
        $longDescription = mysqli_real_escape_string($conn, $_POST['lDescription']);

        $insert = "INSERT INTO product (SellerID, ProductName, isSold, listingDate, ProductCondition, CategoryID, Price, Quantity, shortDescription, longDescription)
                   VALUES ('$sellerid','$productName','$isSold','$listingDate','$Pcondition','$Categoryid','$Price','$Quantity','$shortDescription','$longDescription')";

        if ($conn->query($insert) === TRUE) {
            $productID = mysqli_insert_id($conn); 
            addPictures($productID);
            exit();
        } else {
            echo "Insert Error: " . $conn->error;
        }
    } else {
        echo "nobody logged in";
    }
}

function addPictures($productID)
{
    include 'connect.php';

    $fileFields = ['productimg1', 'productimg2', 'productimg3', 'productimg4'];
    $altFields = ['pic1alt', 'pic2alt', 'pic3alt', 'pic4alt'];

    foreach ($fileFields as $index => $fileKey)
    {
        if (!empty($_FILES[$fileKey]['name'])) 
        {
            $file_name = $_FILES[$fileKey]['name'];
            $tempname = $_FILES[$fileKey]['tmp_name'];
            $folder = 'Images/' . $file_name;
            $altText = $_POST[$altFields[$index]];

            if (move_uploaded_file($tempname, $folder)) {
                $insert = "INSERT INTO productimages (ProductID, ImagePath, altText)
                           VALUES ('$productID', '$file_name', '$altText')";
                if (!mysqli_query($conn, $insert)) {
                    echo "Image {$index}+1 not uploaded: " . mysqli_error($conn);
                }
            } else {
                echo "Failed to move image file: $file_name";
            }
        }
    }

    header("Location:treasure hub seller page home.php?view=home");
}

if(isset($_POST['confirmEditButtons']))
{
    if (isset($_SESSION['email'])) 
    {
        $email = $_SESSION['email'];
        $sellerid = 0;

        
        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        if ($query && mysqli_num_rows($query) > 0) 
        {
            $row = mysqli_fetch_assoc($query);
            $sellerid = $row['SellerID'];
            if (isset($_SESSION['edit_product_id'])) 
            {
            
                $productId = $_SESSION['edit_product_id'];
                $productName = $_POST['Pname'];
                $Pcondition = $_POST['Pcondition'];
                $Categoryid = $_POST['CategoryDropDown'];
                $Price = $_POST['Pprice'];
                $Quantity = $_POST['Pquantity'];
                $shortDescription = mysqli_real_escape_string($conn, $_POST['sDescription']);
                $longDescription = mysqli_real_escape_string($conn, $_POST['lDescription']);

                $update = "UPDATE product SET ProductName = '$productName',
                                                ProductCondition = '$Pcondition',
                                                CategoryID = '$Categoryid',
                                                Price = '$Price',
                                                Quantity = '$Quantity',
                                                shortDescription = '$shortDescription',
                                                longDescription = '$longDescription'
                                                WHERE ProductID = '$productId' AND SellerID = '$sellerid'";
                if (mysqli_query($conn, $update)) 
                {
                    header("Location:treasure hub seller page listing.php?action=edit");
                }
                else
                {
                    echo "Insert Error: " . $conn->error;
                }

                    
            }
        }
     
    }
    
}


if(isset($_POST['FoodSellerListing']))
{
    if (isset($_SESSION['email'])) 
    {
        $email = $_SESSION['email'];
        $sellerid = 0;

        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        if ($query && mysqli_num_rows($query) > 0) 
        {
            $row = mysqli_fetch_assoc($query);
            $sellerid = $row['SellerID'];
            $productName = $_POST['Food_Pname'];
            $productDescription = $_POST['Food_sDescription'];
            $Categoryid = $_POST['CategoryDropDown'];
            $listingDate = date("Y-m-d");
            $price = $_POST['Food_Pprice'];
            $picAltText = $_POST['food_picalt'];
            $file_name = $_FILES['food_productimg']['name'];
            $tempname = $_FILES['food_productimg']['tmp_name'];
            $folder = 'Images/' . $file_name;

            if (move_uploaded_file($tempname, $folder)) 
            {
                $stmt = $conn->prepare("INSERT INTO foodproduct (SellerID, FoodName, Description, Price, ImagePath, altText,CategoryID,ListingDate) VALUES (?, ?, ?, ?, ?, ?,?,?)");
                $stmt->bind_param("issdssss", $sellerid, $productName, $productDescription, $price, $file_name, $picAltText,$Categoryid,$listingDate);
                $stmt->execute();
                $productId = $conn->insert_id; 
                header("Location:treasure hub seller page home.php?view=sell");

            } 
            else
            {
                echo "Failed to upload file.";
            }

            
        }
    }
}
if(isset($_POST['EditFoodSellerListing']))
{
    if (isset($_SESSION['email'])) 
    {
        $email = $_SESSION['email'];
        $sellerid = 0;

        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        if ($query && mysqli_num_rows($query) > 0) 
        {
            $row = mysqli_fetch_assoc($query);
            
            $sellerid = $row['SellerID'];
            $productid = $_POST['Food_Pt'];
            $productName = $_POST['Food_Pname'];
            $productDescription = $_POST['Food_sDescription'];
            $price = $_POST['Food_Pprice'];
            $picAltText = $_POST['food_picalt'];
            $file_name = $_FILES['food_productimg']['name'];
            $tempname = $_FILES['food_productimg']['tmp_name'];
            $folder = 'Images/' . $file_name;

            if (move_uploaded_file($tempname, $folder)) 
            {
                $stmt = $conn->prepare("INSERT INTO foodproduct (ProductID, SellerID, FoodName, Description, Price, ImagePath, altText) VALUES (?, ?, ?, ?, ?, ?,?)");
                $stmt->bind_param("iissdss",$productid , $sellerid, $productName, $productDescription, $price, $file_name, $picAltText);
                $stmt->execute();
                $productId = $conn->insert_id; 
                header("Location:treasure hub seller page home.php?view=sell");

            } 
            else
            {
                echo "Failed to upload file.";
            }

            
        }
    }
}

if (isset($_POST['addresssubmit'])) {
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $streetAddress = $_POST['street-address'];
        $city = $_POST['city'];
        $po_Box = $_POST['PO_Box'];
        $sellerid = 0;

        // Get SellerID from seller table
        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        if ($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $sellerid = $row['SellerID'];

            // Check if selleraddress entry already exists
            $check = mysqli_query($conn, "SELECT * FROM selleraddress WHERE SellerID = '$sellerid'");
            
            if ($check && mysqli_num_rows($check) > 0) {
                // Address already exists, perform update
                $update = "UPDATE selleraddress 
                           SET StreetAddress = '$streetAddress', City = '$city', POBox = '$po_Box' 
                           WHERE SellerID = '$sellerid'";
                
                if ($conn->query($update) === TRUE) {
                    echo "Address updated successfully.";
                    exit();
                } else {
                    echo "Update Error: " . $conn->error;
                }
            } else {
                // Address doesn't exist, perform insert
                $insert = "INSERT INTO selleraddress (SellerID, StreetAddress, City, POBox)
                           VALUES ('$sellerid', '$streetAddress', '$city', '$po_Box')";

                if ($conn->query($insert) === TRUE) {
                    header("Location: treasure hub settings page.php?action=sell");
                    exit();
                } else {
                    echo "Insert Error: " . $conn->error;
                }
            }
        }
    }
}


if (isset($_POST['sellerfnameeditbutton']))
{
    if (isset($_SESSION['email'])) 
    {
        $email = $_SESSION['email'];
        $firstname = $_POST['firstname'];
        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        if ($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $sellerid = $row['SellerID'];
            $update = " UPDATE seller
                        SET FirstName = '$firstname'
                        WHERE SellerID = '$sellerid'";
                
                if ($conn->query($update) === TRUE) {
                    header("Location: treasure hub settings page.php?action=sell");
                    exit();
                } else {
                    echo "Update Error: " . $conn->error;
                }
        }
    }
}

if (isset($_POST['sellerlnameeditbutton']))
{
    if (isset($_SESSION['email'])) 
    {
        $email = $_SESSION['email'];
        $lastname = $_POST['lastname'];
        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        if ($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $sellerid = $row['SellerID'];
            $update = " UPDATE seller
                        SET LastName = '$lastname';
                        WHERE SellerID = '$sellerid'";
                
                if ($conn->query($update) === TRUE) {
                    header("Location: treasure hub settings page.php?action=sell");
                    exit();
                } else {
                    echo "Update Error: " . $conn->error;
                }
        }
    }
}

if (isset($_POST['usereditbutton']))
{
    if (isset($_SESSION['email'])) 
    {
        $email = $_SESSION['email'];
        $username = $_POST['username'];
        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        if ($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $sellerid = $row['SellerID'];
            $update = " UPDATE seller
                        SET UserName = '$username';
                        WHERE SellerID = '$sellerid'";
                
                if ($conn->query($update) === TRUE) {
                    header("Location: treasure hub settings page.php?action=sell");
                    exit();
                } else {
                    echo "Update Error: " . $conn->error;
                }
        }
    }
}

if (isset($_POST['descriptioneditbutton']))
{
    if (isset($_SESSION['email'])) 
    {
        $email = $_SESSION['email'];
        $Description = mysqli_real_escape_string($conn, $_POST['description']);
        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        if ($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $sellerid = $row['SellerID'];
            $update = " UPDATE seller
                        SET Description = '$Description'
                        WHERE SellerID = '$sellerid'";
                
                if ($conn->query($update) === TRUE) {
                    header("Location: treasure hub settings page.php?action=sell");
                    exit();
                } else {
                    echo "Update Error: " . $conn->error;
                }
        }
    }
}

if (isset($_POST['confirmpassword']))
{
    if (isset($_SESSION['email'])) 
    {
        $email = $_SESSION['email'];
        $password = trim($_POST['passwordattempt']);  
        $hashedPassword = md5($password); 
        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        if ($query && mysqli_num_rows($query) > 0)
        {
            $row = mysqli_fetch_assoc($query);
            if($hashedPassword == $row['Password'])
            {
                 echo "<script>alert('Verification successful. Redirecting to reset password...');</script>";
                echo "<meta http-equiv='refresh' content='2; url=reset_password.php'>";
            }
            else
            {
                echo "<script>alert('Password incorrect. Please try again.'); window.history.back();</script>";
            }
        }
        else
        {
            $query = mysqli_query($conn, "SELECT * FROM user WHERE Email = '$email'");
            if ($query && mysqli_num_rows($query) > 0)
            {
                $row = mysqli_fetch_assoc($query);
                if($hashedPassword == $row['Password'])
                {
                    echo "<script>alert('Verification successful. Redirecting to reset password...');</script>";
                    echo "<meta http-equiv='refresh' content='2; url=reset_password.php'>";
                }
                else
                {
                    echo "<script>alert('Password incorrect. Please try again.'); window.history.back();</script>";
                }
            }
        }
    }
    
}

/*
if(isset($_POST['SellerListing']))
{
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];  
        $sellerid ;  
        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        if ($query && mysqli_num_rows($query) > 0) 
        {
            while ($row = mysqli_fetch_array($query)) 
            {
                $sellerid = $row['SellerID'];
            }
        } 
        $productName = $_POST['Pname'];
        $isSold = 0;
        $listingDate = date("Y-m-d");
        $Pcondition = $_POST['Pcondition'];
        $Categoryid = $_POST['CategoryDropDown'];
        $Price = $_POST['Pprice'];
        $Quantity = $_POST['Pquantity'];
        $shortDescription = $_POST['sDescription'];
        $longDescription = $_POST['lDescription'];
        
        $insert = "INSERT INTO product('SellerID','ProductName','isSold','listingDate','ProductCondition','CategoryID','Price','Quality','shortDescription','longDescription')
                 values ('$sellerid','$productName','$isSold','$listingDate','$Pcondition','$Categoryid','$Price','$Quantity','$shortDescription','$longDescription')";

        if ($conn->query($insert) === TRUE) 
        {
           //  header("Location: treasure_hub_signup_or_login.php");
           $externalProductValue = $row['ProductID'];
           addPictures();
            exit();
        }
         else 
        {
            echo "Insert Error: " . $conn->error;
        } 
    }
    else
    {
        echo "nobody logged in";
    }
}



function addPictures()
{
    include 'connect.php';
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];    
        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        
        if ($query && mysqli_num_rows($query) > 0)
        {
            $sellerID = $row['ProductID'];
            $file_name = $_FILES['productimg1']['name'];
            $tempname = $_FILES['productimg1']['tmp_name'];
            $folder = 'Images/' . $file_name;
            $altText1 = $_POST['pic1alt'];
            $altText2 = $_POST['pic2alt'];
            $altText3 = $_POST['pic3alt'];
            $altText4 = $_POST['pic4alt'];

            if (move_uploaded_file($tempname, $folder))
            {
                $insert = "INSERT INTO productimages (ProductID, ImagePath ,alt_text) VALUES('$externalProductValue','$file_name','$altText1')";
                if (mysqli_query($conn, $insert))
                {
                    $file_name = $_FILES['productimg2']['name'];
                    $tempname = $_FILES['productimg2']['tmp_name'];
                    $insert = "INSERT INTO productimages (ProductID, ImagePath ,alt_text) VALUES('$externalProductValue','$file_name','$altText2')";
                    if (mysqli_query($conn, $insert))
                    {
                        $file_name = $_FILES['productimg3']['name'];
                        $tempname = $_FILES['productimg3']['tmp_name'];
                        $insert = "INSERT INTO productimages (ProductID, ImagePath ,alt_text) VALUES('$externalProductValue','$file_name','$altText3')"; 
                        if (mysqli_query($conn, $insert))
                        {
                            $file_name = $_FILES['productimg4']['name'];
                            $tempname = $_FILES['productimg4']['tmp_name'];
                            $insert = "INSERT INTO productimages (ProductID, ImagePath ,alt_text) VALUES('$externalProductValue','$file_name','$altText4')";  
                            if(mysqli_query($conn, $insert))
                            {
                                echo"Product added successfully";
                                header("treasure hub seller page home.php?view=home");
                            }
                            else echo "4th pirctures not uploaded";
                        }
                        else echo "3rd pictures not uploaded";
                    }
                    else
                    {
                        echo "2nd pictures not uploaded";
                    }
                } 
                else 
                {
                    echo "Database update failed: " . mysqli_error($conn);
                }
            } 
            else 
            {
                echo "Failed to upload file.";
            }
        } 
        else 
        {
            echo "No user found with this email.";
        }
    } 
    else
    {
        echo "User not logged in.";
    }
}
    */
?>
