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

    public function search()
    {
        if (isset($_GET['query'])) {
            $query = trim($_GET['query']);

            $bookModel = new Book();
            $books = $bookModel->searchBooks($query); // Search function in the model

            $data = [
                "books" => $books,
                "search_query" => $query
            ];

            $this->view("books/search_results", $data);
        } else {
            redirect(ROOT . "/home");
        }

    }
}
?>