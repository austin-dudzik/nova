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
     * @var bool Status of current user upvote
     */
    public bool $hasUpvoted;

    /**
     * getPost
     * Returns post details for a given post
     *
     * @param string $post_slug The post ID
     * @return Post|Response|stdClass The post or response object
     */
    public static function getPost(string $post_slug): Post|Response|stdClass
    {
        global $user;
        global $conn;

        $stmt = $conn->prepare("SELECT po.id as post_id, po.user_id, po.title, po.content, po.board_id, po.status_id, po.updated_at, po.created_at, COUNT(up.id) upvotes FROM posts po LEFT JOIN upvotes up ON po.id = up.post_id WHERE po.slug = ? GROUP BY po.id");
        $stmt->bind_param("i", $post_slug);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            // Assign variable to Posts object
            $post = $result->fetch_object('Post');

            // If post has assigned status
            if ($post->status_id) {
                $post->status = Status::getStatus($post->status_id);
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

}