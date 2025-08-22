<?php
session_start();
include "db.php";

// Check if user is admin
if (!isset($_SESSION['uname']) || !isset($_SESSION['acc']) || $_SESSION['acc'] != 1) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    exit();
}

if (!isset($_POST['pid']) || empty($_POST['pid'])) {
    echo json_encode(["status" => "error", "message" => "Product ID is required"]);
    exit();
}

$pid = (int)$_POST['pid'];

// Also remove from cart if exists
$cartQuery = "DELETE FROM cart WHERE id = ?";
$cartStmt = $conn->prepare($cartQuery);
$cartStmt->bind_param("i", $pid);
$cartStmt->execute();
$cartStmt->close();

// Remove ratings for this product
$ratingQuery = "DELETE FROM rating WHERE pid = ?";
$ratingStmt = $conn->prepare($ratingQuery);
$ratingStmt->bind_param("i", $pid);
$ratingStmt->execute();
$ratingStmt->close();

// Remove the product
$query = "DELETE FROM uploads WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $pid);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Product deleted successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to delete product"]);
}

$stmt->close();
$conn->close();
