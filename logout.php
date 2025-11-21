<?php
session_start();
include "connect.php";

if (isset($_POST['logoutButton'])) 
{
    unset($_SESSION['adminEmail']);
    unset($_SESSION['email']);
    header("Location: treasure_hub_welcome.php");
}

if(isset($_POST['foodlogoutButton']))
{
    unset($_SESSION['adminEmail']);
    unset($_SESSION['email']);
    header("Location: treasure hub foods welcome.php");
}


?>