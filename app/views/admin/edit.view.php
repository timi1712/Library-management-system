<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>

<div class="container mt-4">
    <h2>Edit User</h2>
    <form action="<?= ROOT ?>/admin/update" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control">
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="<?= ROOT ?>/admin/users" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>
