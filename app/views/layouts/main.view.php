<?php require_once dirname(__DIR__) . "/layouts/header.view.php"; ?>

<div class="container mt-4">
    <main role="main" class="pb-3">
    <?php if (isset($content)) echo $content; ?>
    </main>
</div>

<?php require_once dirname(__DIR__) . "/layouts/footer.view.php"; ?>
