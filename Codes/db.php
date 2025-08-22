<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projectii";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die("Database connection failed. Please try again later.");
}

// Set charset to prevent SQL injection
$conn->set_charset("utf8");
