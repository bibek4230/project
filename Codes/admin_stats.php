<?php
session_start();
include "db.php";

// Check if user is logged in and has admin access
if (!isset($_SESSION['uname']) || !isset($_SESSION['acc']) || $_SESSION['acc'] != 1) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

try {
    $stats = [];

    // Get total products
    $productQuery = "SELECT COUNT(*) as count FROM uploads";
    $productResult = $conn->query($productQuery);
    if (!$productResult) {
        throw new Exception("Failed to get product count: " . $conn->error);
    }
    $stats['products'] = (int)$productResult->fetch_assoc()['count'];

    // Get total users (excluding admins)
    $userQuery = "SELECT COUNT(*) as count FROM login WHERE acc = 2";
    $userResult = $conn->query($userQuery);
    if (!$userResult) {
        throw new Exception("Failed to get user count: " . $conn->error);
    }
    $stats['users'] = (int)$userResult->fetch_assoc()['count'];

    // Get total orders (count distinct products in cart)
    $orderQuery = "SELECT COUNT(DISTINCT id) as count FROM cart";
    $orderResult = $conn->query($orderQuery);
    if (!$orderResult) {
        throw new Exception("Failed to get order count: " . $conn->error);
    }
    $stats['orders'] = (int)$orderResult->fetch_assoc()['count'];

    // Get average rating
    $ratingQuery = "SELECT AVG(cstar) as avg_rating FROM rating";
    $ratingResult = $conn->query($ratingQuery);
    if (!$ratingResult) {
        throw new Exception("Failed to get rating: " . $conn->error);
    }
    $avgRating = $ratingResult->fetch_assoc()['avg_rating'];
    $stats['rating'] = $avgRating ? (float)round($avgRating, 1) : 0.0;

    // Additional stats
    $stats['total_categories'] = 8; // Based on the categories in the system

    // Get low stock products count (assuming stock < 10 is low)
    $lowStockQuery = "SELECT COUNT(*) as count FROM uploads WHERE stock < 10";
    $lowStockResult = $conn->query($lowStockQuery);
    $stats['low_stock'] = $lowStockResult ? $lowStockResult->fetch_assoc()['count'] : 0;

    // Get recent activity count (since there's no created_at, we'll skip this or use another metric)
    $stats['recent_products'] = 0; // Placeholder since no timestamp column exists

    header('Content-Type: application/json');
    echo json_encode($stats);
} catch (Exception $e) {
    error_log("Admin stats error: " . $e->getMessage());
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Internal server error', 'details' => $e->getMessage()]);
}

$conn->close();
