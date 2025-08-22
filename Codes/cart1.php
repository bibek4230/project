<?php
session_start();
include "db.php";

// Check if user is logged in
if (!isset($_SESSION['uname'])) {
    echo json_encode(["error" => "Please log in first"]);
    exit();
}

$data = [];
$query1 = "SELECT * FROM cart INNER JOIN uploads ON cart.id = uploads.id";
$res = $conn->query($query1);

if ($res) {
    while ($row = $res->fetch_assoc()) {
        $data[] = [
            'id' => (int)$row['id'],
            'name' => htmlspecialchars($row['pname']),
            'description' => htmlspecialchars($row['pdes']),
            'price' => (float)$row['total'],
            'category' => htmlspecialchars($row['category']),
            'stock' => (int)$row['stock'],
            'image' => htmlspecialchars($row['fname']),
            'qty' => (int)$row['qty'],
        ];
    }
    echo json_encode($data);
} else {
    echo json_encode(["error" => "Error fetching cart data"]);
}

$conn->close();
