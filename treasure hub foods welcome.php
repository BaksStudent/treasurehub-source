<?php
session_start();
include 'connect.php';
$loggedIn = isset($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foods Home Page</title>
    <link rel="stylesheet"href= "treasure hub foods welcome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>


 <header>
  <nav class = "MainNavbar">
  <button class = "MainLogo" onclick="MainCall()"style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "Treasure hub foods logo reduced 4.png" ></button>
  
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
    <form action="treasure hub foods searchpage.php" method="get" class="searchbar-form">
        <input type="text" class= "Search-Bar" placeholder="Search..." name="search">
        <button class = "SearchButton"><i class="fa-solid fa-magnifying-glass"></i></button>
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
        else{
          echo "categories not found";
        }
        ?>
  <div class = CategoryPlaceholder-Mobile>
    <p class="PlaceholderImage-mobile"><i class="fa-solid fa-computer" ></i> </p>
    <p>Placeholder</p>
</div>
  </div>
</nav>
 </header>

 <div class = "DesktopContainer">
  <div class = "SectionContainer">
    <section class = "recentlyAdded" id = "RecentlyAdded">
      <h4 class = "recentlyAddedTitle">Recently added</h4>
      <div class = recentlyAddedContainer>

       <?php
                $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE isSold = 0 ORDER BY ListingDate DESC LIMIT 4");
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                while ($row = mysqli_fetch_assoc($productQuery)) {
                    $placeholderPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";
                    $productId = $row['ProductID'];
                    $placeholderPicPath = "Images/".$row['ImagePath'];
                    $altText = $row['altText'];
                  
                  ?>
        <div class = "recentlyAddedItem" onclick="ShowProduct('<?php echo htmlspecialchars($row['ProductID'], ENT_QUOTES); ?>')">
          <img src = "<?php echo $placeholderPicPath ?>"  alt = "<?php echo $altText ?>">
          <h5 class = "recentlyAddedItemTitle"><?php echo htmlspecialchars($row['FoodName'])?></h5>
          <p class = "recentlyAddedItemPrice" ><?php echo number_format($row['Price'], 2)?></p>
        </div>
        <?php
                }
              }
              ?>
      </div>
     </section> 

     <div class = "MainBannerContainer" id ="mainbanner">
      <img class="mainbanner" src="Treasure hub banner image.png" onclick = MainCall()>
     </div>

     <!--This is the desktop for sale page-->
     <section class = "sellerSection" id = "forSale">
      <h4 class = "sellersSectionTitle">Try these</h4>
      <div class = sellerSectionContainer>
         <?php
                $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE isSold = 0 ORDER BY ListingDate DESC LIMIT 4");
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                while ($row = mysqli_fetch_assoc($productQuery)) {
                    $placeholderPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";
                    $productId = $row['ProductID'];
                    $placeholderPicPath = "Images/".$row['ImagePath'];
                    $altText = $row['altText'];
                  
                  ?>
        <div class = "sellersSectionItem" onclick="ShowProduct('<?php echo htmlspecialchars($row['ProductID'], ENT_QUOTES); ?>')">
          <img src = "<?php echo $placeholderPicPath ?>"  alt = "<?php echo $altText ?>">
          <h5 class = "sellersSectionItemitle"><?php echo $row['FoodName']?></h5>
        </div>
        <?php
                }
              }
        ?>
        
      </div>
     </section>
 
   </div>
  </div>

  <section class="recentlyAddedMobile" id = "recentlyAddedMobile">
    <p class = "recentlyAddedTitleMobile">Recently Added</p>
    <div class = "recentlyAddedContainerMobile">

     <?php
                $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE isSold = 0 ORDER BY ListingDate DESC LIMIT 4");
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                while ($row = mysqli_fetch_assoc($productQuery)) {
                    $placeholderPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";
                    $productId = $row['ProductID'];
                    $placeholderPicPath = "Images/".$row['ImagePath'];
                    $altText = $row['altText'];
                  
                  ?>
      <div class = "ItemPlaceholderMobile" onclick="ShowProduct('<?php echo htmlspecialchars($row['ProductID'], ENT_QUOTES); ?>')">
        <img src = "<?php echo $placeholderPicPath ?>"  alt = "<?php echo $altText ?>">
        <p class = "ItemTitleMobile"><?php echo htmlspecialchars($row['FoodName'])?></p>
        <p class = "ItemPriceMobile" ><?php echo number_format($row['Price'], 2)?></p>
      </div>
      <?php
                }
              }
      ?> 
    </div>    
   </section>
  
 <div class = "MainBannerContainerMobile" id ="mainbannermobile">
  <img class="mainbanner" src="Treasure hub banner image.png" onclick = MainCall()>
 </div>


 <section class="sellersSectionMobile" id = "forSaleMobile">
  <p class = "sellersSectionTitleMobile">Try these</p>
  <div class = "sellersSectionContainerMobile">

    <?php
                $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE isSold = 0 ORDER BY ListingDate DESC LIMIT 4");
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                while ($row = mysqli_fetch_assoc($productQuery)) {
                    $placeholderPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";
                    $productId = $row['ProductID'];
                    $placeholderPicPath = "Images/".$row['ImagePath'];
                    $altText = $row['altText'];
                  
                  ?>
        <div class = "sellersPlaceholderMobile" onclick="ShowProduct('<?php echo htmlspecialchars($row['ProductID'], ENT_QUOTES); ?>')">
          <img src = "<?php echo $placeholderPicPath ?>"  alt = "<?php echo $altText ?>" style="width: 60px;">
          <p class = "sellersItemMobile"><?php echo $row['FoodName']?></p>
        </div> 
        <?php
                }
              }
        ?>
    
  </div>    
 </section>
 
 


  <!--<div class = "MainNavbar">
    <div class = "MainLogo">
      <input type="image" src="placeholder logo.png" name="saveForm" class="btTxtsubmit" id="saveForm" />
    </div>
    <ul class = "links">
      <li><a href= "Help"> Help </a></li>
      <li><a href = "Menu"> Menu</a></li>
      <li><a href = "Cart"> <i class="fa-solid fa-cart-shopping"></i></a></li>
    </ul>
  </div>-->
 </header>

   <script src = "treasure hub foods welcome.js"></script>   
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
  function ToCart()
  {
    window.location.href = "treasure hub foods cart section.php"
  }
  function DisplayCategories(categoryName)
  {
    window.location.href = "treasure hub foods searchpage.php?Category="+categoryName;
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
                
      window.location.href = "Treasure hub foods product page.php";
      document.body.scrollTop = 0; // For Safari
      document.documentElement.scrollTop = 0;
      })
      .catch(error => {
      console.error('Error:', error);
      });
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
</body>
</html>