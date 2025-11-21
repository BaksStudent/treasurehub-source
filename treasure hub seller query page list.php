<?php
session_start();
include "connect.php";
if(isset($_SESSION['email']))
{
    $email = $_SESSION['email'];
    $query = mysqli_query($conn, "SELECT seller.* FROM seller WHERE seller.Email ='$email'");
    while($row = mysqli_fetch_array($query))
    {
         $sellerID = $row['SellerID'];
    }
}
if (isset($_SESSION['view_sellerid'])) 
{

        $sellerId = $_SESSION['view_sellerid'];
        $sellerQuery = mysqli_query($conn, "SELECT * FROM seller WHERE SellerID = '$sellerId'");
        $sellerProfilePic = "placeholder logo.png";
        $sellerBannerPic = "placeholder logo.png";
        if ($sellerQuery && mysqli_num_rows($sellerQuery) > 0) 
        {
            $seller = mysqli_fetch_assoc($sellerQuery);
            $disp_sellername = $seller['UserName'];
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queries List</title>
    <link rel="stylesheet" href="treasure hub seller page home.css">
    <link rel="stylesheet" href="treasure hub seller page listing.css">
    <link rel="stylesheet" href="treasure hub developer listing page.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .SectionContainer
        {
    /*
    display: block;
    width:100%;
    margin-bottom: 20px;
   padding: 20px;*/
            display: block;
            margin-top: 2em;
            margin-left: 2em;
        }
    </style>
</head>
<body>
    <header>
        <nav class = "MainNavbar">
            <button class = "MainLogo" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "Treasure hub foods logo reduced 4.png" ></button>
       
            <div class ="Nav-links">
                <button class = "Nav-Buttons" onclick="Logout()">Logout</button>
                <button class = "Nav-Buttons" onclick = "HomeLink()">Home</button>
            </div>
        </nav>
    </header>

    
<div class="SectionContainer" id = "SectionContainer-query" >
  <h2>All Queries</h2>
  <?php
        
        $querySql = "SELECT * FROM queries WHERE SellerID = '$sellerID'";
        $queryResult = $conn->query($querySql);
        if ($queryResult && $queryResult->num_rows > 0)
        {
          while($row = $queryResult->fetch_assoc())
          {
            $queryID = $row['QueryID'];
            $reason = htmlspecialchars($row['Reason']);
            $dateCreated = date("Y-m-d", strtotime($row['dateCreated']));
            $resolved = ($row['isResolved'] == 1) ? "Yes" : "No";
        ?>
        <div class="query-card">
            <div class="query-info">
              <h3>Query #<?= $queryID ?></h3>
              <p><strong>Reason:</strong> <?= $reason ?></p>
              <p><strong>Date Created:</strong> <?= $dateCreated ?></p>
              <p><strong>Resolved:</strong> <?= $resolved ?></p>
              <a href="treasure_hub_seller_query_Display.php?queryid=<?= $queryID ?>" class="btn" style="background-color:rgb(97, 160, 95)">View Details</a>
            </div>
      </div>
      <?php
          }
        } else echo "No queries found.";
      ?>
</div>

    
<script>
    function Logout()
    {
        window.location.href = "treasure_hub_signup_or_login.php";
    }

    function HomeLink()
    {
        window.location.href = "treasure hub seller page home.php";
    }  
</script>

</body>
</html>