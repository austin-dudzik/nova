<?php

/**
 * Settings class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Settings
{

    /**
     * getSettings
     * Returns all configured site settings
     *
     * @param string $setting The setting to return
     *
     * @return string The returned setting
     */
    public static function getSettings(string $setting): string
    {

        global $conn;

        $stmt = $conn->prepare("SELECT se.value FROM " . DB_PREFIX . "settings se WHERE se.setting = ? LIMIT 1");
        $stmt->bind_param("s", $setting);
        $stmt->execute();
        $result = $stmt->get_result();

        // Return the result
        $row = $result->fetch_assoc();
        return $row["value"];
    }

    /**
     * saveSettings
     * Saves site settings to database
     *
     * @param string $site_name The site name
     * @param string $description The site description
     * @param string $accent The site accent
     * @param int $feed_type The feed type
     *
     * @return bool The status of the query
     */
    public static function saveSettings(string $site_name, string $description, string $accent, int $feed_type): bool
    {

        global $conn;

        // Update site name
        $stmt = $conn->prepare("UPDATE " . DB_PREFIX . "settings SET value = ? WHERE setting = 'site_title' LIMIT 1");
        $stmt->bind_param("s", $site_name);
        $success = $stmt->execute();
        $stmt->close();

        // Update site accent
        if ($success) {
            $stmt = $conn->prepare("UPDATE " . DB_PREFIX . "settings SET value = ? WHERE setting = 'accent_color' LIMIT 1");
            $stmt->bind_param("s", $accent);
            $success = $stmt->execute();
            $stmt->close();

            if ($success) {
                $stmt = $conn->prepare("UPDATE " . DB_PREFIX . "settings SET value = ? WHERE setting = 'site_desc' LIMIT 1");
                $stmt->bind_param("s", $description);
                $success = $stmt->execute();
                $stmt->close();

                if ($success) {
                    $stmt = $conn->prepare("UPDATE " . DB_PREFIX . "settings SET value = ? WHERE setting = 'feed_type' LIMIT 1");
                    $stmt->bind_param("i", $feed_type);
                    $success = $stmt->execute();
                    $stmt->close();
                }

            }

        }

        return $success;

    }


}