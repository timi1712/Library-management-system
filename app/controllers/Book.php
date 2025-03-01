<?php

require_once dirname(__DIR__) . "/models/Category.php";
class BookController
{
    use Controller;
    public function category($categoryId)
    {
        $bookModel = new Book();
        $categoryModel = new Category();

        $books = $bookModel->getBooksByCategory($categoryId);
        $category = $categoryModel->findById($categoryId);

        if (!$category) {
            die("Category not found.");
        }

        $data = [
            "books" => $books,
            "category" => $category
        ];

        view("books/category", $data);
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
