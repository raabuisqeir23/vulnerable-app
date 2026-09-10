<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'bj_user');
define('DB_PASS', 'Bazaarjo2024!');
define('DB_NAME', 'bazaarjo_db');

// Application settings
define('SITE_NAME', 'Bazaarjo Employee Portal');
define('UPLOAD_DIR', '/var/www/html/bazaarjo/uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection
function getDB() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            throw new Exception("Connection failed");
        }
        return $conn;
    } catch (Exception $e) {
        die("Database unavailable. Please try again later.");
    }
}
?>
