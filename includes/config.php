<?php
// Start the session
session_start();

// Include DB config
include "db.php";

// Autoload classes
spl_autoload_register(function ($class_name) {
    require_once 'classes/' . $class_name . '.php';
});

// Load the language file
require_once "lang/" . Settings::getSettings('language') . ".php";

function __($term) {
    global $lang;
    return $lang[$term];
}

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

function isAdmin(): bool
{
    if (isset($_SESSION["admin"])) {
        return true;
    } else {
        return false;
    }
}

if (isset($_SESSION['user'])) {
    $user = json_decode($_SESSION["user"]);
}