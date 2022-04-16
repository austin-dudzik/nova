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
     * @var string The result slug
     */
    private string $slug;

    /**
     * getResults
     * Returns all posts for a given search term
     *
     * @param string $term The search term
     *
     * @return Search|Response|array The search or response object
     */
    public static function getResults(string $term): Search|Response|array
    {

        global $conn;

        $site_url = SITE_URL;

        // If not term is entered
        if (!$term) {
            // Return an empty array
            return [Response::throwResponse(204, "No results found")];
        }

        // Trim the term
        $term = trim($term);


        if ($term) {
            $term = "%" . trim($term) . "%";
        } else {
            return [];
        }

        $stmt = $conn->prepare("SELECT name, type, slug, url FROM (SELECT po.title AS name, 'post' AS type, po.slug, CONCAT(?, '/p/', po.slug) url FROM  " . DB_PREFIX . "posts po WHERE po.title LIKE ? UNION SELECT CONCAT(us.first_name, ' ', us.last_name) AS name, 'user' AS type, us.username, CONCAT(?, '/u/', us.username) url FROM  " . DB_PREFIX . "users us WHERE CONCAT(us.first_name, ' ', us.last_name) LIKE ? UNION SELECT bo.name AS name, 'board' AS type, bo.slug, CONCAT(?, '/b/', bo.slug) url FROM  " . DB_PREFIX . "boards bo WHERE bo.name LIKE ?) AS search ORDER BY name LIMIT 10");
        $stmt->bind_param("ssssss", $site_url, $term, $site_url, $term, $site_url, $term);
        $stmt->execute();
        $result = $stmt->get_result();

        // Define new array
        $searchResults = [];

        while ($searchResult = $result->fetch_object('Search')) {

            // If result is post
            if ($searchResult->type === "post") {
                // Determine result visibility
                if (Rules::verifyRulesByPost($searchResult->slug)) {
                    // Add result to array
                    $searchResults[] = $searchResult;
                }

            }
            // If result is user
            else if ($searchResult->type === "user") {
                // Add result to array
                $searchResults[] = $searchResult;

            }
            // Is result is board
            else if ($searchResult->type === "board") {
                // Determine result visibility
                if (Rules::verifyRulesByBoard($searchResult->slug)) {
                    // Add result to array
                    $searchResults[] = $searchResult;
                }
            }

        }

        if (count($searchResults) > 0) {
            // Return the results
            return $searchResults;
        } else {
            // Return 204 response
            return [Response::throwResponse(204, "No results found")];
        }


    }

}