<?php
session_start();
include "connect.php";

if (isset($_POST['productId'])) {
    $_SESSION['edit_product_id'] = intval($_POST['productId']);
    echo "Product ID stored in session.";
} else {
    echo "No product ID received.";
}
?>