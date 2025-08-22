<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Payment Success</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .success-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 90%;
        }

        .success-icon {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="success-container">
        <div class="success-icon">✅</div>
        <h1>Payment Successful!</h1>
        <p>Thank you for your purchase. Your payment has been processed successfully through eSewa.</p>
        <p>You will receive a confirmation email shortly.</p>
        <a href="prabin.php" class="btn">Continue Shopping</a>
    </div>
</body>

</html>