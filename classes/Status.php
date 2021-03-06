<?php

/**
 * Status class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Status
{

    /**
     * @var string The status name
     */
    public string $name;
    /**
     * @var string The status color
     */
    public string $color;


    /**
     * getStatuses
     * Returns all statuses
     *
     * @return Statuses|Response|array The status or response object
     */
    public static function getStatuses(): Statuses|Response|array
    {
        global $conn;

        $stmt = $conn->prepare("SELECT st.id, st.name, st.color FROM  " . DB_PREFIX . "statuses st");
        $stmt->execute();
        $result = $stmt->get_result();

        // Define new array
        $statuses = [];

        while ($status = $result->fetch_object('Status')) {
            // Add status to array
            $statuses[] = $status;
        }

        if (count($statuses) > 0) {
            // Return the statuses
            return $statuses;
        } else {
            // Return 204 response
            return Response::throwResponse(204, "No data found");
        }

    }

    /**
     * getStatusExcerpt
     * Returns status excerpt for a given status
     *
     * @param int $status_id The status ID
     *
     * @return object The status or response object
     */
    public static function getStatusExcerpt(int $status_id): object
    {
        global $conn;

        $stmt = $conn->prepare("SELECT st.id, st.name, st.color FROM  " . DB_PREFIX . "statuses st WHERE st.id = ?");
        $stmt->bind_param("i", $status_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Return status details
            return $result->fetch_object('Status');
        } else {
            // Return 204 response
            return Response::throwResponse(204, 'No data found');
        }
    }

    /**
     * createStatus
     * Creates a new status
     *
     * @param string $name The status name
     * @param string $color The status color
     *
     * @return bool The status of the query
     */
    public static function createStatus(string $name, string $color): bool
    {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO " . DB_PREFIX . "statuses (name, color) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $color);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

    /**
     * updateStatus
     * Updates a given status
     *
     * @param int $id The status ID
     * @param string $name The status name
     * @param string $color The status color
     *
     * @return bool The status of the query
     */
    public static function updateStatus(int $id, string $name, string $color): bool
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE " . DB_PREFIX . "statuses SET name = ?, color = ? WHERE id = ? LIMIT 1");
        $stmt->bind_param("ssi", $name, $color, $id);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

    /**
     * deleteStatus
     * Deletes a given status
     *
     * @param int $id The status ID
     * @return bool The status of the query
     */
    public static function deleteStatus(int $id): bool
    {
        global $conn;

        $stmt = $conn->prepare("DELETE FROM " . DB_PREFIX . "statuses WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

}