<?php

/**
 * Voters class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Voters
{

    /**
     * getVoters
     * Returns >=5 random users who have upvoted a given post
     *
     * @param int $post_id The post ID
     * @return Voters|Response|array The voters or response object
     */
    public static function getVoters(int $post_id): Voters|Response|array
    {
        global $conn;
        $stmt = $conn->prepare("SELECT CONCAT(us.first_name, ' ', us.last_name) name, CONCAT('https://gravatar.com/avatar/', md5(us.email), '?s=500') avatar FROM upvotes up LEFT JOIN users us ON up.user_id = us.id WHERE post_id = ? GROUP BY us.id ORDER BY RAND() LIMIT 5");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            // Define new array
            $voters = array();

            while ($voter = $result->fetch_object('Voters')) {
                // Add voter to array
                $voters[] = $voter;
            }

            // Return random voters
            return $voters;

        } else {
            // Return 204 response
            return Response::throwResponse(204, "Data not found");
        }

    }

}