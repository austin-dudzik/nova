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

        $stmt = $conn->prepare("SELECT se.value FROM settings se WHERE se.setting = ? LIMIT 1");
        $stmt->bind_param("s", $setting);
        $stmt->execute();
        $result = $stmt->get_result();

        // Return the result
        $row = $result->fetch_assoc();
            return $row["value"];
        }


}