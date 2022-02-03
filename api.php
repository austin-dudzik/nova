<?php
// Start the session
session_start();

// Set content type to JSON
header('Content-Type: application/json');

// Autoload classes
spl_autoload_register(function ($class_name) {
    require_once 'classes/' . $class_name . '.php';
});

////If CSRF tokens don't match
//if($_GET) {
//    if (!isset($_GET["csrf_token"]) || !isset($_SESSION["csrf_token"]) || $_GET["csrf_token"] != $_SESSION["csrf_token"]) {
//        // Remove the token
//        unset($_SESSION["csrf_token"]);
//        // Return error to client
//        http_response_code(403);
//        die(json_encode(Response::throwResponse(403, "CSRF verification failed"), JSON_PRETTY_PRINT));
//    }
//}
//else if($_POST) {
//    if (!isset($_POST["csrf_token"]) || !isset($_SESSION["csrf_token"]) || $_POST["csrf_token"] != $_SESSION["csrf_token"]) {
//        // Remove the token
//        unset($_SESSION["csrf_token"]);
//        // Return error to client
//        http_response_code(403);
//        die(json_encode(Response::throwResponse(403, "CSRF verification failed"), JSON_PRETTY_PRINT));
//    }
//}

// Include configuration
require_once "includes/config.php";

$result = array();

if($_GET) {
    $type = $_GET["type"] ?? "";
    // Determine call type
    $result = match ($type) {
        // Get posts by board
        'getPostsByBoard' => Posts::getPostsByBoard($_GET["board_id"], $_GET["offset"] ?? 0, $_GET["limit"] ?? 10),
        // Get posts by user
        'getPostsByUser' => Posts::getPostsByUser($_GET["user_id"], $_GET["offset"] ?? 0, $_GET["limit"] ?? 10),
        // Get posts by status
        'getPostsByStatus' => Posts::getPostsByStatus($_GET["status_id"], $_GET["offset"] ?? 0, $_GET["limit"] ?? 10),
        // Get single post
        'getPost' => Post::getPost($_GET["post_slug"]),
        // Get board details
        'getBoard' => Board::getBoard($_GET["board_slug"]),
        // Get board excerpt
        'getBoardExcerpt' => Board::getBoardExcerpt($_GET["board_id"]),
        // Get post voters
        'getVoters' => Voters::getVoters($_GET["post_id"]),
        // Get user details
        'getUser' => User::getUser($_GET["user_slug"]),
        // Revoke user session
        'revokeSession' => Authentication::revokeSession(),
        // Default response
        default => Response::throwResponse(404, "Requested API endpoint does not exist or inaccessible from this method")
    };
} else if($_POST) {
    $type = $_POST["type"] ?? "";
    // Determine call type
    $result = match ($type) {
        // Authenticate user
        'authenticateUser' => Authentication::authenticateUser($_POST["email"], $_POST["password"]),
        // Add/remove post upvote
        'votePost' => Upvote::votePost($_POST["post_id"]),
        // Default response
        default => Response::throwResponse(404, "Requested API endpoint does not exist or inaccessible from this method")
    };
}

// Return API interface
echo json_encode($result, JSON_PRETTY_PRINT);