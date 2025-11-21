<?php
include "connect.php";
session_start();
$loggedIn = isset($_SESSION['email']);


if (isset($_SESSION['email']))
{
        $email = $_SESSION['email'];
        $query = mysqli_query($conn, "SELECT * FROM user WHERE Email ='$email'");
        if($row = mysqli_fetch_array($query))
        {
          $userID =  $row['UserID'];
        }
}
else echo "Email not found";

$orderQuery = mysqli_query($conn, "SELECT * FROM foodorders WHERE UserID = '$userID' ORDER BY OrderDate DESC LIMIT 1");
$order = mysqli_fetch_assoc($orderQuery);
if (isset($_SESSION['view_order_id'])) 
{
    $orderID = $_SESSION['view_order_id'];
}
else
{
    $orderID = $order['OrderID'];
}
$deliveryFee = 45.00;
$finalTotal = $order['TotalAmount'] + $deliveryFee;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Summary</title>
    <link rel="stylesheet" href="order_summary.css">
    <link rel="stylesheet" href= "treasure hub foods welcome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<header>
     <nav class = "MainNavbar">
  <button class = "MainLogo" onclick="MainCall()"style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "Treasure hub foods logo reduced 4.png" ></button>
 
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
      <button class = "Account-Buttons-mobile">Sign Up</button>
      <button class = "Account-Buttons-mobile">Login</button> 
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
</header>
<div class="order-summary">
    <div class="order-info">
        <h2>Order Summary</h2>
        <p><strong>Order ID:</strong> <?= $order['OrderID'] ?></p>
        <p><strong>Order Date:</strong> <?= $order['OrderDate'] ?></p>
        <p><strong>Status:</strong> <?= $order['OrderStatus'] ?></p>
    </div>

    <?php
    // Get products in the order
$itemsQuery = mysqli_query($conn, "SELECT * FROM foodorder_details WHERE OrderID = '$orderID'");

while ($item = mysqli_fetch_assoc($itemsQuery)) {
    $productID = $item['ProductID'];
    $productQuantity = $item['Quantity'];
    $productPrice = $item['Price'];
    $productNotes = $item['SpecialNotes'];

    // Get product details
    $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE ProductID = '$productID'");
    $product = mysqli_fetch_assoc($productQuery);
    $productName = $product['FoodName'];
    $productDescription = $product['Description'];
    $listingPicPath = "placeholder logo.png"; //
    $altText = "Product image";
    $listingPicPath = "Images/" . $product['ImagePath'];
    $altText = $product['altText'];
?>
    
    <div class="product-card" style="display: flex; border: 1px solid #ccc; padding: 15px; margin-bottom: 15px;">
        <img src="<?php echo $listingPicPath ?>" alt="<?php echo htmlspecialchars($altText) ?>" style="width: 150px; height: auto; margin-right: 20px; object-fit: cover;">
        <div style="flex: 1;">
            <div class="product-title" style="font-weight: bold; font-size: 18px;"><?php echo htmlspecialchars($productName) ?></div>
            <div class="product-description" style="margin-top: 5px;"><?php echo htmlspecialchars($productNotes) ?></div>
        </div>
        <div style="text-align: right; min-width: 120px;">
            <div class="product-qty">Qty: <?php echo $productQuantity ?></div>
            <div class="product-price">R<?= number_format($productPrice, 2) ?></div>
        </div>
    </div>
<?php } ?>

    <div class="totals">
        <p><span>Subtotal:</span> <span>R<?= number_format($order['TotalAmount'], 2) ?></span></p>
        <p><span>Delivery Fee:</span> <span>R<?= number_format($deliveryFee, 2) ?></span></p>
        <p class="total"><span>Total:</span> <span>R<?= number_format($finalTotal, 2) ?></span></p>
    </div>

    <a href="foodsorder_list.php" class="back-button">← Back to Orders</a>
</div>

<div class = "address-summary">
<h5>Delivery Summary</h5>

<div style="display: flex; align-items: center; justify-content: center;">
<div class="tenor-gif-embed" data-postid="18146487" data-share-method="host" data-aspect-ratio="1" data-width="30%"><a href="https://tenor.com/view/motorbike-motorbikes-delivery-deliveryservice-deliveryfood-gif-18146487">Motorbike Motorbikes Sticker</a>from <a href="https://tenor.com/search/motorbike-stickers">Motorbike Stickers</a></div> <script type="text/javascript" async src="https://tenor.com/embed.js"></script>
</div>


<?php
    $query = mysqli_query($conn, "SELECT OrderTime, TimeDelivered FROM foodorders WHERE OrderID = '$orderID'");

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $timeOrdered = strtotime($row['OrderTime']);
        $timeDelivered = $row['TimeDelivered']; // Check if already delivered

        // If already delivered, return a message
        if (!empty($timeDelivered)) {
           echo '<p>Delivery status: <p style="color: green; font-weight: 700">Delivered</p></p>';
            return;
        }

        $currentTime = time();
        $oneHourLater = $timeOrdered + 3600; // 1 hour = 3600 seconds

        if ($currentTime >= $oneHourLater) {
            // One hour has passed, update TimeDelivered
            $timeNowFormatted = date("Y-m-d H:i:s", $currentTime);
            $updateQuery = "UPDATE foodorders SET TimeDelivered = '$timeNowFormatted' WHERE OrderID = '$orderID'";
            if (mysqli_query($conn, $updateQuery)) {
            } else {
            echo "Error updating TimeDelivered: " . mysqli_error($conn);
            }
        } else {
            // Time hasn't passed yet - calculate remaining minutes
            $secondsLeft = $oneHourLater - $currentTime;
            $minutesLeft = ceil($secondsLeft / 60);
            ?>
            <p>Delivery status: </p>
            <div style="text-align: center;">
              <p style="font-weight: 600;">Minutes until Delivery</p>
              <p style="font-weight: 700;"><?php echo $minutesLeft ?></p>
            </div>
            <?php
        }
    } else {
        echo "Order not found.";
    }


?>



</div>
<script src="mobileOptimizer.js"></script>
<script>
    function MainCall()
    {
      window.location.href = "treasure_hub_welcome.php";
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