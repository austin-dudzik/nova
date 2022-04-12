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
     * @return object The post or response object
     */
    public static function getStatuses(): Statuses|array
    {
        global $conn;
        global $prefix;

        $stmt = $conn->prepare("SELECT st.id, st.name, st.color FROM  ". $prefix . "statuses st");
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
     * getStatus
     * Returns status details for a given status
     *
     * @param int $status_id The status ID
     * @return object The post or response object
     */
    public static function getStatus(int $status_id): object
    {
        global $conn;
        global $prefix;

        $stmt = $conn->prepare("SELECT st.name, st.color FROM  ". $prefix . "statuses st WHERE st.id = ?");
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
     * getStatusExcerpt
     * Returns status excerpt for a given status
     *
     * @param int $status_id The status ID
     * @return object The post or response object
     */
    public static function getStatusExcerpt(int $status_id): object
    {
        global $conn;
        global $prefix;

        $stmt = $conn->prepare("SELECT st.id, st.name, st.color FROM  ". $prefix . "statuses st WHERE st.id = ?");
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
     * @param int $status_id The status ID
     * @return object The post or response object
     */
    public static function createStatus(string $name, string $color): bool
    {
        global $conn;
        global $prefix;

        $stmt = $conn->prepare("INSERT INTO ". $prefix . "statuses (name, color) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $color);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }


    /**
     * updateStatus
     * Updates a given status
     *
     * @param int $status_id The status ID
     * @return object The post or response object
     */
    public static function updateStatus(int $id, string $name, string $color): bool
    {
        global $conn;
        global $prefix;

        $stmt = $conn->prepare("UPDATE ". $prefix . "statuses SET name = ?, color = ? WHERE id = ? LIMIT 1");
        $stmt->bind_param("ssi", $name, $color, $id);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

    /**
     * deleteStatus
     * Deletes a given status
     *
     * @param int $status_id The status ID
     * @return object The post or response object
     */
    public static function deleteStatus(int $id): bool
    {
        global $conn;
        global $prefix;

        $stmt = $conn->prepare("DELETE FROM ". $prefix . "statuses WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->affected_rows > 0;

    }

}