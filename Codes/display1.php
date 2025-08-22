<?php
include "db.php";
$pid = isset($_POST['pid']) ? $_POST['pid'] : '';
$data = [];

if (empty($pid)) {
    $query = "SELECT * FROM uploads";
    $stmt = $conn->prepare($query);
} else {
    $query = "SELECT * FROM uploads WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $pid);
}

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
