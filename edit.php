<?php
// Include config file
include "includes/config.php";

// Define required parameters
$post_slug = $_GET['post_slug'];

// Get the board
$post = Post::getPost($post_slug);

// If board not found
if (isset($post->code) && $post->code === 204) {
    header("Location: ../index.php");
    die();
}

if ($post->user->id != $user->id) {
    if (!isAdmin()) {
        header("Location: ../index.php");
        die();
    }
}

include "includes/logic/edit.php";

?>
<!doctype html>
<html lang="en">
<?= Render::header('Edit post'); ?>
<body>
<?= Render::navigation(); ?>
<div class="row mt-5">
    <div class="col"></div>
    <div class="col-md-6">

        <p class="d-inline-block pe-0 mb-3">
            <a href="<?= SITE_URL ?>"
               class="text-accent text-decoration-none">
                Home
            </a>
            <i class="fas fa-caret-right mx-2"></i>
        </p>
        <a href="<?= $post->board->url ?>"
           class="text-accent text-decoration-none">
            <?= $post->board->name ?>
        </a>
        <i class="fas fa-caret-right mx-2 text-muted"></i>
        <a href="<?= $post->url ?>"
           class="text-accent text-decoration-none">
            <?= $post->title ?>
        </a>
        <i class="fas fa-caret-right mx-2 text-muted"></i>
        <p class="d-inline pe-0 text-muted">Edit post</p>

        <div class="card shadow rounded-lg round">
            <div class="card-header bg-accent text-white px-5 py-3 round-top">
                <div class="d-flex">
                    <a href="<?= $post->url ?>">
                        <i class="fas fa-long-arrow-left h6 me-3 mb-0 mt-2 text-white"></i>
                    </a>
                    <div>
                        <h1 class="h6 mb-0 mt-1">Editing: <span
                                    style="font-weight:400"><?= $post->title ?></span></h1>
                    </div>
                </div>
            </div>


            <div class="card-body px-5 py-4">

                <form method="post">
                    <label for="suggestion" class="mb-1" style="font-weight:500">Title</label>
                    <input type="text" class="form-control p-2 px-3 mb-3 round" id="suggestion"
                           placeholder="A short, descriptive title"
                           name="title" value="<?= $post->title ?? "" ?>">
                    <p class="small text-danger"><?= $title_err ?></p>
                    <label for="description" class="mb-1"
                           style="font-weight:500">Description</label>
                    <textarea placeholder="Please include only one suggestion per post"
                              class="form-control p-2 px-3 mb-3 round"
                              id="description" name="description"><?= $post->content ?? "" ?></textarea>
                    <p class="small text-danger"><?= $desc_err ?></p>
                    <button type="submit" name="submit" class="btn bg-accent text-white px-3 round">Save changes
                    </button>
                    <a href="<?= $post->url ?>" type="button" class="btn btn-light border px-3 round">Cancel
                    </a>
                </form>
            </div>
        </div>
    </div>
    <div class="col"></div>
</div>
<?= Render::footer(); ?>
</body>
</html>