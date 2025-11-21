<?php
session_start();
include "connect.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller info page</title>
    <link rel="stylesheet" href="treasure hub developer display pages.css">
    <link rel="stylesheet" href="treasure hub developer page home.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
     <header>
        <nav class = "MainNavbar">
            <button class = "MainLogo" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "treasure hub logo reduced 4.png" ></button>
            <div class ="Nav-links">
                <button class = "Nav-Buttons" onclick="Logout()">Logout</button>
                <button class = "Nav-Buttons" onclick = "HomeLink()">Home</button>>
            </div>
        </nav>
    </header>


<div class="seller-details-container">

<?php
$search = isset($_GET['sellerid']) ? trim($_GET['sellerid']) : '';
if (!empty($search)) {
    $sellerID = $search;

    $sellerQuery = mysqli_query($conn, "
        SELECT s.*, sa.StreetAddress, sa.City, sa.POBox
        FROM seller s
        LEFT JOIN selleraddress sa ON s.SellerID = sa.SellerID
        WHERE s.SellerID = $sellerID
    ");

    if ($seller = mysqli_fetch_assoc($sellerQuery)) {
        
        $profilePic = !empty($seller['ProfilePicFile']) ? "Images/" . $seller['ProfilePicFile'] : "placeholder logo.png";
    } else {
        echo "Seller not found.";
        exit();
    }
} 
else {
    echo "Seller ID not provided.";
    exit();
}



if (isset($_POST['delist-seller']))
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
        $update= "UPDATE seller SET allowedToSell = 0 WHERE SellerID = '$sellerID'";
        $date = date("Y-m-d");
        $description = "delisted seller number ".$sellerID;
        if (mysqli_query($conn, $update)) 
        {
            
            $delistquery = mysqli_query($conn,"UPDATE product SET isSold = '1' WHERE SellerID  ='$sellerID'" );
            
            $insert = "INSERT INTO adminaction(AdminID, Description, ActionDate) VALUES ('$adminID','$description','$date')";
            if (mysqli_query($conn, $insert)) 
            {
                header("Location:treasure hub developer page home.php");
            }
        }
    }

    if (isset($_POST['verify-seller']))
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
        $update= "UPDATE seller SET Verified = 1 WHERE SellerID = '$sellerID'";
        $date = date("Y-m-d");
        $description = "Verified seller number ".$sellerID;
        if (mysqli_query($conn, $update)) 
        {            
            $insert = "INSERT INTO adminaction(AdminID, Description, ActionDate) VALUES ('$adminID','$description','$date')";
            if (mysqli_query($conn, $insert)) 
            {
                header("Location:treasure hub developer page home.php");
            }
        }
    }
?>
    <div class="profile-section">
        <img src="<?= $profilePic ?>" alt="Seller Profile" class="profile-pic">
    </div>

    <div class="form-section">
        <label>Seller ID:</label>
        <input type="text" value="<?= $seller['SellerID'] ?>" readonly>

        <label>First Name:</label>
        <input type="text" value="<?= htmlspecialchars($seller['FirstName']) ?>" readonly>

        <label>Last Name:</label>
        <input type="text" value="<?= htmlspecialchars($seller['LastName']) ?>" readonly>

        <label>Email:</label>
        <input type="text" value="<?= htmlspecialchars($seller['Email']) ?>" readonly>

        <label>Username:</label>
        <input type="text" value="<?= htmlspecialchars($seller['UserName']) ?>" readonly>

        <label>Date Joined:</label>
        <input type="text" value="<?= date("d M Y", strtotime($seller['dateJoined'])) ?>" readonly>

        <label>Description:</label>
        <textarea readonly><?= htmlspecialchars($seller['Description']) ?></textarea>
    </div>

    <div class="address-section">
        <h3>Address Details</h3>

        <label>Street Address:</label>
        <input type="text" value="<?= htmlspecialchars($seller['StreetAddress']) ?>" readonly>

        <label>City:</label>
        <input type="text" value="<?= htmlspecialchars($seller['City']) ?>" readonly>

        <label>PO Box:</label>
        <input type="text" value="<?= htmlspecialchars($seller['POBox']) ?>" readonly>
    </div>

    <div class="action-buttons">
        <form method="post">
            <input type="hidden" name="sellerID" value="<?= $seller['SellerID'] ?>">
            <button type="submit" class="btn verify-btn" name = "verify-seller">Verify Seller</button>
        </form>

        <form method="post" onsubmit="return confirm('Are you sure you want to de-list this seller?');">
            <input type="hidden" name="sellerID" value="<?= $seller['SellerID'] ?>">
            <button type="submit" class="btn delete-btn" name = "delist-seller">Delete Seller</button>
        </form>
    </div>
</div>

</div>
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