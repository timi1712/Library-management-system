<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>

<div class="container mt-5 mb-6">
    <h2 class="mb-4">Borrowed Books Report</h2>
    <?php if (!empty($borrowedBooks)) : ?>
        <table class="table table-bordered">
            <thead class="custom-bg text-white">
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Borrower</th>
                    <th>Status</th>
                    <th>Return Date</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrowedBooks as $book) : ?>
                    <tr>
                        <td><img src="<?= ROOT ?>/<?= $book['image'] ?>" alt="<?= $book['title'] ?>" width="50"></td>
                        <td><?= htmlspecialchars($book['title']) ?></td>
                        <td><?= htmlspecialchars($book['user_name']) ?></td>
                        <td>
                            <?php if ($book['status'] == 'borrowed') : ?>
                                <span class="badge bg-warning">Borrowed</span>
                            <?php elseif ($book['status'] == 'overdue') : ?>
                                <span class="badge bg-danger">Overdue</span>
                            <?php else : ?>
                                <span class="badge bg-success">Returned</span>
                            <?php endif; ?>
                        </td>
                        <td><?= !empty($book['return_date']) ? htmlspecialchars($book['return_date']) : 'N/A' ?></td>
                        

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <!-- Pagination -->
            <nav>
                <ul class="pagination">
                     <!-- Previous Button -->
                     <li class="page-item">
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
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= min($totalPages, $currentPage + 1) ?>" aria-label="Next">
                                    <i class="fas fa-angle-right"></i> <!-- Right arrow -->
                                </a>
                            </li>
                </ul>
            </nav>
        </div>
    <?php else : ?>
        <p>No borrowed books available.</p>
    <?php endif; ?>
</div>

<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>
