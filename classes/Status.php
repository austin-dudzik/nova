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
     * @var string The status slug
     */
    public string $slug;
    /**
     * @var string The status color
     */
    public string $color;

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

        $stmt = $conn->prepare("SELECT st.name, st.slug, st.color FROM  ". $prefix . "statuses st WHERE st.id = ?");
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

        $stmt = $conn->prepare("SELECT st.name, st.slug, st.color FROM  ". $prefix . "statuses st WHERE st.id = ?");
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

}