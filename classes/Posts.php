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
     * @var int The post status ID
     */
    private int $status_id;

    /**
     * getPostsByBoard
     * Returns all posts for a given board
     *
     * @param int $board_id The board ID
     * @param int $offset The offset of the posts (default = 0)
     * @param int $limit The limit of the posts (default = 10)
     * @return object|array The posts or response object
     */
    public static function getPostsByBoard(int $board_id, int $offset = 0, int $limit = 10): object|array
    {

        global $conn;
        global $site_url;

        $stmt = $conn->prepare("SELECT po.id AS post_id, po.user_id, po.title, po.slug, CONCAT(?, '/p/', po.slug) url, po.content, po.board_id, po.status_id, po.updated_at, po.created_at, COUNT(up.id) upvotes, COUNT(co.id) comments FROM posts po LEFT JOIN upvotes up ON po.id = up.post_id LEFT JOIN comments co ON po.id = co.post_id WHERE po.board_id = ? GROUP BY po.id DESC LIMIT ?, ?");
        $stmt->bind_param("siii", $site_url, $board_id, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        // Define new array
        $posts = array();

        if ($result->num_rows > 0) {

            while ($post = $result->fetch_object('Posts')) {

                // If post has assigned status
                if ($post->status_id) {
                    $post->status = Status::getStatus($post->status_id);
                }

                // If user is signed in
                if (isset($_SESSION['id'])) {
                    $post->hasUpvoted = Upvote::hasUpvoted($post->post_id);
                }
                // Get post user details
                $post->user = User::getUserExcerpt($post->user_id);

                // Add post to array
                $posts[] = $post;

            }

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
     * @return object The posts object or a response
     */
    public static function getPostsByUser(int $user_id, int $offset = 0, int $limit = 10): object|array
    {

        global $conn;
        global $site_url;

        $stmt = $conn->prepare("SELECT po.id AS post_id, po.user_id, po.title, po.slug, CONCAT(?, '/p/', po.slug) url, po.content, po.board_id, po.status_id, po.updated_at, po.created_at, COUNT(up.id) upvotes, COUNT(co.id) comments FROM posts po LEFT JOIN upvotes up ON po.id = up.post_id LEFT JOIN comments co ON po.id = co.post_id WHERE po.user_id = ? GROUP BY po.id DESC LIMIT ?, ?");
        $stmt->bind_param("siii", $site_url, $user_id, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            // Define new array
            $posts = array();

            while ($post = $result->fetch_object('Posts')) {

                // If post has assigned status
                if ($post->status_id) {
                    $post->status = Status::getStatus($post->status_id);
                }

                // If user is signed in
                if (isset($_SESSION['id'])) {
                    $post->hasUpvoted = Upvote::hasUpvoted($post->post_id);
                }

                // Get post user details
                $post->user = User::getUserExcerpt($post->user_id);

                // Add post to array
                $posts[] = $post;

            }

            // Return the posts
            return $posts;

        } else {
            // Return 204 response
            return Response::throwResponse(204, "No posts found");
        }

    }

}