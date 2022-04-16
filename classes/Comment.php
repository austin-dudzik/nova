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
     * @var int The comment ID
     */
    public int $id;
    /**
     * @var string The comment user ID
     */
    public int $user_id;
    /**
     * @var string The comment content
     */
    public string $content;
    /**
     * @var string The comment creation date
     */
    public string $created_at;

    /**
     * getComments
     * Returns comments for a given post
     *
     * @param int $post_id The post ID
     * @return Voters|Response|array The voters or response object
     */
    public static function getComments(int $post_id): Comment|Response|array
    {
        global $conn;
        global $user;

        $stmt = $conn->prepare("SELECT co.id, co.user_id, co.content, co.created_at FROM  " . DB_PREFIX . "comments co WHERE post_id = ? ORDER BY co.created_at DESC");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            // Define new array
            $comments = [];

            while ($comment = $result->fetch_object('Comment')) {
                // Add comment to array
                $comment->can_manage = (isset($user) && $user->id === $comment->user_id) || isset($_SESSION["admin"]) && $_SESSION["admin"];
                $comment->user = User::getUserExcerpt($comment->user_id);
                $comments[] = $comment;
            }

            // Return comments
            return $comments;

        } else {
            // Return 204 response
            return Response::throwResponse(204, "Data not found");
        }
    }

    /**
     * newComment
     * Creates a new comment on a given post
     *
     * @param string $post_id The post ID
     * @param string $comment The comment content
     * @return bool Status of the query
     */
    public static function newComment(string $post_id, string $comment): bool
    {

        global $conn;
        global $user;

        $stmt = $conn->prepare("INSERT INTO  " . DB_PREFIX . "comments (post_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $post_id, $user->id, $comment);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

    /**
     * deleteComment
     * Deletes a given comment
     *
     * @param int $comment_id The comment ID
     * @return bool Status of the query
     */
    public static function deleteComment(string $comment_id): bool
    {

        global $conn;
        global $user;

        // If current user is admin
        if (isset($_SESSION["admin"]) && $_SESSION["admin"]) {
            $stmt = $conn->prepare("DELETE FROM  " . DB_PREFIX . "comments WHERE id = ?");
            $stmt->bind_param("i", $comment_id);
        } else {
            $stmt = $conn->prepare("DELETE FROM  " . DB_PREFIX . "comments WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $comment_id, $user->id);
        }

        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

}