<?php
session_start();
include 'connect.php';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $query = mysqli_query($conn, "SELECT * FROM user WHERE Email = '$email'");
    if ($row = mysqli_fetch_assoc($query)) 
    {
        $userID = $row['UserID'];
        if ($userID) {
            $verifyQuery = mysqli_query($conn, "SELECT * FROM verify_user WHERE UserID = '$userID'");
            if ($verifyRow = mysqli_fetch_assoc($verifyQuery)) {
                $usertype = "Buyer";
            }
        } 
    }
    else
    {
        $query = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");
        if ($row = mysqli_fetch_assoc($query)) {
            $sellerID = $row['SellerID'];
            if ($sellerID) {
                $verifyQuery = mysqli_query($conn, "SELECT * FROM verify_seller WHERE SellerID = '$sellerID'");
                if ($verifyRow = mysqli_fetch_assoc($verifyQuery)) {
                    $usertype = "Seller";
                }
            }
        }
    }
}
else if(isset($_SESSION['adminEmail']))
{
    $email = $_SESSION['adminEmail'];
    $query = mysqli_query($conn, "SELECT * FROM `admin` WHERE Email = '$email'");
        if ($row = mysqli_fetch_assoc($query)) {
            $adminID = $row['AdminID'];
            if ($adminID) {
                $verifyQuery = mysqli_query($conn, "SELECT * FROM verify_admin WHERE AdminID = '$adminID'");
                if ($verifyRow = mysqli_fetch_assoc($verifyQuery)) {
                    $usertype = "Admin";
                }
            }
        }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0faff;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .logo {
      margin-top: 30px;
    }

    .logo img {
      width: 120px;
    }

    .island {
      background-color: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      max-width: 95%;
      width: 400px;
      margin: 30px;
    }

    .island h2 {
      margin-top: 0;
      font-size: 1.5rem;
      color: #0077cc;
    }

    .form-group {
      margin: 15px 0;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
    }

    .submit-btn {
      background-color: #0077cc;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 6px;
      font-size: 1rem;
      margin-top: 20px;
      cursor: pointer;
    }

    .submit-btn:hover {
      background-color: #005fa3;
    }

    @media screen and (max-width: 480px) {
      .island {
        padding: 1.5rem;
        width: 90%;
      }

      .island h2 {
        font-size: 1.3rem;
      }
    }
    #message {
    display:none;
    background: #f1f1f1;
    color: #000;
    position: relative;
    padding: 20px;
    margin-top: 10px;
  }

  #message p {
    padding: 10px 35px;
    font-size: 18px;
  }


  .valid {
    color: green;
  }

  .valid:before {
    position: relative;
    left: -35px;
    content: "✔";
  }


  .invalid {
    color: red;
  }

  .invalid:before {
    position: relative;
    left: -35px;
    content: "✖";
  }
  </style>
</head>
<body>

  <div class="logo">
    <img src="treasure hub logo reduced 2.png" alt="Logo" />
  </div>

  <form class="island" action="reset_password_process.php" method="post">
    <?php
    if($usertype == "Buyer")
    {
    ?>
        <input type="hidden" name="getID" value="<?= $userID ?>">
    <?php
    }
    if($usertype == "Seller")
    {
    ?>
        <input type="hidden" name="getID" value="<?= $sellerID ?>">
    <?php
    }
    if($usertype == "Admin")
    {
    ?>
        <input type="hidden" name="getID" value="<?= $adminID ?>">
    <?php
    }
    ?>
    <h2>Reset Your Password</h2>

    <div class="form-group">
      <input type="password" name="new_password" id="password" placeholder="New Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
      title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
    </div>
    <div class="form-group">
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    </div>
    <?php
    if($usertype == "Buyer")
    {
    ?>
        <button type="submit" class="submit-btn" name="resetbuyer">Update Password</button>
    <?php
    }
    if($usertype == "Seller")
    {
    ?>
        <button type="submit" class="submit-btn" name="resetseller">Update Password</button>
    <?php
    }
    if($usertype == "Admin")
    {
    ?>
        <button type="submit" class="submit-btn" name="resetAdmin">Update Password</button>
    <?php
    }
    ?>
    <div id="message">
      <h3>Password must contain the following:</h3>
      <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
      <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
      <p id="number" class="invalid">A <b>number</b></p>
      <p id="length" class="invalid">Minimum <b>8 characters</b></p>
    </div>
  </form>

<script>
var myInput = document.getElementById("password");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");


myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}


myInput.onkeyup = function() {
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
 

  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }


  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  

  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}  
</script>
</body>
</html>