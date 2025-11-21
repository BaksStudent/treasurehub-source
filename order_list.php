<?php
session_start();
$loggedIn = isset($_SESSION['email']);
include 'connect.php'; 


if (!isset($_SESSION['email'])) {
    header("Location: treasure_hub_signup_or_login.php");
    exit();
}

$email = $_SESSION['email'];
$userQuery = mysqli_query($conn, "SELECT * FROM user WHERE Email = '$email'");
$user = mysqli_fetch_assoc($userQuery);
$userID = $user['UserID'];

$orderQuery = mysqli_query($conn, "SELECT * FROM orders WHERE UserID = '$userID' ORDER BY OrderDate DESC");
?>

<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Your Orders</title>
    <link rel="stylesheet" href="order-List.css">
    <link rel="stylesheet" href="treasure hub welcome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
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

<h2>Your Orders</h2>
<?php while ($order = mysqli_fetch_assoc($orderQuery)): ?>
    <?php
    $orderID = $order['OrderID'];
    $imagePath = "placeholder.png";
    $altText = "Product image";

    $itemQuery = mysqli_query($conn, "SELECT ProductID FROM order_details WHERE OrderID = '$orderID' LIMIT 1");
    if ($item = mysqli_fetch_assoc($itemQuery)) {
        $productID = $item['ProductID'];
        $imageQuery = mysqli_query($conn, "SELECT * FROM productimages WHERE ProductID = '$productID' LIMIT 1");
        if ($image = mysqli_fetch_assoc($imageQuery)) {
            if (!empty($image['ImagePath'])) {
                $imagePath = "Images/" . $image['ImagePath'];
                $altText = $image['altText'];
            }
        }
    }
    ?>

    <div class="order-container">
        <div class="order-thumbnail">
            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($altText) ?>">
        </div>
        <div class="order-details">
            <div class="order-info"><span>Order ID:</span> <?= $orderID ?></div>
            <div class="order-info"><span>Date:</span> <?= $order['OrderDate'] ?></div>
            <div class="order-info"><span>Total:</span> R<?= number_format($order['TotalAmount'] + 35, 2) ?> (incl. delivery)</div>
            <div class="order-info"><span>Status:</span> <?= htmlspecialchars($order['OrderStatus']) ?></div>
        </div>
        <button class="view-button" onclick="OpenSummary('<?php echo $orderID ?>')">View Summary</button>

    </div>
<?php endwhile; ?>

</body>
<script src="mobileOptimizer.js"></script>
<script>
    function FoodsCall()
    {
        window.location.href = "treasure hub foods welcome.php";
    }
    function ToCart()
    {
        window.location.href = "treasure hub cart section.php";
    }
    function OpenSummary(orderID)
    {
        fetch('set_order_session.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },

        body: 'orderId=' + encodeURIComponent(orderID)
            })
            .then(response => response.text())
            .then(data => {
                
            window.location.href = "Order-Summary.php";
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
</html>