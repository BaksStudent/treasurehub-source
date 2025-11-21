<?php
session_start();
require 'connect.php';
$loggedIn = isset($_SESSION['email']);


if(isset($_SESSION['email']))
    {
        $email = $_SESSION['email'];
        $query = mysqli_query($conn, "SELECT user.* FROM user WHERE user.Email ='$email'");
        while($row = mysqli_fetch_array($query))
        {
          $userId = $row['UserID'];
        }
    }


$stmt = $conn->prepare("SELECT q.QueryID, q.dateCreated, q.isResolved, s.UserName 
                        FROM foodqueries q
                        JOIN seller s ON q.SellerID = s.SellerID
                        WHERE q.UserID = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$queryListResult = $stmt->get_result();


$selectedQuery = null;
$sellerDetails = null;
if (isset($_GET['queryid'])) {
    $queryId = intval($_GET['queryid']);
    $profilePic = "placeholder logo.png";
    
    
    
    $stmt = $conn->prepare("SELECT q.*, s.UserName, s.ProfilePicFile
                            FROM foodqueries q 
                            JOIN seller s ON q.SellerID = s.SellerID
                            WHERE q.QueryID = ? AND q.UserID = ?");
    $stmt->bind_param("ii", $queryId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $selectedQuery = $result->fetch_assoc();
        $profilePic = "Images/".$selectedQuery['ProfilePicFile'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Queries</title>
    <link rel="stylesheet"href= "treasure hub foods welcome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .MainPage
        {
            display: flex;
        }
        .sidebar {
            width: 30%;
            background-color: #f2f2f2;
            padding: 20px;
            overflow-y: auto;
            height: 100vh;
            border-right: 1px solid #ccc;
        }
        .sidebar h2 {
            margin-top: 0;
        }
        .query-item {
            margin-bottom: 15px;
            padding: 10px;
            background: #fff;
            border: 1px solid #ddd;
        }
        .query-item a {
            text-decoration: none;
            color: #333;
        }
        .resolved {
            color: green;
            font-weight: bold;
        }
        .content {
            flex-grow: 1;
            padding: 30px;
        }
        .content h2 {
            margin-top: 0;
        }
        .readonly-input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            background-color: #e9e9e9;
            border: 1px solid #ccc;
        }
        textarea.readonly-input {
            height: 100px;
            resize: none;
        }
        .seller-info {
            margin-top: 30px;
        }
        .seller-info img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
<header>
   <nav class = "MainNavbar">
  <button class = "MainLogo" onclick="MainCall()" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "Treasure hub foods logo reduced 4.png" ></button>
 
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


<!---
<div class = "WelcomePlaceholder">
  <p class="WelcomeParagraph">Welcome <a class = "NameText"> (placeholder)</a></p>
</div>-->

</header>

<div class = "MainPage">
    <div class="sidebar">
    <h2>Your Queries</h2>
    <?php while ($row = $queryListResult->fetch_assoc()): ?>
        <div class="query-item">
            <a href="?queryid=<?= $row['QueryID'] ?>">
                <strong>Query ID:</strong> <?= $row['QueryID'] ?><br>
                <strong>Seller:</strong> <?= htmlspecialchars($row['UserName']) ?><br>
                <strong>Date:</strong> <?= $row['dateCreated'] ?><br>
                <strong>Resolved:</strong>
                <?= $row['isResolved'] == 1 ? '<span class="resolved">Resolved</span>' : 'No' ?>
            </a>
        </div>
    <?php endwhile; ?>
</div>

    <div class="content">
        <?php if ($selectedQuery): ?>
            <h2>Query Information</h2>
            <label>Reason</label>
            <input type="text" class="readonly-input" value="<?= htmlspecialchars($selectedQuery['Reason']) ?>" readonly>

            <label>Description</label>
            <textarea class="readonly-input" readonly><?= htmlspecialchars($selectedQuery['UserDescription']) ?></textarea>

            <label>Date Created</label>
            <input type="text" class="readonly-input" value="<?= $selectedQuery['dateCreated'] ?>" readonly>

            <label>Resolved</label>
            <input type="text" class="readonly-input"
               value="<?= $selectedQuery['isResolved'] == 1 ? 'Resolved' : 'No' ?>" readonly>

            <div class="seller-info">
                <h3>Seller Info</h3>
                <p><strong>Username:</strong> <?= htmlspecialchars($selectedQuery['UserName']) ?></p>
                <img src="<?= htmlspecialchars($profilePic) ?>" alt="Profile Picture">
            </div>
        <?php else: ?>
            <p>Select a query from the left to view more details.</p>
        <?php endif; ?>
    </div>
</div>
</body>
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
</html>