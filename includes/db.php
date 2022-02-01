<?php

// Set database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback";

// Open new connection to database
@$conn = new mysqli($servername, $username, $password, $dbname);

// If connection fails
if ($conn->connect_error) {
    // Set content type to JSON
    header('Content-Type: application/json');
    // Return error to client
    die(json_encode(array("code" => 500, "message" => "Internal Server Error"), JSON_PRETTY_PRINT));
}