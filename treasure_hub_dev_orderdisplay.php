<?php
include "connect.php";


$search = isset($_GET['orderid']) ? trim($_GET['orderid']) : '';
if (!empty($search)) 
{
    $orderID = $search;

$orderQuery = mysqli_query($conn, "
    SELECT o.OrderID, o.OrderDate, o.TotalAmount, o.AddressID, u.DateJoined
    FROM `orders` o
    JOIN user u ON o.UserID = u.UserID
    WHERE o.OrderID = '$orderID'
");

if (!$orderRow = mysqli_fetch_assoc($orderQuery)) {
    echo "Order not found.";
    exit();
}


$addressID = $orderRow['AddressID'];
$addressQuery = mysqli_query($conn, "SELECT * FROM address WHERE AddressID = '$addressID'");
$addressRow = mysqli_fetch_assoc($addressQuery);

$orderItemsQuery = mysqli_query($conn, "
    SELECT od.Quantity, od.Price, p.ProductName, p.ProductID
    FROM order_details od
    JOIN product p ON od.ProductID = p.ProductID
    WHERE od.OrderID = '$orderID'
");
}
    
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <link rel="stylesheet" href="treasure hub developer page home.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .section { margin-bottom: 30px; padding: 15px; border: 1px solid #ccc; border-radius: 8px; }
        .order-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; }
        .users-details-container{padding: 15px;}
    </style>
</head>
<body>
    <header>
        <nav class = "MainNavbar">
            <button class = "MainLogo" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "treasure hub logo reduced 4.png" ></button>
            <div class ="Nav-links">
              <button class = "Nav-Buttons" onclick="Logout()">Logout</button>
              <button class = "Nav-Buttons" onclick = "HomeLink()">Home</button>
            </div>
        </nav>
    </header>
<div class = "users-details-container">
    <h2>Order Details</h2>

    <div class="section">
        <h3>Order Info</h3>
        <p><strong>Order ID:</strong> <?= $orderRow['OrderID'] ?></p>
        <p><strong>Order Date:</strong> <?= $orderRow['OrderDate'] ?></p>
        <p><strong>Total Amount:</strong> R<?= number_format($orderRow['TotalAmount'], 2) ?></p>
        <p><strong>User Joined:</strong> <?= $orderRow['DateJoined'] ?></p>
    </div>

    <div class="section">
        <h3>Shipping Address</h3>
        <?php if ($addressRow): ?>
            <p><strong>Street:</strong> <?= $addressRow['StreetAddress'] ?></p>
            <p><strong>City:</strong> <?= $addressRow['City'] ?></p>
            <p><strong>PO Box:</strong> <?= $addressRow['POBox'] ?></p>
        <?php else: ?>
            <p>Address not found.</p>
        <?php endif; ?>
    </div>

    <div class="section">
        <h3>Products</h3>
        <?php
        $orderItemsQuery = mysqli_query($conn, "
            SELECT od.Quantity, od.Price, p.ProductName, p.ProductID
            FROM order_details od
            JOIN product p ON od.ProductID = p.ProductID
            WHERE od.OrderID = '$orderID'
        ");

        while ($item = mysqli_fetch_assoc($orderItemsQuery)):
            $productID = $item['ProductID'];
            $imgResult = mysqli_query($conn, "SELECT ImagePath FROM productimages WHERE ProductID = '$productID' LIMIT 1");
            $imgRow = mysqli_fetch_assoc($imgResult);
            $imagePath = isset($imgRow['ImagePath']) ? 'Images/' . $imgRow['ImagePath'] : 'Images/default.png'; // default fallback
        ?>
            <div class="order-item" style="display: flex; align-items: center;">
                <img src="<?= $imagePath ?>" alt="Thumbnail" style="width: 60px; height: 60px; object-fit: cover; margin-right: 15px; border-radius: 6px;">
                <div style="flex: 1;">
                    <strong><?= htmlspecialchars($item['ProductName']) ?></strong><br>
                    Quantity: <?= $item['Quantity'] ?> | Price: R<?= number_format($item['Price'], 2) ?>
                    <br><a href="treasure_hub_dev_productdisplay.php?productid=<?= $productID ?>">View Product</a>
                </div>
            </div>
        <?php endwhile; ?>
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