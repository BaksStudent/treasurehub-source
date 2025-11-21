<?php
session_start();
if (session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION)) 
{    
    session_unset();
    session_destroy();
    
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="treasure hub signup or login.css">
</head>
<body>
    <?php if (isset($_GET['log']) && $_GET['log'] === 'reported'): ?>
        <div class="notification-banner">
            <p>✅ New admin has been created.</p>
        </div>
    <?php endif; ?>

     <?php if (isset($_GET['log']) && $_GET['log'] === 'pass'): ?>
        <div class="notification-banner">
            <p>✅ Password Update</p>
        </div>
    <?php endif; ?>
    <div class="imageContainer">
        <img src="treasure hub logo reduced 2.png" alt="Picture of logo">
    </div>
<div class = Optionscontainer id = "UserType" style="display: none;">
    <h4 class = "OptionWords">
        Do you want to be a buyer or a Seller?
    </h4>
    <div class = "OptionButtons" >
        <button id = "BuyerButton">Buyer</button>
        <button id = "SellerButton">Seller</button>
    </div>
</div>   
<div class="container" id = "BuyerSignup" style="display: none;">
    <h1 class = "form-title">Register</h1>
        <form method="post" action="register.php">
            <div class = "input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="fName" id = "fName" placeholder="First Name" required>
                <label for = "fname">First Name</label>
            </div>
            <div class = "input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="lName" id = "lName" placeholder="Last Name" required>
                <label for = "lname">Last Name</label>
            </div>
            <div class = "input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id = "email" placeholder="Email" required>
                <label for = "email">Email</label>
            </div>
            <div class = "input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id = "password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"required>
                <label for = "password">Password</label>
            </div>
            <input type="submit" class = "btn" value="Sign Up" name = "SignUp">
        </form>   
        <p class = "or">
            ---------or---------
        </p>
        <div class = "links">
        <p>Already Have Account ?</p>
        <button id="loginButton">Login</button>
        </div>
        <div id="message">
            <h3>Password must contain the following:</h3>
            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
            <p id="number" class="invalid">A <b>number</b></p>
            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
        </div>
</div> 




<div class="container" id = "SellerSignup" style="display: none;">
    <h1 class = "form-title">Register as Seller</h1>
        <form method="post" action="register.php">
            <div class = "input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="fName" id = "fName" placeholder="First Name" required>
                <label for = "fname">First Name</label>
            </div>
            <div class = "input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="lName" id = "lName" placeholder="Last Name" required>
                <label for = "lname">Last Name</label>
            </div>
            <div class = "input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id = "email" placeholder="Email" required>
                <label for = "email">Email</label>
            </div>
            <div class = "input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id = "sellerpassword" placeholder="Password"
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"required>
                <label for = "password">Password</label>
            </div>
            <div class = "input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="uName" id = "uName" placeholder="Username" required>
                <label for = "uname">Username</label>
            </div>
            <input type="submit" class = "btn" value="Sign Up" name = "SellerSignUp">
        </form>   
        <div class = "links">
        <p>Already Have Account ?</p>
        <button id="loginButton">Login</button>
        </div>
        <div id="sellermessage">
            <h3>Password must contain the following:</h3>
            <p id="sellerletter" class="invalid">A <b>lowercase</b> letter</p>
            <p id="sellercapital" class="invalid">A <b>capital (uppercase)</b> letter</p>
            <p id="sellernumber" class="invalid">A <b>number</b></p>
            <p id="sellerlength" class="invalid">Minimum <b>8 characters</b></p>
        </div>
</div>

<div class="container" id = "login">
    <h1 class = "form-title">Login</h1>
        <form method="post" action="register.php">
            <div class = "input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id = "email" placeholder="Email" required>
                <label for = "email">Email</label>
            </div>
            <div class = "input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id = "loginpassword" placeholder="Password">
                <label for = "password">Password</label>
            </div>
            <p class = "recover">
                <button type="submit" name = "RecoverPassword"> Recover Password</button>
            </p>
            <input type="submit" class = "btn" value="Login" name = "Login">
        </form>   
        <p class = "or">
            ---------or---------
        </p>
        <div class = "links">
        <p>Don't have an account? ?</p>
        <button id="signInButton">Sign in</button>
        </div>
</div> 
<script src="treasure hub signup or login.js"></script>
</body>
</html>