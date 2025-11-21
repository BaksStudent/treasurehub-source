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
    <title>Home Page</title>
    <link rel="stylesheet"href= "treasure hub welcome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>


<header>
   <nav class = "MainNavbar">
  <button class = "MainLogo" onclick="FoodsCall()" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "treasure hub logo reduced 4.png" ></button>
 
 <div class ="Nav-links">
   
    <div class = "Acc-links" id = "Acc-links">
      <button class = "Account-Buttons" onclick= "register()">Sign Up</button>
      <button class = "Account-Buttons" onclick= "login()">Login</button>
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
      <button class = "Account-Buttons-mobile" onclick= "register()">Sign Up</button>
      <button class = "Account-Buttons-mobile" onclick= "login()">Login</button> 
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
  <form action="treasure hub searchpage.php" method="get">
    <div class="Main_Search">
      <input type="text" class= "Search-Bar" placeholder="Search..." name="search">
      <button class = "SearchButton" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
  </form>
</nav>
<div class = "DesktopHeaderContainer">
  <nav class = "CategoryBar" id = "CategoryBar">
    <p class = CategoryText>Shop for categories:</p>
    <?php
          $categoryQuery = mysqli_query($conn, "SELECT * FROM categories");
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

<!---
<div class = "WelcomePlaceholder">
  <p class="WelcomeParagraph">Welcome <a class = "NameText"> (placeholder)</a></p>
</div>-->


<nav class = "CatergoryBar-Mobile" id = "CatergoryBar-Mobile">
  <p class = CategoryText-mobile>Shop for categories:</p>
  <div class = CategoryMobileRectangle>
    <?php
          $categoryQuery = mysqli_query($conn, "SELECT * FROM categories");
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
  </div>
