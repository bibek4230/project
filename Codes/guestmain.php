<?php
include "db.php";
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
} else {
    $sql = "SELECT * FROM uploads";
    $ra = $conn->query($sql);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Admin Main</title>
</head>

<body>
    <div id="pra6">
        <ul>
            <li><a href="index.php">
                    <div style="height:35px; width:40px; border:2px solid green; margin:-20px 0px 20px 20px; background-image:url('images/logout.png'); background-size:cover;">
                    </div>
                </a></li>
            <li><a href="upload.php">
                    <div style="height:35px; width:40px; border:2px solid green; margin:-20px 0px 20px 20px; background-image:url('images/upload.jpg'); background-size:cover;">
                    </div>
                </a></li>
        </ul>
    </div>
    <?php
    while ($row = $ra->fetch_assoc()) {
        $pname = htmlspecialchars($row['pname']);
        $pprice = htmlspecialchars($row['pprice']);
        $pdes = htmlspecialchars($row['pdes']);
        $fname = htmlspecialchars($row['fname']);
        echo "<div id='pra11'>
        <div style='height:300px;
    width:100%;
    box-sizing:border-box;
    border:5px solid purple;
    background-image:url(\"$fname\");
    background-size:100%;
    background-repeat:no-repeat;
    border-radius:15px;'></div>
        <div id='pra13'>
            <h3 style='text-align:center; font-weight:bold;'>$pname</h3>
            <h5 style='font-weight:Bold; margin:10px;'>
               Price:" . $pprice . "<br>
               Description:" . $pdes . "<br>

            </h5>
        </div>

    </div>";
    }
    ?>
</body>

</html>