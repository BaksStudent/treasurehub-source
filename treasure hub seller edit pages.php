<?php
session_start();
include "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="treasure hub seller page home.css">
    <link rel="stylesheet" href="treasure hub seller page listing.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" /></header>
</head>
<body>
    <header>
        <nav class = "MainNavbar">
            <button class = "MainLogo" ><img src =  "treasure hub logo reduced 4.png" ></button>
       
            <div class ="Nav-links">
              
              <button class = "Nav-Buttons" onclick="Logout()">Logout</button>
              <button class = "Nav-Buttons" onclick = "HomeLink()">Home</button>
            </div>
        </nav>
    </header>
    

    <section class = "editBackground" id= "editBackground">
        <div class = "CaptionSection" id = "CaptionSection" >
            <h2>Create a new listing</h2>
            <form action="register.php" method="post">
                <div class = "infoContainer">
                    <h5>Product name</h5>
                    <Input type="text" placeholder=" "name="Pname" id = "editName" value="<?php
                    if (isset($_SESSION['edit_product_id'])) {
                        $productId = $_SESSION['edit_product_id'];
                    
                        $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '$productId'");
                        
                        if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                            $product = mysqli_fetch_assoc($productQuery);
                            echo $product['ProductName'];
                        } else {
                            echo "Product not found.";
                        }
                    } else {
                        echo "No product ID received.";
                    }
                    ?>" onclick="EditName()"></Input>
                </div>

                <div class = "infoContainer">
                    <h5>Condition</h5>
                    <Input type="text" placeholder=" "name="Pcondition" id = "editCondition" value = "<?php
                    if (isset($_SESSION['edit_product_id'])) 
                    {
                        $productId = $_SESSION['edit_product_id'];
                    
                        $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '$productId'");
                        
                        if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                            $product = mysqli_fetch_assoc($productQuery);
                            echo $product['ProductCondition'];
                        } else {
                            echo "Product not found.";
                        }
                    } 
                    else
                    {
                        echo "No product ID received.";
                    }
                    ?>" onclick="EditCondition()"></Input>
                </div>

                <div class = "infoContainer">
                    <h5>Category</h5>
                    <div class = "CategoryMenu_Drop">
                        <div>
                            <select name="CategoryDropDown" id="CategoryDrop">
                                <option value ="" selected disabled ><a class = "DropText">Select a category
                                </a>
                                </option>
                                <option value="electronics">Electronics</option>
                                <option value="fashion">Fashion</option>
                                <option value="home-kitchen">Home & Kitchen</option>
                                <option value="beauty-health">Beauty & Health</option>
                                <option value="sports-outdoors">Sports & Outdoors</option>
                                <option value="toys-games">Toys & Games</option>
                                <option value="books-media">Books & Media</option>
                                <option value="automotive">Automotive</option>
                                <option value="pet-supplies">Pet Supplies</option>
                                <option value="office-stationery">Office & Stationery</option>
                                <option value="grocery-gourmet">Grocery & Gourmet</option>
                                <option value="baby-maternity">Baby & Maternity</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class = "infoContainer">
                    <h5>Price</h5>
                    <Input type = "number" placeholder="" name="Pprice" min="0" max="100000" id = "editPrice" value="<?php
                    if (isset($_SESSION['edit_product_id'])) {
                        $productId = $_SESSION['edit_product_id'];
                    
                        $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '$productId'");
                        
                        if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                            $product = mysqli_fetch_assoc($productQuery);
                            echo $product['Price'];
                        } else {
                            echo "Product not found.";
                        }
                    } else {
                        echo "No product ID received.";
                    }
                    ?>" onclick="EditPrice()"></Input>
                </div>
                <div class = "infoContainer">
                    <h5>Quantity</h5>
                    <Input type = "number" placeholder="" name="Pquantity" min="0" max="100" id = "editQuantity" value="<?php
                    if (isset($_SESSION['edit_product_id'])) {
                        $productId = $_SESSION['edit_product_id'];
                    
                        $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '$productId'");
                        
                        if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                            $product = mysqli_fetch_assoc($productQuery);
                            echo $product['Quantity'];
                        } else {
                            echo "Product not found.";
                        }
                    } else {
                        echo "No product ID received.";
                    }
                    ?>" onclick="EditQuantity()"></Input>
                </div>
                <div class = "infoContainer">
                    <h5>Short Description</h5>
                    <textarea class="shortTextarea" name="sDescription" id = "editShortDescription" onclick="EditshortDescription()"><?php
                    if (isset($_SESSION['edit_product_id'])) {
                        $productId = $_SESSION['edit_product_id'];
                    
                        $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '$productId'");
                        
                        if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                            $product = mysqli_fetch_assoc($productQuery);
                            echo $product['shortDescription'];
                        } else {
                            echo "Product not found.";
                        }
                    } else {
                        echo "No product ID received.";
                    }
                    ?>    
                    </textarea>
                </div>
                <div class = "infoContainer">
                    <h5>Long Description</h5>
                    <textarea class="longTextarea" name="lDescription" id = "editLongDescription" onclick="EditlongDescription()"><?php
                    if (isset($_SESSION['edit_product_id'])) {
                        $productId = $_SESSION['edit_product_id'];
                    
                        $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '$productId'");
                        
                        if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                            $product = mysqli_fetch_assoc($productQuery);
                            echo $product['longDescription'];
                        } else {
                            echo "Product not found.";
                        }
                    } else {
                        echo "No product ID received.";
                    }
                    ?>  
                    </textarea>
                </div>

                <button class = "editButtons" id="confirmbutton" name = "confirmEditButtons">Confirm your changes</button>
                <br>
            </form>
            <button class = "editButtons" id = "editImagesButton" onclick = "handleImages()">Edit Images</button>
        </div>
        <div class = "ImageSection" id = "ImageSection" style="display: none;">
            <?php
                if (isset($_SESSION['edit_product_id'])) {
                    $productId = $_SESSION['edit_product_id'];

                $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '$productId'");
    
                if ($productQuery && mysqli_num_rows($productQuery) > 0) 
                {
                    $stmt = $conn->prepare("SELECT * FROM productimages WHERE ProductID = ? ORDER BY ImageID ASC LIMIT 4");
                    $stmt->bind_param("i", $productId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $imagePaths = [];
                    $alt_Texts = [];
                    $first = true;

                    while ($row = $result->fetch_assoc()) {
                        if ($first) 
                        {
                            $_SESSION['Temporary_image_ID'] = $row['ImageID'];
                            $first = false;
                        }
                        $imagePaths[] = "Images/" . $row['ImagePath'];
                        $alt_Texts[] = $row['altText'];
                    }
                }
                else
                {
                    echo "Product not found";
                }
            }
            ?>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <h3>Edit Photos</h3>
                <div class = "imageContainer">
                    <h6>Image 1</h6>
                    <img src="<?= $imagePaths[0] ?? 'placeholder logo.png' ?>" alt="<?php echo $alt_Texts[0] ?>" class ="ProductImage" id = "firstProductPic">
                    <br>
                    <input type="file" id="upload" name="productimg1" accept="image/*" style="margin-bottom: 10px;">
                    <div class = "altContainer">
                        <p style="font-size:small;font-weight: 600;margin-bottom: 5px;">add alt text</p>
                        <Input type="text" placeholder=" "name="pic1alt" value="<?php echo $alt_Texts[0] ?>"></Input>  
                    </div>
                
                <button name = "UploadImg1">Upload</button>
                
                </div>
                <div class = "imageContainer">
                    <h6>Image 2</h6>
                    <img src="<?= $imagePaths[1] ?? 'placeholder logo.png' ?>" alt="<?= $alt_Texts[1] ?? 'placeholder logo.png' ?>" class ="ProductImage" id = "SecondProductPic">
                    <br>
                    <input type="file" id="upload" name="productimg2" accept="image/*">
                    <div class = "altContainer">
                        <p style="font-size:small;font-weight: 600;margin-bottom: 5px;">add alt text</p>
                        <Input type="text" placeholder=" "name="pic2alt" value="<?php echo $alt_Texts[1] ?>"></Input>  
                    </div>
                
                <button name = "UploadImg2">Upload</button>
                
                </div>
                <div class = "imageContainer">
                    <h6>Image 3</h6>
                    <img src="<?= $imagePaths[2] ?? 'placeholder logo.png' ?>" alt="<?= $alt_Texts[2] ?>" class ="ProductImage" id = "ThridProductPic" >
                    <br>
                    <input type="file" id="upload" name="productimg3" accept="image/*" >
                    <div class = "altContainer">
                        <p style="font-size:small;font-weight: 600;margin-bottom: 5px;">add alt text</p>
                        <Input type="text" placeholder=" "name="pic3alt" value = "<?php echo $alt_Texts[2] ?>"></Input>  
                    </div>
                
                <button name = "UploadImg3">Upload</button>
                
                </div>
                <div class = "imageContainer">
                    <h6>Image 4</h6>
                    <img src="<?= $imagePaths[3] ?? 'placeholder logo.png' ?>" alt="<?= $alt_Texts[3] ?? 'placeholder logo.png' ?>" class ="ProductImage" id = "FourthProductPic" >
                    <br>
                    <input type="file" id="upload" name="productimg4" accept="image/*" >
                    <div class = "altContainer">
                        <p style="font-size:small;font-weight: 600;margin-bottom: 5px;">add alt text</p>
                        <Input type="text" placeholder=" "name="pic4alt" value = "<?php echo $alt_Texts[3] ?>"></Input>  
                    </div>
                
                    <button name = "UploadImg4">Upload</button>
                
                </div>
            </form>
        </div>
    </section>


    <section class = "editBackground" id= "editFoodBackground" style="display: none;">
        <div class = "CaptionSection" id = "CaptionSection" >
            <h2>Create a new listing</h2>
            <form action="register.php" method="post">
                <div class = "infoContainer">
                    <h5>Product name</h5>
                    <Input type="text" placeholder=" "name="Pname" id = "editName" value="<?php
                    if (isset($_SESSION['edit_product_id'])) 
                    {
                        $productId = $_SESSION['edit_product_id'];
                        $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE ProductID = '$productId'");
                        
                        if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                            $product = mysqli_fetch_assoc($productQuery);
                            echo $product['FoodName'];
                        } else {
                            echo "Product not found.";
                        }
                    }
                    else 
                    {
                        echo "No product ID received.";
                    }
                    ?>" onclick="EditName()"></Input>
                </div>

                <div class = "infoContainer">
                    <h5>Short Description</h5>
                    <textarea class="shortTextarea" name="Food_sDescription"><?php
                    if (isset($_SESSION['edit_product_id'])) 
                    {
                        $productId = $_SESSION['edit_product_id'];
                        $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE ProductID = '$productId'");
                        
                        if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                            $product = mysqli_fetch_assoc($productQuery);
                            echo $product['Description'];
                        } else {
                            echo "Product not found.";
                        }
                    }
                    else 
                    {
                        echo "No product ID received.";
                    }
                    ?>  
                    </textarea>
                </div>

                <div class = "infoContainer">
                    <h5>Price</h5>
                    <Input type = "number" placeholder="" name="Pprice" min="0" max="100000" id = "editPrice" value="<?php
                    if (isset($_SESSION['edit_product_id'])) {
                        $productId = $_SESSION['edit_product_id'];

                        $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE ProductID = '$productId'");
                        
                        if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                            $product = mysqli_fetch_assoc($productQuery);
                            echo $product['Price'];
                        } else {
                            echo "Product not found.";
                        }
                        
                    } else {
                        echo "No product ID received.";
                    }
                    ?>" onclick="EditPrice()"></Input>
                </div>
                <button class = "editButtons" id="confirmbutton" name = "confirmEditButtons">Confirm your changes</button>
                <br>
            </form>
        </div>
        <div class = "ImageSection" id = "ImageSection" >  
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <h3>Edit Photos</h3>
                <div class = "imageContainer">
                    <?php
                    if (isset($_SESSION['edit_product_id'])) {
                        $productId = $_SESSION['edit_product_id'];

                        $productQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE ProductID = '$productId'");
                        
                        if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                            $product = mysqli_fetch_assoc($productQuery);
                            $foodimagePath = 'Images/'.$product['ImagePath'];
                            $foodalt_Texts = $product['altText'];
                        } else {
                            echo "Product not found.";
                        }
                        
                    } else {
                        echo "No product ID received.";
                    }
                    ?>
                    <img src="<?= $foodimagePath ?? 'placeholder logo.png' ?>" alt="<?php echo $foodalt_Texts ?>" class ="ProductImage" id = "firstProductPic">
                    <br>
                    <input type="file" id="upload" name="productimg1" accept="image/*" style="margin-bottom: 10px;">
                    <div class = "altContainer">
                        <p style="font-size:small;font-weight: 600;margin-bottom: 5px;">add alt text</p>
                        <Input type="text" placeholder=" "name="pic1alt" value="<?php echo $foodalt_Texts ?>"></Input>  
                    </div>
                
                <button name = "FoodImgUpload"  style="margin-bottom: 10px; color:white; background-color:rgb(97, 160, 95); border: none;">Upload</button>
                </div>  
            </form>
        </div>

        <button class = "editButtons" id="confirmbutton" name = "">Return to main page</button>
    </section>

    <script src="treasure hub seller edit pages.js"></script>
    <script>
            function Logout()
            {
                window.location.href = "treasure_hub_signup_or_login.php";
            }
            function HomeLink()
            {
                window.location.href = "treasure hub seller page home.php";
            }
            function getQueryParam(name) 
            {
                const params = new URLSearchParams(window.location.search);
                return params.get(name);
            } 
            function RedoListing()
            {
                <?php
                if (isset($_SESSION['email'])) 
                {
                    $email = $_SESSION['email'];
                    $sellerQuery = mysqli_query($conn, "SELECT * FROM seller WHERE Email = '$email'");

                    if ($sellerQuery && mysqli_num_rows($sellerQuery) > 0) 
                    {
                        $sellerRow = mysqli_fetch_assoc($sellerQuery);
                        $sellerID = $sellerRow['SellerID'];
                        if (isset($_SESSION['edit_product_id'])) 
                        {
                            $productId = $_SESSION['edit_product_id'];
                            $stmt = $conn->prepare("SELECT * FROM foodproduct WHERE ProductID = ?");
                            $stmt->bind_param("i", $productId);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result && $row = $result->fetch_assoc()) 
                            {
                                $temp_ProductID = $productId;
                                $temp_foodName = $row['FoodName'];
                                $temp_SellerId = $sellerID;
                                $temp_description = $row['Description'];
                                $temp_price = $row['Price'];
                                $temp_imagePath = $row['ImagePath'];
                                $temp_altText = $row['altText'];
                            } 
                            else 
                            {
                                echo "Product not found.";
                                exit;
                            }
                        } 
                        else 
                        {
                            echo "No product selected.";
                            exit;
                         }
                    }
            
                }
                ?>

                const currentProduct = 
                {
                    productId: <?php echo $temp_ProductID?>,
                    sellerID:<?php echo $temp_SellerId?>,
                    name: "<?php echo $temp_foodName?>",
                    description: "<?php echo htmlspecialchars($temp_description)?>",
                    price: <?php echo $temp_price?>,
                    imagePath: "<?php echo $temp_imagePath?>",
                    altText: "<?php echo $temp_altText?>",
        
                };
                backupProductToLocalStorage(currentProduct);
        
            }


            function backupProductToLocalStorage(product) 
            {
                localStorage.setItem("backupProduct", JSON.stringify(product));
                deleteProductFromDB(<?php echo $temp_ProductID?>)
                
                
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
                    window.location.href = "treasure hub seller page home.php?view=edit"; 
                });
            }



            function maincall()
            {
                const action = getQueryParam('edit');
                if (action === "product") 
                    {
                        const ProductBackground = document.getElementById("editBackground");
                        const FoodBackground = document.getElementById("editFoodBackground");

                        ProductBackground.style.display = "block";
                        FoodBackground.style.display = "none";
                        const dropdown = document.getElementById('CategoryDrop');
                        dropdown.value = '<?php
                            if (isset($_SESSION['edit_product_id'])) 
                            {
                                $productId = $_SESSION['edit_product_id'];
                    
                                $productQuery = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '$productId'");
                        
                                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                                    $product = mysqli_fetch_assoc($productQuery);
                                    echo $product['CategoryID'];
                                }
                                else 
                                {
                                 echo "Product not found.";
                                }
                            }
                            else 
                            {
                                echo "No product ID received.";
                            }
                        ?>';
                    }
                if(action === "food")
                    {
                        const ProductBackground = document.getElementById("editBackground");
                        const FoodBackground = document.getElementById("editFoodBackground");

                        ProductBackground.style.display = "none";
                        FoodBackground.style.display = "block";
                    }
            }


        window.addEventListener("load", maincall);

    </script>
</body>
</html>