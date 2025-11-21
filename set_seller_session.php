<?php
session_start();
include "connect.php";

if (isset($_POST['sellerID'])) {
    $_SESSION['view_sellerid'] = intval($_POST['sellerID']);
    echo "sellerID stored in session.";
} else {
    echo "No seller ID received.";
}
?>