</nav>
 </header>

 <div class = "DesktopContainer">
  <div class = "SectionContainer">
    <section class = "recentlyAdded" id = "RecentlyAdded">
      <h4 class = "recentlyAddedTitle">Recently added</h4>

      
      <div class = recentlyAddedContainer>
        <?php
                $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE isSold = 0 ORDER BY listingDate DESC LIMIT 4");
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                while ($row = mysqli_fetch_assoc($productQuery)) {
                    $placeholderPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";
                    $productId = $row['ProductID'];
                    $imageQuery = mysqli_query($conn, "SELECT * FROM productimages WHERE ProductID = '$productId' LIMIT 1");
                    if ($imageQuery && mysqli_num_rows($imageQuery) > 0) {
                        $imgRow = mysqli_fetch_array($imageQuery);
                        if (!empty($imgRow['ImagePath'])) {
                            $placeholderPicPath = "Images/" . $imgRow['ImagePath'];
                            $altText = $imgRow['altText'];
                        }
                    }
                  
                  ?>
                  <div class = "recentlyAddedItem" onclick="ShowProduct('<?php echo htmlspecialchars($row['ProductID'], ENT_QUOTES); ?>')">
                    <img src = "<?php echo $placeholderPicPath ?>"  alt = "<?php echo htmlspecialchars($altText)?>">
                    <h5 class = "recentlyAddedItemTitle"><?php echo htmlspecialchars($row['ProductName'])?></h5>
                    <p class = "recentlyAddedItemDescription"><?php echo htmlspecialchars($row['shortDescription'])?></p>
                    <p class = "recentlyAddedItemPrice" >R<?php echo htmlspecialchars($row['Price'])?></p>
                  </div>
                  <?php
                  }
                }
            ?>

            <div class="viewAllContainer" onclick="SearchPageRecently()">
                <button class="viewAllButton">
                  View All
                <span class="arrowCircle">
                  ➔
                </span>
                </button>
            </div>
      </div>
     </section> 

     <div class = "foodsBannerContainer" id ="foodsbanner">
      <img class="foodsbanner" src="Treasure hub foods banner image.png" onclick = FoodsCall()>
     </div>

     <!--This is the desktop for sale page-->
     <section class = "recentlyAdded" id = "forSale">
      <h4 class = "recentlyAddedTitle">View all</h4>
      <div class = recentlyAddedContainer>
        <?php
                $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE isSold = 0 ORDER BY listingDate LIMIT 4");
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                while ($row = mysqli_fetch_assoc($productQuery)) {
                    $placeholderPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";
                    $productId = $row['ProductID'];
                    $imageQuery = mysqli_query($conn, "SELECT * FROM productimages WHERE ProductID = '$productId' LIMIT 1");
                    if ($imageQuery && mysqli_num_rows($imageQuery) > 0) {
                        $imgRow = mysqli_fetch_array($imageQuery);
                        if (!empty($imgRow['ImagePath'])) {
                            $placeholderPicPath = "Images/" . $imgRow['ImagePath'];
                            $altText = $imgRow['altText'];
                        }
                    }
                  
                  ?>
                  <div class = "recentlyAddedItem" onclick="ShowProduct('<?php echo htmlspecialchars($row['ProductID'], ENT_QUOTES); ?>')">
                    <img src = "<?php echo $placeholderPicPath ?>"  alt = "<?php echo htmlspecialchars($altText)?>">
                    <h5 class = "recentlyAddedItemTitle"><?php echo htmlspecialchars($row['ProductName'])?></h5>
                    <p class = "recentlyAddedItemDescription"><?php echo htmlspecialchars($row['shortDescription'])?></p>
                    <p class = "recentlyAddedItemPrice" >R<?php echo htmlspecialchars($row['Price'])?></p>
                  </div>
                  <?php
                  }
                }
            ?>

            <div class="viewAllContainer" onclick="SearchPage()">
                <button class="viewAllButton">
                  View All
                <span class="arrowCircle">
                  ➔
                </span>
                </button>
            </div>
       
      </div>
     </section>
 
   </div>
  </div>

  <section class="recentlyAddedMobile" id = "recentlyAddedMobile">
    <p class = "recentlyAddedTitleMobile">Recently Added</p>
    <div class = "recentlyAddedContainerMobile">
      <?php
                $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE isSold = 0 ORDER BY ProductName LIMIT 4");
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                while ($row = mysqli_fetch_assoc($productQuery)) {
                    $placeholderPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";
                    $productId = $row['ProductID'];
                    $imageQuery = mysqli_query($conn, "SELECT * FROM productimages WHERE ProductID = '$productId' LIMIT 1");
                    if ($imageQuery && mysqli_num_rows($imageQuery) > 0) {
                        $imgRow = mysqli_fetch_array($imageQuery);
                        if (!empty($imgRow['ImagePath'])) {
                            $placeholderPicPath = "Images/" . $imgRow['ImagePath'];
                            $altText = $imgRow['altText'];
                        }
                    }
                  
                  ?>
     
      <div class = "ItemPlaceholderMobile"  onclick="ShowProduct('<?php echo htmlspecialchars($row['ProductID'], ENT_QUOTES); ?>')">
        <img src = "<?php echo $placeholderPicPath ?>"  alt = "<?php echo htmlspecialchars($altText)?>">
        <p class = "ItemTitleMobile"><?php echo htmlspecialchars($row['ProductName'])?></p>
        <p class = "ItemDescriptionMobile"><?php echo htmlspecialchars($row['shortDescription'])?></p>
        <p class = "ItemPriceMobile" >R<?php echo htmlspecialchars($row['Price'])?></p>
      </div> 

    <?php
                }
              } 
    ?>

      <div class="viewAllContainer" onclick="SearchPageRecently()">
        <button class="viewAllButton">
          View All
          <span class="arrowCircle">
          ➔
          </span>
        </button>
      </div>
    </div>    
   </section>
  
 <div class = "foodsBannerContainerMobile" id ="foodsbannermobile">
  <img class="foodsbanner" src="Treasure hub foods banner image.png" onclick = FoodsCall()>
 </div>


 <section class="recentlyAddedMobile" id = "forSaleMobile">
  <p class = "recentlyAddedTitleMobile">For Sale</p>
  <div class = "recentlyAddedContainerMobile">
    <?php
                $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE isSold = 0 ORDER BY ProductName LIMIT 4");
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                while ($row = mysqli_fetch_assoc($productQuery)) {
                    $placeholderPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";
                    $productId = $row['ProductID'];
                    $imageQuery = mysqli_query($conn, "SELECT * FROM productimages WHERE ProductID = '$productId' LIMIT 1");
                    if ($imageQuery && mysqli_num_rows($imageQuery) > 0) {
                        $imgRow = mysqli_fetch_array($imageQuery);
                        if (!empty($imgRow['ImagePath'])) {
                            $placeholderPicPath = "Images/" . $imgRow['ImagePath'];
                            $altText = $imgRow['altText'];
                        }
                    }
                  
                  ?>
     
      <div class = "ItemPlaceholderMobile"  onclick="ShowProduct('<?php echo htmlspecialchars($row['ProductID'], ENT_QUOTES); ?>')">
        <img src = "<?php echo $placeholderPicPath ?>"  alt = "<?php echo htmlspecialchars($altText)?>">
        <p class = "ItemTitleMobile"><?php echo htmlspecialchars($row['ProductName'])?></p>
        <p class = "ItemDescriptionMobile"><?php echo htmlspecialchars($row['shortDescription'])?></p>
        <p class = "ItemPriceMobile" >R<?php echo htmlspecialchars($row['Price'])?></p>
      </div> 

    <?php
                }
              } ;
    ?>
    
    <div class="viewAllContainer" onclick="SearchPage()">
        <button class="viewAllButton">
          View All
          <span class="arrowCircle">
          ➔
          </span>
        </button>
    </div>


  </div>    
 </section>
 
 

   <script src = "treasure hub welcome.js"></script>   

   
   <script>

    function SearchPage()
    {
      window.location.href = "treasure hub searchpage.php";
    }

    function SearchPageRecently()
    {
        window.location.href = "treasure hub searchpage.php?sortby=DateDescending";
    }
    function DisplayCategories(categoryName)
    {
          window.location.href = "treasure hub searchpage.php?Category="+categoryName;
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