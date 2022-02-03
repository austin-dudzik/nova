<?php

include "db.php";

$site_name = "Hexagonal";
$site_url = "http://localhost/feedback";

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

function isAdmin() {
    if (isset($_SESSION["admin"])) {
        return true;
    } else {
        return false;
    }
}

if (isset($_SESSION['user'])) {
    $user = json_decode($_SESSION["user"]);
}