<?php

/**
 * User class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class User
{

    /**
     * @var string The user's name
     */
    public string $name;
    /**
     * @var string The user's avatar URL
     */
    public string $avatar;
    /**
     * @var string The user's username
     */
    public string $username;

    /**
     * getUser
     * Returns user details for a given user
     *
     * @param int $user_id The user ID
     * @return object The user or response object
     */
    public static function getUser(int $user_id): object
    {
        global $conn;
        $stmt = $conn->prepare("SELECT CONCAT(us.first_name , ' ', us.last_name) name, CONCAT('https://gravatar.com/avatar/', md5(us.email), '?s=500') avatar, us.username  FROM users us WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Return user details
            return $result->fetch_object('User');
        } else {
            // Return 204 response
            return Response::throwResponse(204, "Data not found");
        }
    }

}