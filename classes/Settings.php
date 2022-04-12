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
     * @return string The returned setting
     */
    public static function getSettings(string $setting): string
    {

        global $conn;
        global $prefix;

        $stmt = $conn->prepare("SELECT se.value FROM " . $prefix . "settings se WHERE se.setting = ? LIMIT 1");
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
     * @param string $setting The setting to return
     * @return string The returned setting
     */
    public static function saveSettings(string $site_name, string $accent): bool
    {

        global $conn;
        global $prefix;

        // Update site name
        $stmt = $conn->prepare("UPDATE " . $prefix . "settings SET value = ? WHERE setting = 'site_title' LIMIT 1");
        $stmt->bind_param("s",$site_name);
        $success = $stmt->execute();
        $stmt->close();

        // Update site accent
        if($success) {
            $stmt = $conn->prepare("UPDATE " . $prefix . "settings SET value = ? WHERE setting = 'accent_color' LIMIT 1");
            $stmt->bind_param("s", $accent);
            $success = $stmt->execute();
            $stmt->close();
        }

        return $success;

    }


}