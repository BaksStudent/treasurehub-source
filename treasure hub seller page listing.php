<?php
session_start();
include "connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Page Listing</title>
    <link rel="stylesheet" href="treasure hub seller page home.css">
    <link rel="stylesheet" href="treasure hub seller page listing.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    <footer id = "listingFooter">
        <button onclick = "CreateListing()">Create a new listing</button>
    </footer>

    

    <section class = messageBackground id = "editSuccesfulMessage" onclick="DisableMessage()" style="display: none;">
        <div class = "messageContainer">
            <h6>Item was edited successfully</h6>
        </div>
    </section>
    <div class="toggle-container">
        <button id="offBtn" class="toggle-button active" onclick="toggleState('product')">Products</button>
        <button id="onBtn" class="toggle-button" onclick="toggleState('food')">Food</button>
    </div>

    
    <section class = "ListBackground" id = "ListBackground">
        <h3>Manage listings</h3>

       <?php
            if (isset($_SESSION['email'])) {
                 $email = $_SESSION['email'];
                 $sellerQuery = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");

                if ($sellerQuery && mysqli_num_rows($sellerQuery) > 0) {
                $sellerRow = mysqli_fetch_assoc($sellerQuery);
                $sellerID = $sellerRow['SellerID'];

                $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE SellerID = '$sellerID'");
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                while ($row = mysqli_fetch_assoc($productQuery)) {
                    $productId = $row["ProductID"];
                    $profilePicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";

                    $imageQuery = mysqli_query($conn, "SELECT * FROM productimages WHERE ProductID = '$productId' LIMIT 1");
                    if ($imageQuery && mysqli_num_rows($imageQuery) > 0) {
                        $imgRow = mysqli_fetch_array($imageQuery);
                        if (!empty($imgRow['ImagePath'])) {
                            $profilePicPath = "Images/" . $imgRow['ImagePath'];
                            $altText = $imgRow['altText'];
                        }
                    }
                ?>

                 <div class="referenceItem-Container">
                    <div class="referenceItem-ContentContainer">
                        <div class="referenceItem-imageContainer">
                            <img src="<?php echo $profilePicPath ?>" alt="<?php echo $altText ?>">
                        </div>
                        <div class="referenceItem-middleTextContainer">
                            <div class="referenceItem-PlaceholderReference">
                                <p><?php echo htmlspecialchars($row['ProductName']); ?></p>
                            </div>
                            <div class="referenceItem-PlaceholderDescription">
                                <p><?php echo htmlspecialchars($row['shortDescription']); ?></p>
                            </div>
                        </div>
                        <div class="referenceItem-dateButtonContainer">
                            <div class="referenceItem-DateAndTimeReference">
                                <p><?php echo htmlspecialchars($row['listingDate']); ?></p>
                            </div>
                            <div class="referenceItem-detailsButton">
                                <button onclick="EditListing('<?php echo htmlspecialchars($row['ProductID'], ENT_QUOTES); ?>')">Edit listing</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
        } else {
            echo "Products not found.";
        }
    } else {
        echo "Email not found.";
    }
} else {
    echo "Email not set.";
}
?>
        
       
        
    </section>






    <section class = "ListBackground" id = "FoodListBackground">
        <h3>Manage Food listings</h3>

       <?php
            if (isset($_SESSION['email'])) {
                 $email = $_SESSION['email'];
                 $sellerQuery = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");

                if ($sellerQuery && mysqli_num_rows($sellerQuery) > 0) {
                $sellerRow = mysqli_fetch_assoc($sellerQuery);
                $sellerID = $sellerRow['SellerID'];

                $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE SellerID = '$sellerID'");
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                while ($row = mysqli_fetch_assoc($productQuery)) {
                    $productId = $row["ProductID"];
                    $profilePicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";
                    if(!empty($row["ImagePath"]))
                    {
                        $profilePicPath = "Images/" . $row['ImagePath'];
                        $altText = $row['altText'];
                    }
                ?>

                 <div class="referenceItem-Container">
                    <div class="referenceItem-ContentContainer">
                        <div class="referenceItem-imageContainer">
                            <img src="<?php echo $profilePicPath ?>" alt="<?php echo $altText ?>">
                        </div>
                        <div class="referenceItem-middleTextContainer">
                            <div class="referenceItem-PlaceholderReference">
                                <p><?php echo htmlspecialchars($row['FoodName']); ?></p>
                            </div>
                            <div class="referenceItem-PlaceholderDescription">
                                <p><?php echo htmlspecialchars($row['Description']); ?></p>
                            </div>
                        </div>
                        <div class="referenceItem-dateButtonContainer">
                            <div class="referenceItem-DateAndTimeReference">
                                <p><?php echo htmlspecialchars($row['ListingDate']); ?></p>
                            </div>
                            <div class="referenceItem-detailsButton">
                                <button onclick="EditFoodListing('<?php echo htmlspecialchars($row['ProductID'], ENT_QUOTES); ?>')">Edit listing</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
        } else {
            echo "Products not found.";
        }
    } else {
        echo "Email not found.";
    }
} else {
    echo "Email not set.";
}
?>
    
    </section>














   


    <script>
            function Logout()
            {
                window.location.href = "treasure_hub_signup_or_login.php";
            }
            function HomeLink()
            {
                window.location.href = "treasure hub seller page home.php";
            }
            let isFoodProduct = false; 
            function RedoPage()
            {
                const product = JSON.parse(localStorage.getItem("backupProduct"));
         
            }

            function deleteProductFromDB(productId) 
            {
                fetch('delete_product.php', 
                {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ productId })
                })
                .then(res => res.text())
                .then(msg => {
                    console.log("Deleted:", msg);
                    RedoPage(); 
                });
            }

            function EditListing(productID)
            {
                fetch('set_product_session.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'productId=' + encodeURIComponent(productID)
                })
                .then(response => response.text())
                .then(data => {
                
                    window.location.href = "treasure hub seller edit pages.php?edit=product";
                    document.body.scrollTop = 0; // For Safari
                    document.documentElement.scrollTop = 0;
                })
                .catch(error => {
                console.error('Error:', error);
                });
            }

            function EditFoodListing(productID)
            {
                fetch('set_product_session.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'productId=' + encodeURIComponent(productID)
                })
                .then(response => response.text())
                .then(data => {
                
                    window.location.href = "treasure hub seller edit pages.php?edit=food";
                })
            .catch(error => {
            console.error('Error:', error);
            });
            }

            function toggleState(state) 
            {
                const onBtn = document.getElementById('onBtn');
                const offBtn = document.getElementById('offBtn');

                if (state === 'food') 
                {
                    onBtn.classList.add('active');
                    offBtn.classList.remove('active');
                    document.getElementById("ListBackground").style.display = "none";
                    document.getElementById("FoodListBackground").style.display = "block";
                    isFoodProduct = true;
                }
                 else 
                {
                    offBtn.classList.add('active');
                    onBtn.classList.remove('active');
                    document.getElementById("ListBackground").style.display = "block";
                    document.getElementById("FoodListBackground").style.display = "none";
                    isFoodProduct = false;
                }
            }

            function CreateListing()
            {
                if (isFoodProduct)
                {
                    window.location.href = "treasure hub seller page home.php?view=flist";
                }
                else
                {
                    window.location.href = "treasure hub seller page home.php?view=list";
                }
                
            }

            function getQueryParam(name) 
            {
                const params = new URLSearchParams(window.location.search);
                return params.get(name);
            }

            function maincall()
            {
                const action = getQueryParam('action');
                if (action === "edit") 
                {
                    const editSuccessful = document.getElementById("editSuccesfulMessage");
                    editSuccessful.style.display = "block";
                    const body = document.body;
                    body.style.overflow = "hidden";
                }
            }

            function DisableMessage()
            {
                const editSuccessful = document.getElementById("editSuccesfulMessage");
                editSuccessful.style.display = "none";
                const body = document.body;
                body.style.overflow = "auto";
            }

            function redoOptionGroup()
            {
                document.getElementById("StartOverCaution").style.display = "flex";
                const body = document.body;
                body.style.overflow = "hidden";

            }

            window.addEventListener("load", maincall);
    </script>
    <!--<script src="treasure hub seller page listing.js"></script>-->
</body>
</html>