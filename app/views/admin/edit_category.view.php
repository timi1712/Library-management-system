<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>

<div class="container mt-4">
    <h2>Edit Category</h2>
    <?php if (isset($_SESSION["errors"])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION["errors"] as $error) : ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION["errors"]); ?>
        </div>
    <?php endif; ?>
    <form action="<?= ROOT ?>/admin/update_category/<?= $category['id'] ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">

        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($category['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            <?php if (!empty($category['image'])): ?>
                <img src="<?= ROOT ?>/<?= htmlspecialchars($category['image']) ?>" alt="Category Image" width="150">
            <?php else: ?>
                <p>No image uploaded</p>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload New Image (Optional)</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <input type="hidden" name="current_image" value="<?= htmlspecialchars($category['image']) ?>">

       

        <button type="submit" class="btn btn-success">Update</button>
        <a href="<?= ROOT ?>/admin/books" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>