<?php

/**
 * Board class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Board
{

    /**
     * @var int The board ID
     */
    public int $board_id;
    /**
     * @var string The board name
     */
    public string $name;
    /**
     * @var string The board slug
     */
    public string $slug;
    /**
     * @var string The board icon
     */
    public string $icon;
    /**
     * @var string The board description
     */
    public string $description;
    /**
     * @var int The board post count
     */
    public int $posts;
    /**
     * @var int The board upvote count
     */
    public int $upvotes;
    /**
     * @var string The board URL
     */
    public string $board_url;


    /**
     * getBoard
     * Returns board details for a given board
     *
     * @param string $board_slug The board slug
     * @return object The board or response object
     */
    public static function getBoard(string $board_slug): object
    {

        global $conn;
        global $prefix;

        $site_url = Settings::getSettings("site_url");

        $stmt = $conn->prepare("SELECT bo.id board_id, bo.name, bo.slug, bo.icon, CONCAT(?, '/b/', bo.slug) url, bo.description, bo.visibility, bo.rules, (SELECT COUNT(po.id) FROM " . $prefix . "posts po WHERE po.board_id = bo.id) posts, (SELECT COUNT(up.id) FROM " . $prefix . "posts po LEFT JOIN " . $prefix . "upvotes up ON up.post_id = po.id WHERE po.board_id = bo.id) upvotes FROM  " . $prefix . "boards bo WHERE bo.slug = ?");
        $stmt->bind_param("ss", $site_url, $board_slug);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Prepare the board object
            $board = $result->fetch_object('Board');
            if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
                return $board;
            } else {
                // Determine board visibility
                if (Rules::verifyRulesByBoard($board->slug)) {
                    //Return the board
                    return $board;
                } else {
                    // Return 204 response
                    return Response::throwResponse(204, 'No data found');
                }
            }
        } else {
            // Return 204 response
            return Response::throwResponse(204, 'No data found');
        }

    }

    /**
     * getBoardExcerpt
     * Returns board excerpt for a given board
     *
     * @param int $board_id The board ID
     * @return object The board or response object
     */
    public static function getBoardExcerpt(int $board_id): object
    {

        global $conn;
        global $prefix;

        $site_url = Settings::getSettings("site_url");

        $stmt = $conn->prepare("SELECT bo.id board_id, bo.name, bo.slug, bo.icon, CONCAT(?, '/b/', bo.slug) url FROM  " . $prefix . "boards bo WHERE bo.id = ?");
        $stmt->bind_param("si", $site_url, $board_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $board = $result->fetch_object('Board');

            if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
                return $board;
            } else {

                if (Rules::verifyRulesByBoard($board->slug)) {
                    // Return the board
                    return $board;
                } else {
                    // Return 204 response
                    return Response::throwResponse(204, 'No data found');
                }

            }
        } else {
            // Return 204 response
            return Response::throwResponse(204, 'No data found');
        }

    }

    /**
     * createBoard
     * Creates a new board
     *
     * @param string $board_id The board ID
     * @return bool Status of the query
     */
    public static function createBoard(string $name, string $icon, string $slug, string $description, int $visibility, string $rules): bool
    {

        global $conn;
        global $prefix;

        $stmt = $conn->prepare("INSERT INTO  " . $prefix . "boards (name, icon, slug, description, visibility, rules) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssis", $name, $icon, $slug, $description, $visibility, $rules);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

    /**
     * updateBoard
     * Updates a given board
     *
     * @param string $board_id The board ID
     * @return bool Status of the query
     */
    public static function updateBoard(int $id, string $name, string $icon, string $slug, string $description, int $visibility, string $rules): bool
    {

        global $conn;
        global $prefix;

        $stmt = $conn->prepare("UPDATE " . $prefix . "boards SET name = ?, icon = ?, slug = ?, description = ?, visibility = ?, rules = ? WHERE id = ? LIMIT 1");
        $stmt->bind_param("ssssisi", $name, $icon, $slug, $description, $visibility, $rules, $id);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

    /**
     * deleteBoard
     * Deletes a given board
     *
     * @param string $board_id The board ID
     * @return bool Status of the query
     */
    public static function deleteBoard(int $id): bool
    {

        global $conn;
        global $prefix;

        $stmt = $conn->prepare("DELETE FROM " . $prefix . "boards WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

}