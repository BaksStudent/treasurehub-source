<?php
session_start();
include "connect.php";
$loggedIn = isset($_SESSION['email']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Review</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="Treasure hub product page.css">
  <link rel="stylesheet" href="reviewpage.css">
  <link rel="stylesheet"href= "treasure hub welcome.css">

</head>
<body>
    <header>  
      <nav class = "MainNavbar">
            <button class = "MainLogo" onclick="FoodsCall()" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "treasure hub logo reduced 4.png"></button>
       
            <div class ="Nav-links">
                <div class = "Acc-links" id = "Acc-links">
                    <button class = "Account-Buttons">Sign Up</button>
                    <button class = "Account-Buttons">Login</button>
                </div>
                <div class="Acc-Name" id = "Acc-Name">
                    <p>Hi <?php
                    if(isset($_SESSION['email']))
                    {
                        $email = $_SESSION['email'];
                        $query = mysqli_query($conn, "SELECT user.* FROM user WHERE user.Email ='$email'");
                        while($row = mysqli_fetch_array($query))
                        {
                            echo $row['FirstName'];
                        }
                    }

                    ?>
                    </p>
                </div>
            <form action="logout.php" method="post">
              <button type= "submit" class = "Nav-Buttons" name = "logoutButton" >Logout</button>
            </form>
            <div class = "Menu_Drop">
                <div>
                    <select name="OnChange" id="DROP">
                    <option value ="" selected disabled ><a class = "DropText">Menu
                    </a></option>
                      <option value = "Orders">Orders</option>
                      <option value="Account">Account</option>
                      <option value = "Queries">Queries</option>
                      <option value = "Home">Home</option>
                    </select>
      
                 </div>
            </div>
          <button class = "Nav-Buttons" onclick="ToCart()"><i class="fa-solid fa-cart-shopping"> </i></button>
        </div>
        <div class="menu-icon" onclick="toggleMobileMenu()">☰</i></div>
        <div class = "MobileMenu" id ="MobileMenu">
          <form action="logout.php" method="post">
              <button type= "submit" class = "Nav-Buttons-Mobile" name = "logoutButton" >Logout</button>
          </form>
          <button  class = "Nav-Buttons-Mobile" onclick="ToCart()"> <i class="fa-solid fa-cart-shopping"></i> Cart</button>
          <select name="OnChange" class = "MobileDropText" id="DROP_Mobile" >
            <option value ="" selected disabled ><a class = "DropText">Menu
            </a></option>
              <option value = "Orders">Orders</option>
              <option value="Account">Account</option>
              <option value = "Queries">Queries</option>
              <option value = "Home">Home</option>
          </select>
          <div class = "Acc-links-mobile" id = "Acc-links-mobile">
            <button class = "Account-Buttons-mobile">Sign Up</button>
            <button class = "Account-Buttons-mobile">Login</button> 
          </div>
          <div class = "Acc-Name-mobile" id = "Acc-Name-mobile">
            <p>Hi <?php
            if(isset($_SESSION['email']))
            {
                $email = $_SESSION['email'];
                $query = mysqli_query($conn, "SELECT user.* FROM user WHERE user.Email ='$email'");
                while($row = mysqli_fetch_array($query))
                {
                    echo $row['FirstName'].' '.$row['LastName'];
                }
            }
            ?>
            </p>
        </div>
    </div>
    </nav>
      
      <nav subNavBar>
         <form action="treasure hub searchpage.php" method="get">
            <div class="Main_Search">
                <input type="text" class= "Search-Bar" placeholder="Search..." name="search">
                <button class = "SearchButton" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
      </nav>
    </header>

<div class="container">
  <h1>Create Review</h1>

  <?php

   if (isset($_SESSION['edit_product_id'])) {
        $productId = $_SESSION['edit_product_id'];

        $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '$productId'");
    
        if ($productQuery && mysqli_num_rows($productQuery) > 0) 
        {
            $product = mysqli_fetch_assoc($productQuery);
            $productName = $product['ProductName'];
            $productDescription = $product['shortDescription'];
            $productPrice = $product['Price'];
            $sellerid = $product['SellerID'];
            $imageQuery = mysqli_query($conn, "SELECT * FROM productimages WHERE ProductID = '$productId' LIMIT 1");
            if ($image = mysqli_fetch_assoc($imageQuery)) {
                if (!empty($image['ImagePath'])) {
                    $imagePath = "Images/" . $image['ImagePath'];
                    $altText = $image['altText'];
                }
            }
        } 
        
        $sellerProfilePic = "placeholder logo.png";
        $sellerquery = mysqli_query($conn, "SELECT * FROM seller WHERE SellerID = '$sellerid'");
        if ($sellerquery && mysqli_num_rows($sellerquery) > 0) 
        {
            $seller = mysqli_fetch_assoc($sellerquery);
            $sellerProfilePic = "Images/".$seller['ProfilePicFile'];
            $sellerName = $seller['UserName'];

        }  
    }
            else echo "Product not set"
  ?>

  
  <!-- Seller Section -->
  <div class="seller-section">
    <img src="<?php echo $sellerProfilePic; ?>" alt="Seller Profile">
    <div class="seller-info"><?php echo htmlspecialchars($sellerName); ?></div>
  </div>

  <!-- Product Section -->
  <div class="product-details">
    <img src="<?php echo $imagePath; ?>" alt="<?php echo $altText; ?>">
    <h2><?php echo htmlspecialchars($productName); ?></h2>
    <p><?php echo htmlspecialchars($productDescription); ?></p>
  </div>

  <!-- Review Form -->
  <form action="submit_review.php" method="POST">
    <label for="rating">Rating (out of 10):</label>
    <input type="number" name="rating" id="rating" min="1" max="10" required>

    <label for="comment">Comment:</label>
    <textarea name="comment" id="comment" placeholder="Write your review..." required></textarea>

    <!-- Optional hidden IDs -->
    <input type="hidden" name="seller_id" value="<?php echo $sellerid; ?>">
     <input type="hidden" name="product_id" value="<?php echo $productId ; ?>">

    <input name = "Submit-Review" type="submit" value="Submit Review">
  </form>
</div>
<script>
  function FoodsCall()
  {
    window.location.href = "treasure hub foods welcome.php";
  }
  window.addEventListener("DOMContentLoaded", () => 
        {
          const isLoggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;
          const accLink = document.getElementById("Acc-links");
          const accName = document.getElementById("Acc-Name");
          const mobileAccLink = document.getElementById("Acc-links-mobile");
          const mobileAccName = document.getElementById("Acc-Name-mobile");


          if (isLoggedIn) 
          {
             accLink.style.display = "none";
             accName.style.display = "block";
             mobileAccLink.style.display = "none";
             mobileAccName.style.display = "block";
          } 
          else 
          {
            accLink.style.display = "flex";
            accName.style.display = "none";
            mobileAccLink.style.display = "flex";
            mobileAccName.style.display = "none";
          }
        });
  document.getElementById("DROP").onchange = function()
    {
        const isLoggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;
        if(isLoggedIn)
        {
          if(this.value === "Orders")
          {
            window.location.href = "order_list.php";
          }
          else if(this.value == "Account")
          {
            window.location.href = "treasure hub settings page.php";
          }
          else if(this.value == "Queries")
          {
            window.location.href = "queriesList.php";
          }
          else if(this.value == "Home")
          {
            window.location.href = "treasure_hub_welcome.php"
          }
        }
        else
        {
          window.location.href = "treasure_hub_signup_or_login.php";
        }
    };

    document.getElementById("DROP_Mobile").onchange = function()
    {
        const isLoggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;
        if(isLoggedIn)
        {
          if(this.value === "Orders")
          {
            window.location.href = "order_list.php";
          }
          else if(this.value == "Account")
          {
            window.location.href = "treasure hub settings page.php";
          }
          else if(this.value == "Queries")
          {
            window.location.href = "queriesList.php";
          }
          else if(this.value == "Home")
          {
            window.location.href = "treasure_hub_welcome.php"
          }
        }
        else
        {
          window.location.href = "treasure_hub_signup_or_login.php";
        }
    };


</script>

</body>
</html>