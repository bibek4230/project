<?php
session_start();
include "db.php";

// Check database connection
if (!$conn) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['uname'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

// Get the sort parameter
$sort = isset($_POST['sort']) ? $_POST['sort'] : 'default';
$search = isset($_POST['search']) ? $_POST['search'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$minPrice = isset($_POST['minPrice']) ? floatval($_POST['minPrice']) : 0;
$maxPrice = isset($_POST['maxPrice']) ? floatval($_POST['maxPrice']) : 999999;

// Base query
$query = "SELECT u.*, AVG(r.cstar) as avg_rating, COUNT(r.cstar) as rating_count 
          FROM uploads u 
          LEFT JOIN rating r ON u.id = r.pid 
          WHERE u.stock > 0";

// Add search filter
if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $query .= " AND (u.pname LIKE '%$search%' OR u.category LIKE '%$search%')";
}

// Add category filter
if (!empty($category)) {
    $category = mysqli_real_escape_string($conn, $category);
    $query .= " AND u.category = '$category'";
}

// Add price filter
$query .= " AND u.pprice BETWEEN $minPrice AND $maxPrice";

// Group by product
$query .= " GROUP BY u.id";

// Add sorting
switch ($sort) {
    case 'price-low':
    case 'price': // Fallback for backward compatibility
        $query .= " ORDER BY u.pprice ASC";
        break;
    case 'price-high':
        $query .= " ORDER BY u.pprice DESC";
        break;
    case 'rating':
        $query .= " ORDER BY avg_rating DESC, rating_count DESC";
        break;
    case 'newest':
        $query .= " ORDER BY u.id DESC";
        break;
    case 'name':
        $query .= " ORDER BY u.pname ASC";
        break;
    case 'stock':
        $query .= " ORDER BY u.stock DESC";
        break;
    default:
        $query .= " ORDER BY u.id DESC";
        break;
}

try {
    // Debug: Log the final query
    error_log("Sort query: " . $query);

    $result = $conn->query($query);
    $products = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Format the product data
            $product = [
                'id' => $row['id'],
                'name' => $row['pname'],
                'price' => $row['pprice'],
                'category' => $row['category'],
                'image' => $row['fname'],
                'stock' => $row['stock'],
                'description' => $row['pdes'] ?? '',
                'avg_rating' => $row['avg_rating'] ? round($row['avg_rating'], 1) : 0,
                'rating_count' => $row['rating_count'] ?? 0
            ];
            $products[] = $product;
        }
    }

    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'products' => $products,
        'count' => count($products),
        'sort' => $sort
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

$conn->close();
