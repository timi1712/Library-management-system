<?php
require_once dirname(__DIR__) . "/models/User.php"; 

class Admin
{
    use Controller;

    public function __construct()
    {
        Middleware::isAdmin(); // Enforce admin-only access on all methods
    }

    public function dashboard()
    {
        $userModel = new User();
        $userCount = $userModel->getUserCount();
        $this->view("admin/dashboard",["userCount" => $userCount]);
    }

    public function users()
    {
        $userModel = new User();
        $users = $userModel->getAllUsers();

        $this->view("admin/users", ["users" => $users]);
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

}
?>
