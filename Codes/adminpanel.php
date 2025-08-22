<?php
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <script defer src="../jquery/jquery.js"></script>
    <script defer src="index.js"></script>
    <title>BuyMart Admin Panel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        table, th, td {
            border: 2px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: center;
        }
        #bt1,#bt2{
            height:50px;
            width:50px;
            border-radius:50px;
        }
        #bt1 img,#bt2 img{
            height:50px;
            width:50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Buy Mart Management System</h1>
            <p class="subtitle">Admin Dashboard</p>
        </div>
        
        <!-- Navigation Buttons -->
        <div class="nav-buttons">
            <button class="nav-btn home active" onclick="adminHome(this)">🏠 Home</button>
            <button class="nav-btn credentials" onclick="udisplay(this)">👥 Login Credentials</button>
            <button class="nav-btn stocks" onclick="udisplay1(this)">📦 Stocks Remaining</button>
            <button class="nav-btn ml" onclick="udisplay2(this)">📦 Most Liked</button>
            <button class="nav-btn sales" onclick="udisplay2(this)">💰 Sales</button>
        </div>
        
        <!-- Home Section -->
        <div id="home" class="section active">
            <h2 class="section-title">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
                Dashboard Overview
            </h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">3</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">4</div>
                    <div class="stat-label">Products</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">$2,500</div>
                    <div class="stat-label">Total Sales</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">1</div>
                    <div class="stat-label">Low Stock Items</div>
                </div>
            </div>
        </div>
        
        <!-- Login Credentials Section -->
        <div id="credentials" class="section">
            <h2 class="section-title">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                User Management
            </h2>
            <table> 
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Address</th>
                        <th>Mobile</th>
                        <th>User Name</th>
                        <th>Status</th>
                        <th>Management</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $str = "";
                    $query = "SELECT * FROM login";
                    $res = $conn->query($query);
                    while ($row = $res->fetch_assoc()) {
                        $str .= "<tr>
                            <td>".htmlspecialchars($row['fname'])."</td>
                            <td>".htmlspecialchars($row['mname'])."</td>
                            <td>".htmlspecialchars($row['lname'])."</td>
                            <td>".htmlspecialchars($row['address'])."</td>
                            <td>".htmlspecialchars($row['mobile'])."</td>
                            <td>".htmlspecialchars($row['uname'])."</td>
                            <td>".htmlspecialchars($row['status'])."</td>
                            <td>";
                        if ($row['status'] == 'inactive') {
                            $str .= "<button id='bt1' onclick=\"sapprove('".htmlspecialchars($row['uname'])."')\"><img src='../images/approve.png'></button><br>";
                        }
                        $str .= "<button id='bt2' onclick=\"userdel('".htmlspecialchars($row['uname'])."')\"><img src='../images/delete.jpg'></button></td></tr>";
                    }
                    echo $str;
                    ?>
                </tbody>
            </table>
        </div>
        
        <!-- Stock Inventory Section -->
        <div id="stocks" class="section">
            <h2 class="section-title">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M20 6h-2c0-2.21-1.79-4-4-4S10 3.79 10 6H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-10 0c0-1.1.9-2 2-2s2 .9 2 2h-4z"/>
                </svg>
                Stocks Remaining
            </h2>
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $str = "";
                    $query = "SELECT * FROM uploads";
                    $res = $conn->query($query);
                    while ($row = $res->fetch_assoc()) {
                        $qty = $row['stock']; // Ensure 'stock' column exists in uploads table
                        $str .= "<tr>
                            <td>".htmlspecialchars($row['id'])."</td>
                            <td>".htmlspecialchars($row['pname'])."</td>
                            <td>$qty</td>";
                        if ($qty > 10) {
                            $str .= "<td><span class='status active-status'>In Stock</span></td></tr>";
                        } elseif ($qty > 0 && $qty <= 10) {
                            $str .= "<td><span class='status low'>Low Stock</span></td></tr>";
                        } else {
                            $str .= "<td><span class='status out'>Out of Stock</span></td></tr>";
                        }
                    }
                    echo $str;
                    ?>
                </tbody>
            </table>
        </div>
        
        <!-- Sales Section -->
        <div id="sales" class="section">
            <h2 class="section-title">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                Sales
            </h2>
            <table>
                <thead>
                    <tr>
                        <th>Product Id</th>
                        <th>Product Name</th>
                        <th>Total Stars</th>
                        <th>Average Rating</th>
                        <th>No of Ratings</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $str = "";
                    $query = "SELECT 
                                pr.pid,
                                u.pname,
                                COUNT(*) AS total_ratings,
                                SUM(pr.cstar) AS total_stars,
                                ROUND(AVG(pr.cstar), 2) AS average_rating
                              FROM rating pr
                              JOIN uploads u ON pr.pid = u.id
                              GROUP BY pr.pid, u.pname
                              ORDER BY total_stars DESC";
                    $res = $conn->query($query);
                    while ($row = $res->fetch_assoc()) {
                        $str .= "<tr>
                            <td>".htmlspecialchars($row['pid'])."</td>
                            <td>".htmlspecialchars($row['pname'])."</td>
                            <td>".htmlspecialchars($row['total_stars'])."</td>
                            <td>".htmlspecialchars($row['average_rating'])."</td>
                            <td>".htmlspecialchars($row['total_ratings'])."</td>
                        </tr>";
                    }
                    echo $str;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
