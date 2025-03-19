<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-8">
    <div class="container mt-4">

<h2 class="text-center my-4 my-color">User Profile</h2>

<h4 class="my-color">Borrowed Books</h4>

<?php if (isset($_SESSION["errors"])): ?>
    <div class="alert alert-danger">
        <?php foreach ($_SESSION["errors"] as $error) : ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
        <?php unset($_SESSION["errors"]); ?>
    </div>
<?php endif; ?>
<?php if (!empty($borrowed_books)): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($borrowed_books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td><?= isset($book['isbn']) ? htmlspecialchars($book['isbn']) : 'N/A'; ?></td>
                    <td><?= htmlspecialchars($book['return_date']) ?></td>
                    <td>
                    <?php if ($book['status'] === 'borrowed' || $book['status'] === 'overdue'): ?>
                        <form action="<?= ROOT ?>/auth/return" method="POST" style="display:inline;">
                            <input type="hidden" name="borrow_id" value="<?= htmlspecialchars($book['book_id']) ?>">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <?= $book['status'] === 'overdue' ? "Return (Overdue)" : "Return" ?>
                            </button>
                        </form>
                    <?php else: ?>
                        <span class="text-muted">Returned</span> 
                    <?php endif; ?>
                </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($total_pages > 1): ?>
    <nav>
        <ul class="pagination justify-content-center mt-3">
            <?php if ($current_page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= ROOT ?>/auth/profile?page=<?= $current_page - 1 ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                    <a class="page-link" href="<?= ROOT ?>/auth/profile?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= ROOT ?>/auth/profile?page=<?= $current_page + 1 ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>

<?php else: ?>
    <p>You have not borrowed any book.</p>
<?php endif; ?>
</div>
    </div>
    <div class="col-md-3">
        <!-- Borrow a Book Form -->
    <div class="card shadow-sm border-0 mt-4">
            <div class="card-body mb-5">
                <form action="<?= ROOT ?>/auth/borrow_book" method="POST">
                    <div class="mb-3">
                        <label for="book_id" class="form-label my-color">Borrow a Book</label>
                        <select class="form-control" name="book_id" required>
                            <?php foreach ($available_books as $book): ?>
                                <option value="<?= $book['id'] ?>">
                                    <?= htmlspecialchars($book['title']) ?> by <?= htmlspecialchars($book['author']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Borrow</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>


    

<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>
