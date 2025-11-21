<?php
    session_start();
    include 'connect.php';
    if(isset($_SESSION['email']))
    {
        $email = $_SESSION['email'];
        $query = mysqli_query($conn, "SELECT user.* FROM user WHERE user.Email ='$email'");
        if($row = mysqli_fetch_array($query))
        {
          //echo $row['FirstName'];
          $id = $row['UserID'];
          $user = "Buyer";
        }
        else
        {
             $query = mysqli_query($conn, "SELECT seller.* FROM seller WHERE seller.Email ='$email'");
            if($row = mysqli_fetch_array($query))
            {
                $id = $row['SellerID'];
                $user = "Seller";
            }
            else
            {
                header("Location: treasure_hub_signup_or_login.php");
            }
        }
    }
   else if (isset($_SESSION['adminEmail'])) 
   {
        $email = $_SESSION['adminEmail'];
        $query = mysqli_query($conn, "SELECT * FROM admin WHERE Email ='$email'");
        if($row = mysqli_fetch_array($query))
        {
          //echo $row['FirstName'];
            $id = $row['AdminID'];
            $user = "Admin";
        }
    }
    else
    {
        header("Location: treasure_hub_signup_or_login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secure Your Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: aliceblue;
            background: linear-gradient(to right,rgb(0, 162, 255),white);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }

        .logo {
            margin-top: 40px;
            margin-bottom: 20px;
        }

        .logo img {
            width: 120px;
            height: auto;
        }

        .form-container {
            background-color: #ffffff;
            width: 90%;
            max-width: 400px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }

        .form-container p {
            text-align: center;
            font-size: 14px;
            color: #555;
            margin: 5px 0 15px;
        }

        .form-container input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 500px) {
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    
    <div class="logo">
        <img src="treasure hub logo reduced 2.png" alt="Logo"> 
    </div>
   
    <!-- Form Section -->
    <form class="form-container" method="post" action="submit_security_questions.php">
        <h2>Secure Your Account</h2>
        <p>Add 2 questions and answers for those questions just in case you forget your password.</p>
        <p><strong>Make sure the questions are simple and you can remember them otherwise you will lose access to your account.</strong></p>

        
        <input type="text" name="question1" placeholder="Enter Question 1" required>
        <input type="text" name="answer1" placeholder="Enter Answer 1" required>

        
        <input type="text" name="question2" placeholder="Enter Question 2" required>
        <input type="text" name="answer2" placeholder="Enter Answer 2" required>
         <?php
            if($user == "Buyer")
            {
                ?>
                <input type="hidden" name = "getID" value="<?php echo $id ?>">
                <button type="submit" name = "saveBuyer" >Save Security Questions</button>
                <?php
            }
            else if($user == "Seller")
            {
            ?>
                <input type="hidden" name = "getID" value="<?php echo $id ?>">
                <button type="submit" name = "saveSeller">Save Security Questions</button>
            <?php
            }
            else if($user == "Admin")
            {
                ?>
                <input type="hidden" name = "getID" value="<?php echo $id ?>">
                <button type="submit" name = "saveAdmin">Save Security Questions</button>
                <?php
            }
        ?>
    </form>

</body>
</html>
