<?php

include "../includes/config.php";

// Deny access to non-admin users
if (!isAdmin()) {
    header("Location: ../index.php");
    die();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Boards | Nova</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="<?= Settings::getSettings("site_url") ?>/assets/css/styles.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled">Disabled</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1 class="h3 mb-3">Boards</h1>
    <div class="row">
    <?php foreach (Boards::getAdminBoards() as $board) { ?>
        <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="d-flex">
            <span class="fa-stack me-2"
                  style="font-size:22px">
                      <i class="fas fa-square fa-stack-2x text-accent"></i>
                      <i class="fas fa-stack-1x fa-inverse fa-<?= $board->icon ?>"></i>
                    </span>
                            <div>
                                <h6 class="text-truncate"><?= $board->name ?></h6>
                                <p class="mb-0 small text-muted">
                                    <?php
                                    if($board->visibility == 0) { ?>
                                        <i class="fas fa-eye-slash me-2"></i> Unlisted
                                    <?php } elseif($board->visibility == 1) { ?>
                                        <i class="fas fa-eye me-1"></i> Public
                                    <?php } elseif($board->visibility == 2) { ?>
                                        <i class="fas fa-lock me-1"></i> Private
                                    <?php } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-external-link"></i>
                        <i class="fas fa-pencil"></i>
                        <i class="fas fa-trash-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        </div>
    <?php } ?>
    </div>
</div>
<?php echo Render::footer(); ?>
</body>
</html>