<?php

/**
 * Users class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Users
{

    /**
     * @var int The user's ID
     */
    public string $user_id;
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
     * getAllUsers
     * Returns all users
     *
     * @param int $type The type of users to return
     *
     * @return Users|Response|array The user or response object
     */
    public static function getAllUsers(int $type = 0): Users|Response|array
    {
        global $conn;
        global $prefix;

        $site_url = Settings::getSettings("site_url");

        $stmt = $conn->prepare("SELECT us.id AS user_id, CONCAT(us.first_name , ' ', us.last_name) name, CONCAT('https://gravatar.com/avatar/', md5(us.email), '?s=500&d=mp') avatar, CONCAT(?, '/u/', us.username) url, us.username FROM  " . $prefix . "users us WHERE is_admin =" . $type . " ORDER BY us.created_at DESC");
        $stmt->bind_param("s", $site_url);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $users = [];

            while ($user = $result->fetch_object('Users')) {
                $users[] = $user;
            }

            return $users;

        } else {
            // Return 204 response
            return Response::throwResponse(204, "Data not found");
        }

    }


}