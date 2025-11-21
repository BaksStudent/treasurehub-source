<?php
session_start();
include "connect.php";
$loggedIn = isset($_SESSION['email']);
?>
<!DOCTYPE html>
<html lang="en">
  <meta charset="UTF-8">
  <title>My Cart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="cart section.css">
  <link rel="stylesheet" href="treasure hub foods welcome.css">
  <style>
    Body{
        background-color: rgba(255, 51, 0,0.2);
    }
  </style>
</head>
<body>
    <header>
        <nav class = "MainNavbar">
          <button class = "MainLogo" onclick="MainCall()" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "Treasure hub foods logo reduced 4.png" ></button>
 
          <div class ="Nav-links">
   
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
          <button class = "Nav-Buttons" onclick="ToCart()"><i class="fa-solid fa-cart-shopping"> </i></button>
        </div>
        <div class="menu-icon" onclick="toggleMobileMenu()">☰</i></div>
            <div class = "MobileMenu" id ="MobileMenu">
              <form action="logout.php" method="post">
                  <button type= "submit" class = "Nav-Buttons-Mobile" name = "foodlogoutButton" >Logout</button>
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
       <nav subNavBar>
        <div class="Main_Search">
          <form action="treasure hub foods searchpage.php" method="get" class="searchbar-form">
            <input type="text" class= "Search-Bar" placeholder="Search..." name="search">
            <button class = "SearchButton"><i class="fa-solid fa-magnifying-glass"></i></button>
          </form>
        </div>
      </nav>

    </header>
  
  <h1>Shopping Cart</h1>

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
            echo "<p>Please log in to view your cart.</p>";
        }
        ?>
    </div>

     <?php

        $totalPrice = 0;

        if (isset($_SESSION['email'])) 
        {
          $email = $_SESSION['email'];


          $userQuery = mysqli_query($conn, "SELECT UserID FROM user WHERE Email = '$email'");
          if ($userQuery && mysqli_num_rows($userQuery) > 0) 
          {
            $user = mysqli_fetch_assoc($userQuery);
            $userId = $user['UserID'];

        
            $cartQuery = mysqli_query($conn, "SELECT c.Quantity, p.Price FROM foodcart c
                                          JOIN foodproduct p ON c.ProductID = p.ProductID
                                          WHERE c.UserID = '$userId'");

            if ($cartQuery && mysqli_num_rows($cartQuery) > 0)
            {
                while ($item = mysqli_fetch_assoc($cartQuery)) 
                {
                  $totalPrice += $item['Quantity'] * $item['Price'];
                }
            } 
          }
        }
      ?>

        <div class="cart-summary">
            <h3>Cart Summary</h3>
            <p class="total">Total Price: <strong>R <?php echo number_format($totalPrice, 2); ?></strong></p>
            <button class="checkout-btn" onclick="ToCheckout()">Proceed to Checkout</button>
        </div>
    </div>
    <script src="mobileOptimizer.js"></script>
    <script>
      function MainCall()
      {
        window.location.href = "treasure_hub_welcome.php";
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
      function ToCheckout()
      {
        window.location.href = "foodcheckout.php";
      }
    </script>
</body>
</html>