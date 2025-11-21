<?php
session_start();
include "connect.php";

$search = isset($_GET['reviewid']) ? trim($_GET['reviewid']) : '';
if (!empty($search)) 
{
    $reviewID = $search;
}

// Fetch review details
$reviewQuery = mysqli_query($conn, "SELECT * FROM review WHERE ReviewID = $reviewID");
if (!$reviewQuery || mysqli_num_rows($reviewQuery) == 0) {
    echo "Review not found.";
    exit;
}

$review = mysqli_fetch_assoc($reviewQuery);
$productID = $review['ProductID'];
$userID = $review['UserID'];
$rating = $review['rating'];
$comment = $review['comment'];
$reviewDate = $review['reviewDate'];

// Fetch product details
$productQuery = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = $productID");
$product = mysqli_fetch_assoc($productQuery);

// Fetch one image
$imagePath = "placeholder logo.png";
$imageQuery = mysqli_query($conn, "SELECT ImagePath FROM productimages WHERE ProductID = $productID LIMIT 1");
if ($imageQuery && mysqli_num_rows($imageQuery) > 0) {
    $img = mysqli_fetch_assoc($imageQuery);
    $imagePath = "Images/" . $img['ImagePath'];
}

// Fetch seller details
$sellerQuery = mysqli_query($conn, "SELECT * FROM user WHERE UserID = $userID");
$seller = mysqli_fetch_assoc($sellerQuery);
$userName = $seller['FirstName'] . " " . $seller['LastName'];




if (isset($_POST['deleteReviewButton']))
    {
        if(isset($_SESSION['adminEmail']))
        {
            $email = $_SESSION['adminEmail'];
            $query = mysqli_query($conn, "SELECT * FROM admin WHERE Email ='$email'");
            while($row = mysqli_fetch_array($query))
            {
                $adminID = $row['AdminID'];
            }
        }
        else
        {
            echo "admin not logged in";
            exit();
        }
        $description = "deleted Review NO.".$reviewID." due to violation policies";
        $Delete= "DELETE FROM review WHERE ReviewID = '$reviewID' ";
        $date = date("Y-m-d");
        
        if (mysqli_query($conn, $Delete)) 
        {
            
            $delistquery = mysqli_query($conn,"UPDATE product SET isSold = '1' WHERE SellerID  ='$sellerID'" );
            
            $insert = "INSERT INTO adminaction(AdminID, Description, ActionDate) VALUES ('$adminID','$description','$date')";
            if (mysqli_query($conn, $insert)) 
            {
                header("Location:treasure hub developer page home.php");
            }
        }
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Review Summary</title>
  <link rel="stylesheet" href="treasure hub developer page home.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>

    .section {
      background: #fff;
      padding: 1rem;
      margin-bottom: 1rem;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      margin: 20px;
    }

    h2 {
      margin-top: 0;
    }

    img {
      max-width: 150px;
      border-radius: 8px;
    }

    .btn {
      display: inline-block;
      padding: 0.5rem 1rem;
      background: #e74c3c;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      margin-top: 10px;
    }

    .btn:hover {
      background: #c0392b;
    }
  </style>
</head>
<body>

<header>
        <nav class = "MainNavbar">
            <button class = "MainLogo" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "treasure hub logo reduced 4.png" ></button>
            <div class ="Nav-links">
                <button class = "Nav-Buttons" onclick="Logout()">Logout</button>
                <button class = "Nav-Buttons" onclick = "HomeLink()">Home</button>>
            </div>
        </nav>
  </header>

<div class="section">
  <h2>Review Details</h2>
  <p><strong>Review ID:</strong> <?= $reviewID ?></p>
  <p><strong>Rating:</strong> <?= $rating ?>/10</p>
  <p><strong>Description:</strong> <?= htmlspecialchars($comment) ?></p>
  <p><strong>Date Created:</strong> <?= $reviewDate ?></p>
</div>

<div class="section">
  <h2>Product Details</h2>
  <p><strong>Name:</strong> <?= htmlspecialchars($product['ProductName']) ?></p>
  <p><strong>Price:</strong> R<?= $product['Price'] ?></p>
  <p><strong>Date Created:</strong> <?= $product['listingDate'] ?></p>
  <img src="<?= htmlspecialchars($imagePath) ?>" alt="Product Image">
  <br>
  <a href="product_detail.php?productid=<?= $productID ?>">View Product</a>
</div>

<div class="section">
  <h2>User Details</h2>
  <p><strong>Seller:</strong> <?= htmlspecialchars($userName) ?></p>
  <a href="user_detail.php?userid=<?= $userID ?>">View Seller Profile</a>
</div>

<div class="section">
  <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this review?');">
    <button type="submit" class = "btn" name = "deleteReviewButton">Delete Review</button>
  </form>
  <!--
  <a href="delete_review.php?reviewid=" class="btn" onclick="return confirm('Are you sure you want to delete this review?')">Delete Review</a>

  -->
</div>

<script>
    function Logout()
    {
        window.location.href = "treasure_hub_signup_or_login.php";
    }
        
    function HomeLink()
    {
        window.location.href = "treasure hub developer page home.php";
    }
</script>
</body>
</html>