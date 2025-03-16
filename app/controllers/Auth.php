<?php
require_once dirname(__DIR__) . "/models/User.php"; 
require_once dirname(__DIR__) . "/models/Borrow.php";

class Auth
{
    use Controller;

    private function validateUsername($username)
    {
        // Trim white spaces
        $username = trim($username);

        // Check if empty
        if (empty($username)) {
            return "Username is required.";
        }

        // Length validation (between 3 and 20 characters)
        if (strlen($username) < 3 || strlen($username) > 20) {
            return "Username must be between 3 and 20 characters long.";
        }

        // Allowed characters: letters, numbers, underscores
        if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
            return "Username can only contain letters, numbers, and underscores.";
        }

        // Username is valid
        return true;
    }

    public function register()
    {
        //echo "Register Controller: Index method called!<br>"; // Debugging
        $data = [];
        $this->view("auth/register");
    }

    public function login()
    {
        $this->view("auth/login");
    }
    public function logout()
    {
        session_start();  // Ensure session is active
        session_unset();  // Remove all session variables
        session_destroy(); // Destroy the session
        // Redirect to home page
        redirect("home"); 
    }

    public function authenticate()
    {
        $errors = [];
        $userModel = new User();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST["email"]);
            $password = $_POST["password"];

            if (empty($email) || empty($password)) {
                $errors[] = "Email and password are required.";
            }

            $user = $userModel->getByEmail($email);
            if (!$user || !password_verify($password, $user["password"])) {
                $errors[] = "Invalid credentials.";
            }

            if (empty($errors)) {
                // Store user session
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_role"] = $user["role"];
                $_SESSION["user_name"] = $user["name"]; // Store name for navbar display

            if ($user['role'] === 'admin') {
                header("Location: " . ROOT . "/admin/index");
            } else {
                header("Location: " . ROOT . "/auth/profile");
            }
            exit;
            
        } else {
            # code...
            //$_SESSION["login_error"] = "Invalid email or password.";
            $_SESSION["login_error"] = implode("<br>", $errors);
            $_SESSION["show_login_modal"] = true; // Set modal to open on reload
            header("Location: " . ROOT . "/home"); // Redirect to reload page
            //header("Location: " . $_SERVER["HTTP_REFERER"]); // Redirect back to login page
            exit;
        }
        
    }
    }

    public function store()
    {
        $errors = [];
        $userModel = new User();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $full_name = trim($_POST["full_name"]);
            $email = trim($_POST["email"]);
            $role = $_POST["role"] ?? "user"; // Default role is "user"
            $password = $_POST["password"];
            $confirm_password = $_POST["confirm_password"];

            // Validate username
            $usernameValidation = $this->validateUsername($full_name);
            if ($usernameValidation !== true) {
                $errors[] = $usernameValidation;
            }

            // Check required fields
            if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
                $errors[] = "All fields are required.";
            }

            // Validate email
            if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                $errors[] = "Invalid email format.";
            } elseif ($userModel->emailExists($email)) {
                $errors[] = "Email is already registered.";
            }

            // Validate password
            if ($password !== $confirm_password) {
                $errors[] = "Passwords do not match.";
            }

            // Validate role
            if (!in_array($role, ["admin", "user"])) {
                $errors[] = "Invalid user role.";
            }

            // If errors exist, reload form with errors
            if (!empty($errors)) {
                $_SESSION["register_errors"] = $errors;
                $_SESSION["register_data"] = [
                    "full_name" => $full_name,
                    "email" => $email,
                    "role" => $role
                ];
                header("Location: " . ROOT . "/home"); // Redirect to home page
                exit;
            
            }

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Save user
            $userModel->create([
                "name" => $full_name, // Ensure this matches your DB column
                "email" => $email,
                "password" => $hashed_password,
                "role" => $role
            ]);

            // Redirect to login
            //redirect("auth/login");
            $_SESSION["show_login_modal"] = true;
            redirect("home");

        }

        // Reload view with errors (if any)
        $this->view("auth/register", ["errors" => $errors]);
    }

    public function profile()
    {
        if (!isset($_SESSION["user_id"])) {
            $_SESSION['flash_message'] = "Log in to access that page.!";
            header("Location: " . ROOT . "/home");
            exit;
        }
        $borrowModel = new Borrow();
        $user_id = $_SESSION["user_id"];
        $borrowed_books = $borrowModel->getUserBorrowedBooks($user_id);
        $this->view("auth/profile",['borrowed_books' => $borrowed_books]);
    }

    public function borrow_book()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
            $book_id = $_POST["book_id"];

            $borrowModel = new BorrowedBook();
            $due_date = date("Y-m-d", strtotime("+14 days"));

            $borrowModel->create([
                "user_id" => $user_id,
                "book_id" => $book_id,
                "borrowed_at" => date("Y-m-d"),
                "due_date" => $due_date,
                "status" => "borrowed"
            ]);

            header("Location: " . ROOT . "/auth/profile");
            exit;
        }
    }

    public function return_book()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
            $borrow_id = $_POST["borrow_id"];
            $borrowModel = new BorrowedBook();
            
            $borrowModel->update($borrow_id, ["status" => "returned"]);

            header("Location: " . ROOT . "/auth/profile");
            exit;
        }
    }

}
