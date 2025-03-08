<?php

require_once dirname(__DIR__) . "/models/Category.php";
require_once dirname(__DIR__) . "/models/Book.php";
class Home
{
    use Controller;
    public function index() {
        $categoryModel = new Category();
        $bookModel = new Book();
        $categories = $categoryModel->getAllCategories();
        $books = $bookModel->getAllBooks();

        $data = [
            "categories" => $categories,
            "books" => $books
        ];
        // Load the home content and store it in $content
        $data["content"] = $this->view("home", $data, true); // Render as string

        $this->view("layouts/main", $data);
    }
}
?>