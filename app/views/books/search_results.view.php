<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>

<div class="container mt-4 mb-5">
    <h3>Search Results for "<?= htmlspecialchars($search_query) ?>"</h3>
    <hr>
 
    <?php if (!empty($books) && is_array($books)): ?>
        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-md-2">
                    <div class="card mb-3">
                        <img src="<?= ROOT ?>/<?= $book['image'] ?>" class="card-img-top" alt="<?= $book['title'] ?>">
                        <div class="card-body mb-5">
                            <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                            <p class="card-text">By <?= htmlspecialchars($book['author']) ?></p>
                            <a href="<?= ROOT ?>/books/view/<?= $book['id'] ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <h4 class="text-muted text-center">No books found matching your search.</h4>
    <?php endif; ?>
    <div class="row"></div>
</div>

<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>
