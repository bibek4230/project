<?php
include "db.php";

$pid = (int)$_POST['pid']; // ensure pid is treated as an integer
$data = [];

// Check if the ID is already present in cart
$query = "SELECT qty FROM cart WHERE id = $pid";
$res = $conn->query($query);

if ($row = $res->fetch_assoc()) {
    // ID exists, increment qty
    $val = $row['qty'] + 1;
    $query = "UPDATE cart SET qty = $val WHERE id = $pid";
} else {
    // ID not found, insert with qty = 1
    $query = "INSERT INTO cart (id, qty) VALUES ($pid, 1)";
}

// Run the insert/update query
if ($conn->query($query)) {
    // Fetch and return product + cart details
    $fetch = "SELECT * FROM cart 
              INNER JOIN uploads ON cart.id = uploads.id 
              WHERE cart.id = $pid";
    $result = $conn->query($fetch);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'id' => $row['id'],
                'name' => $row['pname'],
                'description' => $row['pdes'],
                'price' => (float)$row['total'],
                'category' => $row['category'],
                'stock' => $row['stock'],
                'image' => $row['fname'],
                'qty' => $row['qty'],
            ];
        }
        echo json_encode($data);
    } else {
        echo json_encode("Error fetching product details.");
    }
} else {
    echo json_encode("Failed to update/insert cart.");
}

$conn->close();
?>
