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
     * @return \Response The user or response object
     */
    public static function getAllUsers(): array|Response
    {
        global $conn;
        global $prefix;

        $stmt = $conn->prepare("SELECT us.id AS user_id, CONCAT(us.first_name , ' ', us.last_name) name, CONCAT('https://gravatar.com/avatar/', md5(us.email), '?s=500') avatar, us.username, (SELECT COUNT(po.id) FROM  " . $prefix . "posts po WHERE us.id = po.user_id) posts, (SELECT COUNT(up.id) FROM  " . $prefix . "upvotes up WHERE us.id = up.user_id) upvotes, us.created_at joined FROM  " . $prefix . "users us ORDER BY us.created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $users = [];

            while ($user = $result->fetch_object('Boards')) {
                $users[] = $user;
            }

            return $users;

        } else {
            // Return 204 response
            return Response::throwResponse(204, "Data not found");
        }

    }


}