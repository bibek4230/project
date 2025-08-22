<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="index.js"></script>
    <link rel="stylesheet" href="index.css">
    <title>Upload Form</title>
    <style>
    *{
        margin:0px;
        padding:3px;
    }
    body{
        background-image:url("../images/bgindex.png");
        background-size:cover;
        background-repeat:no-repeat;
        
    }


    </style>
</head>
<body>
<button id="pra14" onclick="home1()"></button>
    <div id="pra7">
        <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="name" style="margin:10px;height:30px;width:90%;border-radius:15px; text-align:center;font-size:20px;"><br>
        <input type="text" name="price" placeholder="price" style="margin:10px;height:30px;width:90%;border-radius:15px; text-align:center;font-size:20px;"><br>
        <input type="text" name="serchar" placeholder="service-charge" style="margin:10px;height:30px;width:90%;border-radius:15px; text-align:center;font-size:20px;"><br>
        <input type="number" name="stock" placeholder="Quantity" style="margin:10px;height:30px;width:90%;border-radius:15px; text-align:center;font-size:20px;"><br>
        <select name="category" id="category" style="margin:10px; height:60px;width:90%;border-radius:15px; text-align:center;font-size:20px;">
                    <option value="">Select Category</option>
                    <option value="electronics">Electronics</option>
                    <option value="clothing">Clothing</option>
                    <option value="food">Food & Beverages</option>
                    <option value="home">Home & Garden</option>
                    <option value="books">Books and Stationary</option>
                    <option value="luxury">Luxury</option>
                    <option value="pet">Pets</option>
                    <option value="kids">Kids</option>
                </select>
        <textarea placeholder="Product Description" name="comment" style="height:150px; width:90%; margin:10px; color:green; font-size:15px; font-weight:bold;border-radius:20px; text-align:center;"></textarea><br><br>
            <input type="file" name="file" accept="image/*" style="margin:10px;height:30px;width:90%;border-radius:15px; text-align:center;font-size:20px;"><br><br>
            <input type="submit" value="post" name="post" style="height:80px; width:120px; border-radius:25px; margin:40px 0px 0px 150px;">
        </form>
    </div>
</body>
</html>

<?php
if(isset($_POST['post'])){
    $pname=$_POST['name'];
    $pprice=$_POST['price'];
    $ptax=0.13*$pprice; 
    $serchar=$_POST['serchar'];
    $pdes=$_POST['comment'];
    $file_name=$_FILES['file']['name'];
    $file_tmp=$_FILES['file']['tmp_name'];
    $file_folder="../files/".$file_name;
    $total=$pprice+$ptax+$serchar;
    $category=$_POST['category'];
    $stock=$_POST['stock'];
   if(move_uploaded_file($file_tmp,$file_folder)){
    $con=new mysqli("localhost","root","","projectii");
    if($con->connect_error){
        die("No connection");
    }else{
        $sql="insert into uploads(pname,pprice,serchar,tax,total,pdes,fname,category,stock)values('$pname','$pprice','$serchar',
        '$ptax','$total','$pdes','$file_folder','$category','$stock')";
        $r=$con->query($sql);
        if($r){
            echo "<script>alert('Your product is uploaded for advertisement')</script>";
        }else{
            echo "<script>alert('Failed to upload')</script>";
        }
        mysqli_close($con);
    }
   }else{
    echo "<script>alert('File upload unsuccessful')</script>";
    mysqli_close($con);
   }
 echo "<script>window.location.href = window.location.href;</script>";
}
?> 

