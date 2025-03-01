<?php require_once dirname(__DIR__, 2) . "/views/layouts/header.view.php"; ?>

<div class="card shadow border-0 mt-4 mb-5"> <!-- Added mb-5 to create space from footer -->
    <div class="row justify-content-center"> <!-- Centers the form -->
        <div class="col-md-6">
            <div class="card-header custom-bg bg-gradient text-center py-4">
                <h2 class="text-white">Login</h2>

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
            <div class="card-body p-4 custom-bg pb-5"> <!-- Added pb-5 for spacing -->
                <form action="<?= ROOT ?>/auth/authenticate" method="POST">
                    <div class="form-floating mb-3 col-md-12">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-floating mb-3 col-md-12">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="w-100 btn btn-lg btn-outline-success">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . "/views/layouts/footer.view.php"; ?>
