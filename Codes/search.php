<?php
include("db.php");

$pname = isset($_POST["pname"]) ? trim($_POST["pname"]) : '';

if (empty($pname)) {
    echo json_encode([]);
    exit(0);
}

$query = "SELECT pname FROM uploads WHERE pname LIKE ? LIMIT 10";
$stmt = $conn->prepare($query);
$searchTerm = '%' . $pname . '%';
$stmt->bind_param("s", $searchTerm);

$output = [];
if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $output[] = htmlspecialchars($row["pname"]);
    }
}

echo json_encode($output);
$stmt->close();
$conn->close();
