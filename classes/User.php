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
     * @param string $user_slug The user slug
     * @return object The user or response object
     */
    public static function getUser(string $user_slug): object
    {
        global $conn;
        $stmt = $conn->prepare("SELECT us.id user_id, CONCAT(us.first_name , ' ', us.last_name) name, CONCAT('https://gravatar.com/avatar/', md5(us.email), '?s=500') avatar, us.username, COUNT(po.id) posts, COUNT(up.id) upvotes, us.created_at joined FROM users us LEFT JOIN posts po ON us.id = po.user_id LEFT JOIN upvotes up ON us.id = up.user_id WHERE us.username = ?");
        $stmt->bind_param("s", $user_slug);
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