<?php

/**
 * Posts class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Posts
{

    /**
     * @var int The post ID
     */
    public int $post_id;
    /**
     * @var string The post title
     */
    public string $title;
    /**
     * @var string The post slug
     */
    public string $slug;
    /**
     * @var string The post URL
     */
    public string $url;
    /**
     * @var string The post content
     */
    public string $content;
    /**
     * @var string The post updated timestamp
     */
    public string $updated_at;
    /**
     * @var string The post created timestamp
     */
    public string $created_at;
    /**
     * @var int The post upvote count
     */
    public int $upvotes;
    /**
     * @var int The post comment count
     */
    public int $comments;
    /**
     * @var bool Status of current user upvote
     */
    public bool $hasUpvoted;
    /**
     * @var int The post author ID
     */
    private int $user_id;
    /**
     * @var int The post board ID
     */
    private int $board_id;
    /**
     * @var int|null The post status ID
     */
    private int|null $status_id;

    /**
     * getPostsByBoard
     * Returns all posts for a given board
     *
     * @param int $board_id The board ID
     * @param array $filter The filter to apply to the posts
     * @param string $sort The sort to apply to the posts
     * @param int $offset The offset of the posts (default = 0)
     * @param int $limit The limit of the posts (default = 10)
     * @return Posts|Response|array The posts or response object
     */
    public static function getPostsByBoard(int $board_id, array $filter = [], string $sort = "", int $offset = 0, int $limit = 10): Posts|Response|array
    {

        global $user;
        global $conn;
        global $prefix;

        $site_url = Settings::getSettings("site_url");

        $filter = (!empty($filter)) ? "AND status_id IN (" . implode(",", $filter) . ")" : "";

        $sort = match ($sort) {
            "top" => "upvotes DESC, created_at DESC",
            default => "created_at DESC",
        };

        $stmt = $conn->prepare("SELECT po.id AS post_id, po.user_id, po.title, po.slug, CONCAT(?, '/p/', po.slug) url, po.content, po.board_id, po.status_id, po.updated_at, po.created_at, COUNT(up.id) upvotes, COUNT(co.id) comments FROM  " . $prefix . "posts po LEFT JOIN  " . $prefix . "upvotes up ON po.id = up.post_id LEFT JOIN  " . $prefix . "comments co ON po.id = co.post_id WHERE po.board_id = ? $filter GROUP BY po.id ORDER BY $sort LIMIT ?, ?");

        $stmt->bind_param("siii", $site_url, $board_id, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        // Define new array
        $posts = [];

        while ($post = $result->fetch_object('Posts')) {

            // Determine post visibility
            if (Rules::verifyRulesByPost($post->slug)) {

                // If post has assigned status
                if ($post->status_id) {
                    $post->status = Status::getStatusExcerpt($post->status_id);
                }

                // Get post board details
                $post->board = Board::getBoardExcerpt($post->board_id);

                // If user is signed in
                if (isset($user)) {
                    $post->hasUpvoted = Upvote::hasUpvoted($post->post_id);
                }
                // Get post user details
                $post->user = User::getUserExcerpt($post->user_id);

                // Add post to array
                $posts[] = $post;

            }

        }

        if (count($posts) > 0) {
            // Return the posts
            return $posts;
        } else {
            // Return 204 response
            return Response::throwResponse(204, "No posts found");
        }

    }

    /**
     * getPostsByUser
     * Returns all posts for a given user
     *
     * @param int $user_id The user ID
     * @param int $offset The offset of the posts (default = 0)
     * @param int $limit The limit of the posts (default = 10)
     * @return Posts|Response|array The posts object or a response
     */
    public static function getPostsByUser(int $user_id, int $offset = 0, int $limit = 10): Posts|Response|array
    {

        global $user;
        global $conn;
        global $prefix;

        $site_url = Settings::getSettings("site_url");

        $stmt = $conn->prepare("SELECT po.id AS post_id, po.user_id, po.title, po.slug, CONCAT(?, '/p/', po.slug) url, po.content, po.board_id, po.status_id, po.updated_at, po.created_at, COUNT(up.id) upvotes, COUNT(co.id) comments FROM  " . $prefix . "posts po LEFT JOIN  " . $prefix . "upvotes up ON po.id = up.post_id LEFT JOIN  " . $prefix . "comments co ON po.id = co.post_id WHERE po.user_id = ? GROUP BY po.id DESC LIMIT ?, ?");
        $stmt->bind_param("siii", $site_url, $user_id, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        // Define new array
        $posts = [];

        while ($post = $result->fetch_object('Posts')) {

            // Determine post visibility
            if (Rules::verifyRulesByPost($post->slug)) {

                // If post has assigned status
                if ($post->status_id) {
                    $post->status = Status::getStatusExcerpt($post->status_id);
                }

                // Get post board details
                $post->board = Board::getBoardExcerpt($post->board_id);

                // If user is signed in
                if (isset($user)) {
                    $post->hasUpvoted = Upvote::hasUpvoted($post->post_id);
                }

                // Get post user details
                $post->user = User::getUserExcerpt($post->user_id);

                // Add post to array
                $posts[] = $post;

            }

        }

        if (count($posts) > 0) {
            // Return the posts
            return $posts;
        } else {
            // Return 204 response
            return Response::throwResponse(204, "No posts found");
        }

    }

    /**
     * getPostsByStatus
     * Returns all posts for a given status
     *
     * @param int $status_id The status ID
     * @param int $offset The offset of the posts (default = 0)
     * @param int $limit The limit of the posts (default = 10)
     * @return Posts|Response|array The posts object or a response
     */
    public static function getPostsByStatus(int $status_id, int $offset = 0, int $limit = 10): Posts|Response|array
    {

        global $user;
        global $conn;
        global $prefix;

        $site_url = Settings::getSettings("site_url");

        $stmt = $conn->prepare("SELECT po.id AS post_id, po.user_id, po.title, po.slug, CONCAT(?, '/p/', po.slug) url, po.content, po.board_id, po.status_id, po.updated_at, po.created_at, COUNT(up.id) upvotes, COUNT(co.id) comments FROM  " . $prefix . "posts po LEFT JOIN  " . $prefix . "upvotes up ON po.id = up.post_id LEFT JOIN  " . $prefix . "comments co ON po.id = co.post_id WHERE po.status_id = ? GROUP BY po.id DESC LIMIT ?, ?");
        $stmt->bind_param("siii", $site_url, $status_id, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        // Define new array
        $posts = [];

        while ($post = $result->fetch_object('Posts')) {

            // Determine post visibility
            if (Rules::verifyRulesByPost($post->slug)) {

                // If post has assigned status
                if ($post->status_id) {
                    $post->status = Status::getStatusExcerpt($post->status_id);
                }

                // Get post board details
                $post->board = Board::getBoardExcerpt($post->board_id);

                // If user is signed in
                if (isset($user)) {
                    $post->hasUpvoted = Upvote::hasUpvoted($post->post_id);
                }

                // Get post user details
                $post->user = User::getUserExcerpt($post->user_id);

                // Add post to array
                $posts[] = $post;

            }

        }

        if (count($posts) > 0) {
            // Return the posts
            return $posts;
        } else {
            // Return 204 response
            return Response::throwResponse(204, "No posts found");
        }


    }

}