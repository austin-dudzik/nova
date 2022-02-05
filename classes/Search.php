<?php

/**
 * Search class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Search
{

    /**
     * @var string The result name
     */
    public string $name;
    /**
     * @var string The result URL
     */
    public string $url;
    /**
     * @var string The result type
     */
    public string $type;

    /**
     * getResults
     * Returns all posts for a given search term
     *
     * @param string $term The search term
     * @return Search|Response|array The posts object or a response
     */
    public static function getResults(string $term): Search|Response|array
    {

        global $conn;
        global $site_url;

        if(!$term) {
            // Return an empty array
            return array(Response::throwResponse(204, "No results found"));
        }

        $term = trim($term);


        if($term) {
            $term = "%" . trim($term) . "%";
        } else {
            return array();
        }

        $stmt = $conn->prepare("SELECT po.title AS name, 'post' AS type, CONCAT(?, '/p/', po.slug) url FROM posts po WHERE po.title LIKE ? UNION SELECT CONCAT(us.first_name, ' ', us.last_name) AS name, 'user' AS type, CONCAT(?, '/u/', us.username) url FROM users us WHERE CONCAT(us.first_name, ' ', us.last_name) LIKE ? UNION SELECT bo.name AS name, 'board' AS type, CONCAT(?, '/b/', bo.slug) url FROM boards bo WHERE bo.name LIKE ?");
        $stmt->bind_param("ssssss", $site_url, $term, $site_url, $term, $site_url, $term);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            // Define new array
            $searchResults = array();

            while ($searchResult = $result->fetch_object('Search')) {

                // Add result to array
                $searchResults[] = $searchResult;

            }

            // Return the results
            return $searchResults;

        } else {
            // Return an empty array
            return array(Response::throwResponse(204, "No results found"));
        }

    }

}