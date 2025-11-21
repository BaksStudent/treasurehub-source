<?php
session_start();
require_once('connect.php'); // Make sure to include your DB connection file

$question1 = $question2 = "";
$userID = null;

// Check for user session
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
            $question1 = $verifyRow['Question1'];
            $question2 = $verifyRow['Question2'];
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
                    $question1 = $verifyRow['Question1'];
                    $question2 = $verifyRow['Question2'];
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
                $usertype = "Admin";
                $verifyQuery = mysqli_query($conn, "SELECT * FROM verify_admin WHERE AdminID = '$adminID'");
                if ($verifyRow = mysqli_fetch_assoc($verifyQuery)) {
                    $question1 = $verifyRow['Question1'];
                    $question2 = $verifyRow['Question2'];
                }
            }
        }
}

else {
    die("User not found. Please log in.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Get Recovery Questions</title>
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
      margin-bottom: 10px;
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
      margin: 20px;
    }

    .island h2 {
      margin-top: 0;
      font-size: 1.5rem;
      color: #0077cc;
    }

    .island h4, .island p {
      margin: 10px 0;
      color: #333;
      font-size: 0.95rem;
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

    .form-group input[disabled] {
      background-color: #f4f4f4;
      font-weight: bold;
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
  </style>
</head>
<body>

  <div class="logo">
    <img src="treasure hub logo reduced 2.png" alt="Logo" />
  </div>

  <form class="island" action="verify_recovery_answers.php" method="post">
    <h2>Secure Your Account</h2>
    <h4>Answer your recovery questions below</h4>
    <p>Please provide answers to the following questions to recover your account.</p>

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
    

    <div class="form-group">
      <label>Question 1</label>
      <input type="text" name="question1" value="<?= htmlspecialchars($question1) ?>" disabled>
    </div>
    <div class="form-group">
      <input type="text" name="answer1" placeholder="Answer 1" required>
    </div>

    <div class="form-group">
      <label>Question 2</label>
      <input type="text" name="question2" value="<?= htmlspecialchars($question2) ?>" disabled>
    </div>
    <div class="form-group">
      <input type="text" name="answer2" placeholder="Answer 2" required>
    </div>

    <?php
    if($usertype == "Buyer")
    {
    ?>
    <button type="submit" class="submit-btn" name = "verifybuyer">Submit Answers</button>
    <?php
    }
    if($usertype == "Seller")
    {
    ?>
    <button type="submit" class="submit-btn" name = "verifyseller">Submit Answers</button>
    <?php
    }
    if($usertype == "Admin")
    {
    ?>
        <button type="submit" class="submit-btn" name = "verifyadmin">Submit Answers</button>
    <?php
    }
    ?>
  </form>

</body>
</html>