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
        global $prefix;

        $stmt = $conn->prepare("SELECT us.id, CONCAT(us.first_name, ' ', us.last_name) name, us.email, us.username, us.password, us.is_admin FROM  " . $prefix . "users us WHERE us.email = ? LIMIT 1");
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
                return Response::throwResponse(200, "User has been successfully logged in");
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
     * createUser
     * Create a new user account
     *
     * @param string $firstName The user's first name
     * @param string $lastName The user's last name
     * @param string $username The user's username
     * @param string $email The email
     * @param string $password The password
     * @param string $confirm_password The confirmation password
     * @return Response The response object
     */
    public static function createUser(string $firstName, string $lastName, string $username, string $email, string $password, string $confirm_password): Response
    {

        // Check if all inputs are filled out
        if ($firstName == "" || $lastName == "" || $username == "" || $email == "" || $password == "") {
            return Response::throwResponse(406, "Please fill out all fields");
        }
        // Check if username meets requirements
        if (!preg_match("^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$^", $username)) {
            return Response::throwResponse(406, 'Sorry, username does not meet requirements');
        } // Check if email meets requirements
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return Response::throwResponse(406, 'Sorry, you must enter a valid email address');
        } // Check if passwords match
        elseif ($password !== $confirm_password) {
            return Response::throwResponse(406, 'Sorry, passwords do not match');
        } // Check if password meets requirements
        elseif (!preg_match("^(?=.{6,99}$)^", $password)) {
            return Response::throwResponse(406, 'Sorry, password does not meet requirements');
        }

        // Hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        global $conn;
        global $prefix;

        $stmt = $conn->prepare("SELECT COUNT(us.id) FROM  " . $prefix . "users us WHERE us.username = ? GROUP BY us.id");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Username already exists
            return Response::throwResponse(406, 'Sorry, that username is already taken');
        } else {

            $stmt = $conn->prepare("SELECT COUNT(us.id) FROM  " . $prefix . "users us WHERE us.email = ? GROUP BY us.id");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Email already exists
                return Response::throwResponse(406, 'Sorry, that email is already taken');
            } else {

                $stmt = $conn->prepare("INSERT INTO nova_users (first_name, last_name, username, email, password) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $firstName, $lastName, $username, $email, $password);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    // Return 200 response
                    return Response::throwResponse(200, "User account has been created");
                } else {
                    // Return 406 response
                    return Response::throwResponse(406, "User account could not be created");
                }
            }
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
        return Response::throwResponse(200, "User has been successfully logged out");
    }

}