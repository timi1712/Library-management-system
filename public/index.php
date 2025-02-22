<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();

// Load core init file dynamically
require_once dirname(__DIR__) . "/app/core/init.php";
// echo "DEBUG: URL = " . ($_GET['url'] ?? 'NOT SET');
// exit;

// Set error reporting based on DEBUG mode
if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Ensure App class is loaded before using it
if (!class_exists('App')) {
    die("Critical Error: Application core missing.");
}

// Initialize the application and load the appropriate controller
$app = new App();
$app->loadController();
