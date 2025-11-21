<?php
session_start();
include 'connect.php';
$loggedIn = isset($_SESSION['email']);
?>
<!DOCTYPE html>
<html lang="en">
  <meta charset="UTF-8">
  <title>Report Seller</title>
  <link rel="stylesheet" href="reportUserPage.css">
  <link rel="stylesheet"href= "treasure hub welcome.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<header>
      <nav class = "MainNavbar">
            <button class = "MainLogo" onclick="FoodsCall()" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "treasure hub logo reduced 4.png"></button>
       
            <div class ="Nav-links">
                <div class = "Acc-links" id = "Acc-links">
                    <button class = "Account-Buttons" onclick= "register()">Sign Up</button>
                    <button class = "Account-Buttons" onclick= "login()">Login</button>
                </div>
                <div class="Acc-Name" id = "Acc-Name">
                    <p>Hi <?php
                    if(isset($_SESSION['email']))
                    {
                        $email = $_SESSION['email'];
                        $query = mysqli_query($conn, "SELECT user.* FROM user WHERE user.Email ='$email'");
                        while($row = mysqli_fetch_array($query))
                        {
                            $userID = $row['UserID'];
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
</header>

  <div class="report-container">
    <div class="report-header">
      <h2>Report Seller</h2>
    </div>
    <?php
    $search = isset($_GET['seller']) ? trim($_GET['seller']) : '';
    if (!empty($search)) 
    {
        $profilePic = "placeholder logo.png";
        $sellerID = $search;
        $sellerQuery = mysqli_query($conn, "SELECT * FROM seller WHERE SellerID = '$sellerID'");
        if ($seller = mysqli_fetch_assoc($sellerQuery))
        {
            $sellerName = $seller['UserName'];
            $profilePic = "Images/".$seller['ProfilePicFile'];
        }
    }
    ?>

    <div class="seller-info">
      <img src='<?php echo $profilePic?>' alt="Seller Profile Picture" />
      <h3><?php echo $sellerName ?></h3>
    </div>

    <form action="createQuery.php" method="POST">
      <label for="report-category">Report Category</label>
      <select id="report-category" name="category" required>
        <option value="">-- Select a category --</option>
        <option value="fraud">Fraud or Scam</option>
        <option value="offensive">Inappropriate or Offensive Behavior</option>
        <option value="misrepresentation">Product Misrepresentation</option>
        <option value="delivery">Non-Delivery or Shipping Issues</option>
        <option value="policy">Policy Violations</option>
        <option value="service">Poor Customer Service</option>
        <option value="prohibited">Counterfeit or Prohibited Products</option>
        <option value="reviews">Review Manipulation</option>
        <option value="privacy">Data Privacy Concerns</option>
        <option value="other">Other</option>
      </select>

      <input type="hidden" name="UserID" value="<?php echo $userID ?>">
      <input type="hidden" name="Seller_ID" value="<?php echo $sellerID ?>">

      <label for="description">Description</label>
      <textarea id="description" name="description" rows="5" placeholder="Please describe the issue in detail..." required></textarea>

      <button type="submit" name = "submitReport">Submit Report</button>
    </form>
  </div>
  <script src = "mobileOptimizer.js" ></script>
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
      window.location.href = "treasure hub cart section.php";
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