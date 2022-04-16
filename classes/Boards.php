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
     * @var string The board URL
     */
    public string $board_url;
    /**
     * @var int The board visibility
     */
    public int $visibility;
    /**
     * @var string The board rules
     */
    private string $rules;
    /**
     * @var int The posts count
     */
    public int $posts;


    /**
     * getBoards
     * Returns all boards
     *
     * @return Boards|Response|array The board or response object
     */
    public static function getBoards(): Boards|Response|array
    {

        global $conn;

        $site_url = SITE_URL;

        $stmt = $conn->prepare("SELECT bo.id board_id, bo.name, bo.slug, CONCAT(?, '/b/', bo.slug) url, bo.icon, bo.description, bo.visibility, bo.rules, (SELECT COUNT(po.id) FROM  " . DB_PREFIX . "posts po WHERE po.board_id = bo.id) posts FROM  " . DB_PREFIX . "boards bo");
        $stmt->bind_param("s", $site_url);
        $stmt->execute();
        $result = $stmt->get_result();

        // Define new array
        $boards = [];

        while ($board = $result->fetch_object('Boards')) {

            // If current user is admin
            if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
                // Add board to array
                $boards[] = $board;
            } else {
                // If board is not unlisted
                if ($board->visibility !== 0) {
                    // Determine board visibility
                    if (Rules::verifyRulesByBoard($board->slug)) {
                        // Add board to array
                        $boards[] = $board;
                    }
                }
            }

        }

        if (count($boards) > 0) {
            // Return the posts
            return $boards;
        } else {
            // Return 204 response
            return Response::throwResponse(204, "No boards found");
        }

    }

}