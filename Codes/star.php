<?php
include "db.php";
$data=[];
$pid = $_POST['pid'];
$uname = $_POST['uname'];
$qty = $_POST['qty'];
$checkQuery = "SELECT * FROM rating WHERE pid='$pid' AND uid='$uname'";
$checkResult = $conn->query($checkQuery);

if ($checkResult && $checkResult->num_rows > 0) {
    $updateQuery = "UPDATE rating SET cstar='$qty' WHERE pid='$pid' AND uid='$uname'";
    $conn->query($updateQuery);
} else {
    $insertQuery = "INSERT INTO rating(pid, uid, cstar) VALUES ('$pid', '$uname', '$qty')";
    $conn->query($insertQuery);
}
$getQuery = "SELECT cstar FROM rating WHERE pid='$pid' AND uid='$uname'";
$getResult = $conn->query($getQuery);
if ($getResult && $row = $getResult->fetch_assoc()) {
    $data=[
        'pid'=>$pid,
        'cstar'=>$row['cstar']
    ];
    echo json_encode($data);
} else {
    echo json_encode(null);
}
$conn->close();
?>