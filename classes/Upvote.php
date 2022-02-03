<?php

/**
 * Upvote class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Upvote
{

    /**
     * votePost
     * Adds/removes a vote from a post
     *
     * @param int $post_id The post ID
     * @return Response The response object
     */
    public static function votePost(int $post_id): Response
    {

        global $user;
        global $conn;

        // If user is not authenticated
        if (!isset($user)) {
            // Return 401 response
            return Response::throwResponse(401, "You must be authenticated in order to vote");
        }

        $stmt = $conn->prepare("SELECT COUNT(up.id) count FROM upvotes up WHERE up.post_id = ? AND up.user_id = ? GROUP BY up.id");
        $stmt->bind_param("ii", $post_id, $user->id);
        $stmt->execute();
        $result = $stmt->get_result();

        // If existing upvote found
        if ($result->num_rows > 0) {

            // Delete upvote from database
            $stmt = $conn->prepare("DELETE up FROM upvotes up WHERE up.post_id = ? AND up.user_id = ?");
            $stmt->bind_param("ii", $post_id, $user->id);
            $stmt->execute();

            // If successful deletion...
            if ($stmt->affected_rows > 0) {
                // Return 200 response
                return Response::throwResponse(200, "Successfully removed upvote");
            } else {
                // Return 500 response
                return Response::throwResponse(500, "Failed to remove upvote");
            }

            // If no existing upvote found
        } else {

            // Insert upvote into database
            $stmt = $conn->prepare("INSERT INTO upvotes (post_id, user_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $post_id, $user->id);
            $stmt->execute();

            // If successful insertion...
            if ($stmt->affected_rows > 0) {
                // Return 200 response
                return Response::throwResponse(200, "Successfully added upvote");
            } else {
                // Return 500 response
                return Response::throwResponse(500, "Failed to add upvote");
            }

        }

    }

    /**
     * hasUpvoted
     * Returns current user upvote status for a post
     *
     * @param int $post_id The post ID
     * @return bool Upvote status
     */
    public static function hasUpvoted(int $post_id): bool
    {
        global $conn;
        $stmt = $conn->prepare("SELECT COUNT(up.id) FROM upvotes up WHERE up.user_id = ? AND up.post_id = ? GROUP BY up.id");
        $stmt->bind_param("ii", $user->id, $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows;
    }

}