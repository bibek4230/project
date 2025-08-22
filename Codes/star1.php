<?php
include "db.php";
session_start();
$uname=$_SESSION['uname'];
$query = "SELECT pid,cstar FROM rating where uid='$uname'";
$res = $conn->query($query);
$data = [];

if ($res) {
    while ($row = $res->fetch_assoc()) {
        $data[] = [  
            'pid' => $row['pid'],
            'cstar' => $row['cstar']
        ];
    }
    echo json_encode($data);
} else {
    echo json_encode([]);
}

$conn->close();
?>
