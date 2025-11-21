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
    <title>Treasure hub search page</title>
    <link rel="stylesheet" href="treasure hub searchpage.css">
    <link rel="stylesheet" href="treasure hub welcome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
      .clearButton
      {
        height: auto;
        width: auto;
        border: none;
        border-radius: 5px;
        background-color: white;
        color: cadetblue;
        margin:2px;
        padding: 2px;
        margin-left: 5px;
      }
    </style>
</head>
<body>
    
    <header>
      
        <nav class = "MainNavbar" id="mainNavbar">
        <button class = "MainLogo" onclick="FoodsCall()"style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "treasure hub logo reduced 4.png" ></button>
       
        <div class ="Nav-links">
          <div class = "Acc-links" id = "Acc-links" >
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
      </nav>
      <div class = "DesktopHeaderContainer" id="DesktopHeaderContainer">
        <nav class = "FilterBar" id = "FilterBar">
          <p class = "FilterText">Filter:</p>

          <div class = "dropdown" id = "sortdropdown">
            <div class = "sortdropdown-title">
                <p>Sorting</p>
                <i class="fa-solid fa-caret-down"></i>
            </div>
            <div class = "dropdown-content">
                <form method = "get">
                    <input type="radio" id="sortNameAscending" name="sortby" value="NameAscending">
                    <label for="sortNameAscending">Name: A-Z</label> <br>
                    <input type="radio" id="sortNameDescending" name="sortby" value="NameDescending">
                    <label for="sortNameDescending">Name: Z-A</label> <br>
                    <input type="radio" id="sortDateAscending" name="sortby" value="DateAscending">
                    <label for="sortDateAscending">Newest Added</label> <br>
                    <input type="radio" id="sortDateDescending" name="sortby" value="DateDescending">
                    <label for="sortDateDescending">Oldest Added</label> <br>
                    <input type="radio" id="sortNone" name="sortby" value="sortnone">
                    <label for="sortNone">None</label> <br>
                     <?php
                          foreach ($_GET as $key => $value) {
                          if ($key !== 'sortby') 
                          {
                            echo "<input type='hidden' name='" . htmlspecialchars($key) . "' value='" . htmlspecialchars($value) . "'>";
                          }
                    }
                ?>
                     <button type="submit" class = "filterButtons">Apply</button>
                  </form>
            </div>
          </div> 

          <div class = "dropdown" id = "pricedropdown">
            <div class = "pricedropdown-title">
               <p>Price</p> 
               <i class="fa-solid fa-caret-down"></i>
            </div>
            <div class = "dropdown-content">
                <form method="get" id="priceFilterForm">
                  <div class="price-inputs">
                  <input type="text" name="minPrice" placeholder="min">
                  <p>To</p>
                  <input type="text" name="maxPrice" placeholder="max">
                  </div>
                   <?php
                    foreach ($_GET as $key => $value) {
                    if ($key !== 'minPrice') {
                    echo "<input type='hidden' name='" . htmlspecialchars($key) . "' value='" . htmlspecialchars($value) . "'>";
                    }
                    }
                    foreach ($_GET as $key => $value) {
                    if ($key !== 'maxPrice') {
                    echo "<input type='hidden' name='" . htmlspecialchars($key) . "' value='" . htmlspecialchars($value) . "'>";
                    }
                    }
                ?>
                  <button type="submit" class="filterButtons">Apply price</button>
                </form>
            </div>
          </div>
          <form action="treasure hub searchpage.php" class="clearform">
                    <button type="submit" class = "clearButton">clear filters</button>
            </form>
          <!--
          <div class = "dropdown" id = "filterdropdown">
            <div class = "filterdropdown-title">
                <p>Filter 1</p>
                <i class="fa-solid fa-caret-down"></i>
            </div>
            <div class = "dropdown-content">
                <form action="">
                    <input type="checkbox" id="filterOne" name="filterOne" value = "FilterOne">
                    <label for="filterOne">Filter1</label>
                    <br>
                    <input type="checkbox" id="filterTwo" name="filterTwo" value = "FilterTwo">
                    <label for="filterTwo">Filter2</label>
                    <br>
                    <input type="checkbox" id="filterThree" name="filterThree" value = "FilterThree">
                    <label for="filterThree">Filter3</label>
                  </form>
            </div>
          </div>
