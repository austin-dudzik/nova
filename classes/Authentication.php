<?php

/**
 * Authentication class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Authentication
{

    /**
     * @var int The user's ID
     */
    public int $id;
    /**
     * @var string The user's name
     */
    public string $name;
    /**
     * @var string The user's email
     */
    public string $email;
    /**
     * @var string The user's username
     */
    public string $username;
    /**
     * @var string The user's password
     */
    private string $password;

    /**
     * authenticateUser
     * Verify credentials and log the user in
     *
     * @param string $email The email
     * @param string $password The password
     * @return Authentication|Response The authentication or response object
     */
    public static function authenticateUser(string $email, string $password): Authentication|Response
    {

        global $conn;

        $stmt = $conn->prepare("SELECT us.id, CONCAT(us.first_name, ' ', us.last_name) name, us.email, us.username, us.password FROM users us WHERE us.email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $auth = $result->fetch_object('Authentication');

            // If submitted password matches the hash
            if (password_verify($password, $auth->password)) {
                // Set session to user details
                $_SESSION["user"] = json_encode($auth);
                // Return 200 response
                return Response::throwResponse(200, "User has successfully been logged in");
            } else {
                // Return 204 response
                return Response::throwResponse(204, "User credentials are invalid");
            }

        } else {
            // Return 204 response
            return Response::throwResponse(204, 'User credentials are invalid');
        }

    }

    /**
     * revokeSession
     * Revokes the current user session
     *
     * @return Response The response object
     */
    public static function revokeSession(): Response
    {
        // Unset the session variable
        unset($_SESSION["user"]);
        // Return 200 response
        return Response::throwResponse(200, "User has successfully been logged out");
    }

}