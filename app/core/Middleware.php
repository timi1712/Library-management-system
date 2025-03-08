<?php

class Middleware
{
    public static function isAdmin()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            // Redirect unauthorized users to the home page
            $_SESSION["flash_message"] = "Access Denied!!!";
            header("Location: " . ROOT . "/home");
            exit;
        }
    }
}
?>
