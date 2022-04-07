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
     * @var int The board visibility
     */
    public int $visibility;
    /**
     * @var string The board rules
     */
    private string $rules;


    /**
     * getBoards
     * Returns all boards
     *
     * @return Boards|Response|array The board or response object
     */
    public static function getBoards(): Boards|Response|array
    {

        global $conn;
        global $prefix;

        $site_url = Settings::getSettings("site_url");

        $stmt = $conn->prepare("SELECT bo.id board_id, bo.name, bo.slug, CONCAT(?, '/b/', bo.slug) url, bo.icon, bo.description, bo.visibility, bo.rules, (SELECT COUNT(po.id) FROM  " . $prefix . "posts po WHERE po.board_id = bo.id) posts, (SELECT COUNT(su.id) FROM  " . $prefix . "subscribers su WHERE su.board_id = bo.id) subscribers, (SELECT COUNT(up.id) FROM  " . $prefix . "posts po LEFT JOIN  " . $prefix . "upvotes up ON up.post_id = po.id WHERE po.board_id = bo.id) upvotes FROM  " . $prefix . "boards bo WHERE bo.visibility IN (1, 2)");
        $stmt->bind_param("s", $site_url);
        $stmt->execute();
        $result = $stmt->get_result();

        // Define new array
        $boards = [];

        while ($board = $result->fetch_object('Boards')) {

            // Determine board visibility
            if (Rules::verifyRulesByBoard($board->slug)) {
                // Add board to array
                $boards[] = $board;
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

    /**
     * getAdminBoards
     * Returns *all* boards for admins
     *
     * @return Boards|Response|array The board or response object
     */
    public static function getAdminBoards(): Boards|Response|array
    {

        global $conn;
        global $prefix;

        $site_url = Settings::getSettings("site_url");

        $stmt = $conn->prepare("SELECT bo.id board_id, bo.name, bo.slug, CONCAT(?, '/b/', bo.slug) url, bo.icon, bo.description, bo.visibility, bo.rules, (SELECT COUNT(po.id) FROM  " . $prefix . "posts po WHERE po.board_id = bo.id) posts, (SELECT COUNT(su.id) FROM  " . $prefix . "subscribers su WHERE su.board_id = bo.id) subscribers, (SELECT COUNT(up.id) FROM  " . $prefix . "posts po LEFT JOIN  " . $prefix . "upvotes up ON up.post_id = po.id WHERE po.board_id = bo.id) upvotes FROM  " . $prefix . "boards bo");
        $stmt->bind_param("s", $site_url);
        $stmt->execute();
        $result = $stmt->get_result();

        // Define new array
        $boards = [];

        while ($board = $result->fetch_object('Boards')) {

            // Add board to array
            $boards[] = $board;

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