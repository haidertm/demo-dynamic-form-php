<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    <title>Dashboard Template · <?= $pageTitle ?? null ?></title>
    <link href="/assets/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom Styles From Bootstrap example file-->
    <link href="/assets/css/main.css" rel="stylesheet">
</head>
<body>
<?php include __DIR__.'/../components/svgs.php'; ?>

<!--Top Header-->
<?php include __DIR__.'/../templates/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Including the left menu component -->
        <?php include __DIR__.'/../templates/left_menu.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><?= $pageTitle ?? '[PageTitle Here]' ?></h1>
            </div>

            <?= $content ?? null; ?>
        </main>
    </div>
</div>
<script src="/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
</html>
