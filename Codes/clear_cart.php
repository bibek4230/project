<?php
include "db.php";

try {
    $query = "DELETE FROM cart";
    if ($conn->query($query)) {
        echo json_encode(["success" => true, "message" => "Cart cleared successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to clear cart"]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

$conn->close();
