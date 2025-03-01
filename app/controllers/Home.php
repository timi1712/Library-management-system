<?php

require_once dirname(__DIR__) . "/models/Category.php";
class Home
{
    use Controller;
    public function index() {
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories(); // Fetch categories from DB

        $data = [
            "categories" => $categories
        ];
        // Load the home content and store it in $content
        $data["content"] = $this->view("home", $data, true); // Render as string

        $this->view("layouts/main", $data);
    }
}
?>