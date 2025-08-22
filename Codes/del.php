<?php
session_start();
include "db.php";

// Check if user is logged in
if (!isset($_SESSION['uname'])) {
    echo json_encode(["status" => "error", "message" => "Please log in first"]);
    exit();
}

if (!isset($_POST['pid']) || empty($_POST['pid'])) {
    echo json_encode(["status" => "error", "message" => "Product ID is required"]);
    exit();
}

$pid = (int)$_POST['pid'];

$query = "DELETE FROM cart WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $pid);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Item removed from cart"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to remove item"]);
}

$stmt->close();
$conn->close();
