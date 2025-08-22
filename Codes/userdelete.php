<?php
session_start();
include "db.php";

// Check if user is admin
if (!isset($_SESSION['uname']) || !isset($_SESSION['acc']) || $_SESSION['acc'] != 1) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    exit();
}

if (!isset($_POST['uname']) || empty($_POST['uname'])) {
    echo json_encode(["status" => "error", "message" => "Username is required"]);
    exit();
}

$uname = $_POST['uname'];

$query = "DELETE FROM login WHERE uname = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $uname);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User deleted successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to delete user"]);
}

$stmt->close();
$conn->close();
