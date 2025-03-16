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
  <?php foreach ($books as $book): ?>
            <div class="col-md-3">
                <div class="card shadow-sm mb-4">
                    <img src="<?= ROOT ?>/<?= $book['image'] ?>" class="card-img-top" alt="<?= $book['title'] ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title my-color"><?= $book['title'] ?></h5>
                        <!-- If user is NOT logged in, show only "View Book" -->
                    <?php if (!isset($_SESSION['user_id'])) : ?>
                    <a href="<?= ROOT ?>/books/detail/<?= $book['id'] ?>" class="btn custom-bg text-white">View Book</a>
                    <?php else : ?>
                    <!-- If user IS logged in, show only "Borrow" -->
                    <form action="<?= ROOT ?>/books/borrowBook" method="POST">
                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                        <button type="submit" class="btn btn-success">Borrow</button>
                    </form>
                    <?php endif; ?>
                        
                        
           
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
  </div>
  <?php else : ?>
        <p>No books available.</p>
    <?php endif; ?>
    <hr/>
    <?php if (!empty($categories) && is_array($categories)) : ?>
    <div class="row custom-bg-light">
        <!-- Flexbox container for alignment -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Get your books of different categories</h3>
            <?php 
            $visibleCategories = 6; // Number of categories to show initially
            $totalCategories = count($categories);
            ?>
            <?php if ($totalCategories >= $visibleCategories): ?>
                <button id="viewMoreCategories" class="btn btn-link my-color">View More</button>
            <?php endif; ?>
        </div>

        <?php foreach ($categories as $index => $category): ?>
            <div class="col-md-2 category-item <?= $index >= $visibleCategories ? 'd-none' : '' ?>">
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("viewMoreCategories")?.addEventListener("click", function () {
            document.querySelectorAll(".category-item.d-none").forEach(function (item) {
                item.classList.remove("d-none");
            });
            this.style.display = "none"; // Hide the button after clicking
        });
    });
</script>

</div>

