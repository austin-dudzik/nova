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
     * @var int The board subscriber count
     */
    public int $subscribers;
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

        $stmt = $conn->prepare("SELECT bo.id board_id, bo.name, bo.slug, bo.icon, bo.description, (SELECT COUNT(po.id) FROM " . $prefix . "posts po WHERE po.board_id = bo.id) posts, (SELECT COUNT(su.id) FROM " . $prefix . "subscribers su WHERE su.board_id = bo.id) subscribers, (SELECT COUNT(up.id) FROM " . $prefix . "posts po LEFT JOIN " . $prefix . "upvotes up ON up.post_id = po.id WHERE po.board_id = bo.id) upvotes FROM  " . $prefix . "boards bo WHERE bo.slug = ?");
        $stmt->bind_param("s", $board_slug);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Prepare the board object
            $board = $result->fetch_object('Board');
            // Determine board visibility
            if (Rules::verifyRulesByBoard($board->slug)) {
                //Return the board
                return $board;
            } else {
                // Return 204 response
                return Response::throwResponse(204, 'No data found');
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
            if (Rules::verifyRulesByBoard($board->slug)) {
                // Return the board
                return $board;
            } else {
                // Return 204 response
                return Response::throwResponse(204, 'No data found');
            }
        } else {
            // Return 204 response
            return Response::throwResponse(204, 'No data found');
        }

    }

    /**
     * checkBoardExistence
     * Returns existence of board
     *
     * @param string $board_slug The board slug
     * @return bool The board or response object
     */
    public static function checkBoardExistence(string $board_slug): bool
    {

        global $conn;
        global $prefix;

        $stmt = $conn->prepare("SELECT bo.id FROM " . $prefix . "boards bo WHERE bo.slug = ? LIMIT 1");
        $stmt->bind_param("s", $board_slug);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;

    }

}