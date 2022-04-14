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
     * @var int The user's ID
     */
    public int $user_id;
    /**
     * @var string The user's first name
     */
    public string $first_name;
    /**
     * @var string The user's last name
     */
    public string $last_name;
    /**
     * @var string The user's email
     */
    private string $email;
    /**
     * @var string The user's name
     */
    public string $name;
    /**
     * @var string The user's avatar
     */
    public string $avatar;
    /**
     * @var string The user's URL
     */
    public string $url;
    /**
     * @var string The user's username
     */
    public string $username;

    /**
     * getUser
     * Returns user details for a given user
     *
     * @param string $user_slug The user slug
     *
     * @return object The user or response object
     */
    public static function getUser(string $user_slug): object
    {
        global $conn;
        global $prefix;

        $site_url = Settings::getSettings("site_url");

        $stmt = $conn->prepare("SELECT us.id AS user_id, us.first_name, us.last_name, us.email, CONCAT(us.first_name , ' ', us.last_name) name, CONCAT('https://gravatar.com/avatar/', md5(us.email), '?s=500&d=mp') avatar, CONCAT(?, '/u/', us.username) url, us.username FROM  " . $prefix . "users us WHERE us.username = ?");
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

    // Magic getter
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * getUserExcerpt
     * Returns user excerpt for a given user
     *
     * @param string $user_id The user ID
     *
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
     * @param int $type The new type
     *
     * @return bool The status of the query
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
     *
     * @return bool The status of the query
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