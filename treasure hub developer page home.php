
<?php
include "connect.php";
session_start();


if(isset($_SESSION['adminEmail']))
{
   
}
else
{
    header("Location: treasure_hub_signup_or_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Home Page</title>
    <link rel="stylesheet" href="treasure hub developer page home.css">
</head>
<body>

    <header>
        <nav class = "MainNavbar">
            <button class = "MainLogo" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "treasure hub logo reduced 4.png"></button>
       
            
            <div class ="Nav-links">
              <button class = "Nav-Buttons" onclick="Logout()">Logout</button>
              <button class = "Nav-Buttons" onclick = "HomeLink()">Home</button>
            </div>
        </nav>
    </header>

    <div class = "Background" >
         <section class="optionsContainer" id="ordersLink" onclick="CallProducts()">
            <div class = "optionsContainer-title">
                Products
            </div>
            <div class = "optionsContainer-contentContainer">
                <div class="optionsContainer-imageContainer">
                    <img src="Products.png" alt="A picture of products">
                </div>
                <div class = "optionsContainer-wordscontainer">
                    <p>View all Products here</p>
                </div>
            </div>
        </section>

        <section class="optionsContainer" id="ordersLink" onclick="CallFoodProducts()">
            <div class = "optionsContainer-title">
                Food Products
            </div>
            <div class = "optionsContainer-contentContainer">
                <div class="optionsContainer-imageContainer">
                    <img src="Products.png" alt="A picture of products">
                </div>
                <div class = "optionsContainer-wordscontainer">
                    <p>View all food products here</p>
                </div>
            </div>
        </section>


        <section class="optionsContainer" id="ordersLink" onclick="CallOrder()">
            <div class = "optionsContainer-title">
                Orders
            </div>
            <div class = "optionsContainer-contentContainer">
                <div class="optionsContainer-imageContainer">
                    <img src="Orders.png" alt="A picture of products">
                </div>
                <div class = "optionsContainer-wordscontainer">
                    <p>View all orders here</p>
                </div>
            </div>
        </section>

        <section class="optionsContainer" id="ordersLink" onclick="CallFoodOrder()">
            <div class = "optionsContainer-title">
                Food Orders
            </div>
            <div class = "optionsContainer-contentContainer">
                <div class="optionsContainer-imageContainer">
                    <img src="Orders.png" alt="A picture of products">
                </div>
                <div class = "optionsContainer-wordscontainer">
                    <p>View all food orders here</p>
                </div>
            </div>
        </section>

        <section class="optionsContainer" id="sellersLink" onclick = "CallSellers()">
            <div class = "optionsContainer-title">
                Sellers
            </div>
            <div class = "optionsContainer-contentContainer">
                <div class="optionsContainer-imageContainer">
                    <img src="sellers.png" alt="">
                </div>
                <div class = "optionsContainer-wordscontainer">
                    <p>View all seller here</p>
                </div>
            </div>
        </section>

        <section class="optionsContainer" id="customersLink" onclick = "CallUsers()">
            <div class = "optionsContainer-title">
                Customers
            </div>
            <div class = "optionsContainer-contentContainer">
                <div class="optionsContainer-imageContainer">
                    <img src="Customers.png" alt="A picture of a women helping two customers">
                </div>
                <div class = "optionsContainer-wordscontainer">
                    <p>View all customers here</p>
                </div>
            </div>
        </section>

        <section class="optionsContainer" id="queriesandReportsLink" onclick="CallReports()">
            <div class = "optionsContainer-title">
                Queries and Reports
            </div>
            <div class = "optionsContainer-contentContainer">
                <div class="optionsContainer-imageContainer">
                    <img src="Queries and reports.png" alt="two scripts containing a exclaimation mark and a question mark">
                </div>
                <div class = "optionsContainer-wordscontainer">
                    <p>View all queries and reports here</p>
                </div>
            </div>
        </section>

        <section class="optionsContainer" id="queriesandReportsLink" onclick="CallReviews()">
            <div class = "optionsContainer-title">
                Reviews
            </div>
            <div class = "optionsContainer-contentContainer">
                <div class="optionsContainer-imageContainer">
                    <img src="Reviews.png" alt="A picture of papers">
                </div>
                <div class = "optionsContainer-wordscontainer">
                    <p>View all reviews here</p>
                </div>
            </div>
        </section>

        <section class="optionsContainer" id="queriesandReportsLink" onclick="newAdmin()">
            <div class = "optionsContainer-title">
                New admin
            </div>
            <div class = "optionsContainer-contentContainer">
                <div class="optionsContainer-imageContainer">
                    <img src="Admin.png" alt="Picture of a women sitting on a desk writing">
                </div>
                <div class = "optionsContainer-wordscontainer">
                    <p>Add a new admin here</p>
                </div>
            </div>
        </section>
       

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
        function CallProducts()
        {
            window.location.href = "treasure hub developer listing page.php?section=product";
        }
        function CallOrder()
        {
            window.location.href = "treasure hub developer listing page.php?section=order";
        }
        function CallUsers()
        {
            window.location.href = "treasure hub developer listing page.php?section=user";
        }
        function CallSellers()
        {
            window.location.href = "treasure hub developer listing page.php?section=seller";
        }
        function CallReports()
        {
            window.location.href = "treasure hub developer listing page.php?section=report";
        }
        function CallReviews()
        {
            window.location.href = "treasure hub developer listing page.php?section=review";
        }
        function newAdmin()
        {
            window.location.href = "treasure_hub_add_admin.php";
        }
        function CallFoodProducts()
        {
            window.location.href = "treasure hub developer listing page.php?section=foodproduct";
        }
        function CallFoodOrder()
        {
            window.location.href = "treasure hub developer listing page.php?section=foodorder";  
        }
    </script>
</body>
</html>