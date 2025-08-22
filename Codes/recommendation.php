<?php
include "db.php";


$query = "SELECT cstar, pid, uid FROM rating ORDER BY pid DESC";
$res = $conn->query($query);
$data = [];

while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}

$tempAvg = [];
// Here what i am trying to do is calculate the average of the rated product
//and sort them in the descending order using bubble sort.
foreach ($data as $row) {
    $pid = $row['pid'];
    $cstar = $row['cstar'];

    if (!isset($tempAvg[$pid])) {
        $tempAvg[$pid] = [
            'pid' => $pid,
            'total' => 0
        ];
    }

    $tempAvg[$pid]['total'] += $cstar / 5;
}

// Step 3: Convert to numerically indexed array for sorting
$avg = array_values($tempAvg);

// Step 4: Bubble Sort based on 'total' value (descending)
$n = count($avg);
for ($i = 0; $i < $n - 1; $i++) {
    for ($j = 0; $j < $n - $i - 1; $j++) {
        if ($avg[$j]['total'] < $avg[$j + 1]['total']) {
            $temp = $avg[$j];
            $avg[$j] = $avg[$j + 1];
            $avg[$j + 1] = $temp;
        }
    }
}
$data=[];
$rec = array_slice($avg, 0, 3);
$pids = array_column($rec, 'pid');   
$pidList = implode(',', $pids);          
$query1 = "SELECT * FROM uploads WHERE id IN ($pidList)";
$res1=$conn->query($query1);
while($row=$res1->fetch_assoc()){
    $data[] = [
        'id' => $row['id'],
        'name' => $row['pname'],
        'description' => $row['pdes'],
        'price' => (float)$row['total'],
        'category' => $row['category'],
        'stock' => $row['stock'],
        'image' => $row['fname'] 
    ];
}
echo json_encode($data);
$conn->close();
?>
