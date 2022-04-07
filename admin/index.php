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
<div class="bg-dark row py-3">
    <div class="col"></div>
    <div class="col-md-6">
        <div class="d-flex justify-content-between text-white">
            <div class="my-auto">

                <svg class="me-1" width="22" height="22" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.6 10.7C13.3 8 16.9 6.3 20.9 6C21.5 6 21.9 5.5 21.9 4.9V3C21.9 2.4 21.4 2 20.9 2C15.8 2.3 11.2 4.4 7.79999 7.8C4.39999 11.2 2.2 15.8 2 20.9C2 21.5 2.4 21.9 3 21.9H4.89999C5.49999 21.9 6 21.5 6 20.9C6.2 17 7.90001 13.4 10.6 10.7Z"
                          fill="#ffffff"/>
                    <path d="M14.8 14.9C16.4 13.3 18.5 12.2 20.9 12C21.5 11.9 21.9 11.5 21.9 10.9V9C21.9 8.4 21.4 8 20.8 8C17.4 8.3 14.3 9.8 12 12.1C9.7 14.4 8.19999 17.5 7.89999 20.9C7.89999 21.5 8.29999 22 8.89999 22H10.8C11.4 22 11.8 21.6 11.9 21C12.2 18.6 13.2 16.5 14.8 14.9ZM16.2 16.3C17.4 15.1 19 14.3 20.7 14C21.3 13.9 21.8 14.4 21.8 15V17C21.8 17.5 21.4 18 20.9 18.1C20.1 18.3 19.5 18.6 19 19.2C18.5 19.8 18.1 20.4 17.9 21.1C17.8 21.6 17.4 22 16.8 22H14.8C14.2 22 13.7 21.5 13.8 20.9C14.2 19.1 15 17.5 16.2 16.3Z"
                          fill="#ffffff"/>
                </svg>

                <p class="h5 d-inline my-auto vertical-align-middle">Nova</p>
            </div>

                <div class="d-flex vertical-align-middle">
                    <a class="text-decoration-none small me-3 text-white" href="#">Feedback</a>
                    <a class="text-decoration-none small me-3 text-white dropdown-toggle" href="#" id="navbarDropdown">
                        Manage
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                    <a class="text-decoration-none small me-3 text-white" href="#">Settings</a>


                    <img src="https://gravatar.com/avatar/<?= md5($user->email) ?>?s=32"
                         class="rounded-circle my-auto" alt="" height="32" width="32">

                </div>

        </div>
    </div>
    <div class="col"></div>
</div>

<div class="row mt-5">
    <div class="col"></div>
    <div class="col-md-6">
        <h1 class="h4 mb-3">Boards</h1>
        <div class="row">
            <?php foreach (Boards::getAdminBoards() as $board) { ?>
                <div class="col-md-12">
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
                                                if ($board->visibility == 0) { ?>
                                                    <i class="fas fa-eye-slash me-2"></i> Unlisted
                                                <?php } elseif ($board->visibility == 1) { ?>
                                                    <i class="fas fa-eye me-1"></i> Public
                                                <?php } elseif ($board->visibility == 2) { ?>
                                                    <i class="fas fa-lock me-1"></i> Private
                                                <?php } ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <i class="fas fa-external-link me-2"></i>
                                    <i class="fas fa-pencil me-2"></i>
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="col"></div>
</div>
<?php echo Render::footer(); ?>
</body>
</html>