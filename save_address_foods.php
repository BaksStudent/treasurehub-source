<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userid'];
    $street = trim($_POST['ship-address']);
    $city = trim($_POST['locality']);
    $pobox = trim($_POST['postcode']);

    if (!empty($street) && !empty($city) && !empty($pobox)) {
        $stmt = $conn->prepare("INSERT INTO address (UserID, StreetAddress, City, POBox) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $userId, $street, $city, $pobox);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: foodcheckout.php?address_saved=1");
            exit;
        } else {
            echo "Error saving address.";
        }
    } else {
        echo "Please fill in all fields.";
    }
} else {
    echo "Invalid request method.";
}
?>