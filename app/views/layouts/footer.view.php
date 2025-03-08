<!-- Footer -->
<footer class="custom-bg text-white text-center py-3 mt-4">
        <p>&copy; <?= date('Y') ?> Library Management System | All Rights Reserved</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="<?= ROOT ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script>
        //user
        function confirmDelete(userId) {
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= ROOT ?>/admin/deleteUser/" + userId;
                }
            });
        }
    // Book
        function confirmDeleteBook(bookId) {
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= ROOT ?>/admin/deleteBook/" + bookId;
                }
            });
        }
    // category
    function confirmDeleteCat(categoryId) {
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= ROOT ?>/admin/deleteCategory/" + categoryId;
                }
            });
        }
</script>


</body>
</html>