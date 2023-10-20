<?php

namespace Haider\Demo\Api\Controllers;

class Controller
{
    // Common functionality for all controllers
    protected function render($viewName, $data = [])
    {
        // Construct the full path to the view file
        $viewPath = __DIR__ . '/../../../views/' . $viewName . '.php';

        if (file_exists($viewPath)) {
            // Extract the data for use in the view
            extract($data);

            // Start an output buffer to capture the view's content
            ob_start();

            // Include the view file
            include $viewPath;

            // Get the content of the buffer and clean the buffer
            $content = ob_get_clean();
            echo $content;
            return $content;
        } else {
            // Handle the case where the view file doesn't exist
            return 'View not found';
        }
    }


    /**
     * Send a JSON response.
     *
     * @param bool $success Indicates the success or failure of the operation
     * @param string $message A message describing the outcome
     * @param array $data Additional data to send in the response
     * @param int $statusCode HTTP status code, defaults to 200
     * @return void
     */
    public function jsonResponse(bool $success, string $message = '', array $data = [], int $statusCode = 200): void
    {
        // Set the response code
        http_response_code($statusCode);

        // Create the response payload
        $response = [
            'success' => $success,
            'message' => $message,
            'data'    => $data
        ];

        // Send the JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
