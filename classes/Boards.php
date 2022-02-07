<?php

/**
 * Boards class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Boards
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
     * @var int The board subscriber count
     */
    public int $subscribers;
    /**
     * @var int The board upvote count
     */
    public int $upvotes;
    /**
     * @var string The board URL
     */
    public string $board_url;
    /**
     * @var int The board visibility
     */
    private int $visibility;
    /**
     * @var string The board rules
     */
    private string $rules;


    /**
     * getBoards
     * Returns all boards
     *
     * @return Boards|Response|array The board or response object
     */
    public static function getBoards(): Boards|Response|array
    {

        global $conn;
        global $prefix;
        global $user;

        $site_url = Settings::getSettings("site_url");

        $stmt = $conn->prepare("SELECT bo.id board_id, bo.name, bo.slug, CONCAT(?, '/b/', bo.slug) url, bo.icon, bo.description, bo.visibility, bo.rules, (SELECT COUNT(po.id) FROM  " . $prefix . "posts po WHERE po.board_id = bo.id) posts, (SELECT COUNT(su.id) FROM  " . $prefix . "subscribers su WHERE su.board_id = bo.id) subscribers, (SELECT COUNT(up.id) FROM  " . $prefix . "posts po LEFT JOIN  " . $prefix . "upvotes up ON up.post_id = po.id WHERE po.board_id = bo.id) upvotes FROM  " . $prefix . "boards bo WHERE bo.visibility = 1 OR bo.visibility = 2");
        $stmt->bind_param("s", $site_url);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            // Define new array
            $boards = array();

            while ($board = $result->fetch_object('Boards')) {

                // If board is private
                if ($board->visibility === 2) {

                    // Convert string to array
                    $rules = json_decode($board->rules);

                    $check_array = array();

                    // Loop through the rules
                    foreach ($rules as $rule) {

                        // If rule is a wildcard
                        if (str_starts_with($rule, "*")) {

                            // The rule's email domain
                            $rule_domain = str_replace("*@", "", $rule);
                            // The user's email domain
                            $user_domain = explode('@', $user->email, 2)[1];

                            // If user's email domain matches the rule's domain
                            if ($rule_domain === $user_domain) {
                                array_push($check_array, true);
                            } else {
                                array_push($check_array, false);
                            }

                        } else {

                            // If rule is a specific email
                            if ($rule === $user->email) {
                                array_push($check_array, true);
                            } else {
                                array_push($check_array, false);
                            }

                        }

                    }

                    if(in_array(true, $check_array)) {
                        $boards[] = $board;
                    }


                } else {
                    // Add post to array
                    $boards[] = $board;
                }

            }

            // Return the boards
            return $boards;

        } else {
            // Return 204 response
            return Response::throwResponse(204, 'No data found');
        }
    }

}