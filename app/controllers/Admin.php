<?php
require_once dirname(__DIR__) . "/models/User.php";
require_once dirname(__DIR__) . "/models/Category.php";
require_once dirname(__DIR__) . "/models/Book.php";
require_once dirname(__DIR__) . "/models/Borrow.php";


class Admin
{
    use Controller;

    public function __construct()
    {
        Middleware::isAdmin(); // Enforce admin-only access on all methods
    }

    public function index()
    {
        $userModel = new User();
        $bookModel = new Book();
        $borrowModel = new Borrow();

        $userCount = $userModel->getUserCount();
        $bookCount = $bookModel->getBookCount();
        $issuedBooks = $borrowModel->getIssuedBooksCount(); 
        $borrowedBooksCount = $borrowModel->getBorrowedBooksCount();
        // Calculate Available Books (Total Books - Borrowed Books)
        $availableBooks = max(0, $bookCount - $borrowedBooksCount);
        $this->view("admin/dashboard",
        ["userCount" => $userCount,
        "bookCount" => $bookCount,
        "availableBooks" => $availableBooks,
        "borrowedBooksCount" => $borrowedBooksCount]);
    }

    public function users()
    {
        $userModel = new User();
        $itemsPerPage = 3;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        $users = $userModel->getPaginatedUsers($itemsPerPage, $offset);
        $totalUsers = $userModel->getTotalUsers();
        $totalPages = ceil($totalUsers / $itemsPerPage);

        $this->view("admin/users", [
            "users" => $users,
            "totalPages" => $totalPages,
            "currentPage" => $currentPage
        ]);
       
    }
    // Store User (Registration)
    public function storeUser()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["full_name"];
            $email = $_POST["email"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $role = $_POST["role"];

            $userModel = new User();
            $userModel->createUser($name, $email, $password, $role);

            redirect("admin/users");
        }
    }
    public function edit($id)
    {
        $userModel = new User();
        $user = $userModel->getUserById($id);

        if (!$user) {
            die("User not found.");
        }

        $this->view("admin/edit", ["user" => $user]);
    }
    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $data = [
                "name" => $_POST["name"],
                "email" => $_POST["email"],
                "role" => $_POST["role"]
            ];

            $userModel = new User();
            if ($userModel->updateUser($id, $data)) {
                header("Location: " . ROOT . "/admin/users");
                exit;
            } else {
                die("Update failed.");
            }
        }
    }

    // Delete User
    public function deleteUser($id)
    {
        $userModel = new User();

        if ($userModel->delete($id)) {
            $_SESSION['flash_message'] = "User deleted successfully!";
        } else {
            $_SESSION['flash_message'] = "Error deleting user!";
        }

        redirect("admin/users");
    }
    //books
    public function books()
    {
        $bookModel = new Book();
        $categoryModel = new Category();
        $itemsPerPage = 3;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        $books = $bookModel->getPaginatedBooks($itemsPerPage, $offset);
        $totalBooks = $bookModel->getTotalBooks();
        $totalPages = ceil($totalBooks / $itemsPerPage);
        
        $itemsPerCatPage = 5;
        $currentCatPage = isset($_GET['page'])?(int)$_GET['page'] : 1;
        $offsetCat = ($currentCatPage - 1) * $itemsPerCatPage;
        $categories = $categoryModel->getPaginatedCategories($itemsPerCatPage, $offsetCat);
        $totalCategories = $categoryModel->getTotalCategories();
        $totalCatPages = ceil($totalCategories/$itemsPerCatPage);

        $this->view("admin/books", [
            "books" => $books,
            "totalPages" => $totalPages,
            "currentPage" => $currentPage,
            "categories" => $categories,
            "totalCatPages" => $totalCatPages,
            "currentCatPage" => $currentCatPage,
        ]);
    }
     // Show the book creation form
     public function createBook()
     {
        if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
            $_SESSION["errors"][] = "Unauthorized access!";
            header("Location: " . ROOT . "/home");
            exit;
        }
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories();
        if (!$categories) {
            die("No categories found! Please add categories to the database.");
        }

         $this->view("admin/books", ["categories" => $categories]);
     }
     // Store a new book in the database
    public function store_book()
    {
        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $bookModel = new Book();
            $categoryModel = new Category();
            $categories = $categoryModel->getAllCategories();
            $data = [
                "title" => trim($_POST["title"]),
                "author" => trim($_POST["author"]),
                "isbn" => trim($_POST["isbn"]),
                "category_id" => trim($_POST["category_id"]),
                "published_year" => trim($_POST["published_year"]),
                "quantity" => trim($_POST["quantity"]),
                "image" => trim($_POST["image"] ?? ""),
                "description" => trim($_POST["description"])
            ];

            // Validate required fields
            if (empty($data["title"]) || empty($data["author"]) || empty($data["isbn"]) || empty($data["category_id"]) || empty($data["published_year"]) || empty($data["quantity"])) {
                $errors[] = "All fields except image are required.";
            }

            // Validate ISBN
            if (!$bookModel->isValidISBN($data["isbn"])) {
                $errors[] = "Invalid ISBN format.";
            }

            // Handle image upload if provided
        if (!empty($_FILES["image"]["name"])) {
            $targetDir = "uploads/books/"; // Directory to store images
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true); // Create directory if not exists
            }

            $fileName = time() . "_" . basename($_FILES["image"]["name"]); // Unique filename
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allow only specific file types
            $allowedTypes = ["jpg", "jpeg", "png", "gif"];
            if (!in_array(strtolower($fileType), $allowedTypes)) {
                $errors[] = "Invalid file format. Only JPG, JPEG, PNG & GIF are allowed.";
            }
            // Move uploaded file to the target directory
            if (empty($errors) && move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                $data["image"] = $targetFilePath; // Save the image path in database
            } else {
                $errors[] = "Failed to upload the book cover image.";
            }
            } else {
                $data["image"] = null; // No image uploaded
            }
            // If errors exist, reload form with errors
            if (!empty($errors)) {
                $_SESSION["errors"] = $errors;
                $_SESSION["book_data"] = $data; // Store entered data for user convenience
                header("Location: " . ROOT . "/admin/books");
                exit;
            }
            // Save book to database
            if ($bookModel->create($data)) {
                $_SESSION["flash_message"] = ["type" => "success", "message" => "Book added successfully!"];
                header("Location: " . ROOT . "/admin/books");
                exit;
            } else {
                $_SESSION["errors"][] = "Failed to add book.";
                header("Location: " . ROOT . "/admin/books");
                exit;
            }
        }

        $this->view("admin/books", ["errors" => $errors]);
    }
    // remove book
    public function deleteBook($id)
    {
        $bookModel = new Book();
        if ($bookModel->delete($id)) {
            $_SESSION['flash_message'] = "Book deleted successfully!";
        } else {
            $_SESSION['flash_message'] = "Error deleting book!";
        }
        //header("Location: " . ROOT . "/admin/books");
        redirect("admin/books");
    }
    // edit a book
    public function edit_book($id)
    {
        $bookModel = new Book();
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories();
        $book = $bookModel->getBookById($id);
        //get category name from book category id
        $cat_id = $book['category_id'];
        $cat = $categoryModel->getCategoryByID($cat_id);
        if (!$book) {
            $_SESSION["errors"][] = "Book not found!";
            header("Location: ". ROOT . "/admin/books");
            exit;
        }
        $this->view("admin/edit_book",["book" => $book, "categories" => $categories, "cat" => $cat]);
    }
    // update book
    public function update_book()
    {
       
        $bookModel = new Book();

        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $id = $_POST["id"];
            $book = $bookModel->getBookById($id);

            if (!$book) {
                $_SESSION["errors"][] = "Book not found!!";
                header("Location: " . ROOT . "/admin/books");
                exit;
            }

            $title = trim($_POST["title"]);
            $author = trim($_POST["author"]);
            $isbn = trim($_POST["isbn"]);
            $category_id = trim($_POST["category_id"]);
            $published_year = trim($_POST["published_year"]);
            $quantity = trim($_POST["quantity"]);
            $current_image = $_POST["current_image"] ?? "";
            $description = $_POST["description"];

              // Image Upload Handling
            //   if (!empty($_FILES["image"]["name"])) {
            //     $image = $_FILES["image"];
            //     $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
            //     $maxFileSize = 2 * 1024 * 1024; // 2MB limit
    
            //     // Validate image type
            //     if (!in_array($image["type"], $allowedTypes)) {
            //         $_SESSION["errors"][] = "Invalid image type. Only JPG, PNG, and GIF are allowed.";
            //         header("Location: " . ROOT . "/admin/edit_book/" . $id);
            //         exit;
            //     }
    
            //     // Validate image size
            //     if ($image["size"] > $maxFileSize) {
            //         $_SESSION["errors"][] = "Image is too large. Max size is 2MB.";
            //         header("Location: " . ROOT . "/admin/edit_book/" . $id);
            //         exit;
            //     }
                
            //     //$upload_dir = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "books";
            //     $upload_dir = "uploads/books/";

            //     // Ensure the uploads directory exists
            //     // if (!is_dir($upload_dir)) {
            //     //     mkdir($upload_dir, 0777, true);
            //     // }
            //     if (!is_dir($upload_dir)) {
            //         mkdir($upload_dir, 0777, true);
            //         echo "Upload directory created: " . $upload_dir . "<br>";
            //     } else {
            //         echo "Upload directory exists: " . $upload_dir . "<br>";
            //     }
            
            //     // Verify folder permissions
            //     if (!is_writable($upload_dir)) {
            //         die("Upload directory is not writable: " . $upload_dir);
            //     }
            
            //     // Move uploaded image
            //     $image_name = time() . "_" . basename($image["name"]);
                
            //     $target_path = $upload_dir . DIRECTORY_SEPARATOR . $image_name;

            //     echo "Target Path: " . $target_path . "<br>";
            //     if (move_uploaded_file($image["tmp_name"], $target_path)) {
            //         // Delete old image if it exists
            //         $old_image_path = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . $current_image;
            //         if (!empty($current_image) && file_exists($old_image_path)) {
            //             unlink($old_image_path);
            //         }
            //     } else {
            //         $_SESSION["errors"][] = "Failed to upload new image." . print_r(error_get_last(), true);
            //         header("Location: " . ROOT . "/admin/edit_book/" . $id);
            //         exit;
            //     }
            // } else {
            //     // Keep the current image if no new image is uploaded
            //     $image_name = $current_image;
            // }
            if (!empty($_FILES["image"]["name"])) {
                $targetDir = "uploads/books/"; // Ensure consistency with store_book()
                
                // Ensure directory exists
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
            
                $fileName = time() . "_" . basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            
                // Validate image type
                $allowedTypes = ["jpg", "jpeg", "png", "gif"];
                if (!in_array(strtolower($fileType), $allowedTypes)) {
                    $_SESSION["errors"][] = "Invalid file format. Only JPG, JPEG, PNG & GIF are allowed.";
                    header("Location: " . ROOT . "/admin/edit_book/" . $id);
                    exit;
                }
            
                // Move uploaded image
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    // Delete old image if it exists
                    if (!empty($current_image) && file_exists($current_image)) {
                        unlink($current_image);
                    }
                    $image_name = $targetFilePath; // Store the new image path
                } else {
                    $_SESSION["errors"][] = "Failed to upload new image.";
                    header("Location: " . ROOT . "/admin/edit_book/" . $id);
                    exit;
                }
            } else {
                // Keep existing image
                $image_name = $current_image;
            }
            

            // Update category in the database
            // $updateData = [
            //     "title" => $title,
            //     "author" => $author,
            //     "isbn" => $isbn,
            //     "category_id" => $category_id,
            //     "published_year" => $published_year,
            //     "quantity" => $quantity,
            //     "image" => "uploads/books/" . $image_name 
            // ];
            $updateData = [
                "title" => $title,
                "author" => $author,
                "isbn" => $isbn,
                "category_id" => $category_id,
                "published_year" => $published_year,
                "quantity" => $quantity,
                "image" => $image_name, // Now stores "uploads/books/imagename.jpg"
                "description" => $description
            ];
            
    
            if ($bookModel->update($id, $updateData)) {
                $_SESSION["success"] = "Book updated successfully!";
                header("Location: " . ROOT . "/admin/books");
                exit;
            } else {
                $_SESSION["errors"][] = "Failed to update book.";
                header("Location: " . ROOT . "/admin/edit_book/" . $id);
                exit;
            }

        }
    }
    // create a category
    public function store_category()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST["name"]);
            $image = $_FILES["image"] ?? null;

            // Validate
            if (empty($name)) {
                $_SESSION["errors"][] = "Category name is required.";
                header("Location: " . ROOT . "/admin/books");
                return;
            }

            $imagePath = "uploads/default.jpg"; // Default image
            if ($image && $image["size"] > 0) {
                $ext = pathinfo($image["name"], PATHINFO_EXTENSION);
                $imagePath = "uploads/" . uniqid() . "." . $ext;
                move_uploaded_file($image["tmp_name"], $imagePath);
            }

            $categoryModel = new Category();
            $categoryModel->addCategory($name, $imagePath);

            $_SESSION["flash_message"] = "Category added successfully!";
            header("Location: " . ROOT . "/admin/books");
        }
    }

    // Edit category
    public function edit_Category($id)
    {
        $categoryModel = new Category();
        $category = $categoryModel->getCategoryById($id);

        if (!$category) {
            $_SESSION["errors"][] = "Category not found!";
            header("Location: ". ROOT . "/admin/books");
            exit;
        }

        $this->view("admin/edit_category", ["category" => $category]); 
    }
    // remove category
    public function deleteCategory($id)
    {
        $categoryModel = new Category();

        if ($categoryModel->delete($id)) {
            $_SESSION['flash_message'] = "Category deleted successfully!";
        } else {
            $_SESSION['flash_message'] = "Error deleting category!";
        }
        
        redirect("admin/books");
    }
    //update category
    public function update_category()
    {
        $categoryModel = new Category();
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST["id"]; // Get category ID
            $category = $categoryModel->getCategoryById($id);
    
            if (!$category) {
                $_SESSION["errors"][] = "Category not found!";
                header("Location: " . ROOT . "/admin/books");
                exit;
            }
    
            $name = trim($_POST["name"]);
            $current_image = $_POST["current_image"] ?? "";
    
            // Image Upload Handling
            if (!empty($_FILES["image"]["name"])) {
                $image = $_FILES["image"];
                $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
                $maxFileSize = 2 * 1024 * 1024; // 2MB limit
    
                // Validate image type
                if (!in_array($image["type"], $allowedTypes)) {
                    $_SESSION["errors"][] = "Invalid image type. Only JPG, PNG, and GIF are allowed.";
                    header("Location: " . ROOT . "/admin/edit_category/" . $id);
                    exit;
                }
    
                // Validate image size
                if ($image["size"] > $maxFileSize) {
                    $_SESSION["errors"][] = "Image is too large. Max size is 2MB.";
                    header("Location: " . ROOT . "/admin/edit_category/" . $id);
                    exit;
                }
                
                $upload_dir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;

                // Ensure the uploads directory exists
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                // Move uploaded image
                $image_name = time() . "_" . basename($image["name"]);
                
                $target_path = $upload_dir . $image_name;

    
                if (move_uploaded_file($image["tmp_name"], $target_path)) {
                    // Delete old image if it exists
                    if (!empty($current_image) && file_exists($upload_dir. $current_image)) {
                        unlink($upload_dir. $current_image);
                    }
                } else {
                    $_SESSION["errors"][] = "Failed to upload new image.";
                    header("Location: " . ROOT . "/admin/edit_category/" . $id);
                    exit;
                }
            } else {
                // Keep the current image if no new image is uploaded
                $image_name = $current_image;
            }
    
            // Update category in the database
            $updateData = [
                "name" => $name,
                "image" => "uploads/" . $image_name 
            ];
            $new_category = $categoryModel->updateCategory($id, $updateData);
            if ($new_category) {
                $_SESSION["success"] = "Category updated successfully!";
                header("Location: " . ROOT . "/admin/books");
                exit;
            } else {
                $_SESSION["errors"][] = "Failed to update category.";
                header("Location: " . ROOT . "/admin/edit_category/" . $id);
                exit;
            }
        }
    }

    public function borrowedBooks()
    {
        $borrowModel = new Borrow();
        $limit = 3; // Books per page
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        $borrowedBooks = $borrowModel->getBorrowedBooks($limit, $offset);

        $totalBooks = $borrowModel->countBorrowedBooks(); // Function to get total borrowed books count
        //$totalPages = ceil($totalBooks / $limit);
        $totalPages = ($totalBooks > 0) ? ceil($totalBooks / $limit) : 1;



        $this->view('admin/borrowed_books', [
            'borrowedBooks' => $borrowedBooks,
            'totalPages' => $totalPages,
            'currentPage' => $page]);
    }

    

}
?>


