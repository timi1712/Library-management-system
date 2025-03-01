<div class="container mt-5">
    <h2 class="text-center mb-4">Book Categories</h2>
    <?php if (!empty($categories) && is_array($categories)) : ?>
    <div class="row">
        <?php foreach ($categories as $category): ?>
            <div class="col-md-3">
                <div class="card shadow-sm mb-4">
                    <img src="<?= ROOT ?>/<?= $category['image'] ?>" class="card-img-top" alt="<?= $category['name'] ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title my-color"><?= $category['name'] ?></h5>
                        <a href="<?= ROOT ?>/books/category/<?= $category['id'] ?>" class="btn custom-bg text-white">View Books</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php else : ?>
        <p>No categories available.</p>
    <?php endif; ?>
</div>

