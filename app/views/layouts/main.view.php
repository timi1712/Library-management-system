<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>

<div class="container-fluid mt-4">
    <?php if (isset($content)) echo $content; ?>
</div>

<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>