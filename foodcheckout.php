<?php
session_start();
$loggedIn = isset($_SESSION['email']);
include 'connect.php'; 

$totalPrice = 0;
$deliveryFee = 45.00;
$userId = null;

$totalPrice = 0;
$deliveryFee = 45.00;
$userId = null;

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $userQuery = mysqli_query($conn, "SELECT UserID FROM user WHERE Email = '$email'");
    if ($userQuery && mysqli_num_rows($userQuery) > 0) {
        $user = mysqli_fetch_assoc($userQuery);
        $userId = $user['UserID'];
        $cartQuery = mysqli_query($conn, "SELECT c.Quantity, p.Price FROM foodcart c JOIN foodproduct p ON c.ProductID = p.ProductID WHERE c.UserID = '$userId'");
        if ($cartQuery && mysqli_num_rows($cartQuery) > 0) {
            while ($item = mysqli_fetch_assoc($cartQuery)) {
                $totalPrice += $item['Quantity'] * $item['Price'];
            }
        }
    }
}
$totalWithDelivery = $totalPrice + $deliveryFee;
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>Checkout Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"href= "treasure hub foods welcome.css">
    <link rel="stylesheet"href= "foodcheckout.css">
    <link rel="stylesheet" href="cart section.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <nav class = "MainNavbar">
        <button class = "MainLogo" onclick="MainCall()"><img src = "Treasure hub foods logo reduced 4.png" ></button>
        
        <div class ="Nav-links">
          <div class = "Acc-links" id = "Acc-links">
            <button class = "Account-Buttons">Sign Up</button>
            <button class = "Account-Buttons">Login</button>
          </div>
          <div class="Acc-Name" id = "Acc-Name">
            <p>
            Hi <?php
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
              <button type= "submit" class = "Nav-Buttons" name = "foodlogoutButton" >Logout</button>
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
          <button class = "Nav-Buttons"><i class="fa-solid fa-cart-shopping"> </i></button>
        </div>
        <div class="menu-icon" onclick="toggleMobileMenu()">☰</i></div>
        <div class = "MobileMenu" id ="MobileMenu">
          <form action="logout.php" method="post">
            <button type= "submit" class = "Nav-Buttons-Mobile" name = "foodlogoutButton" >Logout</button>
          </form>
          <button  class = "Nav-Buttons-Mobile"> <i class="fa-solid fa-cart-shopping"></i> Cart</button>
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
          <p>
              Hi <?php
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
    </header>
<div class="back-button">
    <a href="treasure hub cart section.php">&larr; Back to Cart</a>
</div>



<div class="checkout-container">
    <!-- LEFT SECTION -->
    <div class="left-section">
      <div class="cart-container">
        <?php

        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];  
            $userid = 0;

            $query = mysqli_query($conn, "SELECT * FROM user WHERE Email = '$email'");
            
            if ($query && mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_assoc($query);
                $userid = $row['UserID'];

                $checkCart = mysqli_query($conn, "SELECT * FROM foodcart WHERE UserID = '$userid'");
                if ($checkCart && mysqli_num_rows($checkCart) > 0) {
                    while ($cart = mysqli_fetch_assoc($checkCart)) {
                        $cart_productID = $cart['ProductID'];

                        $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE ProductID = '$cart_productID'");
                        if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                            while ($product = mysqli_fetch_assoc($productQuery)) {
                                $listingPicPath = "placeholder logo.png";
                                $altText = "Product Image";
                                $listingPicPath = "Images/" . $product['ImagePath'];
                                $altText = $product['altText'];
        ?>
                                <div class="cart-item">
                                    <img src="<?php echo $listingPicPath; ?>" alt="<?php echo htmlspecialchars($altText); ?>">

                                    <div class="cart-item-details">
                                        <h4><?php echo htmlspecialchars($product['FoodName']); ?></h4>
                                        <p><?php echo htmlspecialchars($product['Description']); ?></p>
                                    </div>

                                    <div class="cart-item-actions">
                                        <div class="price">R <?php echo number_format($product['Price'], 2); ?></div>
                                        <form method="post" >
                                            <input type="hidden" name="product_id" value="<?php echo $cart_productID; ?>">
                                            <input type="number" name="quantity" value="<?php echo $cart['Quantity']; ?>" min="1">
                                        </form>
                                        <form method="post" action="foodcartFunctions.php">
                                            <input type="hidden" name="product_id" value="<?php echo $cart_productID; ?>">
                                            <button type="submit" name="cartdelete" class="delete-btn">Delete</button>
                                        </form>
                                    </div>
                                </div>
        <?php
                            }
                        }
                    }
                } else {
                    echo "<p>Your cart is empty.</p>";
                }
            } else {
                echo "<p>User not found.</p>";
            }
        } else {
            echo "<p>Please log in for checkout.</p>";
        }
        ?>
    </div>
        <!-- Address Dropdown -->
        <div class="dropdown-section">
            <div class="dropdown-header" onclick="toggleDropdown('addressContent')">Address Information</div>
            <div class="dropdown-content" id="addressContent">
                <form action="save_address_foods.php" method="POST">

                    <div class="form-group">
                        <label for="ship-address">Enter address:</label>
                        <input type="text" id="ship-address" name="ship-address" required autocomplete="off">
                    </div>
