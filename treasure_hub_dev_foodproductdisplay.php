<?php
session_start();
include 'connect.php';


$search = isset($_GET['productid']) ? trim($_GET['productid']) : '';
if (!empty($search)) 
{
    $productID = $search;


    $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE ProductID = $productID");
    if (!$product = mysqli_fetch_assoc($productQuery)) {
        echo "Product not found.";
        exit();
    }


    $sellerID = $product['SellerID'];
    $sellerQuery = mysqli_query($conn, "SELECT * FROM seller WHERE SellerID = $sellerID");
    $seller = mysqli_fetch_assoc($sellerQuery);

}
?>

<?php

    if (isset($_POST['delist-btn']))
    {
        if(isset($_SESSION['adminEmail']))
        {
            $email = $_SESSION['adminEmail'];
            $query = mysqli_query($conn, "SELECT Admin.* FROM Admin WHERE Admin.Email ='$email'");
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
        $update= "UPDATE foodproduct SET isSold = 1 WHERE ProductID = $productID";
        $date = date("Y-m-d");
        $description = "Delisted food product number ".$productID;
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

<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
    <link rel="stylesheet" href="treasure hub developer page home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        h2 {
            color: #444;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
            margin-top: 30px;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.05);
        }

        .product-info, .seller-info, .description {
            flex: 1 1 300px;
            margin: 10px;
        }

        .info-box {
            margin-bottom: 10px;
        }

        .info-box label {
            font-weight: bold;
            display: block;
        }

        .info-box input, .info-box textarea {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background: #fefefe;
        }

        .product-images {
            gap: 15px;
            margin-top: 15px;
        }

        .product-images img {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border: 2px solid #bbb;      
            border-radius: 10px;         
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1); 
        }

        .button-container {
            margin-top: 30px;
        }

        .button-container form {
            display: inline;
        }

        .btn {
            background: #e53935;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 10px;
            font-size: 14px;
        }

        .btn:hover {
            background: #c62828;
        }
        .container { max-width: 800px; margin: auto; padding: 20px; font-family: Arial; }
        .section { margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; border-radius: 5px; }
        .images img { width: 100px; height: auto; margin: 5px; border: 1px solid #ddd; }
        .delist-btn { background: red; color: white; padding: 10px 20px; border: none; cursor: pointer; }
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
        </nav>
    </header>

<div class="container">
    <div class="section">
        <h2>Product Details</h2>
        <p><strong>Product ID:</strong> <?= $product['ProductID'] ?></p>
        <p><strong>Name:</strong> <?= htmlspecialchars($product['FoodName']) ?></p>
        <p style="font-weight=600;"><strong>Status:</strong> <?= $product['isSold'] == 0 ? 'Listed' : 'No Longer listed' ?></p>
        <p><strong>Category:</strong> <?= htmlspecialchars($product['CategoryID']) ?></p>
        <p><strong>Price:</strong> R<?= number_format($product['Price'], 2) ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($product['Description']) ?></p>
    </div>

    <div class="section">
        <h2>Seller Details</h2>
        <p><strong>Seller ID:</strong> <?= $seller['SellerID'] ?></p>
        <p><strong>First Name:</strong> <?= htmlspecialchars($seller['FirstName']) ?></p>
        <p><strong>Last Name:</strong> <?= htmlspecialchars($seller['LastName']) ?></p>
        <p><a href=>View Seller Page</a></p>
    </div>

    <div class="section">
        <h2>Product Images</h2>
        <div class="product-images">
        <img src="Images/<?= htmlspecialchars($product['ImagePath']) ?>" alt="<?= htmlspecialchars($product['altText']) ?>">
        </div>
    </div>

    <?php
        $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE ProductID = $productID");
        if ($product = mysqli_fetch_assoc($productQuery)) 
        {
            $isSold = $product['isSold'];
            if($isSold == '0')
            {
                ?>
                <form method="post">
                    <input type="hidden" name="productID" value="<?= $productID ?>">
                    <button type="submit" class="delist-btn" name = "delist-btn">De-list Product</button>
                </form>
                <?php
            }
        }
    ?>
    


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