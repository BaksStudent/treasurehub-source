<?php 
session_start();
include "connect.php";
$loggedIn = isset($_SESSION['email']);

if (isset($_SESSION['edit_product_id'])) {
    $productId = $_SESSION['edit_product_id'];

    $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '$productId'");
    
    if ($productQuery && mysqli_num_rows($productQuery) > 0) 
    {
      $product = mysqli_fetch_assoc($productQuery);
      $productName = $product['SellerID'];
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $productName ?></title>
    <link rel="stylesheet" href="Treasure hub product page.css">
    <link rel="stylesheet"href= "treasure hub welcome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php if (isset($_GET['log']) && $_GET['log'] === 'review'): ?>
    <div class="notification-banner">
        <p>✅ Item has been reviewed</p>
    </div>
    <?php endif; ?>
    <header> 
      <nav class = "MainNavbar">
            <button class = "MainLogo" onclick="FoodsCall()" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "treasure hub logo reduced 4.png" ></button>
       
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
                            $MainuserID = $row['UserID'];
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

<?php
                if (isset($_SESSION['edit_product_id'])) {
                $productId = $_SESSION['edit_product_id'];

                $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '$productId'");
    
                if ($productQuery && mysqli_num_rows($productQuery) > 0) 
                {
                    $product = mysqli_fetch_assoc($productQuery);
                    $sellerid = $product['SellerID'];
                    $stmt = $conn->prepare("SELECT * FROM productimages WHERE ProductID = ? ORDER BY ImageID ASC LIMIT 4");
                    $stmt->bind_param("i", $productId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $imagePaths = [];
                    $alt_Texts = [];
                    $first = true;

                    while ($row = $result->fetch_assoc()) {
                        if ($first) 
                        {
                            $_SESSION['Temporary_image_ID'] = $row['ImageID'];
                            $first = false;
                        }
                        $imagePaths[] = "Images/" . $row['ImagePath'];
                        $alt_Texts[] = $row['altText'];
                    }
                }
                else
                {
                    echo "Product not found";
                }
            }
            ?>
<div class = "mainBackground" id = "mainBackground">
    <div class="mainInfoContainer">
        <div class="mainInfoContainer-imagesContainer">
           <div class="imagesCointainer-smallImagesContainer">
             <img src="<?= $imagePaths[1] ?? 'placeholder logo.png'?>" alt="<?php echo $alt_Texts[1]?>">       
             <br>
             <img src="<?= $imagePaths[2] ?? 'placeholder logo.png'?>" alt="<?php echo $alt_Texts[2]?>">       
             <br>
             <img src="<?= $imagePaths[3] ?? 'placeholder logo.png'?>" alt="<?php echo $alt_Texts[3]?>">       
           </div> 
             <div class="imagesCointainer-BigimagesContainer">
                 <img src = "<?= $imagePaths[0] ?? 'placeholder logo.png'?>" alt = "<?php echo $alt_Texts[0]?>">
             </div>
        </div>
        <div class="mainInfoContainer-TextContainer">
            <div class="mainInfoContainer-TitlePriceContainer">
               <div class="TitleName">
                    <h4><?php echo htmlspecialchars($product['ProductName'])?></h4>
               </div> 
               <div class="PriceText">
                    <p>R <?php echo htmlspecialchars($product['Price'])?></p>
               </div>
            </div>
            <form method="post" action="add_to_cart.php" class="mainInfoContainer-form">
            <div class="mainInfoContainer-DescriptionbuttonContainer">
                 <div class="DescriptionPlaceholder">
                    <p><?php echo htmlspecialchars($product['shortDescription']) ?></p>
                </div>

                <div class="cartButton">
                    <input type="hidden" name="product_id" value="<?php echo $product['ProductID'] ?>">

                    <input type="number" name="P_quantity" value="1" min="1" max="<?php echo $product['Quantity']?>" class="quantityInput">

            <!-- Submit Button -->
              <?php
                        if(isset($_SESSION['email']))
                        {
                          $p_ID = $product['ProductID'] ;
                          $orderquery = mysqli_query($conn, "SELECT * FROM cart WHERE ProductID = $p_ID");
                          if ($orderquery && mysqli_num_rows($orderquery) > 0) 
                          {
                             ?>
                              <button type = "submit" class = "alreadyInCart" name = "alreadyInCart" onclick="ToCart()">Already in cart +<i class="fa-solid fa-cart-shopping"> </i></button>
                            <?php
                             
                          }
                          else
                          {
                              ?>
                              <button type="submit" class = "addtoCartBtn" name="addtoCartBtn">Add to cart <i class="fa-solid fa-cart-shopping"></i></button>
                              <?php
                          }
                        }
                        else
                        {
                          ?>
                                <button  class = "addtoCartBtn" name="cartBtnLogin" onclick="toLogin()">Add to cart <i class="fa-solid fa-cart-shopping"></i></button>
                          <?php
                        }
                        ?>
                    
                </div>
            </div>
        </form>
            <!--
            <div class="mainInfoContainer-DescriptionbuttonContainer">
                <div class = "DescriptionPlaceholder">
                    <p><?//php echo htmlspecialchars($product['shortDescription'])?></p>
                </div>
                <div class = "cartButton">
                        <button > add to cart <i class="fa-solid fa-cart-shopping"></i> </button>
                        <input type="text" name = "currentid" value="<?//php echo $product['ProductID']?>" style="display: none;">
                    </div>
                <form method = "post" action="add_to_cart.php">
                    
                </form>
            </div>
        -->

            <div class = "aboutSellerSection">
                <p class = "aboutSellerSection-title">Seller</p>
                <div class="aboutSellerSection-Container">
                    <?php
                    $sellerProfilePic = "placeholder logo.png";
                    $sellerQuery = mysqli_query($conn, "SELECT * FROM seller WHERE SellerID = '$sellerid'");
                    if ($sellerQuery && mysqli_num_rows($sellerQuery) > 0)
                    {
                        $seller = mysqli_fetch_assoc($sellerQuery);
                        $sellerProfilePic =  "Images/".$seller['ProfilePicFile'];
                    }   
                    ?>
                    <div class="aboutSellerSection-ImageContainer">
                        <img src="<?php echo $sellerProfilePic?>" alt="picture of seller">
                    </div>
                    <div class="aboutSellerSection-textContainer">
                        <div class="sellerNameAndRatings">
                            <div class = sellerName>
                                <p><?php echo htmlspecialchars($seller['UserName'])?></p>    
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
                            <Button class="sellerButton" onclick="ShowSeller(<?php echo $sellerid ?>)"> view seller</Button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="keyInfocontainer">
        <div class = "keyInfocontainer-title">
            <p>Key info</p>
        </div>
        <table>
            <tr>
              <th style="width: 40%;">Info</th>
              <th style="width: 60%;">Details</th>
            </tr>
            <tr>
              <td>Condition</td>
              <td style="font-weight: 600;"><?php echo htmlspecialchars($product['ProductCondition'])?></td>
            </tr>
            <tr>
              <td>Product ID</td>
              <td><?php echo htmlspecialchars($product['ProductID'])?></td>
            </tr>
            <tr>
              <td>Product name</td>
              <td><?php echo htmlspecialchars($product['ProductName'])?></td>
            </tr>
            <tr>
              <td>listingDate</td>
              <td><?php echo htmlspecialchars($product['listingDate'])?></td>
            </tr>
            <tr>
              <td>Price</td>
              <td><?php echo htmlspecialchars($product['Price'])?></td>
            </tr>
            <tr>
              <td>Quantity</td>
              <td><?php echo htmlspecialchars($product['Quantity'])?></td>
            </tr>
          </table>
    </div>
    <div class = "DescriptionContainer">
        <div class = "DescriptionContainer-title">
            <p>Description</p>
        </div>
        <div class = "DescriptionContainer-placeholderText">
            <p><?php echo htmlspecialchars($product['longDescription'])?></p>
        </div>
    </div>


    <div class = "ReviewsContainer">
        <h2>Customer Reviews</h2>
        <?php
        $reviewQuery = mysqli_query($conn, "SELECT * FROM review WHERE ProductID = '$productId'");
        if ($reviewQuery && mysqli_num_rows($reviewQuery) > 0) 
        {
            while ($review = mysqli_fetch_assoc($reviewQuery)) 
            {
                $userID = $review['UserID'];
                $rating = $review['rating'];
                $comment = $review['comment'];
                $date = $review['reviewDate'];
                $userQuery = mysqli_query($conn,"SELECT * FROM user WHERE UserID = '$userID'");
                if($userQuery && mysqli_num_rows($userQuery)>0)
                {
                    $user = mysqli_fetch_assoc($userQuery);
                    $name = htmlspecialchars($user['FirstName'] . ' ' . strtoupper($user['LastName'][0]) . '.');
                }
                
        ?>
        <div class="review">
            <div class="reviewer-name"><?= $name ?></div>
            <div class="rating">Rating: <?= $rating ?>/10</div>
            <div> <?= $date ?> </div>
            <div class="comment"><?= $comment ?></div>
        </div>
        <?php
            }
        }

        if (isset($_SESSION['email'])) 
        {
            $email = $_SESSION['email'];

    // Get the logged-in user's ID
            $userQuery = mysqli_query($conn, "SELECT * FROM user WHERE Email = '$email'");
            if ($userQuery && mysqli_num_rows($userQuery) > 0) 
            {
                $userData = mysqli_fetch_assoc($userQuery);
                $currentUserID = $userData['UserID'];

        // Check if the user has ordered this specific product
                $orderQuery = mysqli_query($conn, "SELECT * FROM orders WHERE UserID = '$currentUserID'");
                if ($orderQuery && mysqli_num_rows($orderQuery) > 0) 
                {
                    while ($order = mysqli_fetch_assoc($orderQuery)) 
                    {
                        $orderID = $order['OrderID'];

                        $detailQuery = mysqli_query($conn, "SELECT * FROM order_details WHERE OrderID = '$orderID' AND ProductID = '$productId'");
                        if ($detailQuery && mysqli_num_rows($detailQuery) > 0) 
                        {
                            ?>
                            <button onclick="ToReview()" class="reviewButton">Create review</button>
                            <?php
                            break; // Show the button once, then exit loop
                        }
                    }
                }
            }
        }
    ?>
    </div>

</div>


    <div class = "mobileBackground" id = "mobileBackground">

        <div class="mobileMainInfoContainer">
            <div class="mobileMainInfo-ImageContainer">
               <img src="<?= $imagePaths[0] ?? 'placeholder logo.png'?>" alt="<?php echo $alt_Texts[0]?>"> 
            </div>
            <div class="mobileMainInfo-TextAndButtonContainer">
                <div class = "mobileMainInfo-TitleContainer">
                    <p><?php echo htmlspecialchars($product['ProductName'])?></p>
                </div>
                <div class = "mobileMainInfo-DescriptionContainer">
                    <p><?php echo htmlspecialchars($product['shortDescription'])?></p>
                </div>
                <div class = "mobileMainInfo-Price">
                    <p>R <?php echo htmlspecialchars($product['Price'])?></p>
                </div>
                <form method="post" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $product['ProductID'] ?>">
                    <?php
                        if(isset($_SESSION['email']))
                        {
                          $p_ID = $product['ProductID'] ;
                          $orderquery = mysqli_query($conn, "SELECT * FROM cart WHERE ProductID = $p_ID");
                          if ($orderquery && mysqli_num_rows($orderquery) > 0) 
                          {
                             ?>
                              <button type = "submit" class = "mobilealreadyInCart" name = "alreadyInCart" onclick="ToCart()">Already in cart +<i class="fa-solid fa-cart-shopping"> </i></button>
                            <?php
                             
                          }
                          else
                          {
                              ?>
                              <button type="submit" name = "addtoCartBtn" class = "mobilecartButton">Add to cart <i class="fa-solid fa-cart-shopping"></i></button>
                              <?php
                          }
                        }
                        else
                        {
                          ?>
                                <button  class = "mobilecartButton" name="cartBtnLogin" onclick="toLogin()">Add to cart <i class="fa-solid fa-cart-shopping"></i></button>
                          <?php
                        }
                        ?>
                    
                    <div class = "mobileQuantity-placeholder">
                        <p style="align-self: center; font-size: medium;">Quantity</p>
                        <input type="number" name="P_quantity" value="1" min="1" max="<?php echo $product['Quantity']?>" class="quantityInput">
                    </div>
                    
                </form>
            <!--
                <button class = "mobilecartButton">
                    Add to cart +<i class="fa-solid fa-cart-shopping"> </i>   
                </button>
                                        -->
                <div class = "aboutSellerSection">
                    <p class = "aboutSellerSection-title">Seller</p>
                    <div class="aboutSellerSection-Container">
                        <div class="aboutSellerSection-ImageContainer">
                            <img src="<?php echo $sellerProfilePic?>" alt="Picture of seller">
                        </div>
                        <div class="aboutSellerSection-textContainer" onclick="ShowSeller(<?php echo $sellerid ?>)">
                            <div class="sellerNameAndRatings">
                                <div class = sellerName>
                                    <p><?php echo htmlspecialchars($seller['UserName'])?></p>    
                                </div>
                                <div class = "SellerverifiedContainer">
                                 <?php if($seller['Verified'] == 1)
                                        {
                            
                                        }
                                        else
                                        {
                                            echo '<p><i class="fa-solid fa-certificate"></i></p>';
                                         }
                                ?>
                                </div>
                                <Button class="sellerButton" > view seller</Button>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>
          
        </div>

        <div class="mobile-keyInfocontainer">
            <div class = "keyInfocontainer-title">
                <p>Key info</p>
            </div>
            <table>
                <tr>
                  <th style="width: 40%;">Info</th>
                  <th style="width: 60%;">Details</th>
                </tr>
                <tr>
              <td>Condition</td>
              <td style="font-weight: 600;"><?php echo htmlspecialchars($product['ProductCondition'])?></td>
            </tr>
            <tr>
              <td>Product ID</td>
              <td><?php echo htmlspecialchars($product['ProductID'])?></td>
            </tr>
            <tr>
              <td>Product name</td>
              <td><?php echo htmlspecialchars($product['ProductName'])?></td>
            </tr>
            <tr>
              <td>listingDate</td>
              <td><?php echo htmlspecialchars($product['listingDate'])?></td>
            </tr>
            <tr>
              <td>Price</td>
              <td><?php echo htmlspecialchars($product['Price'])?></td>
            </tr>
            <tr>
              <td>Quantity</td>
              <td><?php echo htmlspecialchars($product['Quantity'])?></td>
            </tr>
              </table>
        </div>

        <div class = "mobile-DescriptionContainer">
            <div class = "DescriptionContainer-title">
                <p>Description</p>
            </div>
            <div class = "DescriptionContainer-placeholderText">
                <p><?php echo htmlspecialchars($product['longDescription'])?></p>
            </div>
        </div>    

    </div>
   <script src="Treasure hub product page.js"></script>
   <script>
    function FoodsCall()
    {
        window.location.href = "treasure hub foods welcome.php";
    }
    function ToReview()
    {
        window.location.href = "ReviewPage.php";
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
                
                    window.location.href = "treasure hub seller display page.php";
                })
                .catch(error => {
                console.error('Error:', error);
                });
        }
   </script>
</body>
</html>