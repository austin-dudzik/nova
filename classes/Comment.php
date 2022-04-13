<?php

/**
 * Comment class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Comment
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
    private int $user_id;

    /**
     * getComments
     * Returns users who have upvoted a given post
     *
     * @param int $post_id The post ID
     * @param int $limit The number of users to return
     * @return Voters|Response|array The voters or response object
     */
    public static function getComments(int $post_id): Comment|Response|array
    {
        global $conn;
        global $prefix;

        if($post_id) {

            $stmt = $conn->prepare("SELECT co.user_id, co.content, co.created_at FROM  " . $prefix . "comments co WHERE post_id = ? ORDER BY co.created_at DESC");
            $stmt->bind_param("i",  $post_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                // Define new array
                $comments = [];

                while ($comment = $result->fetch_object('Comment')) {
                    // Add comment to array
                    $comment->user = User::getUserExcerpt($comment->user_id);
                    $comments[] = $comment;
                }

                // Return comments
                return $comments;

            } else {
                // Return 204 response
                return Response::throwResponse(204, "Data not found");
            }

        } else {
            // Return 400 response
            //return Response::throwResponse(400, "Post ID is required for this request");
        }

    }

    /**
     * newComment
     * Creates a new comment on a post
     *
     * @param string $board_id The board ID
     * @return bool Status of the query
     */
    public static function newComment(string $post_id, string $content): bool
    {

        global $conn;
        global $prefix;
        global $user;

        $stmt = $conn->prepare("INSERT INTO  " . $prefix . "comments (post_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $post_id, $user->id, $content);
        $stmt->execute();

        echo $stmt->error;

        return $stmt->affected_rows > 0;

    }

}