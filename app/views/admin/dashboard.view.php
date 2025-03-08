<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>

<div class="container mt-4">
    <h2 class="text-center my-4 my-color">Admin Dashboard</h2>
    <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
    <!-- Stats Section -->
    <div class="row text-center">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <i class="bi bi-book display-4 text-primary"></i>
                    <h5 class="mt-3">Total Books</h5>
                    <h3><?= $bookCount ?? 0; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <i class="bi bi-people-fill display-4 text-success"></i>
                    <h5 class="mt-3">Total Users</h5>
                    <h3><?= $userCount ?? 0; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <i class="bi bi-journal-check display-4 text-warning"></i>
                    <h5 class="mt-3">Books Issued</h5>
                    <h3><?= $issuedBooks ?? 0; ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Panels -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body text-center">
                    <i class="bi bi-book-half display-4 text-primary"></i>
                    <h4 class="mt-3">Book Management</h4>
                    <p>Manage library books, add, edit, and delete book records.</p>
                    <a href="<?= ROOT ?>/admin/books" class="btn btn-primary">Manage Books</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body text-center">
                    <i class="bi bi-people display-4 text-success"></i>
                    <h4 class="mt-3">User Management</h4>
                    <p>Manage user accounts, assign roles, and monitor activity.</p>
                    <a href="<?= ROOT ?>/admin/users" class="btn btn-success">Manage Users</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="col-md-1"></div>
    </div>
</div>

<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>
