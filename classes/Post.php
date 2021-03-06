<?php

/**
 * Post class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Post
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
     * getPost
     * Returns post details for a given post
     *
     * @param string $post_slug The post ID
     *
     * @return Post|Response|stdClass The post or response object
     */
    public static function getPost(string $post_slug): Post|Response|stdClass
    {
        global $user;
        global $conn;

        $site_url = SITE_URL;

        $stmt = $conn->prepare("SELECT po.id as post_id, po.user_id, po.title, po.slug, po.content, po.board_id, po.status_id, po.updated_at, po.created_at, CONCAT(?, '/p/', po.slug) url, COUNT(up.id) upvotes FROM " . DB_PREFIX . "posts po LEFT JOIN  " . DB_PREFIX . "upvotes up ON po.id = up.post_id WHERE po.slug = ? GROUP BY po.id");
        $stmt->bind_param("ss", $site_url, $post_slug);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            // Assign variable to Posts object
            $post = $result->fetch_object('Post');

            if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
                // If post has assigned status
                if ($post->status_id) {
                    $post->status = Status::getStatusExcerpt($post->status_id);
                }

                // If user is signed in
                if (isset($user)) {
                    $post->hasUpvoted = Upvote::hasUpvoted($post->post_id);
                }

                // Get post board details
                $post->board = Board::getBoardExcerpt($post->board_id);

                // Get post user details
                $post->user = User::getUserExcerpt($post->user_id);

                // Return the post
                return $post;
            } else {

                if (Rules::verifyRulesByPost($post->slug)) {

                    // If post has assigned status
                    if ($post->status_id) {
                        $post->status = Status::getStatusExcerpt($post->status_id);
                    }

                    // If user is signed in
                    if (isset($user)) {
                        $post->hasUpvoted = Upvote::hasUpvoted($post->post_id);
                    }

                    // Get post board details
                    $post->board = Board::getBoardExcerpt($post->board_id);

                    // Get post user details
                    $post->user = User::getUserExcerpt($post->user_id);

                    // Return the post
                    return $post;

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
     * deletePost
     * Deletes a given post
     *
     * @param string $post_slug The post slug
     *
     * @return bool The status of the query
     */
    public static function deletePost(string $post_slug): bool
    {

        global $conn;

        $stmt = $conn->prepare("DELETE FROM " . DB_PREFIX . "posts WHERE slug = ? LIMIT 1");
        $stmt->bind_param("s", $post_slug);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

    /**
     * changeStatus
     * Changes the status on a given post
     *
     * @param int $status_id The status ID
     * @param string $post_slug The post slug
     *
     * @return bool The status of the query
     */
    public static function changeStatus(int $status_id, string $post_slug): bool
    {

        global $conn;

        $stmt = $conn->prepare("UPDATE " . DB_PREFIX . "posts SET status_id = ? WHERE slug = ? LIMIT 1");
        $stmt->bind_param("ss", $status_id, $post_slug);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

    /**
     * movePost
     * Moves a given post to another board
     *
     * @param int $board_id The board ID
     * @param string $post_slug The post slug
     *
     * @return bool The status of the query
     */
    public static function movePost(int $board_id, string $post_slug): bool
    {

        global $conn;

        $stmt = $conn->prepare("UPDATE " . DB_PREFIX . "posts SET board_id = ? WHERE slug = ? LIMIT 1");
        $stmt->bind_param("is", $board_id, $post_slug);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

    /**
     * createPost
     * Creates a new post
     *
     * @param string $title The post title
     * @param string $slug The post slug
     * @param string $content The post content
     * @param int $board_id The board ID
     *
     * @return bool The status of the query
     */
    public static function createPost(string $title, string $slug, string $content, int $board_id): bool
    {

        global $conn;
        global $user;

        $stmt = $conn->prepare("INSERT INTO " . DB_PREFIX . "posts (user_id, title, slug, content, board_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $user->id, $title, $slug, $content, $board_id);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

    /**
     * updatePost
     * Updates a given post
     *
     * @param string $title The post title
     * @param string $content The post content
     * @param int $post_id The post ID
     *
     * @return bool The status of the query
     */
    public static function updatePost(string $title, string $content, int $post_id): bool
    {

        global $conn;
        global $user;

        $stmt = $conn->prepare("UPDATE " . DB_PREFIX . "posts SET title = ?, content = ? WHERE user_id = ? AND id = ? LIMIT 1");
        $stmt->bind_param("ssii", $title, $content, $user->id, $post_id);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }


}