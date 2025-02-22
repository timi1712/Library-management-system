<?php require_once dirname(__DIR__, 2) . "/views/layouts/header.view.php"; ?>

<div class="card shadow border-0 mt-4 mb-5">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
        <div class="card-header custom-bg bg-gradient ml-0 py-4">
        <h2 class="text-center text-white">Register</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        </div>
        <div class="card-body p-4 custom-bg mb-5">
        <form action="<?= ROOT ?>/auth/store" method="POST">
            <div class="form-floating mb-3 col-md-12">
                <label class="form-label ms-2 text-muted">Full Name</label>
                <input type="text" name="full_name" class="form-control" required>
            </div>
            <div class="form-floating mb-3 col-md-12">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-floating mb-3 col-md-12">
                <select name="role" class="form-control form-select form-select-lg mb-3" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-floating mb-3 col-md-12">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-floating mb-3 col-md-12">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <div class="col-12">
                <button id="registerSubmit" type="submit" class="w-100 btn btn-lg btn-outline-success">Register</button>
            </div>
        </form>
        </div>
        <div class="col-md-3"></div>
    </div>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . "/views/layouts/footer.view.php"; ?>
