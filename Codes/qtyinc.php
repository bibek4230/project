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

$query = "SELECT cart.qty, uploads.stock FROM cart INNER JOIN uploads ON cart.id = uploads.id WHERE cart.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $pid);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $currentQty = $row['qty'];
        $stock = $row['stock'];
        $newQty = $currentQty + 1;

        if ($newQty > $stock) {
            echo json_encode(["status" => "error", "message" => "Not enough stock available"]);
        } else {
            $updateQuery = "UPDATE cart SET qty = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ii", $newQty, $pid);

            if ($updateStmt->execute()) {
                echo json_encode(["status" => "success", "qty" => $newQty]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update quantity"]);
            }
            $updateStmt->close();
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Product not found in cart"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Database error"]);
}

$stmt->close();
$conn->close();
