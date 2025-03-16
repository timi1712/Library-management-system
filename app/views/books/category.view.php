<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>
<div class="container mt-5 mb-5">
    <?php if (isset($_SESSION["flash_message"])) : ?>
        <script>
            Swal.fire({
                icon: "warning",
                title: "Warning!",
                text: "<?php echo $_SESSION['flash_message']; ?>",
                showConfirmButton: false,
                timer: 2000
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
    <?php if (!empty($books) && is_array($books)) : ?>
    <div class="row custom-bg-light">
    <h3 class="mb-4">Books in Category: <?= htmlspecialchars($category['name']) ?></h3>
    <?php foreach ($books as $book): ?>
                <div class="col-md-3">
                    <div class="card shadow-sm mb-4">
                        <img src="<?= ROOT ?>/<?= $book['image'] ?>" class="card-img-top" alt="<?= $book['title'] ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title my-color"><?= $book['title'] ?></h5>
                            <a href="<?= ROOT ?>/books/detail/<?= $book['id'] ?>" class="btn custom-bg text-white">View Book</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
    </div>
    <?php else : ?>
            <p>No books available in this category.</p>
        <?php endif; ?>

</div>
<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>
