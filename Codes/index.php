<?php
session_start();
include "db.php";

// Login Processing
if (isset($_POST['post1'])) {
    $uname = trim($_POST['uname']);
    $pwd = $_POST['pwd'];

    if (empty($uname) || empty($pwd)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('Please fill all fields', 'error');
                login();
            });
        </script>";
    } else {
        $sql = "SELECT acc, status, pwd FROM login WHERE uname = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $uname);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $acc = $row['acc'];
                $status = $row['status'];
                $stored_pwd = $row['pwd'];

                // Check if password is hashed (new format) or plain text (old format)
                $pwd_valid = false;
                if (password_verify($pwd, $stored_pwd)) {
                    $pwd_valid = true; // New hashed password
                } else if ($stored_pwd === $pwd) {
                    $pwd_valid = true; // Old plain text password (for backward compatibility)
                    // Update to hashed password
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                    $updateStmt = $conn->prepare("UPDATE login SET pwd = ? WHERE uname = ?");
                    $updateStmt->bind_param("ss", $hashedPwd, $uname);
                    $updateStmt->execute();
                    $updateStmt->close();
                }

                if ($pwd_valid) {
                    if ($status == 'inactive') {
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showNotification('Account is inactive. Please contact administrator.', 'error');
                                login();
                            });
                        </script>";
                    } else {
                        $_SESSION['uname'] = $uname;
                        $_SESSION['acc'] = $acc;
                        session_regenerate_id(true);

                        if ($acc == 1) {
                            header("Location: adminmain.php");
                            exit();
                        } else if ($acc == 2) {
                            header("Location: prabin.php");
                            exit();
                        }
                    }
                } else {
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showNotification('Invalid username or password', 'error');
                            login();
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showNotification('Invalid username or password', 'error');
                        login();
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showNotification('Database error occurred', 'error');
                    login();
                });
            </script>";
        }
        $stmt->close();
    }
}

// User Registration Processing
if (isset($_POST['post2'])) {
    $fname = trim($_POST['sfname']);
    $mname = trim($_POST['smname']);
    $lname = trim($_POST['slname']);
    $address = trim($_POST['saddress']);
    $email = trim($_POST['semail']);
    $mobile = trim($_POST['smobile']);
    $gender = $_POST['sgender'];
    $uname = trim($_POST['suname']);
    $pwd = $_POST['spwd'];
    $acc = 2;

    // Basic validation
    if (empty($fname) || empty($lname) || empty($address) || empty($email) || empty($mobile) || empty($uname) || empty($pwd)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('Please fill all required fields', 'error');
                signup();
            });
        </script>";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('Please enter a valid email address', 'error');
                signup();
            });
        </script>";
    } else if (strlen($pwd) < 6) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('Password must be at least 6 characters long', 'error');
                signup();
            });
        </script>";
    } else {
        // Check if username or email already exists
        $checkQuery = "SELECT COUNT(*) as count FROM login WHERE uname = ? OR email = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("ss", $uname, $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $checkRow = $checkResult->fetch_assoc();

        if ($checkRow['count'] > 0) {
            echo "<script>alert('Username or email already exists')</script>";
        } else {
            // Hash password for security
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

            $sql = "INSERT INTO login(fname,mname,lname,address,email,mobile,gender,uname,pwd,acc,status) VALUES(?,?,?,?,?,?,?,?,?,?,'inactive')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssi", $fname, $mname, $lname, $address, $email, $mobile, $gender, $uname, $hashedPwd, $acc);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful! Please wait for admin approval.'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Error in registration. Please try again.')</script>";
            }
            $stmt->close();
        }
        $checkStmt->close();
    }
}
if (isset($_POST['post3'])) {
    $fname = trim($_POST['afname']);
    $mname = trim($_POST['amname']);
    $lname = trim($_POST['alname']);
    $address = trim($_POST['aaddress']);
    $email = trim($_POST['aemail']);
    $mobile = trim($_POST['amobile']);
    $gender = $_POST['agender'];
    $uname = trim($_POST['auname']);
    $pwd = $_POST['apwd'];
    $acc = 1;

    // Basic validation
    if (empty($fname) || empty($lname) || empty($address) || empty($email) || empty($mobile) || empty($uname) || empty($pwd)) {
        echo "<script>alert('Please fill all required fields')</script>";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address')</script>";
    } else if (strlen($pwd) < 6) {
        echo "<script>alert('Password must be at least 6 characters long')</script>";
    } else {
        // Check if username or email already exists
        $checkQuery = "SELECT COUNT(*) as count FROM login WHERE uname = ? OR email = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("ss", $uname, $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $checkRow = $checkResult->fetch_assoc();

        if ($checkRow['count'] > 0) {
            echo "<script>alert('Username or email already exists')</script>";
        } else {
            // Hash password for security
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

            $sql = "INSERT INTO login(fname,mname,lname,address,email,mobile,gender,uname,pwd,acc,status) VALUES(?,?,?,?,?,?,?,?,?,?,'active')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssi", $fname, $mname, $lname, $address, $email, $mobile, $gender, $uname, $hashedPwd, $acc);

            if ($stmt->execute()) {
                echo "<script>alert('Admin registration successful!'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Error in registration. Please try again.')</script>";
            }
            $stmt->close();
        }
        $checkStmt->close();
    }
}
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="../bootstrap-5.3.4-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS Files -->
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/auth.css">

    <title>BuyMart - Your Shopping Destination</title>


    <script>
        let navigationVisible = false;

        document.addEventListener("mousemove", function(e) {
            if (!navigationVisible && (e.clientX > window.innerWidth - 100 || e.clientY < 100)) {
                showNavigation();
            }
        });

        function showNavigation() {
            if (!navigationVisible) {
                document.getElementById("navigationTrigger").style.display = "block";
                navigationVisible = true;

                setTimeout(() => {
                    if (navigationVisible) {
                        document.getElementById("navigationTrigger").style.display = "none";
                        navigationVisible = false;
                    }
                }, 10000);
            }
        }
    </script>
