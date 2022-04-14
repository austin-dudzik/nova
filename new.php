<?php
// Include config file
include "includes/config.php";

// Define required parameters
$board_slug = $_GET['board_slug'];

// Get the board
$board = Board::getBoard($_GET['board_slug']);

// If board not found
if(isset($board->code) && $board->code === 204) {
    header("Location: ../index.php");
    die();
}

include "includes/logic/new.php";

?>
<!doctype html>
<html lang="en">
<?= Render::header('New post'); ?>
<body>
<?= Render::navigation(); ?>
<div class="row mt-5">
    <div class="col"></div>
    <div class="col-md-6">

        <p class="d-inline-block pe-0 mb-3">
            <a href="<?= Settings::getSettings("site_url") ?>"
               class="text-accent text-decoration-none">
                Home
            </a>
            <i class="fas fa-caret-right mx-2"></i>
        </p>
        <a href="<?= $board->url ?>"
           class="text-accent text-decoration-none">
            <?= $board->name ?>
        </a>
        <i class="fas fa-caret-right mx-2 text-muted"></i>
        <p class="d-inline pe-0 text-muted">New suggestion</p>

        <div class="card shadow round">
            <div class="card-header bg-accent text-white p-5"
                 style="border-top-left-radius:8px;border-top-right-radius:8px">
                <div class="d-flex">
                    <i class="fas fa-comments me-2 h5 me-3 mt-1"></i>
                    <div>
                        <h1 class="h5">New Suggestion</h1>
                        <p class="small mb-0">We want to hear your feedback!</p>
                    </div>
                </div>
            </div>


            <div class="card-body px-5 py-4">

                <p>Posting to: <?= $board->name ?></p>

                <form method="post">
                    <label for="suggestion" class="mb-1" style="font-weight:500">Title</label>
                    <input type="text" class="form-control p-2 px-3 mb-3 round" id="suggestion"
                           placeholder="A short, descriptive title"
                           name="title" value="<?= $title ?? "" ?>">
                    <p class="small text-danger"><?= $title_err ?></p>
                    <label for="description" class="mb-1" style="font-weight:500">Description</label>
                    <textarea placeholder="Please include only one suggestion per post" class="form-control p-2 px-3 mb-3 round"
                              id="description"
                              rows="6" name="description"><?= $description ?? "" ?></textarea>
                    <p class="small text-danger"><?= $desc_err ?></p>
                    <button type="submit" name="submit" class="btn bg-accent text-white px-3 round">Create post
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col"></div>
</div>
<?= Render::footer(); ?>
</body>
</html>