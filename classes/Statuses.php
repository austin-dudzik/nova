<?php

/**
 * Statuses class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Statuses
{

    /**
     * @var int The status ID
     */
    public int $status_id;
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
     * Returns all statuses
     *
     * @return Statuses|Response|array The statuses or response object
     */
    public static function getStatuses(): Statuses|Response|array
    {
        global $conn;

        $stmt = $conn->prepare("SELECT st.id status_id, st.name, st.slug, st.color FROM statuses st");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            // Define new array
            $statuses = array();

            while ($status = $result->fetch_object('Status')) {

                // Get post's under this status
                $status->posts = Posts::getPostsByStatus($status->status_id);

                // Add status to array
                $statuses[] = $status;
            }

            // Return the statuses
            return $statuses;

        } else {
            // Return 204 response
            return Response::throwResponse(204, 'No data found');
        }
    }

}