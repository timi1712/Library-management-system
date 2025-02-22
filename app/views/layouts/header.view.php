<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/style.css">
</head>
<body>
<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm navbar-dark custom-bg border-bottom box-shadow mb-3">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="<?= ROOT ?>">
                <img src="<?= ROOT ?>/assets/images/mybooky.png" style="width:30px;" />
            </a>

            <!-- Toggler for small screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse d-sm-inline-flex justify-content-between" id="navbarNav">
                <!-- Left-aligned Links -->
                <ul class="navbar-nav flex-grow-1">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT ?>/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT ?>/books">Books</a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Dropdown for Admin Content Management -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Content Management
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= ROOT ?>/categories">Category</a></li>
                                <li><a class="dropdown-item" href="<?= ROOT ?>/books/manage">Manage Books</a></li>
                                <li><a class="dropdown-item" href="<?= ROOT ?>/company">Company</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= ROOT ?>/auth/register">Create User</a></li>
                                <li><a class="dropdown-item" href="<?= ROOT ?>/users/manage">Manage Users</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Right-aligned Login/Register Links -->
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= ROOT ?>/auth/logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= ROOT ?>/auth/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= ROOT ?>/auth/register">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
