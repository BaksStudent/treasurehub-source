<?php
session_start();
include "connect.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User info page</title>
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

<div class = users-details-container>
<?php
$search = isset($_GET['userid']) ? trim($_GET['userid']) : '';
if (!empty($search)) {
    $userID = $search;
    $userQuery = mysqli_query($conn, "SELECT * FROM user WHERE UserID = $userID");
    $user = mysqli_fetch_assoc($userQuery);
    $addressQuery = mysqli_query($conn, "SELECT * FROM `address` WHERE UserID = $userID");
    $address = mysqli_fetch_assoc($addressQuery);
    $ordersQuery = mysqli_query($conn, "SELECT * FROM orders WHERE UserID = $userID ORDER BY OrderDate DESC");
}
else echo "user not found";


if (isset($_POST['delete_user']))
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
        $update= "UPDATE user SET IsBanned = 1 WHERE UserID = '$userID'";
        $date = date("Y-m-d");
        $description = "Removed user number ".$userID;
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


    <h2>User Details</h2>

    <div class="section">
        <h3>Personal Information</h3>
        <div class="field"><label>First Name:</label> <?= htmlspecialchars($user['FirstName']) ?></div>
        <div class="field"><label>Last Name:</label> <?= htmlspecialchars($user['LastName']) ?></div>
        <div class="field"><label>Email:</label> <?= htmlspecialchars($user['Email']) ?></div>
        <div class="field"><label>Status:</label> 
        <?php
        $isbanned = $user['IsBanned'];
        if($isbanned == '0')
        {
            echo htmlspecialchars('Active');
        }
        else{
            echo htmlspecialchars('Banned');
        }
         ?>
         </div>
    </div>

    <div class="section">
        <h3>Addresses</h3>
        <?php if (mysqli_num_rows($addressQuery) > 0): ?>
            <?php while ($address = mysqli_fetch_assoc($addressQuery)): ?>
                <div class="address-box">
                    <div class="field"><label>Street:</label> <?= htmlspecialchars($address['StreetAddress']) ?></div>
                    <div class="field"><label>City:</label> <?= htmlspecialchars($address['City']) ?></div>
                    <div class="field"><label>PO Box:</label> <?= htmlspecialchars($address['POBox']) ?></div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No addresses found.</p>
        <?php endif; ?>
    </div>

    <div class="section">
        <h3>Order History</h3>
        <?php if (mysqli_num_rows($ordersQuery) > 0): ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = mysqli_fetch_assoc($ordersQuery)): ?>
                        <tr>
                            <td><?= $order['OrderID'] ?></td>
                            <td><?= $order['OrderDate'] ?></td>
                            <td>R<?= number_format($order['TotalAmount'], 2) ?></td>
                            <td><a href="treasure_hub_dev_orderdisplay.php?orderid=<?= $order['OrderID'] ?>">View</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>This user has no orders.</p>
        <?php endif; ?>
    </div>

    <button class = "back-button" >back</button>

    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
        <input type="hidden" name="delete_user_id" value="<?php echo htmlspecialchars($user['UserID']); ?>">
        <button type="submit" name="delete_user" class="delete-button">Delete User</button>
    </form>
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