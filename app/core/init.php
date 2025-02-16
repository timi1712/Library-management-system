<?php

spl_autoload_register(function($classname){

    $directories = [
        dirname(__DIR__)."/app/models/",
        dirname(__DIR__). "/app/controllers/",
        dirname(__DIR__). "/app/core/"
    ];

    foreach ($directories as $directory) {
        # get the file
        $filename = $directory.ucfirst($classname).".php";
        if (file_exists($filename)) {
            require_once $filename;
            return;
        }
    }
});

require_once __DIR__.'/functions.php';
require_once __DIR__.'/controller.php';
require_once __DIR__.'/App.php';
require_once __DIR__.'/config.php';