<?php

require_once dirname(__DIR__) . "/models/Category.php";
require_once dirname(__DIR__) . "/models/Book.php";
require_once dirname(__DIR__) . "/models/Borrow.php";
require_once dirname(__DIR__) . "/models/User.php";


class Books
{
    use Controller;

    public function index()
    {
        $bookModel = new Book();
        $books = $bookModel->getAllBooks();
        $data = ["books" => $books];
        $this->view("home", $data);
    }

    public function borrowBook()
    {

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_message'] = "You must be logged in to borrow a book.";
            header("Location: " . ROOT . "/login");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['book_id'])) {
            $book_id = $_POST['book_id'];
            $user_id = $_SESSION['user_id']; // Assuming user session contains 'id'

            $borrowModel = new Borrow();

                // Debugging
            if (empty($user_id) || empty($book_id)) {
                $_SESSION['flash_message'] = ["type" => "info", "message" => "Invalid user or book ID."];
                header("Location: " . ROOT . "/home");
                exit();
            }

            //Check if the book is already borrowed
            if ($borrowModel->isBookBorrowed($user_id, $book_id)) {
                $_SESSION['flash_message'] = ["type" => "warning", "message" => "You have already borrowed this book."];
                header("Location: " . ROOT . "/auth/profile");
                exit();
            }
            // Attempt to borrow the book
            if ($borrowModel->borrowBook($user_id, $book_id)) {
                $_SESSION['flash_message'] = "Book borrowed successfully!";
                header("Location: " . ROOT . "/auth/profile"); // Redirect to profile or books page
                exit();
            } else {
                $_SESSION['flash_message'] = ["type" => "error", "message" => "Failed to borrow book."];
                header("Location: " . ROOT . "/auth/profile");
                exit();
            }
        } else {
            $_SESSION['flash_message'] = ["type" => "info", "message" => "Invalid request."];
            header("Location: " . ROOT . "home");
            exit();
        }

    }
    
    public function category($categoryId)
    {
        $bookModel = new Book();
        $categoryModel = new Category();

        $books = $bookModel->getBooksByCategory($categoryId);
        $category = $categoryModel->getCategoryByID($categoryId);

        if (!$category) {
            die("Category not found.");
        }

        $data = [
            "books" => $books,
            "category" => $category
        ];

        $this->view("books/category", $data);
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

    public function detail($id)
    {
        $bookModel = new Book();
        $book = $bookModel->getBookById($id);
        if (!$book) {
            $_SESSION["flash_message"] = ["type" => "error", "message" => "Book not found!."];
        }
        $this->view("books/details", ["book" => $book]);
    }
}
