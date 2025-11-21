<?php
session_start();
include "connect.php";


$search = isset($_GET['queryid']) ? trim($_GET['queryid']) : '';
if (!empty($search)) 
{
    $queryID = $search;
    $queryResult = mysqli_query($conn, "SELECT * FROM queries WHERE QueryID = $queryID");
    if (!$queryResult || mysqli_num_rows($queryResult) == 0) {
        echo "Query not found.";
        exit;
}

$query = mysqli_fetch_assoc($queryResult);
$sellerID = $query['SellerID'];
$reason = $query['Reason'];
$description = $query['UserDescription'];
$dateCreated = $query['dateCreated'];

// Get seller details
$sellerResult = mysqli_query($conn, "SELECT * FROM seller WHERE SellerID = $sellerID");
$seller = mysqli_fetch_assoc($sellerResult);
$sellerName = $seller['UserName'];

// Count queries for this seller
$countResult = mysqli_query($conn, "SELECT COUNT(*) AS queryCount FROM queries WHERE SellerID = $sellerID");
$countRow = mysqli_fetch_assoc($countResult);
$sellerQueryCount = $countRow['queryCount'];
}
else{
    echo "query not found";
}

// Get query details

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Query Details</title>
    <link rel="stylesheet" href="treasure hub developer page home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    .section {
      background: #fff;
      padding: 1rem;
      margin-bottom: 1rem;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      margin: 20px;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 10px;
    }

    input[type="text"], textarea {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
      background-color: #eee;
    }

    textarea {
      resize: vertical;
      height: 80px;
    }

    .btn {
      display: inline-block;
      margin-top: 15px;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      text-decoration: none;
      font-size: 16px;
    }

    .resolve-btn {
      background-color: #27ae60;
      color: white;
    }

    .delete-btn {
      background-color: #e74c3c;
      color: white;
      margin-left: 10px;
    }
  </style>
</head>
<body>
    <header>
        <nav class = "MainNavbar">
            <button class = "MainLogo" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "treasure hub logo reduced 4.png" ></button>
              <div class ="Nav-links">
                <button class = "Nav-Buttons" onclick="Logout()">Logout</button>
                <button class = "Nav-Buttons" onclick = "HomeLink()">Home</button>>
             </div>
            </div>
        </nav>
    </header>

<div class="section">
  <h2>Query Details</h2>

  <label for="queryID">Query ID</label>
  <input type="text" id="queryID" value="<?= $queryID ?>" readonly>

  <label for="reason">Reason</label>
  <input type="text" id="reason" value="<?= htmlspecialchars($reason) ?>" readonly>

  <label for="userdescription">User Description</label>
  <textarea readonly><?= htmlspecialchars($description) ?></textarea>

  <label for="datecreated">Date Created</label>
  <input type="text" id="datecreated" value="<?= $dateCreated ?>" readonly>
</div>

<div class="section">
  <h2>Seller Details</h2>
  <p><strong>Seller:</strong> <?= htmlspecialchars($sellerName) ?></p>
  <p><strong>Total Queries:</strong> <?= $sellerQueryCount ?></p>
</div>

<div class="section">
  <form method="post">
    <input type="hidden" name="queryid" value="<?= $queryID ?>">
    <input type="hidden" name="sellerid" value="<?= $sellerID ?>">
    <button type="submit" name="resolve" class="btn resolve-btn">Mark Query as Resolved</button>
    <button type="submit" name="delete_seller" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this seller?')">Solve by Deleting Seller</button>
  </form>
</div>

<?php
// Handle form actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['resolvehgyg'])) {
        $id = intval($_POST['queryid']);
        mysqli_query($conn, "UPDATE queries SET isResolved = 1 WHERE QueryID = $id");
        echo "<script>alert('Query marked as resolved'); location.href='treasure_hub_dev_querydisplay.php?queryid=$id';</script>";
    }

    if (isset($_POST['resolve']))
    {
        if(isset($_SESSION['adminEmail']))
        {
            $email = $_SESSION['adminEmail'];
            $query = mysqli_query($conn, "SELECT * FROM admin WHERE Email ='$email'");
            while($row = mysqli_fetch_array($query))
            {
                $adminID = $row['AdminID'];
            }
        }
        else
        {
            echo "admin not logged in";
            exit();
        }
        
        $id = intval($_POST['queryid']);
        mysqli_query($conn, "UPDATE queries SET isResolved = 1 WHERE QueryID = $id");
        $update= "UPDATE seller SET allowedToSell = 0 WHERE SellerID = '$sellerID'";
        $date = date("Y-m-d");
        $description = "solved query no ".$id."By delisting".$sellerID;
        if (mysqli_query($conn, $update)) 
        {
            
            $delistquery = mysqli_query($conn,"UPDATE product SET isSold = '1' WHERE SellerID  ='$sellerID'" );
            
            $insert = "INSERT INTO adminaction(AdminID, Description, ActionDate,QueryID) VALUES ('$adminID','$description','$date','$id')";
            if (mysqli_query($conn, $insert)) 
            {
                header("Location:treasure hub developer page home.php");
            }
        }
    }

    if (isset($_POST['delete_seller'])) {
        $sid = intval($_POST['sellerid']);
        mysqli_query($conn, "UPDATE seller SET isResolved = 1 WHERE SellerID = $id");
        echo "<script>alert('Seller deleted'); location.href='treasure hub developer listing page.php?';</script>";
    }
}
?>
<script>
    function Logout()
    {
        window.location.href = "treasure_hub_signup_or_login.php";
    }
        
    function HomeLink()
    {
        window.location.href = "treasure hub developer page home.php";
    }
</script>
</body>
</html>