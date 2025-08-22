<?php
include "db.php";

if (isset($_POST['pid']) && isset($_POST['qty'])) {
    $pid = (int)$_POST['pid'];
    $qty = (int)$_POST['qty'];

    if ($qty > 0) {
        $query = "UPDATE cart SET qty = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $qty, $pid);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Quantity updated"]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update quantity"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid quantity"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Missing parameters"]);
}

$conn->close();
