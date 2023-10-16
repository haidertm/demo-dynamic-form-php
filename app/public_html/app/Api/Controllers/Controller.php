<?php

namespace Haider\Demo\Api\Controllers;

class Controller
{
    // Common functionality for all controllers
    public function render($viewName, $data = [])
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

    public function loadLayout($layoutPath, $content) {
        include(__DIR__ . '/../../../views/layouts/default.php');
    }
}
