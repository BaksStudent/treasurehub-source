<?php
    session_start();
    include 'connect.php';
    if(isset($_SESSION['email']))
    {
        $email = $_SESSION['email'];
        $query = mysqli_query($conn, "SELECT seller.* FROM seller WHERE seller.Email ='$email'");
        while($row = mysqli_fetch_array($query))
        {
            if (is_null($row['ProfilePicFile']))
            {
                header("Location: treasure hub settings page.php?action=sell");
            } 
        }
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller home page</title>
    <link rel="stylesheet" href="treasure hub seller page home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <header>
        <nav class = "MainNavbar">
            <button class = "MainLogo" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "treasure hub logo reduced 4.png" onclick="homePageLink()"></button>
        <div class="Acc-Name" id = "Acc-Name">
        <p>
            Hi <?php
            if(isset($_SESSION['email']))
            {
                $email = $_SESSION['email'];
                $query = mysqli_query($conn, "SELECT seller.* FROM seller WHERE seller.Email ='$email'");
                while($row = mysqli_fetch_array($query))
            {
                echo $row['UserName'];
            }
            }
      ?>
      </p>

    </div>
            <div class ="Nav-links"> 
              <button class = "Nav-Buttons" onclick="Logout()">Logout</button>
              <button class = "Nav-Buttons" onclick = "HomeLink()">Home</button>
            </div>
        </nav>
    </header>

    <div class = "Background" id = "mainback">
        <section class="optionsContainer" id="accountinfoLink" onclick="accountInfoEnter()">
            <div class = "optionsContainer-title">
                Account Info
            </div>
            <div class = "optionsContainer-contentContainer">
                <div class="optionsContainer-imageContainer">
                    <img src="Account info.png" alt="An image of an I inside a question mark">
                </div>
                <div class = "optionsContainer-wordscontainer">
                    <p>View your account info</p>
                </div>
            </div>
        </section>

        <section class="optionsContainer" id = "listingsLink" onclick = "manageListing()">
            <div class = "optionsContainer-title">
                Listings
            </div>
            <div class = "optionsContainer-contentContainer">
                <div class="optionsContainer-imageContainer">
                    <img src="listing.png" alt="">
                </div>
                <div class = "optionsContainer-wordscontainer">
                    <p>View all your listings here</p>
                </div>
            </div>
        </section>
        <section class="optionsContainer" id="SellerqueriesandReportsLink" onclick="QueriesList()">
            <div class = "optionsContainer-title">
                Queries and Reports
            </div>
            <div class = "optionsContainer-contentContainer">
                <div class="optionsContainer-imageContainer">
                    <img src="Queries and reports.png" alt="">
                </div>
                <div class = "optionsContainer-wordscontainer">
                    <p>View all queries and reports here</p>
                </div>
            </div>
        </section>
       

    </div>





    <div class = "createSellerBackground" id = "createSellerBackground" style="display:none;">
        <h2>Create a new listing</h2>
        <form action="register.php" method="post" enctype="multipart/form-data">
            <div class = "infoContainer">
                    <h5>Product name</h5>
                    <Input type="text" placeholder=" "name="Pname" required></Input>
            </div>

            <div class = "infoContainer">
                    <h5>Condition</h5>
                    <Input type="text" placeholder=" "name="Pcondition" required></Input>
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
                                <option value="baby-maternity">Baby & Maternity</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class = "infoContainer">
                    <h5>Price</h5>
                    <Input type = "number" placeholder=" " name="Pprice" min="0" max="100000" value="0" required></Input>
            </div>
            <div class = "infoContainer">
                    <h5>Quantity</h5>
                    <Input type = "number" placeholder=" " name="Pquantity" min="0" max="100" value="0" required></Input>
            </div>
            <div class = "infoContainer">
                    <h5>Short Description</h5>
                    <textarea class="shortTextarea" name="sDescription">
                        
                    </textarea>
            </div>
            <div class = "infoContainer">
                    <h5>Long Description</h5>
                    <textarea class="longTextarea" name="lDescription">
                        
                    </textarea>
            </div>

            <h3>Photo Upload</h3>
            <h5>You need a minimum of 4 images when listing a new product</h5>

            <div class = "imageContainer">
                <h6>Image 1</h6>
                <img src="placeholder logo.png" alt="Profile Picture" class ="ProductImage" id = "firstProductPic">
                <br>
                <input type="file" id="upload" name="productimg1" accept="image/*" style="margin-bottom: 10px;" onchange="preview1stImage(event)" required >
                <div class = "altContainer">
                    <p style="font-size:small;font-weight: 600;margin-bottom: 5px;">add alt text</p>
                    <Input type="text" placeholder=" "name="pic1alt" required></Input>  
                </div>
                <!--
                <button name = "UploadImg1">Upload</button>
                -->
            </div>
            <div class = "imageContainer">
                <h6>Image 2</h6>
                <img src="placeholder logo.png" alt="Profile Picture" class ="ProductImage" id = "SecondProductPic">
                <br>
                <input type="file" id="upload" name="productimg2" accept="image/*" onchange="preview2ndImage(event)"required>
                <div class = "altContainer">
                    <p style="font-size:small;font-weight: 600;margin-bottom: 5px;">add alt text</p>
                    <Input type="text" placeholder=" "name="pic2alt" required></Input>  
                </div>
                <!--
                <button name = "UploadImg2">Upload</button>
                -->
            </div>
            <div class = "imageContainer">
                <h6>Image 3</h6>
                <img src="placeholder logo.png" alt="Profile Picture" class ="ProductImage" id = "ThridProductPic" >
                <br>
                <input type="file" id="upload" name="productimg3" accept="image/*" onchange="preview3rdImage(event)" required>
                <div class = "altContainer">
                    <p style="font-size:small;font-weight: 600;margin-bottom: 5px;">add alt text</p>
                    <Input type="text" placeholder=" "name="pic3alt" required></Input>  
                </div>
                <!--
                <button name = "UploadImg3">Upload</button>
                -->
            </div>
            <div class = "imageContainer">
                <h6>Image 4</h6>
                <img src="placeholder logo.png" alt="Profile Picture" class ="ProductImage" id = "FourthProductPic" >
                <br>
                <input type="file" id="upload" name="productimg4" accept="image/*" onchange="preview4thImage(event)" required>
                <div class = "altContainer">
                    <p style="font-size:small;font-weight: 600;margin-bottom: 5px;">add alt text</p>
                    <Input type="text" placeholder=" "name="pic4alt" required></Input>  
                </div>
                <!--
                <button name = "UploadImg4">Upload</button>
                -->
            </div>

            <button class = "SumbitButton" name = "SellerListing">Submit button</button>

        </form>
            
    </div>    













    <div class = "createFoodListingBackground" id = "createFoodListingBackground" style="display:none;">
        <h2>Create a new food listing</h2>
        <form action="register.php" method="post" enctype="multipart/form-data">
            <div class = "infoContainer">
                    <h5>Product name</h5>
                    <Input type="text" name="Food_Pname" required>
            </div>

            <div class = "infoContainer">
                    <h5>Short Description</h5>
                    <textarea class="shortTextarea" name="Food_sDescription" required>
                        
                    </textarea>
            </div>
            <div class = "infoContainer">
                    <h5>Price</h5>
                    <Input type = "number" placeholder=" " name="Food_Pprice" min="0" max="100000" value="0" required></Input>
            </div>
            <div class = "infoContainer">
                    <h5>Category</h5>
                    <div class = "CategoryMenu_Drop">
                        <div>
                            <select name="CategoryDropDown" id="CategoryDrop">
                                <option value ="" selected disabled ><a class = "DropText">Select a category
                                </a>
                                </option>
                                <option value="produce">Fresh Produce</option>
                                <option value="meat">Meat & Seafood</option>
                                <option value="dairy">Dairy & Eggs</option>
                                <option value="bakery">Bakery</option>
                                <option value="pantry">Pantry Essentials</option>
                                <option value="ready-to-eat">Ready-to-Eat</option>
                                <option value="condiments">Condiments & Sauces</option>
                                <option value="sweets">Sweets & Treats</option>
                                <option value="beverages">Beverages</option>
                                <option value="baby-kids">Baby & Kids</option>
                            </select>
                        </div>
                    </div>
            </div>



            

            <h3>Photo Upload</h3>

            <div class = "imageContainer">
                <img src="placeholder logo.png" alt="Profile Picture" class ="ProductImage" id = "FoodProductPic">
                <br>
                <input type="file" id="upload" name="food_productimg" accept="image/*" style="margin-bottom: 10px;" onchange="previewfoodImage(event)" required >
                <div class = "altContainer">
                    <p style="font-size:small;font-weight: 600;margin-bottom: 5px;">add alt text</p>
                    <Input type="text" placeholder=" "name="food_picalt" required></Input>  
                </div>
            </div>
            

            <button class = "SumbitButton" name = "FoodSellerListing">Submit button</button>

        </form>
            
    </div>


    <div class = "createFoodListingBackground" id = "EditFoodListingBackground" style="display:none;">
        <h2>Create a new food listing</h2>
        <form action="register.php" method="post" enctype="multipart/form-data">
            <div class = "infoContainer">
                    <h5>Product name</h5>
                    <Input type="text" name="Food_Pname" id = "Food_Pname_edit" required>
                    <Input type="text" name = "Food_Pt" id ="Food_Pt" style="display:none;">
            </div>

            <div class = "infoContainer">
                    <h5>Category</h5>
                    <div class = "CategoryMenu_Drop">
                        <div>
                            <select name="CategoryDropDown" id="CategoryDrop">
                                <option value ="" selected disabled ><a class = "DropText">Select a category
                                </a>
                                </option>
                                <option value="produce">Fresh Produce</option>
                                <option value="meat">Meat & Seafood</option>
                                <option value="dairy">Dairy & Eggs</option>
                                <option value="bakery">Bakery</option>
                                <option value="pantry">Pantry Essentials</option>
                                <option value="ready-to-eat">Ready-to-Eat</option>
                                <option value="condiments">Condiments & Sauces</option>
                                <option value="sweets">Sweets & Treats</option>
                                <option value="beverages">Beverages</option>
                                <option value="baby-kids">Baby & Kids</option>
                            </select>
                        </div>
                    </div>
            </div>

            <div class = "infoContainer">
                    <h5>Short Description</h5>
                    <textarea class="shortTextarea" name="Food_sDescription" id ="Food_sDescription_edit" required>
                        
                    </textarea>
            </div>
            <div class = "infoContainer">
                    <h5>Price</h5>
                    <Input type="number" placeholder=" " name="Food_Pprice" id = "Food_Pprice_edit" min="0" max="100000" value="0" required></Input>
            </div>

            <h3>Photo Upload</h3>

            <div class = "imageContainer">
                <img src="placeholder logo.png" alt="Profile Picture" class ="ProductImage" id = "FoodProductPic">
                <br>
                <input type="file" id="upload" name="food_productimg" accept="image/*" style="margin-bottom: 10px; color:white; background-color:rgb(97, 160, 95); border: none;"  onchange="previewfoodImage(event)" required >
                <div class = "altContainer">
                    <p style="font-size:small;font-weight: 600;margin-bottom: 5px;">add alt text</p>
                    <Input type="text" placeholder=" "name="food_picalt" required></Input>  
                </div>
            </div>
            

            <button class = "SumbitButton" name = "EditFoodSellerListing">Submit button</button>

        </form>
            
    </div>




   <script src="treasure hub seller page home.js"></script>
   <script>
    function Logout()
    {
        window.location.href = "treasure_hub_signup_or_login.php";
    }
    function HomeLink()
    {
        window.location.href = "treasure hub seller page home.php";
    }
    function QueriesList()
    {
        window.location.href = "treasure hub seller query page list.php";
    }
   </script>
        
</body>
</html>