</head>

<body>
    <!-- Navigation Trigger -->
    <div class="navigation-trigger" id="navigationTrigger">
        <div class="nav-buttons">
            <button class="nav-btn nav-btn-login" onclick="login()">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </button>
            <button class="nav-btn nav-btn-signup" onclick="signup()">
                <i class="fas fa-user-plus"></i>
                Sign Up
            </button>
            <button class="nav-btn nav-btn-admin" onclick="admin()">
                <i class="fas fa-user-shield"></i>
                Admin
            </button>
        </div>
    </div>

    <!-- Welcome Screen -->
    <div class="welcome-screen" id="welcome">
        <div class="welcome-content">
            <img src="../images/logo.png" alt="BuyMart" class="welcome-logo">
            <h1 class="welcome-title">BuyMart</h1>
            <p class="welcome-subtitle">Your Ultimate Shopping Destination</p>
            <p class="lead">
                Discover amazing products, enjoy seamless shopping, and experience the future of e-commerce.
            </p>

            <div class="welcome-buttons">
                <a href="#" class="welcome-btn" onclick="login()">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Get Started
                </a>
                <a href="#" class="welcome-btn" onclick="signup()">
                    <i class="fas fa-user-plus me-2"></i>
                    Join Now
                </a>
            </div>
        </div>

        <div class="mouse-instruction">
            <i class="fas fa-mouse-pointer me-2"></i>
            Move your mouse to the top-right corner to access options
        </div>
    </div>

    <!-- Features Section -->
    <div class="features-section d-none">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-4 fw-bold mb-3">Why Choose BuyMart?</h2>
                    <p class="lead text-muted">Experience the best in online shopping</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h4>Fast Delivery</h4>
                        <p class="text-muted">Get your products delivered quickly and safely to your doorstep.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Secure Shopping</h4>
                        <p class="text-muted">Shop with confidence using our secure payment system.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>24/7 Support</h4>
                        <p class="text-muted">Our customer support team is always here to help you.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Form -->
    <div class="auth-container" id="pra4" style="display: none;">
        <div class="auth-card">
            <div class="auth-brand">
                <img src="../images/logo.png" alt="BuyMart" class="auth-logo">
                <h2 class="auth-brand-title">Welcome Back</h2>
                <p class="auth-brand-subtitle">
                    Sign in to your BuyMart account to access exclusive deals, track your orders, and enjoy a personalized shopping experience.
                </p>
                <div class="auth-features">
                    <div class="auth-feature">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Track Orders</span>
                    </div>
                    <div class="auth-feature">
                        <i class="fas fa-heart"></i>
                        <span>Save Favorites</span>
                    </div>
                    <div class="auth-feature">
                        <i class="fas fa-tags"></i>
                        <span>Exclusive Deals</span>
                    </div>
                </div>
            </div>

            <div class="auth-form-container">
                <div class="auth-form-header">
                    <h3 class="auth-form-title">Sign In</h3>
                    <p class="auth-form-subtitle">Enter your credentials to continue</p>
                </div>

                <form action="" method="post" class="auth-form" id="loginForm">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user me-2"></i>Username
                        </label>
                        <input type="text" class="form-input" placeholder="Enter your username" name="uname" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        <div class="password-group">
                            <input type="password" class="form-input" placeholder="Enter your password" name="pwd" required id="loginPassword">
                            <button type="button" class="password-toggle" onclick="togglePassword('loginPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" class="remember-checkbox">
                            <span class="checkmark"></span>
                            Remember me
                        </label>
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="post1" class="auth-btn auth-btn-primary">
                            <i class="fas fa-sign-in-alt"></i>
                            Sign In
                        </button>
                    </div>
                </form>

                <div class="form-footer">
                    <p class="form-footer-text">Don't have an account?</p>
                    <button type="button" class="form-switch-link" onclick="signup()">
                        <i class="fas fa-user-plus me-2"></i>Create Account
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Signup Form -->
    <div class="auth-container" id="pra5" style="display: none;">
        <div class="auth-card auth-card-wide">
            <div class="auth-brand">
                <img src="../images/logo.png" alt="BuyMart" class="auth-logo">
                <h2 class="auth-brand-title">Join BuyMart</h2>
                <p class="auth-brand-subtitle">
                    Create your account to access thousands of products and enjoy exclusive member benefits.
                </p>
                <div class="auth-benefits">
                    <div class="auth-benefit">
                        <i class="fas fa-check-circle"></i>
                        <span>Free Shipping on Orders Over $50</span>
                    </div>
                    <div class="auth-benefit">
                        <i class="fas fa-check-circle"></i>
                        <span>Exclusive Member Discounts</span>
                    </div>
                    <div class="auth-benefit">
                        <i class="fas fa-check-circle"></i>
                        <span>Priority Customer Support</span>
                    </div>
                </div>
            </div>

            <div class="auth-form-container">
                <div class="auth-form-header">
                    <h3 class="auth-form-title">Create Account</h3>
                    <p class="auth-form-subtitle">Fill in your details to get started</p>
                </div>

                <form onsubmit="return validation()" action="index.php" method="post" class="auth-form" id="signupForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user me-2"></i>First Name
                            </label>
                            <input type="text" class="form-input" placeholder="First Name" name="sfname" required>
                            <div id="msg1" class="form-error"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user me-2"></i>Last Name
                            </label>
                            <input type="text" class="form-input" placeholder="Last Name" name="slname" required>
                            <div id="msg3" class="form-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user me-2"></i>Middle Name (Optional)
                        </label>
                        <input type="text" class="form-input" placeholder="Middle Name" name="smname">
                        <div id="msg2" class="form-error"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt me-2"></i>Address
                        </label>
                        <textarea class="form-input form-textarea" placeholder="Your complete address" name="saddress" rows="3" required></textarea>
                        <div id="msg5" class="form-error"></div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" class="form-input" placeholder="your@email.com" name="semail" required>
                            <div id="msg7" class="form-error"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-phone me-2"></i>Mobile Number
                            </label>
                            <input type="tel" class="form-input" placeholder="Your mobile number" name="smobile" required>
                            <div id="msg6" class="form-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-venus-mars me-2"></i>Gender
                        </label>
                        <div class="radio-group">
                            <label class="radio-item">
                                <input type="radio" name="sgender" value="m" required>
                                <span class="radio-custom"></span>
                                <span class="radio-text">Male</span>
                            </label>
                            <label class="radio-item">
                                <input type="radio" name="sgender" value="f" required>
                                <span class="radio-custom"></span>
                                <span class="radio-text">Female</span>
                            </label>
                            <label class="radio-item">
                                <input type="radio" name="sgender" value="o" required>
                                <span class="radio-custom"></span>
                                <span class="radio-text">Other</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user-circle me-2"></i>Username
                            </label>
                            <input type="text" class="form-input" placeholder="Choose a username" name="suname" required>
                            <div id="msg4" class="form-error"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <div class="password-group">
                                <input type="password" class="form-input" placeholder="Create password" name="spwd" required id="signupPassword">
                                <button type="button" class="password-toggle" onclick="togglePassword('signupPassword')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="msg8" class="form-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock me-2"></i>Confirm Password
                        </label>
                        <div class="password-group">
                            <input type="password" class="form-input" placeholder="Confirm your password" name="spwd1" required id="confirmPassword">
                            <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="msg9" class="form-error"></div>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-group">
                            <input type="checkbox" name="sterms" required>
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-text">
                                I agree to the <a href="#" class="terms-link">Terms and Conditions</a> and
                                <a href="#" class="terms-link">Privacy Policy</a>
                            </span>
                        </label>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="post2" class="auth-btn auth-btn-success">
                            <i class="fas fa-user-plus"></i>
                            Create Account
                        </button>
                    </div>
                </form>

                <div class="form-footer">
                    <p class="form-footer-text">Already have an account?</p>
                    <button type="button" class="form-switch-link" onclick="login()">
                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Registration Form -->
    <div class="auth-container" id="pra10" style="display: none;">
        <div class="auth-card">
            <div class="auth-brand">
                <img src="../images/logo.png" alt="BuyMart" class="auth-logo">
                <h2 class="auth-brand-title">Admin Access</h2>
                <p class="auth-brand-subtitle">
                    Register as an administrator to manage the BuyMart platform and oversee all operations.
                </p>
                <div class="admin-features">
                    <div class="admin-feature">
                        <i class="fas fa-users-cog"></i>
                        <span>User Management</span>
                    </div>
                    <div class="admin-feature">
                        <i class="fas fa-chart-bar"></i>
                        <span>Analytics Dashboard</span>
                    </div>
                    <div class="admin-feature">
                        <i class="fas fa-cog"></i>
                        <span>System Settings</span>
                    </div>
                </div>
            </div>

            <div class="auth-form-container">
                <div class="auth-form-header">
                    <h3 class="auth-form-title">Admin Registration</h3>
                    <p class="auth-form-subtitle">Complete the form to request admin access</p>
                </div>

                <form action="index.php" method="post" class="auth-form" id="adminForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user me-2"></i>First Name
                            </label>
                            <input type="text" class="form-input" placeholder="First Name" name="afname" required>
                            <div id="msg11" class="form-error"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user me-2"></i>Last Name
                            </label>
                            <input type="text" class="form-input" placeholder="Last Name" name="alname" required>
                            <div id="msg13" class="form-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user me-2"></i>Middle Name (Optional)
                        </label>
                        <input type="text" class="form-input" placeholder="Middle Name" name="amname">
                        <div id="msg12" class="form-error"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt me-2"></i>Address
                        </label>
                        <textarea class="form-input form-textarea" placeholder="Complete address" name="aaddress" rows="3" required></textarea>
                        <div id="msg15" class="form-error"></div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" class="form-input" placeholder="admin@email.com" name="aemail" required>
                            <div id="msg17" class="form-error"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-phone me-2"></i>Mobile Number
                            </label>
                            <input type="tel" class="form-input" placeholder="Mobile number" name="amobile" required>
                            <div id="msg14" class="form-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-venus-mars me-2"></i>Gender
                        </label>
                        <div class="radio-group">
                            <label class="radio-item">
                                <input type="radio" name="agender" value="m" required>
                                <span class="radio-custom"></span>
                                <span class="radio-text">Male</span>
                            </label>
                            <label class="radio-item">
                                <input type="radio" name="agender" value="f" required>
                                <span class="radio-custom"></span>
                                <span class="radio-text">Female</span>
                            </label>
                            <label class="radio-item">
                                <input type="radio" name="agender" value="o" required>
                                <span class="radio-custom"></span>
                                <span class="radio-text">Other</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user-shield me-2"></i>Admin Username
                            </label>
                            <input type="text" class="form-input" placeholder="Admin username" name="auname" required>
                            <div id="msg16" class="form-error"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <div class="password-group">
                                <input type="password" class="form-input" placeholder="Secure password" name="apwd" required id="adminPassword">
                                <button type="button" class="password-toggle" onclick="togglePassword('adminPassword')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="msg18" class="form-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock me-2"></i>Confirm Password
                        </label>
                        <div class="password-group">
                            <input type="password" class="form-input" placeholder="Confirm password" name="apwd1" required id="adminConfirmPassword">
                            <button type="button" class="password-toggle" onclick="togglePassword('adminConfirmPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="msg19" class="form-error"></div>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-group">
                            <input type="checkbox" name="aterms" required>
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-text">
                                I agree to the admin <a href="#" class="terms-link">Terms and Conditions</a> and understand my responsibilities
                            </span>
                        </label>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="post3" class="auth-btn auth-btn-warning">
                            <i class="fas fa-user-shield"></i>
                            Request Admin Access
                        </button>
                    </div>
                </form>

                <div class="form-footer">
                    <p class="form-footer-text">Already have an account?</p>
                    <button type="button" class="form-switch-link" onclick="login()">
                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Functions -->
    <script>
        function login() {
            hideAllForms();
            document.getElementById("pra4").style.display = "flex";
        }

        function signup() {
            hideAllForms();
            document.getElementById("pra5").style.display = "flex";
        }

        function admin() {
            hideAllForms();
            document.getElementById("pra10").style.display = "flex";
        }

        function hideAllForms() {
            document.getElementById("welcome").style.display = "none";
            document.getElementById("pra4").style.display = "none";
            document.getElementById("pra5").style.display = "none";
            document.getElementById("pra10").style.display = "none";
            document.getElementById("navigationTrigger").style.display = "none";
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.parentElement.querySelector('.password-toggle i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Show notification function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
                <span>${message}</span>
                <button class="notification-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        // Enhanced form validation
        function validation() {
            // Add your validation logic here
            return true;
        }
    </script>

    <!-- jQuery -->
    <script src="../jquery/jquery.js"></script>

    <!-- Bootstrap JS -->
    <script src="../bootstrap-5.3.4-dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script defer src="index.js"></script>

</body>

</html>