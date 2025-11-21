<?php
session_start();
include "connect.php";

if (isset($_POST['orderId'])) {
    $_SESSION['view_order_id'] = intval($_POST['orderId']);
    echo "Order ID stored in session.";
} else {
    echo "No Order ID received.";
}
?>