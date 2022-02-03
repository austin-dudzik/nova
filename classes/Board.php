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

        $stmt = $conn->prepare("SELECT bo.id board_id, bo.name, bo.slug, bo.icon, bo.description, (SELECT COUNT(po.id) FROM posts po WHERE po.board_id = bo.id) posts, (SELECT COUNT(su.id) FROM subscribers su WHERE su.board_id = bo.id) subscribers, (SELECT COUNT(up.id) FROM posts po LEFT JOIN upvotes up ON up.post_id = po.id WHERE po.board_id = bo.id) upvotes FROM boards bo WHERE bo.slug = ?");
        $stmt->bind_param("s", $board_slug);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Return the board
            return $result->fetch_object('Board');
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
        global $site_url;
        global $conn;

        $stmt = $conn->prepare("SELECT bo.name, bo.slug, bo.icon, CONCAT(?, '/b/', bo.slug) url FROM boards bo WHERE bo.id = ?");
        $stmt->bind_param("si", $site_url, $board_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Return the board
            return $result->fetch_object('Board');
        } else {
            // Return 204 response
            return Response::throwResponse(204, 'No data found');
        }

    }

}