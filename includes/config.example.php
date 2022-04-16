<?php
// Start the session
session_start();

// !!! BEGIN YOUR EDITS HERE !!!

// Set the application URL
const SITE_URL = "";

// Set database credentials
const DB_HOST = "localhost";
const DB_USER = "";
const DB_PASS = "";
const DB_NAME = "";

// The table prefix
const DB_PREFIX = "nova_";

// Open new connection to database
@$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// If connection fails
if ($conn->connect_error) {
    // Set content type to JSON
    header('Content-Type: application/json');
    // Return error to client
    die(json_encode(["code" => 500, "message" => "Internal Server Error"], JSON_PRETTY_PRINT));
}

// !!! END YOUR EDITS HERE !!!

// Autoload classes
spl_autoload_register(function ($class_name) {
    require_once dirname(__DIR__, 1) . '/classes/' . $class_name . '.php';
});

// Generate CSRF token
function generate_token()
{
    if (!isset($_SESSION["csrf_token"])) {
        $token = bin2hex(random_bytes(64));
        $_SESSION["csrf_token"] = $token;
    } else {
        $token = $_SESSION["csrf_token"];
    }
    return $token;
}

// Retrieve user details
$user = isset($_SESSION['user']) ? json_decode($_SESSION['user']) : null;
$user_s = isset($_SESSION['user']) ? (string)$_SESSION['user'] : null;

// Check admin status
function isAdmin(): bool
{
    return isset($_SESSION["admin"]) && $_SESSION["admin"] === true;
}