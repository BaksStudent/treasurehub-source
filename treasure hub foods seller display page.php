<?php
session_start();
include "connect.php";
$loggedIn = isset($_SESSION['email']);


 if (isset($_SESSION['view_sellerid'])) 
    {

        $sellerId = $_SESSION['view_sellerid'];
        $sellerQuery = mysqli_query($conn, "SELECT * FROM seller WHERE SellerID = '$sellerId'");
        $sellerProfilePic = "placeholder logo.png";
        $sellerBannerPic = "placeholder logo.png";
        if ($sellerQuery && mysqli_num_rows($sellerQuery) > 0) 
        {
            $seller = mysqli_fetch_assoc($sellerQuery);
            $disp_sellername = $seller['UserName'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $disp_sellername?></title>
    <link rel="stylesheet" href="treasure hub foods welcome.css">
    <link rel="stylesheet" href="treasure hub foods seller page.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php if (isset($_GET['log']) && $_GET['log'] === 'reported'): ?>
        <div class="notification-banner">
            <p>✅ The seller has been successfully reported.</p>
        </div>
    <?php endif; ?>

    <header>
        <nav class = "MainNavbar">
        <button class = "MainLogo" onclick="MainCall()" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "Treasure hub foods logo reduced 4.png" ></button>
        
        <div class ="Nav-links">
          <div class = "Acc-links" id = "Acc-links">
            <button class = "Account-Buttons" onclick="register()">Sign Up</button>
            <button class = "Account-Buttons" onclick="login()">Login</button>
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
          <button class = "Nav-Buttons" onclick="ToCart()"><i class="fa-solid fa-cart-shopping"> </i></button>
        </div>
        <div class="menu-icon" onclick="toggleMobileMenu()">☰</i></div>
        <div class = "MobileMenu" id ="MobileMenu">
          <form action="logout.php" method="post">
            <button type= "submit" class = "Nav-Buttons" name = "foodlogoutButton" >Logout</button>
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
            <button class = "Account-Buttons-mobile" onclick="register()">Sign Up</button>
            <button class = "Account-Buttons-mobile" onclick="login()">Login</button>
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
      <nav subNavBar>
        <div class="Main_Search">
          <form action="treasure hub foods searchpage.php" method="get" class = "searchbar-form">
                <input type="text" name="search" class= "Search-Bar" placeholder="Search...">
                <button class = "SearchButton"><i class="fa-solid fa-magnifying-glass"></i></button>
          </form>
        </div>
      </nav>
    </header> 

    <?php
        if (isset($_SESSION['view_sellerid'])) 
        {

            $sellerId = $_SESSION['view_sellerid'];
            $sellerQuery = mysqli_query($conn, "SELECT * FROM seller WHERE SellerID = '$sellerId'");
            $sellerProfilePic = "placeholder logo.png";
            $sellerBannerPic = "placeholder logo.png";
            if ($sellerQuery && mysqli_num_rows($sellerQuery) > 0) 
            {
                $seller = mysqli_fetch_assoc($sellerQuery);
                $sellerProfilePic = "Images/" .$seller['ProfilePicFile'];
                $disp_sellername = $seller['UserName'];
                $disp_Description = $seller['Description'];
                if (is_null($seller['BannerImage'])) 
                {
        
                } 
                else 
                {
                    $sellerBannerPic = "Images/" .$seller['BannerImage'];
                }
                if (is_null($seller['ProfilePicFile'])) 
                {
                    $sellerProfilePic = "placeholder logo.png";
                }
            }
            else{
                echo "seller does not exist";
            }
        }
        else
        {
            echo "seller id not found";
        }
        ?>
    
    <section class = "mobileBackground" id ="mobileBackground">
        <div class="mobileSellerbanner-container">
            <div class="mobileSellerbanner">
               <img src="<?php echo $sellerBannerPic?>" alt="banner image" class="ba">
            </div>
            <img src="<?php echo $sellerProfilePic ?>" alt="Circle" class="mobilecircle-image">
        </div>
        <div class = "mobileSellerNameContainer">
            <p><?php echo $disp_sellername ?></p>
        </div>
        <div class="mobileSellerDescriptionContainer">
            <p><?php echo $disp_Description ?></p>
        </div>
       
        <div class = "PlaceholderSliderContainer" id="SellerForSaleSection">
            <div class = "PlaceholderSliderContainer-title">
                <p>Products for sale</p>
            </div>
            <div class = "PlaceholderSliderContainer-contentSection">
                 <?php
                 $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE isSold = 0 AND SellerID = $sellerId");
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                while ($row = mysqli_fetch_assoc($productQuery)) {
                    $placeholderPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";
                    $productId = $row['ProductID'];
                    $placeholderPicPath = "Images/" . $row['ImagePath'];
                    $altText = $row['altText'];
                ?>
                <div class="PlaceholderSliderItemPlaceholder">
                    <div class = "PlaceholderSliderItemPlaceholder-imageContainer">
                        <img src="<?php echo $placeholderPicPath ?>" alt="<?php echo $altText ?>">
                    </div>
                    <div class = "PlaceholderSliderItemPlaceholder-wordsContainer">
                        <div class = "wordsContainer-Title">
                            <p><?php echo htmlspecialchars($row['FoodName'])?></p>
                        </div>
                        <div class = "priceContainer-Title">
                            <p><?php echo number_format($row['Price'], 2)?></p>
                        </div>
                    </div>
                </div>
                <?php
                }
            }
                ?>
    
            </div>
    
        </div>
       <div class = "PlaceholderSliderContainer" id="SellerSoldSection">
            <div class = "PlaceholderSliderContainer-title">
                <p>Items sold</p>
            </div>
            <div class = "PlaceholderSliderContainer-contentSection">
                <?php
                 $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE isSold = 1 AND SellerID = $sellerId");
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                while ($row = mysqli_fetch_assoc($productQuery)) {
                    $placeholderPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";
                    $productId = $row['ProductID'];
                    $placeholderPicPath = "Images/" . $row['ImagePath'];
                    $altText = $row['altText'];
                    
                ?>
                <div class="PlaceholderSliderItemPlaceholder">
                    <div class = "PlaceholderSliderItemPlaceholder-imageContainer">
                        <img src="<?php echo $placeholderPicPath?>" alt="<?php htmlspecialchars($altText)?>">
                    </div>
                    <div class = "PlaceholderSliderItemPlaceholder-wordsContainer">
                        <div class = "wordsContainer-Title">
                            <p><?php echo htmlspecialchars($row['FoodName'])?></p>
                        </div>
                        <div class = "soldContainer-Title">
                            <p>Sold</p>
                        </div>
                    </div>
                </div>
                <?php
                }
            } else echo '<p class = "noResultsText"> No items sold yet :) </p>';
            ?>
            </div>
        </div>
        <?php
        if($loggedIn == true)
        {
            ?>
            <nav class="reportUserContainer">
                <button onclick="reportUser('<?php echo htmlspecialchars($seller['SellerID'])?>')">Report user</button>
            </nav>
            
            <?php
        }
         ?>
    </section>
    
    <section class = "desktopBackground" id = "desktopBackground">

        <div class="Sellerbanner-container">
            <div class="Sellerbanner">
             
               <img src="<?php echo $sellerBannerPic?>" alt="banner image" class="ba">
            </div>
            <img src="<?php echo $sellerProfilePic ?>" alt="Circle" class="circle-image">
        </div>
    
        <div class="mainDetailsContainers">
            <div class="buttonContainer">
                
            </div>
            <div class = "mainDetailsContainers-textContainer">
                <div class="PlaceholderandRatingContainer">
                        <div class="SellerNameContainer">
                            <p><?php echo $disp_sellername ?></p>
                        </div>
                        <div class = "SellerverifiedContainer">
                        <?php if($seller['Verified'] == 0)
                        {

                        }
                        else
                        {
                            echo '<p><i class="fa-solid fa-certificate"></i> Verfied</p>';
                        }
                        ?>
                        </div>
                </div>
                <div class = sellerDescriptionConatiner>
                    <p><?php echo $disp_Description ?></p><br>
                </div>
    
            </div>
        </div>
    
    
    
        <div class = "PlaceholderSliderContainer" id="SellerForSaleSection">
            <div class = "PlaceholderSliderContainer-title">
                <p>Products for sale</p>
            </div>
            <div class = "PlaceholderSliderContainer-contentSection">
                <?php
                 $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE isSold = 0 AND SellerID = $sellerId");
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                while ($row = mysqli_fetch_assoc($productQuery)) {
                    $placeholderPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";
                    $productId = $row['ProductID'];
                    $placeholderPicPath = "Images/" . $row['ImagePath'];
                    $altText = $row['altText'];
                ?>
                <div class="PlaceholderSliderItemPlaceholder">
                    <div class = "PlaceholderSliderItemPlaceholder-imageContainer">
                        <img src="<?php echo $placeholderPicPath ?>" alt="<?php echo $altText ?>">
                    </div>
                    <div class = "PlaceholderSliderItemPlaceholder-wordsContainer">
                        <div class = "wordsContainer-Title">
                            <p><?php echo htmlspecialchars($row['FoodName'])?></p>
                        </div>
                        <div class = "priceContainer-Title">
                            <p><?php echo number_format($row['Price'], 2)?></p>
                        </div>
                    </div>
                </div>
                <?php
                }
            }
                ?>
    
            </div>
    
        </div>
         <?php
        if($loggedIn == true)
        {
            ?>
            <nav class="reportUserContainer">
                <button onclick="reportUser('<?php echo htmlspecialchars($seller['SellerID'])?>')">Report user</button>
            </nav>
            <?php
        }

        ?>
        
        

    </section>
    <script src="treasure hub seller page.js"></script>
    <script>
    function MainCall()
    {
        window.location.href = "treasure_hub_welcome.php";
    }
    function ToCart()
    {
        window.location.href = "treasure hub foods cart section.php"
    }
    function register()
    {
        window.location.href = "treasure_hub_signup_or_login.php?showDiv=signup";
    }
    function login()
    {
        window.location.href = "treasure_hub_signup_or_login.php";
    }
    function reportUser(seller)
    {
        window.location.href = "foodsreportUserPage.php?seller="+seller;
    }
    function ShowProduct(productID)
    {
        fetch('set_product_session.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'productId=' + encodeURIComponent(productID)
        })
        .then(response => response.text())
        .then(data => {
                
            window.location.href = "Treasure hub product page.php";
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0;
        })
        .catch(error => {
        console.error('Error:', error);
        });
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
    </script>
</body>
</html>
