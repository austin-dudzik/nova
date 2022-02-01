<?php
// Start session
session_start();

// Set content type to JSON
header('Content-Type: application/json');

// If endpoint accessed directly
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(array("code" => 403, "message" => "Endpoint cannot be accessed directly"), JSON_PRETTY_PRINT));
}

// If CSRF tokens don't match
if ($_POST["csrf_token"] != $_SESSION["csrf_token"]) {
    // Remove the token
    unset($_SESSION["csrf_token"]);
    die(json_encode(array("code" => 403, "message" => "CSRF verification failed"), JSON_PRETTY_PRINT));
}

// Include DB configuration
include "../../includes/db.php";

// Define required parameters
$post_id = $_POST['post_id'];

// Prepare statement and execute
$stmt = $conn->prepare("SELECT CONCAT(us.first_name, ' ', us.last_name) name, us.email, us.username FROM upvotes up JOIN users us ON (us.id = up.user_id) WHERE up.post_id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

// If results exist
if ($result->num_rows > 0) {
    // Define array w/ result code
    $rows = array("code" => 200);
    // Loop through all results
    while ($row = $result->fetch_assoc()) {
        // Add to array
        $rows[] = $row;
    }
    // Return array to client
    print json_encode($rows, JSON_PRETTY_PRINT);

} else {
    // Return message to client
    print json_encode(array("code" => 204, "message" => "No data found"), JSON_PRETTY_PRINT);
}

// Close the connection
$stmt->close();