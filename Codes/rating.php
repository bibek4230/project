<?php
session_start();
include "db.php";

// Check if user is logged in
if (!isset($_SESSION['uname'])) {
    echo json_encode(["status" => "error", "message" => "Please log in first"]);
    exit();
}

if (!isset($_POST['pid']) || !isset($_POST['rating'])) {
    echo json_encode(["status" => "error", "message" => "Missing required data"]);
    exit();
}

$pid = (int)$_POST['pid'];
$rating = (int)$_POST['rating'];
$uname = $_SESSION['uname'];

// Validate rating value
if ($rating < 1 || $rating > 5) {
    echo json_encode(["status" => "error", "message" => "Rating must be between 1 and 5"]);
    exit();
}

// Check if user has already rated this product
$checkQuery = "SELECT COUNT(*) as count FROM rating WHERE pid = ? AND uid = ?";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("is", $pid, $uname);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();
$checkRow = $checkResult->fetch_assoc();

if ($checkRow['count'] > 0) {
    // Update existing rating
    $updateQuery = "UPDATE rating SET cstar = ? WHERE pid = ? AND uid = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("iis", $rating, $pid, $uname);
    $success = $updateStmt->execute();
    $updateStmt->close();
} else {
    // Insert new rating
    $insertQuery = "INSERT INTO rating (pid, uid, cstar) VALUES (?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("iss", $pid, $uname, $rating);
    $success = $insertStmt->execute();
    $insertStmt->close();
}

if ($success) {
    echo json_encode(["status" => "success", "message" => "Rating saved successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to save rating"]);
}

$checkStmt->close();
$conn->close();
