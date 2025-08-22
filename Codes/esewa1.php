<?php
include 'db.php';

$total_amount = 0;
$total_pprice = 0;
$total_serchar = 0;
$total_tax = 0;
$product_names = [];

if (isset($_GET['pid'])) {
    $pids = explode(',', $_GET['pid']);

    // Remove any empty values and sanitize
    $pids = array_filter(array_map('intval', $pids));

    if (empty($pids)) {
        echo "<script>alert('No valid product IDs found'); window.location.href='prabin.php';</script>";
        exit();
    }

    // Build IN clause for multiple products
    $pid_list = implode(',', $pids);

    $sql = "SELECT * FROM cart INNER JOIN uploads ON cart.id = uploads.id WHERE cart.id IN ($pid_list)";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_names[] = $row['pname'];

            // Use the total field which already includes tax and service charges
            $item_total = floatval($row['total']) * $row['qty'];
            $total_amount += $item_total;

            // Calculate individual components for eSewa form
            $item_pprice = $row['pprice'] * $row['qty'];
            $item_serchar = $row['serchar'] * $row['qty'];
            $item_tax = floatval($row['tax']) * $row['qty'];

            $total_pprice += $item_pprice;
            $total_serchar += $item_serchar;
            $total_tax += $item_tax;
        }

        $total_pprice = number_format($total_pprice, 2, '.', '');
        $total_serchar = number_format($total_serchar, 2, '.', '');
        $total_tax = number_format($total_tax, 2, '.', '');
        $total_amount = number_format($total_amount, 2, '.', '');
    } else {
        echo "<script>alert('No cart items found'); window.location.href='prabin.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No product ID found'); window.location.href='prabin.php';</script>";
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Esewa payment integration</title>
</head>

<body>
    <?php
    // Create transaction ID from first product ID and timestamp
    $first_pid = $pids[0];
    $tranuid = $first_pid . time();
    $signed_field_names = "total_amount,transaction_uuid,product_code";
    $signature_string = "total_amount={$total_amount},transaction_uuid={$tranuid},product_code=EPAYTEST";
    $secret_key = "8gBm/:&EnhH.1/q";
    $s = hash_hmac('sha256', $signature_string, $secret_key, true);
    $signature = base64_encode($s);
    ?>

    <div id="pra15">
        <h3>Order Summary</h3>
        <p><strong>Products:</strong> <?php echo implode(', ', $product_names); ?></p>

        <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
            <label>Amount:</label><br><input type="text" id="amount" name="amount" value="<?php echo $total_pprice ?>" required>
            <label>Tax-Amount:</label><br><input type="text" id="tax_amount" name="tax_amount" value="<?php echo $total_tax ?>" required>
            <input type="hidden" id="transaction_uuid" name="transaction_uuid" value="<?php echo $tranuid ?>" required>
            <input type="hidden" id="product_code" name="product_code" value="EPAYTEST" required>
            <label>Service Charge:</label><br><input type="text" id="product_service_charge" name="product_service_charge" value="<?php echo $total_serchar ?>" required>
            <label>Delivery Charge:</label><br><input type="text" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
            <label>Total-Amount:</label><br><input type="text" id="total_amount" name="total_amount" value="<?php echo $total_amount ?>" required>
            <input type="hidden" id="success_url" name="success_url" value="http://localhost/projectII-main/Codes/sucess.php" required>
            <input type="hidden" id="failure_url" name="failure_url" value="http://localhost/projectII-main/Codes/prabin.php" required>
            <input type="hidden" id="signed_field_names" name="signed_field_names" value="<?php echo $signed_field_names ?>" required>
            <input type="hidden" id="signature" name="signature" value="<?php echo $signature ?>" required>
            <input value="Submit Payment" type="submit" style="border-radius:30px; padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer;">
        </form>
    </div>
</body>

</html>