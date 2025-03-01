<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/bootstrap.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/style.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm navbar-dark custom-bg border-bottom box-shadow mb-3">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="<?= ROOT ?>">
                <img src="<?= ROOT ?>/assets/images/mybooky.png" style="width:30px;" />
                <span class="logo-text">Lms</span>
            </a>

            <!-- Toggler for small screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse d-sm-inline-flex justify-content-between" id="navbarNav">
                <!-- Left-aligned Links -->
                <!-- <ul class="navbar-nav flex-grow-1">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT ?>/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT ?>/books">Books</a>
                    </li>

                   
                </ul> -->

                <!-- Right-aligned Login/Register Links -->
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                        <a class="nav-link text-white">Hello, <?= htmlspecialchars($_SESSION['user_name']) ?></a>
                        </li>
                         <!-- Check if the user is an admin -->
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= ROOT ?>/admin/dashboard">Admin Dashboard</a>
                        </li>
                    <?php endif; ?>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= ROOT ?>/auth/logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <!-- <a class="nav-link" href="<?= ROOT ?>/auth/login">Login</a> -->
                            
                            <button type="button" class="btn custom-btn" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="bi bi-person text-white"></i> Login
                            </button> 
                            <button type="button" class="btn custom-btn mx-2" data-bs-toggle="modal" data-bs-target="#registerModal">
                             Register
                            </button>
                        </li>
                        
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-3">
    <form action="<?= ROOT ?>/books/search" method="GET" class="d-flex">
        <input class="form-control me-2" type="text" name="query" placeholder="Search for books..." required>
        <button class="btn custom-bg text-white" type="submit">
        <span class="bi-search"></span>
        </button>
    </form>
</div>

</header>
<div class="my-10"></div>


<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel">
    <div class="modal-dialog">
        <div class="modal-content custom-shadow p-3 mb-5 bg-body rounded custom-modal">
            <div class="modal-header d-flex justify-content-center w-100">
                <h5 class="modal-title text-center my-color" id="loginModalLabel">Signin</h5>
                <button type="button" class="btn-close position-absolute end-0 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['login_error']; ?>
                    </div>
                    <?php unset($_SESSION['login_error']); // Clear error after displaying ?>
                <?php endif; ?>
                <form action="<?= ROOT ?>/auth/authenticate" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn custom-bg text-white w-100">Login</button>
    
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade <?php echo isset($_SESSION['register_errors']) ? 'show d-block' : ''; ?>" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content custom-shadow custom-modal p-3 mb-5 bg-body rounded">
            <div class="modal-header d-flex justify-content-center w-100">
                <h5 class="modal-title my-color text-center" id="registerModalLabel">Signup</h5>
                <button type="button" class="btn-close position-absolute end-0 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php if (isset($_SESSION["register_errors"])): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($_SESSION["register_errors"] as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php unset($_SESSION["register_errors"]); // Clear errors after displaying ?>
                <?php endif; ?>
                <form action="<?= ROOT ?>/auth/store" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="<?php echo $_SESSION['register_data']['full_name'] ?? ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $_SESSION['register_data']['email'] ?? ''; ?>" required>
                    </div>
                    <div class="form-floating mb-3 col-md-12">
                        <select name="role" class="form-control form-select form-select-lg mb-3" required>
                        <option value="user" <?php echo (isset($_SESSION['register_data']['role']) && $_SESSION['register_data']['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo (isset($_SESSION['register_data']['role']) && $_SESSION['register_data']['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn custom-bg text-white w-100">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php unset($_SESSION['register_data']); ?> <!-- Clear old input data -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        <?php if (!empty($_SESSION['show_login_modal'])): ?>
            setTimeout(() => {
                let loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
            }, 200);

            <?php unset($_SESSION['show_login_modal']); ?> // Clear after displaying once
        <?php endif; ?>
    });

</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Open register modal if validation fails
    if (document.querySelector(".modal.show")) {
        let registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
        registerModal.show();
    }
});
</script>

