<?php
require_once dirname(__DIR__) . "/models/User.php"; 

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
        session_destroy();
        redirect("auth/login");
    }

    public function authenticate()
    {
        $errors = [];
        $userModel = new UserModel();

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

                // Redirect based on role
                if ($user["role"] === "admin") {
                    redirect("admin/dashboard");
                } else {
                    redirect("home");
                }
            }
        }

        // Reload login view with errors
        $this->view("auth/login", ["errors" => $errors]);
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

            // Validate full name
            if (empty($full_name)) {
                $errors[] = "Full name is required.";
            }

        
            // Validation
            if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
                $errors[] = "All fields are required.";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }

            if ($userModel->emailExists($email)) {
                $errors[] = "Email is already registered.";
            }

            if ($password !== $confirm_password) {
                $errors[] = "Passwords do not match.";
            }

            if (!in_array($role, ["admin", "user"])) {
                $errors[] = "Invalid user role.";
            }
            // Debugging: Print errors if they exist
            // if (!empty($errors)) {
            //     echo "<pre>";
            //     print_r($errors);
            //     echo "</pre>";
            //     die(); // Stop execution for debugging
            // }
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            //  // Debugging: Print data before inserting
            // echo "<pre>";
            // print_r([
            //     "name" => $full_name,
            //     "email" => $email,
            //     "password" => $hashed_password,
            //     "role" => $role
            // ]);
            // echo "</pre>";
            // die(); // Stop execution for debugging

             // Save user
             $userModel->create([
                "name" => $full_name,
                "email" => $email,
                "password" => $hashed_password,
                "role" => $role
            ]);

            if (empty($errors)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Save user
                $userModel->create([
                    "name" => $full_name,
                    "email" => $email,
                    "password" => $hashed_password,
                    "role" => $role
                ]);

            //     // Redirect to login
                redirect("auth/login");
             }
                // Redirect to login
            //header("Location: " . BASE_URL . "/auth/login");
            //exit;
        }

        // Reload view with errors
        $this->view("auth/register", ["errors" => $errors]);
    }
}
