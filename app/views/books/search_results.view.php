<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>

<div class="container mt-4">
    <h3>Search Results for "<?= htmlspecialchars($search_query) ?>"</h3>
    <hr>

    <?php if (!empty($books)): ?>
        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <img src="<?= ROOT ?>/assets/images/books/<?= $book['image'] ?>" class="card-img-top" alt="<?= $book['title'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                            <p class="card-text">By <?= htmlspecialchars($book['author']) ?></p>
                            <a href="<?= ROOT ?>/books/view/<?= $book['id'] ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted">No books found matching your search.</p>
    <?php endif; ?>
</div>

<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>
