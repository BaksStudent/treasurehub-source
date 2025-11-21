<?php
session_start();
include "connect.php";
$loggedIn = isset($_SESSION['email']);

 if (isset($_SESSION['edit_product_id'])) {
    $productId = $_SESSION['edit_product_id'];
    $imagePath = "placeholder logo.png";

    $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE ProductID = '$productId'");
    
    if ($productQuery && mysqli_num_rows($productQuery) > 0) 
    {
      $product = mysqli_fetch_assoc($productQuery);
      $productName = $product['FoodName'];
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $productName?></title>
    <link rel="stylesheet"href= "treasure hub foods welcome.css">
    <link rel="stylesheet" href="Treasure hub foods product page.css">
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
          <form action="treasure hub foods searchpage.php" method="get" class = "searchbar-form">
            <input type="text" name="search" class= "Search-Bar" placeholder="Search...">
            <button class = "SearchButton"><i class="fa-solid fa-magnifying-glass"></i></button>
          </form>
        </div>
      </nav>
    </header>

  <section class = "mainBackground">

    <section class = "MainContainer">
      <?php
      if (isset($_SESSION['edit_product_id'])) {
                $productId = $_SESSION['edit_product_id'];
                $imagePath = "placeholder logo.png";

                $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE ProductID = '$productId'");
    
                if ($productQuery && mysqli_num_rows($productQuery) > 0) 
                {
                    $product = mysqli_fetch_assoc($productQuery);
                    $sellerid = $product['SellerID'];
                    $imagePath = "Images/" . $product['ImagePath'];
                    $alt_Text = $product['altText'];
                }
                else
                {
                    echo "Product not found";
                }
              }
                ?>
        <div class = "productImages-Containter">
            <div class="mainInfoContainer-imagesContainer">
              <!--
                <div class="imagesCointainer-smallImagesContainer">
                  <img src="placeholder logo.png" alt="small product">       
                  <br>
                  <img src="placeholder logo.png" alt="small product">       
                  <br>
                  <img src="placeholder logo.png" alt="small product">       
                </div> 
-->
                  <div class="imagesCointainer-BigimagesContainer">
                      <img src = "<?php echo $imagePath?>" alt = "<?php echo $alt_Text?>">
                  </div>
             </div>
        </div>
        <div class = "ProductNameContainer">
            <p><?php echo $product['FoodName']?></p>
        </div>
        <div class = "productDescription-Container">
            <p><?php echo $product['Description']?></p>
        </div>
        <div class = "productPrice-Container">
            <p><?php echo number_format($product['Price'], 2)?></p>
        </div>
    </section>

    <section class = sellerContainer>
      <div class="sellerContainer-info" onclick="ShowSeller(<?php echo $sellerid ?>)">
        <?php
          $sellerProfilePic = "placeholder logo.png";
          $sellerQuery = mysqli_query($conn, "SELECT * FROM seller WHERE SellerID = '$sellerid'");
          if ($sellerQuery && mysqli_num_rows($sellerQuery) > 0)
          {
            $seller = mysqli_fetch_assoc($sellerQuery);
            $sellerProfilePic =  "Images/".$seller['ProfilePicFile'];
            if (is_null($seller['ProfilePicFile'])) 
            {
              $sellerProfilePic = "placeholder logo.png";
            }
          }   
        ?>
        <img src="<?php echo $sellerProfilePic ?>" alt="Picture of seller">
        <p><?php echo htmlspecialchars($seller['UserName'])?></p>  
        <?php 
        if($seller['Verified'] == 0)
        {
                            
        }
        else
        {
          echo '<p class = "varifiedText"><i class="fa-solid fa-certificate"></i> Verfied</p>';
        }
        ?>
      </div>
    </section>

    <!--
    <section class = "FlavourContainer-Compulsory">
        
        <div class="FlavourTitle">
            <p>Choose your flavour</p>
        </div>
        <div class = mainRadioContainer>
            <label class="radio-container">
                <div class="radiobutton-nameContainer">
                  <input type="radio" id="flavour1-r" name="flavourRadio">
                  <span>flavour 1</span>
                </div>
                <div class="right-content">
                  <span>Price</span>
                </div>
            </label>
            <label class="radio-container">
                <div class="radiobutton-nameContainer">
                  <input type="radio" id="flavour2-r" name="flavourRadio">
                  <span>flavour 2</span>
                </div>
                <div class="right-content">
                  <span>Price</span>
                </div>
            </label>
            <label class="radio-container">
                <div class="radiobutton-nameContainer">
                  <input type="radio" id="flavour2-r" name="flavourRadio">
                  <span>flavour 2</span>
                </div>
                <div class="right-content">
                  <span>Price</span>
                </div>
            </label>
            
        </div>
        
          
    </section>

    <section class="AddonsContainer-Optional">
        <div class="AddonsTitle">
            <p>Add-ons</p>
        </div>
        <div class = mainCheckboxContainer>
            <label class="checkbox-container">
                <div class="checkbox-nameContainer">
                  <input type="checkbox" id="option1" name="option1">
                  <span>Option 1</span>
                </div>
                <div class="right-content">
                  <span>Price</span>
                </div>
            </label>
            <label class="checkbox-container">
                <div class="checkbox-nameContainer">
                  <input type="checkbox" id="option2" name="option2">
                  <span>Option 2</span>
                </div>
                <div class="right-content">
                  <span>Price</span>
                </div>
            </label>
            <label class="checkbox-container">
                <div class="checkbox-nameContainer">
                  <input type="checkbox" id="option3" name="option3">
                  <span>Option 3</span>
                </div>
                <div class="right-content">
                  <span>Price</span>
                </div>
            </label>   
        </div>
    </section>

-->
<form method="post" action="add_to_cart.php" style="width:100%; height: auto;">
  <section class = "specialNotes-Container">
        <div class="notesTitle">
            <p>Special Instructions</p>
        </div>
        <div class="notesText-container">
            <textarea name = "specialNotes"placeholder="Enter your message here..."></textarea>
        </div>
    </section>

  </section>  
    


    <footer>
        <div class="orderSection">
           <div class = PriceOrderContainer>
                <p class="priceText"><?php echo number_format($product['Price'], 2)?></p>
                
                   <div class = "orderbutton-container">
                    <button name="addtofoodCartBtn">Add to cart</button>
                    <input type="hidden" name="product_id" value="<?php echo $product['ProductID'] ?>">
                  </div>          
           </div> 
        </div>
    </footer> 
</form>   
<script src="Treasure hub foods product page.js"></script>
<script>
  function MainCall()
{
    window.location.href = "treasure_hub_welcome.php";
}
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
  function ShowSeller(sellerID)
  {
    fetch('set_seller_session.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'sellerID=' + encodeURIComponent(sellerID)
    })
    .then(response => response.text())
    .then(data => {
      window.location.href = "treasure hub foods seller display page.php";
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