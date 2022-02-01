<?php
// Start session
session_start();

// Set content type to JSON
header('Content-Type: application/json');

// If endpoint accessed directly
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Return error to client
    http_response_code(403);
    die(json_encode(array("code" => 403, "message" => "Endpoint cannot be accessed directly"), JSON_PRETTY_PRINT));
}

// If user is not authenticated
if (!isset($_SESSION['loggedIn'])) {
    // Return error to client
    http_response_code(403);
    die(json_encode(array("code" => 403, "message" => "Must be logged in to upvote post"), JSON_PRETTY_PRINT));
}

// If CSRF tokens don't match
if ($_POST["csrf_token"] != $_SESSION["csrf_token"]) {
    // Remove the token
    unset($_SESSION["csrf_token"]);
    // Return error to client
    http_response_code(403);
    die(json_encode(array("code" => 403, "message" => "CSRF verification failed"), JSON_PRETTY_PRINT));
}

// Include DB configuration
include "../../includes/db.php";

// Define required parameters
$post_id = $_POST['post_id'];
$user_id = $_SESSION["id"];

$stmt = $conn->prepare("SELECT COUNT(up.id) count FROM upvotes up WHERE up.post_id = ? AND up.user_id = ? GROUP BY up.id");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// If existing upvote found
if ($result->num_rows > 0) {

    // Delete upvote from database
    $stmt1 = $conn->prepare("DELETE up FROM upvotes up WHERE up.post_id = ? AND up.user_id = ?");
    $stmt1->bind_param("ii", $post_id, $user_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    // If successful deletion...
    if ($stmt1->affected_rows > 0) {
        http_response_code(200);
        die(json_encode(array("code" => 200, "message" => "Vote removed"), JSON_PRETTY_PRINT));
    } else {
        http_response_code(500);
        die(json_encode(array("code" => 500, "message" => "Error removing vote"), JSON_PRETTY_PRINT));
    }

    // If no existing upvote found
} else {

    // Insert upvote into database
    $stmt2 = $conn->prepare("INSERT INTO upvotes (post_id, user_id) VALUES (?, ?)");
    $stmt2->bind_param("ii", $post_id, $user_id);
    $stmt2->execute();
    $result1 = $stmt2->get_result();

    // If successful insertion...
    if ($stmt2->affected_rows > 0) {
        http_response_code(200);
        die(json_encode(array("code" => 200, "message" => "Vote added"), JSON_PRETTY_PRINT));
    } else {
        http_response_code(500);
        die(json_encode(array("code" => 500, "message" => "Error adding vote"), JSON_PRETTY_PRINT));
    }

}

// Close the connection
$stmt->close();