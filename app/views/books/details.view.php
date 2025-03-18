<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>

<div class="container mt-5 mb-6">
    <div class="row">
        <div class="col-md-4">
        <img src="<?= ROOT ?>/<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" width="250">
        </div>
        <div class="col-md-8">
        <h2><?= htmlspecialchars($book['title']) ?></h2>
    
    <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($book['description'])) ?></p>
        </div>
    </div>
    
</div>

<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>
