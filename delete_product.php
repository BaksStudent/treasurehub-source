<?php
session_start();
include "connect.php";

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$productId = isset($data['productId']) ? intval($data['productId']) : 0;

if ($productId > 0) {
    
    $conn->begin_transaction();

    try {
        
        $stmt1 = $conn->prepare("DELETE FROM food_option WHERE OptionGroupID IN (SELECT OptionGroupID FROM food_optiongroup WHERE ProductID = ?)");
        $stmt1->bind_param("i", $productId);
        $stmt1->execute();

        // Delete option groups
        $stmt2 = $conn->prepare("DELETE FROM food_optiongroup WHERE ProductID = ?");
        $stmt2->bind_param("i", $productId);
        $stmt2->execute();

        // Delete product
        $stmt3 = $conn->prepare("DELETE FROM foodproduct WHERE ProductID = ?");
        $stmt3->bind_param("i", $productId);
        $stmt3->execute();

        // Commit if all deletes are successful
        $conn->commit();
        echo json_encode(["success" => true, "message" => "Product and related data deleted successfully."]);
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        echo json_encode(["success" => false, "message" => "Error occurred: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid Product ID."]);
}
?>