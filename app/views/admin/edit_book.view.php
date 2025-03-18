<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>

<div class="container mt-4 mb-10">
    <h2>Edit Book</h2>
    <?php if (isset($_SESSION["errors"])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION["errors"] as $error) : ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION["errors"]); ?>
        </div>
    <?php endif; ?>
    <form action="<?= ROOT ?>/admin/update_book/<?= $book['id'] ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">
       <div class="row">
            <div class="mb-3 col-md-3">
                <label class="form-label">Book Title</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($book['title']) ?>" required>
            </div>
            <div class="mb-3 col-md-3">
                <label class="form-label">Book Author</label>
                <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($book['author']) ?>" required>
            </div>
            <div class="mb-3 col-md-3">
                <label class="form-label">Book ISBN</label>
                <input type="text" name="isbn" class="form-control" value="<?= htmlspecialchars($book['isbn']) ?>" required>
            </div>
            <div class="mb-3 col-md-3">
                <label class="form-label">Category</label>
                <?php if (!empty($categories) && is_array($categories)): ?>
                    <select name="category_id" class="form-control" required>
                        <option value="<?= $book["category_id"] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
            <p>No categories found. Please add categories first.</p>
            <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-2">
                <label class="form-label">Published Year</label>
                <input type="text" name="published_year" class="form-control" value="<?= htmlspecialchars($book['published_year']) ?>" required>
            </div>
            <div class="mb-3 col-md-2">
                <label class="form-label">Book Quantity</label>
                <input type="number" name="quantity" class="form-control" value="<?= htmlspecialchars($book['quantity']) ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"  rows="5"><?= htmlspecialchars($book["description"]) ?></textarea>
            </div>
            <div class="mb-3 col-md-3">
                <label class="form-label">Current Image</label><br>
                <?php if (!empty($book['image'])): ?>
                    <img src="<?= ROOT ?>/<?= htmlspecialchars($book['image']) ?>" alt="Book Image" width="150">
                <?php else: ?>
                    <p>No image uploaded</p>
                <?php endif; ?>
            </div>
            <div class="mb-3 col-md-2">
                <label for="image" class="form-label">Upload New Image (Optional)</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-5">
                <input type="hidden" name="current_image" value="<?= htmlspecialchars($category['image']) ?>">
            </div>
           
            <div class="col-md-4 mb-5">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
            <div class="col-md-4 mb-5">
                <a href="<?= ROOT ?>/admin/books" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>

<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>