<!--
                    <div class="form-group">
                        <label for="street">Street Address:</label>
                        <input type="text" name="street" id="street" placeholder="123 Main Street">
                    </div>
-->

                    <div class="form-group">
                        <label for="locality">City:</label>
                        <input type="text" id="locality" name="locality" required>
                    </div>

                    <div class="form-group">
                        <label for="postcode">PO Box:</label>
                        <input type="text" id="postcode" name="postcode" required>
                    </div>

                    <input type="hidden" name="userid" value="<?php echo $userId; ?>">

                    <button type="submit" class = "cartbutton">Save Address</button>
                </form>
            </div>
        </div>

        <!-- Payment Dropdown -->
        <div class="dropdown-section">
            <div class="dropdown-header" onclick="toggleDropdown('paymentContent')">Payment Information</div>
            <div class="dropdown-content" id="paymentContent">
                <form method="POST" action="Process_payment_foods.php">
                    <!-- SELECTED ADDRESS -->
            <div class="form-group">
                <label for="savedAddress">Select a saved address:</label>
                <select name="address_id" id="savedAddress" required>
                    <option value="">-- Select --</option>
                    <?php
                    $addressQuery = mysqli_query($conn, "SELECT * FROM address WHERE UserID = '$userId'");
                    while ($addr = mysqli_fetch_assoc($addressQuery)) {
                        $display = "{$addr['StreetAddress']}, {$addr['City']}, PO Box: {$addr['POBox']}";
                        echo "<option value='{$addr['AddressID']}'>$display</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- PAYMENT FIELDS -->
            <div class="form-group">
                <label>Cardholder Name</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Card Number</label>
                <input type="text" name="card" maxlength="16" required>
            </div>

            <div class="form-group">
                <label>Expiry Date (MM/YY)</label>
                <input type="text" name="expiry" placeholder="MM/YY" required>
            </div>

            <div class="form-group">
                <label>CVV</label>
                <input type="password" name="cvv" maxlength="3" required>
            </div>

            <button type="submit" class = "foodcartbutton">Pay Now</button>
                </form>
            </div>
        </div>
    </div>

    <!-- RIGHT SECTION -->
    <div class="right-section">
        <div class="cart-summary">
            <h3>Cart Summary</h3>
            <?php
            $totalPrice = 0;
            $deliveryFee = 45;
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
                $userQuery = mysqli_query($conn, "SELECT UserID FROM user WHERE Email = '$email'");
                if ($userQuery && mysqli_num_rows($userQuery) > 0) {
                    $user = mysqli_fetch_assoc($userQuery);
                    $userId = $user['UserID'];
                    $cartQuery = mysqli_query($conn, "SELECT c.Quantity, p.Price FROM foodcart c JOIN foodproduct p ON c.ProductID = p.ProductID WHERE c.UserID = '$userId'");
                    if ($cartQuery && mysqli_num_rows($cartQuery) > 0) {
                        while ($item = mysqli_fetch_assoc($cartQuery)) {
                            $totalPrice += $item['Quantity'] * $item['Price'];
                        }
                    }
                }
            }
            $totalWithDelivery = $totalPrice + $deliveryFee;
            ?>
            <p>Items Total: <strong>R <?php echo number_format($totalPrice, 2); ?></strong></p>
            <p>Delivery Fee: <strong>R <?php echo number_format($deliveryFee, 2); ?></strong></p>
            <p><strong>Total: R <?php echo number_format($totalWithDelivery, 2); ?></strong></p>
            <!--
            <form action="confirm_checkout.php" method="POST">
                <input type="submit" class="checkout-btn" value="Confirm Checkout">
            </form>
        -->
        </div>
    </div>
</div>

<script type="module" src="autocomplete.js"></script>
<script>
  function MainCall()
  {
    window.location.href = "treasure_hub_welcome.php";
  }
    function toggleDropdown(id) 
    {
        const content = document.getElementById(id);
        content.style.display = content.style.display === 'block' ? 'none' : 'block';
    }
    document.getElementById("DROP").onchange = function()
    {
        const isLoggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;
        if(isLoggedIn)
        {
          if(this.value === "Orders")
          {
            window.location.href = "foodsorder_list.php";
          }
          else if(this.value == "Account")
          {
            window.location.href = "treasure hub settings page.php";
          }
          else if(this.value == "Queries")
          {
            window.location.href = "foodqueriesList.php";
          }
          else if(this.value == "Home")
          {
            window.location.href = "treasure hub foods welcome.php"
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
            window.location.href = "foodsorder_list.php";
          }
          else if(this.value == "Account")
          {
            window.location.href = "treasure hub settings page.php";
          }
          else if(this.value == "Queries")
          {
            window.location.href = "foodqueriesList.php";
          }
          else if(this.value == "Home")
          {
            window.location.href = "treasure hub foods welcome.php"
          }
        }
        else
        {
          window.location.href = "treasure_hub_signup_or_login.php";
        }
    };
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
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnWC2pgSYiQ4P8pLZih-fCRevQDaP6Yg8&libraries=places"></script>
<script src="mobileOptimizer.js"></script>

</body>
</html>
