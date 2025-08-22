<?php
// Configuration file for the project

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'projectii');

// Application settings
define('APP_NAME', 'BuyMart Management System');
define('APP_VERSION', '2.0');
define('UPLOAD_DIR', '../files/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);

// Security settings
define('SESSION_TIMEOUT', 3600); // 1 hour
define('PASSWORD_MIN_LENGTH', 6);

// eSewa configuration
define('ESEWA_URL', 'https://rc-epay.esewa.com.np/api/epay/main/v2/form');
define('SUCCESS_URL', 'http://localhost/projectII-main/Codes/sucess.php');
define('FAILURE_URL', 'http://localhost/projectII-main/Codes/prabin.php');

// Tax rate
define('TAX_RATE', 0.13); // 13%

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session with security settings
if (session_status() == PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => SESSION_TIMEOUT,
        'cookie_secure' => false, // Set to true if using HTTPS
        'cookie_httponly' => true,
        'cookie_samesite' => 'Strict'
    ]);
}
