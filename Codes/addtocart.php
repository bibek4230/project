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

// Check if product exists and has stock
$productQuery = "SELECT stock FROM uploads WHERE id = ?";
$productStmt = $conn->prepare($productQuery);
$productStmt->bind_param("i", $pid);
$productStmt->execute();
$productResult = $productStmt->get_result();

if ($productResult->num_rows == 0) {
    echo json_encode(["status" => "error", "message" => "Product not found"]);
    exit();
}

$productRow = $productResult->fetch_assoc();
$availableStock = $productRow['stock'];

if ($availableStock <= 0) {
    echo json_encode(["status" => "error", "message" => "Product is out of stock"]);
    exit();
}

// Check if product is already in cart
$cartCheckQuery = "SELECT qty FROM cart WHERE id = ?";
$cartCheckStmt = $conn->prepare($cartCheckQuery);
$cartCheckStmt->bind_param("i", $pid);
$cartCheckStmt->execute();
$cartCheckResult = $cartCheckStmt->get_result();

if ($cartCheckResult->num_rows > 0) {
    // Product already in cart, increase quantity
    $cartRow = $cartCheckResult->fetch_assoc();
    $currentQty = $cartRow['qty'];

    if ($currentQty >= $availableStock) {
        echo json_encode(["status" => "error", "message" => "Cannot add more. Stock limit reached."]);
    } else {
        $newQty = $currentQty + 1;
        $updateQuery = "UPDATE cart SET qty = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ii", $newQty, $pid);

        if ($updateStmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Quantity updated in cart"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update cart"]);
        }
        $updateStmt->close();
    }
} else {
    // Add new product to cart
    $insertQuery = "INSERT INTO cart (id, qty) VALUES (?, 1)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("i", $pid);

    if ($insertStmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Product added to cart"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add to cart"]);
    }
    $insertStmt->close();
}

$productStmt->close();
$cartCheckStmt->close();
$conn->close();
