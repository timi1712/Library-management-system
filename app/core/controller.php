<?php

trait Controller
{
    public function view($path, $data = [])
    {
        // Convert dot notation (if used) to slashes (e.g., "auth.login" → "auth/login")
        $path = str_replace(".", "/", $path);

        // Define full path to the view
        $filename = dirname(__DIR__) . "/views/" . $path . ".view.php";

        if (file_exists($filename)) {
            // Extract data so variables can be used inside the view
            extract($data);

            //Load the view file
            require_once $filename;
        } else {
            // Load the 404 error page if the view does not exist
            require_once dirname(__DIR__) . "/views/errors/404.view.php";
        }
    }
}
