<?php

/**
 * Rules class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Rules
{

    /**
     * verifyRulesByPost
     * Verifies if user can access a given post
     *
     * @param string $post_slug The post slug
     * @return bool True if user can access post, false if not
     */
    public static function verifyRulesByPost(string $post_slug): bool
    {

        global $conn;
        global $user;

        $stmt = $conn->prepare("SELECT bo.rules, bo.visibility FROM " . DB_PREFIX . "posts po LEFT JOIN " . DB_PREFIX . "boards bo ON po.board_id = bo.id WHERE po.slug = ?");
        $stmt->bind_param("s", $post_slug);
        $stmt->execute();
        $result = $stmt->get_result();
        $rule = $result->fetch_object('Rules');

        // If post board is private
        if ($rule->visibility === 2) {

            // If user is logged in
            if (isset($user)) {

                // Convert string to array
                $rules = json_decode($rule->rules);

                // Define array
                $check_array = [];

                // Loop through the rules
                foreach ($rules as $rule) {

                    // If rule is a wildcard
                    if (str_starts_with($rule, "*")) {

                        // The rule's email domain
                        $rule_domain = str_replace("*@", "", $rule);

                        // The user's email domain
                        $user_domain = explode('@', $user->email, 2)[1];

                        // If user's email domain matches the rule's domain
                        $check_array[] = ($rule_domain === $user_domain);

                    } else {
                        // If rule is a specific email
                        $check_array[] = ($rule === $user->email);
                    }
                }

                if (in_array(true, $check_array)) {
                    return true;
                }

            } else {
                // If user is not logged in
                return false;
            }
        } else {
            // If post board is not private
            return true;
        }
        // Default return
        return false;

    }

    /**
     * verifyRulesByBoard
     * Verifies if user can access a given post
     *
     * @param string $board_slug The board slug

     * @return bool True if user can access post, false if not
     */
    public static function verifyRulesByBoard(string $board_slug): bool
    {

        global $conn;
        global $user;

        $stmt = $conn->prepare("SELECT bo.rules, bo.visibility FROM " . DB_PREFIX . "boards bo WHERE bo.slug = ?");
        $stmt->bind_param("s", $board_slug);
        $stmt->execute();
        $result = $stmt->get_result();
        $rule = $result->fetch_object('Rules');

        // If board is private
        if ($rule->visibility === 2) {

            // If user is logged in
            if (isset($user)) {

                // Convert string to array
                $rules = json_decode($rule->rules);

                // Define array
                $check_array = [];

                // Loop through the rules
                foreach ($rules as $rule) {

                    // If rule is a wildcard
                    if (str_starts_with($rule, "*")) {

                        // The rule's email domain
                        $rule_domain = str_replace("*@", "", $rule);

                        // The user's email domain
                        $user_domain = explode('@', $user->email, 2)[1];

                        // If user's email domain matches the rule's domain
                        $check_array[] = ($rule_domain === $user_domain);

                    } else {
                        // If rule is a specific email
                        $check_array[] = ($rule === $user->email);
                    }
                }

                if (in_array(true, $check_array)) {
                    return true;
                }

            } else {
                // If user is not logged in
                return false;
            }
        } else {
            // If post board is not private
            return true;
        }
        // Default return
        return false;

    }

}