<?php

trait Controller
{
    public function view($path, $data = [], $return = false)
    {
        // Convert dot notation (e.g., "auth.login") to slashes ("auth/login")
        $path = str_replace(".", "/", $path);

        // Define full path to the view
        $filename = dirname(__DIR__) . "/views/" . $path . ".view.php";

        if (file_exists($filename)) {
            //echo "Rendering View: " . $filename . "<br>"; // Debugging
            extract($data); // Extract variables for use in the view

            if ($return) {
                ob_start(); // Start output buffering
                require $filename;
                return ob_get_clean(); // Capture output and return it
            } else {
                require $filename; // Directly load the view
            }
        } else {
            require_once dirname(__DIR__) . "/views/errors/404.view.php";
        }
    }
}
