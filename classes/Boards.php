<?php

/**
 * Boards class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Boards
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
     * getBoards
     * Returns all boards
     *
     * @return Boards|Response|array The board or response object
     */
    public static function getBoards(): Boards|Response|array
    {

        global $conn;
        global $site_url;

        $stmt = $conn->prepare("SELECT bo.id board_id, bo.name, bo.slug, CONCAT(?, '/b/', bo.slug) url, bo.icon, bo.description, (SELECT COUNT(po.id) FROM posts po WHERE po.board_id = bo.id) posts, (SELECT COUNT(su.id) FROM subscribers su WHERE su.board_id = bo.id) subscribers, (SELECT COUNT(up.id) FROM posts po LEFT JOIN upvotes up ON up.post_id = po.id WHERE po.board_id = bo.id) upvotes FROM boards bo");
        $stmt->bind_param("s", $site_url);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            // Define new array
            $boards = array();

            while ($board = $result->fetch_object('Boards')) {
                // Add post to array
                $boards[] = $board;
            }

            // Return the boards
            return $boards;

        } else {
            // Return 204 response
            return Response::throwResponse(204, 'No data found');
        }
    }

}