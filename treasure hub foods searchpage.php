<?php 
session_start();
include "connect.php";
$loggedIn = isset($_SESSION['email']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SearchPage</title>
    <link rel="stylesheet"href= "treasure hub foods welcome.css">
    <link rel="stylesheet" href="treasure hub foods searchpage.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

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
          <button  class = "Nav-Buttons-Mobile"> <i class="fa-solid fa-cart-shopping"></i> Cart</button>
          <select name="OnChange" class = "MobileDropText" id="DROP_Mobile" >
            <option value ="" selected disabled ><a class = "DropText">Menu
            </a></option>
            <option value = "Orders">Orders</option>
            <option value="Account">Account</option>
            <option value = "Queries">Queries</option>
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
          <form method="get" class = "searchbar-form">
            <div class = searchbar>
                <input type="text" name="search" class= "Search-Bar" placeholder="Search..."> <br>
                <?php
                    foreach ($_GET as $key => $value) {
                    if ($key !== 'search') {
                    echo "<input type='hidden' name='" . htmlspecialchars($key) . "' value='" . htmlspecialchars($value) . "'>";
                    }
                    }
                ?>
                <button type="submit" class = "SearchButton"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>  
          </form> 
        </div>
    </nav>
    
    <div class = "DesktopHeaderContainer">
      <nav class = "CategoryBar" id = "CategoryBar">
        <p class = CategoryText>Shop for categories:</p>
          <?php
          $categoryQuery = mysqli_query($conn, "SELECT * FROM food_categories");
          if ($categoryQuery && mysqli_num_rows($categoryQuery) > 0) {
          while ($row = mysqli_fetch_assoc($categoryQuery)) {
          ?>
          <div class = CategoryPlaceholder onclick="DisplayCategories('<?php echo $row['Name']?>')">
            <p class="PlaceholderImage"><i class="<?php echo $row['Iconlink'] ?>"></i> </p>
            <p><?php echo htmlspecialchars($row['DisplayName'])?></p>
          </div>
    <?php
          }
        }
        else{
          echo "categories not found";
        }
      ?>
    </nav>
  </div>

</header>
    
    
    <nav class = "CatergoryBar-Mobile" id = "CatergoryBar-Mobile">
        <p class = CategoryText-mobile>Shop for categories:</p>
        <div class = CategoryMobileRectangle>
          <?php
            $categoryQuery = mysqli_query($conn, "SELECT * FROM food_categories");
            if ($categoryQuery && mysqli_num_rows($categoryQuery) > 0) {
            while ($row = mysqli_fetch_assoc($categoryQuery)) {
          ?>
            <div class = CategoryPlaceholder-Mobile onclick="DisplayCategories('<?php echo $row['Name']?>')">
              <p class="PlaceholderImage-mobile"><i class="<?php echo $row['Iconlink'] ?>"></i> </p>
              <p><?php echo htmlspecialchars($row['DisplayName'])?></p>
            </div>
          <?php
            }
          }
        else
        {
          echo "categories not found";
        }
        ?>
  <div class = CategoryPlaceholder-Mobile>
    <p class="PlaceholderImage-mobile"><i class="fa-solid fa-computer" ></i> </p>
    <p>Placeholder</p>
</div>
  </div>
    </nav>
       <section class = "foodsContainer">
        <?php
          $search = isset($_GET['search']) ? trim($_GET['search']) : '';
          $filter = isset($_GET['Category']) ? $_GET['Category'] : '';
          $hasFilter = false;
          $where = "WHERE isSold = 0";

          
          if (!empty($filter)) 
          {
            $filter = strtolower($filter); // to handle URL case insensitivity
            if ($filter === 'produce') $where .= " AND CategoryID = 'produce'";
            else if ($filter === 'meat') $where .= " AND CategoryID = 'meat'";
            else if ($filter === 'dairy') $where .= " AND CategoryID = 'dairy'";
            else if ($filter === 'bakery') $where .= " AND CategoryID = 'bakery'";
            else if ($filter === 'pantry') $where .= " AND CategoryID = 'pantry'";
            else if ($filter === 'ready-to-eat') $where .= " AND CategoryID = 'ready-to-eat'";
            else if ($filter === 'condiments') $where .= " AND CategoryID = 'condiments'";
            else if ($filter === 'sweets') $where .= " AND CategoryID = 'sweets'";
            else if ($filter === 'beverages') $where .= " AND CategoryID = 'beverages'";
            else if ($filter === 'baby-kids') $where .= " AND CategoryID = 'baby-kids'";
            else if ($filter === 'pet-food') $where .= " AND CategoryID = 'pet-food'";
            $hasFilter = true;
          }

        if (!empty($search)) 
        {
            $searchEscaped = mysqli_real_escape_string($conn, $search);
            $where .= " AND (FoodName LIKE '%$searchEscaped%' OR Description LIKE '%$searchEscaped%')";
            $hasFilter = true;
        }

      $min = (isset($_GET['minPrice']) && is_numeric($_GET['minPrice'])) ? $_GET['minPrice'] : 0;
      $max = (isset($_GET['maxPrice']) && is_numeric($_GET['maxPrice'])) ? $_GET['maxPrice'] : PHP_INT_MAX;
      $where .= " AND Price BETWEEN $min AND $max";

      if (!is_null($min) || !is_null($max)) 
      {
          $min = $min ?? 0;
          $max = $max ?? PHP_INT_MAX;
          $where .= " AND Price BETWEEN $min AND $max";
          $hasFilter = true;
      }

      
      //$where $orderBy

      $listquery = mysqli_query($conn, "SELECT * FROM foodproduct $where");
      if ($listquery && mysqli_num_rows($listquery) > 0) {
                while ($row = mysqli_fetch_assoc($listquery)) {
                   $productId = $row["ProductID"];
                   $sellerId = $row["SellerID"];
                    $listingPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";
                    $listingPicPath = "Images/".$row['ImagePath'];
                    $altText = $row['altText'];

                    $sellerquery = mysqli_query($conn, "SELECT * FROM seller WHERE SellerID = '$sellerId'");
                    if ($seller = mysqli_fetch_assoc($sellerquery))
                    {
                        $userName = $seller['UserName'];
                    }

        ?>
        <div class = "foodsItemPlaceholder" onclick="ShowProduct(<?php echo $productId?>)">
                <div class = "foodsItemPlaceholder-imageContainer">
                       <img src="<?php echo $listingPicPath ?>" alt="<?php echo $altText ?>">
                </div>
                <div class = "foodsItemPlaceholder-nameContainer">
                    <p><?php echo htmlspecialchars($row['FoodName'])?></p>
               </div>
               <div class = "foodsItemPlaceholder-SellerNameContainer">
                <p><?php echo htmlspecialchars($userName)?></p>
              </div>
              <div class = "foodsItemPlaceholder-PriceContainer">
                <p><?php echo number_format($row['Price'], 2)?></p>
              </div>
        </div>
        <?php
                }
              }
        ?>

         <div class = "foodsItemPlaceholder">
            
                 <div class = "foodsItemPlaceholder-imageContainer">
                   <img src="placeholder logo.png" alt="">
                 </div>
                 <div class = "foodsItemPlaceholder-nameContainer">
                    <p>Item Name</p>
                 </div>
                 <div class = "foodsItemPlaceholder-SellerNameContainer">
                   <p>Item Name</p>
                 </div>
                 <div class = "foodsItemPlaceholder-PriceContainer">
                   <p>Item Name</p>
              </div>
         </div>

       </section>
        
          
      <script src="treasure hub foods searchpage.js"></script>
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>  
      <script>
        function register()
        {
          window.location.href = "treasure_hub_signup_or_login.php?showDiv=signup";
        }
        function login()
        {
          window.location.href = "treasure_hub_signup_or_login.php";
        }
        function DisplayCategories(categoryName)
        {
            window.location.href = "treasure hub foods searchpage.php?Category="+categoryName;
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
                
                    window.location.href = "Treasure hub foods product page.php";
                    document.body.scrollTop = 0; // For Safari
                    document.documentElement.scrollTop = 0;
                })
                .catch(error => {
                console.error('Error:', error);
                });
        }

        function ToCart()
        {
          window.location.href = "treasure hub foods cart section.php";
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
        }
        else
        {
          window.location.href = "treasure_hub_signup_or_login.php";
        }
    };
      </script>
      </body>
      </html>
  