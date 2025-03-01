<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>
<?php if (isset($_SESSION['flash_message'])): ?>
    <script>
        Swal.fire({
            title: "Success",
            text: "<?= $_SESSION['flash_message']; ?>",
            icon: "success",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    <?php unset($_SESSION['flash_message']); ?>
<?php endif; ?>


<div class="container mt-4">
    <h2 class="text-center my-4 my-color">User Management</h2>
    <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
    <!-- User Registration Form -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h4 class="card-title">Add New User</h4>
            <form action="<?= ROOT ?>/admin/users/store" method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-3">Add User</button>
            </form>
        </div>
    </div>

    <!-- User List Table -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-body">
            <h4 class="card-title">User List</h4>
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id']; ?></td>
                            <td><?= htmlspecialchars($user['name']); ?></td>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'primary'; ?>">
                                    <?= ucfirst($user['role']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= ROOT ?>/admin/edit/<?= $user['id']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                <!-- <a href="<?= ROOT ?>/admin/delete/<?= $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a> -->
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $user['id']; ?>)">
                                    <i class="bi bi-trash"></i> Delete
                                </button>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <div class="col-md-1"></div>
    </div>
</div>

<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>
