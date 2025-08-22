<?php 
include "db.php";
$query="select *from login";
$res=$conn->query($query);
$data=[];
while($row=$res->fetch_assoc()){
$data[]=$row;
}
echo json_encode($data);

$conn->close();

?>