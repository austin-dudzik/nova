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

@$userId = $_SESSION["id"];

$result = array();

if($_GET) {
    $type = $_GET["type"] ?? "";
    // Determine call type
    $result = match ($type) {
        'getPostsByBoard' => Posts::getPostsByBoard($_GET["board_id"], $_GET["offset"] ?? 0, $_GET["limit"] ?? 10),
        'getPostsByUser' => Posts::getPostsByUser($_GET["user_id"], $_GET["offset"] ?? 0, $_GET["limit"] ?? 10),
        'getPost' => Post::getPost($_GET["post_id"]),
        'getBoard' => Board::getBoard($_GET["board_slug"]),
        'getBoardExcerpt' => Board::getBoardExcerpt($_GET["board_id"]),
        'getUser' => User::getUser($_GET["user_id"]),
        'checkCredentials' => Authentication::checkCredentials($_GET["email"], $_GET["password"]),
        default => Response::throwResponse(404, "Requested API endpoint does not exist or inaccessible from this method")
    };
} else if($_POST) {
    $type = $_POST["type"] ?? "";
    // Determine call type
    $result = match ($type) {
        'votePost' => Upvote::votePost($_POST["post_id"]),
        default => Response::throwResponse(404, "Requested API endpoint does not exist or inaccessible from this method")
    };
}

// Return API interface
echo json_encode($result, JSON_PRETTY_PRINT);