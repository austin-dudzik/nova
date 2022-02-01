<?php

/**
 * Response class
 * @author Austin Dudzik
 * @version 1.0
 * @copyright Copyright (C) 2022 Austin Dudzik
 */
class Response
{

    /**
     * @var int The response code
     */
    public int $code;
    /**
     * @var string The response message
     */
    public string $message;

    /**
     * throwResponse
     * Returns a specific API response
     *
     * @param int $code The response code
     * @param string $message The response message
     * @return Response The response object
     */
    public static function throwResponse(int $code, string $message): Response
    {
        // Define new response object
        $issue = new Response();

        // Assign response code
        $issue->code = $code;

        // Assign message code
        $issue->message = $message;

        // Return response object
        return $issue;
    }


}