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
     * Returns users who have upvoted a given post
     *
     * @param int $post_id The post ID
     * @param int $limit The number of users to return
     * @return Voters|Response|array The voters or response object
     */
    public static function getVoters(int $post_id, int $limit = 18446744073709551610): Voters|Response|array
    {
        global $conn;
        global $prefix;

        $stmt = $conn->prepare("SELECT CONCAT(us.first_name, ' ', us.last_name) name, CONCAT('https://gravatar.com/avatar/', md5(us.email), '?s=500') avatar FROM  ". $prefix . "upvotes up LEFT JOIN  ". $prefix . "users us ON up.user_id = us.id WHERE post_id = ? GROUP BY us.id LIMIT ?");
        $stmt->bind_param("ii", $post_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            // Define new array
            $voters = [];

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