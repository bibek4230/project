<?php
include "db.php";
$data = [];

// Sanitize and validate input
$pname = isset($_POST['pname']) ? trim($_POST['pname']) : '';
$price = isset($_POST['price']) ? $_POST['price'] : '';
$categoryFilter = isset($_POST['cfilter']) ? $_POST['cfilter'] : '';
$range = isset($_POST['range']) ? (int)$_POST['range'] : 0;

// Build query with prepared statements
$query = "SELECT * FROM uploads WHERE pname LIKE ? AND total <= ? AND category LIKE ?";
$orderBy = ($price == "high") ? " ORDER BY total ASC" : " ORDER BY total DESC";
$query .= $orderBy;

$stmt = $conn->prepare($query);
$searchName = '%' . $pname . '%';
$searchCategory = $categoryFilter ? $categoryFilter : '%';
$stmt->bind_param("sis", $searchName, $range, $searchCategory);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'id' => (int)$row['id'],
            'name' => htmlspecialchars($row['pname']),
            'description' => htmlspecialchars($row['pdes']),
            'price' => (float)$row['total'],
            'category' => htmlspecialchars($row['category']),
            'stock' => (int)$row['stock'],
            'image' => htmlspecialchars($row['fname'])
        ];
    }
}

echo json_encode($data);
$stmt->close();
$conn->close();
?>
echo json_encode($data);
?>