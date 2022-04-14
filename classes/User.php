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

    private string $email;

    /**
     * getUser
     * Returns user details for a given user
     *
     * @param string $user_slug The user slug
     * @return object The user or response object
     */
    public static function getUser(string $user_slug): User|Response
    {
        global $conn;
        global $prefix;

        $site_url = Settings::getSettings("site_url");

        $stmt = $conn->prepare("SELECT us.id AS user_id, us.first_name, us.last_name, us.email, CONCAT(us.first_name , ' ', us.last_name) name, CONCAT('https://gravatar.com/avatar/', md5(us.email), '?s=500') avatar, CONCAT(?, '/u/', us.username) url, us.username, (SELECT COUNT(po.id) FROM  " . $prefix . "posts po WHERE us.id = po.user_id) posts, (SELECT COUNT(up.id) FROM  " . $prefix . "upvotes up WHERE us.id = up.user_id) upvotes, us.created_at joined FROM  " . $prefix . "users us WHERE us.username = ?");
        $stmt->bind_param("ss", $site_url, $user_slug);
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

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * getUserExcerpt
     * Returns user excerpt for a given user
     *
     * @param string $user_id The user ID
     * @return object The user or response object
     */
    public static function getUserExcerpt(string $user_id): object
    {
        global $conn;
        global $prefix;

        $site_url = Settings::getSettings("site_url");

        $stmt = $conn->prepare("SELECT us.id, CONCAT(us.first_name , ' ', us.last_name) name, CONCAT('https://gravatar.com/avatar/', md5(us.email), '?s=500') avatar, CONCAT(?, '/u/', us.username) url, us.username FROM  " . $prefix . "users us WHERE us.id = ?");
        $stmt->bind_param("ss", $site_url, $user_id);
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

    /**
     * updateRole
     * Updates a given users role
     *
     * @param string $user_id The user ID
     * @return bool The user or response object
     */
    public static function updateRole(string $user_id, int $type): bool
    {
        global $conn;
        global $prefix;

        $stmt = $conn->prepare("UPDATE  " . $prefix . "users SET is_admin = ? WHERE id = ?");
        $stmt->bind_param("ii", $type, $user_id);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

    /**
     * deleteUser
     * Deletes a given user account
     *
     * @param string $user_id The user ID
     * @return bool The user or response object
     */
    public static function deleteUser(string $user_id): bool
    {
        global $conn;
        global $prefix;

        $stmt = $conn->prepare("DELETE FROM " . $prefix . "users WHERE id = ? LIMIT 1");
        $stmt->bind_param("i",  $user_id);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

}