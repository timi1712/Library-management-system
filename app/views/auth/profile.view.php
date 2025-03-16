<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>

<div class="container mt-4">
    <h2 class="text-center my-4 my-color">User Profile</h2>

    <h4 class="my-color">Borrowed Books</h4>

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
                            <a href="<?= ROOT ?>/user/return/<?= $book['id'] ?>" class="btn btn-sm btn-danger">Return</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have not borrowed any books.</p>
    <?php endif; ?>
</div>

<!-- Borrow a Book Form -->
<div class="card shadow-sm border-0 mb-5">
        <div class="card-body">
            <h2 class="mt-4">Borrow a Book</h2>
            <form action="<?= ROOT ?>/auth/borrow_book" method="POST">
                <div class="mb-3">
                    <label for="book_id" class="form-label">Select a Book</label>
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

<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>