-->
        </nav>
        
      </div>
      

      <nav class = "MobileNavbar" id="mobileNavbar">
        <div class = "filterButton">
          <i class="fa-solid fa-filter" onclick="toggleFilterMenu()"></i>
        </div>
        <div class = "logoContainer">
          <button class = "mobileMainLogo" onclick="FoodsCall()" ><img src = "placeholder logo.png" ></button>
        </div>
        <div class = "barsContainer">
          <div class="menu-icon2" onclick="toggleMobileMenu()">☰</i></div>
        </div>
    
      </nav>
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
          <button class = "Account-Buttons-mobile" onclick = "register()" >Sign Up</button>
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

      <div class = "mobileFiltersMenu" id = "mobilefiltersMenu">
        <p class = "FilterText">Filter:</p>

        <div class = "dropdown" id = "mobilesortdropdown">
          <div class = "sortdropdown-title">
              <p>Sorting</p>
              <i class="fa-solid fa-caret-down"></i>
          </div>
          <div class = "dropdown-content">
              <form method = "get">
                  <input type="radio" id="sortNameAscending" name="sortby" value="NameAscending">
                  <label for="sortNameAscending">Name: A-Z</label> <br>
                  <input type="radio" id="sortNameDescending" name="sortby" value="NameDescending">
                  <label for="sortNameDescending">Name: Z-A</label> <br>
                  <input type="radio" id="sortDateAscending" name="sortby" value="DateAscending">
                  <label for="sortDateAscending">Newest Added</label> <br>
                  <input type="radio" id="sortDateDescending" name="sortby" value="DateDescending">
                  <label for="sortDateDescending">Oldest Added</label> <br>
                  <input type="radio" id="sortNone" name="sortby" value="sortnone">
                  <label for="sortNone">None</label> <br>
                   <?php
                    foreach ($_GET as $key => $value) {
                    if ($key !== 'sortby') {
                    echo "<input type='hidden' name='" . htmlspecialchars($key) . "' value='" . htmlspecialchars($value) . "'>";
                    }
                    }
                ?>
                  <button type="submit" class="filterButtons">Apply</button>
                </form>
          </div>
        </div> 

        <div class = "dropdown" id = "mobilepricedropdown">
          <div class = "pricedropdown-title">
             <p>Price</p> 
             <i class="fa-solid fa-caret-down"></i>
          </div>
          <div class = "dropdown-content">
              <form method="get" id="priceFilterForm">
                  <div class="price-inputs">
                  <input type="text" name="minPrice" placeholder="min">
                  <p>To</p>
                  <input type="text" name="maxPrice" placeholder="max">
                  </div>
                  <button type="submit" class="filterButtons">Apply price</button>
                </form>
          </div>
        </div>

        <form action="treasure hub searchpage.php">
                    <button type="submit" class = "clearButton">clear filters</button>
        </form>
        
        <div class = "dropdown" id = "mobilefilterdropdown" style="display: none;">
          <div class = "filterdropdown-title">
              <p>Filter 1</p>
              <i class="fa-solid fa-caret-down"></i>
          </div>
          <div class = "dropdown-content">
              <form action="">
                  <input type="checkbox" id="filterOne" name="filterOne" value = "FilterOne">
                  <label for="filterOne">Filter1</label>
                  <br>
                  <input type="checkbox" id="filterTwo" name="filterTwo" value = "FilterTwo">
                  <label for="filterTwo">Filter2</label>
                  <br>
                  <input type="checkbox" id="filterThree" name="filterThree" value = "FilterThree">
                  <label for="filterThree">Filter3</label>
                </form>
          </div>
        </div>
      </div>
      
    </header>
    
    <div class = "DesktopContainer" id = "desktopContainer">
        <div class = "SearchContainer">
          <form method="get" class = "searchbar-form">
            <div class = searchbar>
                <input type="text" name="search"> <br>
                <?php
                    foreach ($_GET as $key => $value) {
                    if ($key !== 'search') {
                    echo "<input type='hidden' name='" . htmlspecialchars($key) . "' value='" . htmlspecialchars($value) . "'>";
                    }
                    }
                ?>
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>  
          </form>   
        </div>

        
        <div class = "SectionContainer">
          <?php
          $search = isset($_GET['search']) ? trim($_GET['search']) : '';
          $filter = isset($_GET['Category']) ? $_GET['Category'] : '';
          $hasFilter = false;
          $where = "WHERE isSold = 0";

          
          if (!empty($filter)) 
          {
            $filter = strtolower($filter); // to handle URL case insensitivity
            if ($filter === 'electronics') $where .= " AND CategoryID = 'electronics'";
            else if ($filter === 'fashion') $where .= " AND CategoryID = 'fashion'";
            else if ($filter === 'home-kitchen') $where .= " AND CategoryID = 'home-kitchen'";
            else if ($filter === 'beauty-health') $where .= " AND CategoryID = 'beauty-health'";
            else if ($filter === 'sports-outdoors') $where .= " AND CategoryID = 'sports-outdoors'";
            else if ($filter === 'toys-games') $where .= " AND CategoryID = 'toys-games'";
            else if ($filter === 'books-media') $where .= " AND CategoryID = 'books-media'";
            else if ($filter === 'automotive') $where .= " AND CategoryID = 'automotive'";
            else if ($filter === 'pet-supplies') $where .= " AND CategoryID = 'pet-supplies'";
            else if ($filter === 'office-stationery') $where .= " AND CategoryID = 'office-stationery'";
            else if ($filter === 'baby-maternity') $where .= " AND CategoryID = 'baby-maternity'";
            $hasFilter = true;
          }

        if (!empty($search)) 
        {
            $searchEscaped = mysqli_real_escape_string($conn, $search);
            $where .= " AND (ProductName LIKE '%$searchEscaped%' OR shortDescription LIKE '%$searchEscaped%')";
            $hasFilter = true;
        }


        $sort = $_GET['sortby'] ?? 'sortnone';
        switch ($sort) 
        {
          case 'NameAscending':
            $orderBy = "ORDER BY ProductName ASC";
            $hasFilter = true;
            break;
          case 'NameDescending':
            $orderBy = "ORDER BY ProductName DESC";
            $hasFilter = true;
            break;
          case 'DateAscending':
            $orderBy = "ORDER BY listingDate DESC";
            $hasFilter = true;
          break;
          case 'DateDescending':
            $orderBy = "ORDER BY listingDate ASC";
            $hasFilter = true;
          break;
          case 'sortnone':
            $orderBy = "";
            break;
          default:
            $orderBy = "";
          break;
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

      $listquery = mysqli_query($conn, "SELECT * FROM product $where $orderBy");
      if ($listquery && mysqli_num_rows($listquery) > 0) {
                while ($row = mysqli_fetch_assoc($listquery)) {
                   $productId = $row["ProductID"];
                    $listingPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";

                    $imageQuery = mysqli_query($conn, "SELECT * FROM productimages WHERE ProductID = '$productId' LIMIT 1");
                    if ($imageQuery && mysqli_num_rows($imageQuery) > 0) {
                        $imgRow = mysqli_fetch_array($imageQuery);
                        if (!empty($imgRow['ImagePath'])) {
                            $listingPicPath = "Images/" . $imgRow['ImagePath'];
                            $altText = $imgRow['altText'];
                        }
                    }
        ?>
            <div class = "DesktopItemPlaceholder">
                <div class = "imageSection">
                    <img src= "<?php echo $listingPicPath ?>" alt="<?php echo $altText?>">
                </div>
                <div class = "contentSection">
                    <div class = "itemNameandDescription">
                        <div class = "itemNamePlacholder">
                            <p><?php echo htmlspecialchars($row['ProductName'])?></p>
                        </div>
                        <div class = "itemDescriptionPlaceholder">
                            <p><?php echo htmlspecialchars($row['shortDescription'])?></p>
                        </div>
                    </div>
                    <div class = "itemPriceandButton">
                        <div class = "itemPricePlaceholder">
                            <p>R<?php echo htmlspecialchars($row['Price'])?></p>
                        </div>
                        <?php
                        if(isset($_SESSION['email']))
                        {
                          $p_ID = $row['ProductID'];
                          $orderquery = mysqli_query($conn, "SELECT * FROM cart WHERE ProductID = $p_ID");
                          if ($orderquery && mysqli_num_rows($orderquery) > 0) 
                          {
                             ?>
                              <button class = "cartFilledButton" onclick="ToCart()">Already in cart +<i class="fa-solid fa-cart-shopping"> </i></button>
                            <?php
                             
                          }
                          else
                          {
                              ?>
                              <button class = "itemCartPlacehholder" onclick="ShowProduct('<?php echo htmlspecialchars($row['ProductID'], ENT_QUOTES); ?>')">View product</button>
                              <?php
                          }
                        }
                        else
                        {
                          ?>
                          <button class = "itemCartPlacehholder" onclick="ShowProduct('<?php echo htmlspecialchars($row['ProductID'], ENT_QUOTES); ?>')">View product</button>
                          <?php
                        }
                        ?>
                        
                    </div>
                </div>
            </div>  
          <?php
          }
        }
        else 
        {
          echo "Products not found.";
        }
    
?>
    
        </div>
    </div>
   

    <div class="mobileSeachContainer" id = "mobileSeachContainer">
      <form method="get" class = "mobilesearchbar-form">
        <div class="mobileSearchbar">
            <input type="text" placeholder="search" id="mobileSearch" name="search">
            <?php
                    foreach ($_GET as $key => $value) {
                    if ($key !== 'search') {
                    echo "<input type='hidden' name='" . htmlspecialchars($key) . "' value='" . htmlspecialchars($value) . "'>";
                    }
                    }
            ?>
            <button type="submit" style="border: none;"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div> 
      </form>
          
    </div>
    <div class="mobileContentSection" id = "mobileContentSection">
       <?php
          $search = isset($_GET['search']) ? trim($_GET['search']) : '';
          $filter = isset($_GET['Category']) ? $_GET['Category'] : '';
          $hasFilter = false;
          $where = "WHERE isSold = 0";

          
          if (!empty($filter)) 
          {
            $filter = strtolower($filter); // to handle URL case insensitivity
            if ($filter === 'electronics') $where .= " AND CategoryID = 'electronics'";
            else if ($filter === 'fashion') $where .= " AND CategoryID = 'fashion'";
            else if ($filter === 'home-kitchen') $where .= " AND CategoryID = 'home-kitchen'";
            else if ($filter === 'beauty-health') $where .= " AND CategoryID = 'beauty-health'";
            else if ($filter === 'sports-outdoors') $where .= " AND CategoryID = 'sports-outdoors'";
            else if ($filter === 'toys-games') $where .= " AND CategoryID = 'toys-games'";
            else if ($filter === 'books-media') $where .= " AND CategoryID = 'books-media'";
            else if ($filter === 'automotive') $where .= " AND CategoryID = 'automotive'";
            else if ($filter === 'pet-supplies') $where .= " AND CategoryID = 'pet-supplies'";
            else if ($filter === 'office-stationery') $where .= " AND CategoryID = 'office-stationery'";
            else if ($filter === 'baby-maternity') $where .= " AND CategoryID = 'baby-maternity'";
            $hasFilter = true;
          }

        if (!empty($search)) 
        {
            $searchEscaped = mysqli_real_escape_string($conn, $search);
            $where .= " AND (ProductName LIKE '%$searchEscaped%' OR shortDescription LIKE '%$searchEscaped%')";
            $hasFilter = true;
        }


        $sort = $_GET['sortby'] ?? 'sortnone';
        switch ($sort) 
        {
          case 'NameAscending':
            $orderBy = "ORDER BY ProductName ASC";
            $hasFilter = true;
            break;
          case 'NameDescending':
            $orderBy = "ORDER BY ProductName DESC";
            $hasFilter = true;
            break;
          case 'DateAscending':
            $orderBy = "ORDER BY listingDate DESC";
            $hasFilter = true;
          break;
          case 'DateDescending':
            $orderBy = "ORDER BY listingDate ASC";
            $hasFilter = true;
          break;
          case 'sortnone':
            $orderBy = "";
            break;
          default:
            $orderBy = "";
          break;
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

      $listquery = mysqli_query($conn, "SELECT * FROM product $where $orderBy");
      if ($listquery && mysqli_num_rows($listquery) > 0) {
                while ($row = mysqli_fetch_assoc($listquery)) {
                   $productId = $row["ProductID"];
                    $listingPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";

                    $imageQuery = mysqli_query($conn, "SELECT * FROM productimages WHERE ProductID = '$productId' LIMIT 1");
                    if ($imageQuery && mysqli_num_rows($imageQuery) > 0) {
                        $imgRow = mysqli_fetch_array($imageQuery);
                        if (!empty($imgRow['ImagePath'])) {
                            $listingPicPath = "Images/" . $imgRow['ImagePath'];
                            $altText = $imgRow['altText'];
                        }
                    }
        ?>
      <div class = "mobileItemPlaceholder">
         <div class = "mobileImageSection">
            <img src = "<?php echo $listingPicPath?>" alt = "<?php echo $altText ?>">
         </div>
         <div class = "mobileItemContentSection">
          <div class = "mobileItemPlaceholderTitle"><p><?php echo htmlspecialchars($row['ProductName'])?></p></div>
          <div class = "mobileItemPlaceholderDescrip">
            <p><?php echo htmlspecialchars($row['shortDescription'])?></p>
          </div>

          <div class = mobilePriceandbuttonSec>
            <div class = "mobileItemPrice">
              <p>R<?php echo htmlspecialchars($row['Price'])?></p>
            </div>
            <?php
                        if(isset($_SESSION['email']))
                        {
                          $p_ID = $row['ProductID'];
                          $orderquery = mysqli_query($conn, "SELECT * FROM cart WHERE ProductID = $p_ID");
                          if ($orderquery && mysqli_num_rows($orderquery) > 0) 
                          {
                             ?>
                              <button class = "mobilecartFilledButton" onclick="ToCart()">Already in cart +<i class="fa-solid fa-cart-shopping"> </i></button>
                            <?php
                             
                          }
                          else
                          {
                              ?>
                              <button class = "mobileitemCartPlacehholder" onclick="ShowProduct('<?php echo htmlspecialchars($row['ProductID'], ENT_QUOTES); ?>')">View product</button>
                              <?php
                          }
                        }
                        else
                        {
                          ?>
                         <button class = "mobileitemCartPlacehholder" onclick="ShowProduct('<?php echo htmlspecialchars($row['ProductID'], ENT_QUOTES); ?>')">View product</button>
                          <?php
                        }
                        ?>
          </div>
         </div>
      </div>
      <?php
                }
              }else echo "No results found"
      ?>
      

    </div>
    <script src="treasure hub searchpage.js"></script>
    <script>
      function FoodsCall()
      {
        window.location.href = "treasure hub foods welcome.php";
      }
      function register()
      {
        window.location.href = "treasure_hub_signup_or_login.php?showDiv=signup";
      }
      function login()
      {
        window.location.href = "treasure_hub_signup_or_login.php";
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
    </script>
</body>
</html>