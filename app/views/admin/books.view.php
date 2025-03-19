<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>
<?php if (isset($_SESSION["flash_message"])) : ?>
    <script>
        Swal.fire({
            icon: "success",
            title: "Success!",
            text: "<?php echo $_SESSION['flash_message']; ?>",
            showConfirmButton: false,
            timer: 2500
        });
    </script>
    <?php unset($_SESSION["flash_message"]); ?>
<?php endif; ?>

<?php if (isset($_SESSION["errors"]) && count($_SESSION["errors"]) > 0) : ?>
    <script>
        Swal.fire({
            icon: "error",
            title: "Error!",
            html: "<?php echo implode('<br>', $_SESSION['errors']); ?>",
        });
    </script>
    <?php unset($_SESSION["errors"]); ?>
<?php endif; ?>

<div class="container mt-4">
<h2 class="text-center my-4 my-color">Book Management</h2>
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-10">
        <!-- CATEGORY LIST -->
        <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="mt-4">Categories List</h4>
                    <?php if (!empty($categories)): ?>
                        <table class="table table-bordered custom-bg-light">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($category["name"]) ?></td>
                                        <td><img src="<?= ROOT ?>/<?= $category["image"] ?>" alt="<?= htmlspecialchars($category["name"]) ?>" width="50"></td>
                                        <td>
                                            <a href="<?= ROOT ?>/admin/edit_category/<?= $category['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
                                             <button class="btn btn-sm btn-danger" onclick="confirmDeleteCat(<?= $category['id']; ?>)">
                                             <i class="bi bi-trash"></i> Delete
                                             </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <h3>No categories yet.</h3>
                    <?php endif; ?>
                      <!-- Pagination -->
        <div class="d-flex justify-content-center">
                    <!-- Pagination Controls -->
                    <nav>
                        <ul class="pagination">
                            <!-- Previous Button -->
                            <li class="page-item <?= ($currentCatPage <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= max(1, $currentCatPage - 1) ?>" aria-label="Previous">
                                    <i class="fas fa-angle-left"></i> <!-- Left arrow -->
                                </a>
                            </li>

                            <!-- Page Numbers -->
                            <?php for ($i = 1; $i <= $totalCatPages; $i++) : ?>
                                <li class="page-item <?= ($i == $currentCatPage) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next Button -->
                            <li class="page-item <?= ($currentCatPage >= $totalCatPages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= min($totalCatPages, $currentCatPage + 1) ?>" aria-label="Next">
                                    <i class="fas fa-angle-right"></i> <!-- Right arrow -->
                                </a>
                            </li>
                        </ul>
                    </nav>
        </div>
        <!-- pagination -->
                </div>
            </div>
    </div>
</div>
<div class="col-md-1"></div>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h4 class="my-color">Add New Category</h4>

                        <form action="<?= ROOT ?>/admin/store_category" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Category Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>
                            <div class="my-3">
                                <button type="submit" class="btn custom-bg text-white">Add Category</button>
                            </div>
                        </form>
                    </div>
        </div>
    </div>
 
    <div class="col-md-1"></div>
</div>
 <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
<!-- Book Creation Form -->
<div class="card shadow-sm border-0 mb-4">
<div class="card-body">
    <h4 class="mt-4 my-color">Add New Book</h4>
    <?php if (!empty($_SESSION["errors"])): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($_SESSION["errors"] as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION["errors"]); ?>
    <?php endif; ?>

    <form action="<?= ROOT ?>/admin/store_book" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Author</label>
                <input type="text" name="author" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">ISBN</label>
                <input type="text" name="isbn" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Category</label>
                <?php if (!empty($categories) && is_array($categories)): ?>
                <select name="category_id" class="form-control" required>
                    <option value="">Select a Category</option>
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
            <div class="col-md-2">
                <label class="form-label">Published Year</label>
                <input type="number" name="published_year" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Cover Image</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="col-md-5">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5"></textarea>
            </div>
        </div>
        <div class="my-3">
        <button type="submit" class="btn custom-bg text-white">Add Book</button>
        </div>
    </form>
</div>
</div>
<!-- List of books -->

<div class="card shadow-sm border-0 mb-5">
    <div class="card-body">
        <h2 class="mt-4">Books List</h2>
        
        <?php if (!empty($books)): ?>
            <table class="table table-bordered custom-bg-light">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Image</th>
                        <th>Published Year</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['author']) ?></td>
                            <td><?= htmlspecialchars($book['isbn']) ?></td>
                            <td><img src="<?= ROOT ?>/<?= $book["image"] ?>" width="30"></td>
                            <td><?= htmlspecialchars($book['published_year']) ?></td>
                            <td><?= htmlspecialchars($book['quantity']) ?></td>
                            <td>
                                <a href="<?= ROOT ?>/admin/edit_book/<?= $book['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>

                                <button class="btn btn-sm btn-danger" onclick="confirmDeleteBook(<?= $book['id']; ?>)">
                                                <i class="bi bi-trash"></i> Delete
                                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <h3>No books yet in the database.</h3>
        <?php endif; ?>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
                    <!-- Pagination Controls -->
                    <nav>
                        <ul class="pagination">
                            <!-- Previous Button -->
                            <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= max(1, $currentPage - 1) ?>" aria-label="Previous">
                                    <i class="fas fa-angle-left"></i> <!-- Left arrow -->
                                </a>
                            </li>

                            <!-- Page Numbers -->
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next Button -->
                            <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= min($totalPages, $currentPage + 1) ?>" aria-label="Next">
                                    <i class="fas fa-angle-right"></i> <!-- Right arrow -->
                                </a>
                            </li>
                        </ul>
                    </nav>
        </div>
        <!-- pagination -->
    </div>
    
</div>
</div>
<div class="col-md-1"></div>
</div>
</div>
<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>