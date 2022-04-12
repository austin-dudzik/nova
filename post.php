<?php
// Include config file
include "includes/config.php";

// Define required parameters
$post_slug = $_GET['post_slug'];

if (isset($_POST['movePost'])) {
    Post::movePost($_POST['board'], $post_slug);
}

if (isset($_POST['deletePost'])) {
    die(Post::deletePost($post_slug));
}

if(isset($_POST['changeStatus'])) {
    Post::changeStatus($_POST['status'], $post_slug);
}

?>
<!doctype html>
<html lang="en">
<?= Render::header(); ?>
<body class="bg-light">
<?= Render::navigation(); ?>

<div class="row mt-5">
    <div class="col"></div>

    <div class="col-md-6">

        <!-- Page loader -->
        <div class="card border-0 bg-transparent" id="loading">
            <div class="card-body p-4 text-center">
                Loading...
            </div>
        </div>

        <!-- Post not found -->
        <div class="card p-4 w-75 mx-auto" id="post-not-found">
            <div class="card-body p-4">
                <i class="h3 fas fa-exclamation-triangle text-warning mb-3"></i>
                <h5>Post Not Found</h5>
                <p>Sorry, we couldn't find a post located at the specified URL.</p>
                <p class="fw-bold">It may have been moved, deleted, or may have never existed.</p>
                <a href="<?= Settings::getSettings("site_url") ?>" class="btn btn-accent">Go back
                    home</a>
            </div>
        </div>

        <!-- Page content -->
        <div id="page">
            <p class="d-inline-block pe-0 text-muted mb-3">
                <a href="<?= Settings::getSettings("site_url") ?>"
                   class="text-accent text-decoration-none">Home</a>
                <i class="fas fa-caret-right mx-2"></i>
            </p>
            <p class="d-inline pe-0 text-muted">
                <a href="#" class="text-accent post-board text-decoration-none"></a>
                <i class="fas fa-caret-right mx-2"></i>
            </p>
            <p class="d-inline-block pe-0 text-muted post-title"></p>

            <p class="d-inline pe-0 text-muted board-name"></p>
            <div class="card shadow round">
                <div class="card-header bg-accent text-white p-5 round-top">

                    <div class="d-flex" id="post-wrapper">
                        <div class="me-1">

                            <div class="upvote">
                                <button class="btn border px-3">
                                    <i class="fas fa-caret-up d-block"></i>
                                    <p class="mb-0"></p>
                                </button>
                            </div>

                        </div>
                        <div>

                            <h4 style="font-weight:700" class="post-title"></h4>

                            <p class="small d-inline-block"><span class="post-date"></span></p>

                        <p class="badge bg-light small text-decoration-none d-inline-block ms-2" id="post-status"></p>


                            <div class="mb-0">
                                <img src="https://gravatar.com/avatar/<?= md5("austin.dudzik@gmail.com") ?>"
                                     class="rounded-circle me-1"
                                     style="width:25px;height:25px;font-weight:700">
                                <span class="mb-0">Austin Dudzik</span>
                            </div>

                        </div>

                    </div>


                </div>

                <div class="bg-light border-bottom px-5 py-3">
                    <div class="nav nav-pills d-flex justify-content-between">
                        <button class="nav-link small active me-2" style="border-radius:8px">
                            <i class="far fa-pencil me-2"></i> Edit post
                        </button>
                        <div class="d-inline-flex">
                            <button class="nav-link small mx-0 pe-2" data-bs-toggle="modal"
                                    data-bs-target="#changeStatus" style="border-radius:8px">
                                <i class="far fa-tag fa-flip-horizontal me-2"></i> Status
                            </button>
                            <button class="nav-link small mx-0 pe-2" data-bs-toggle="modal"
                                    data-bs-target="#movePost" style="border-radius:8px">
                                <i class="far fa-arrow-right-arrow-left me-2"></i> Move
                            </button>
                            <button class="nav-link small mx-0 pe-2" style="border-radius:8px">
                                <i class="far fa-lock me-2"></i> Lock
                            </button>
                            <button class="nav-link small mx-0 pe-2 text-danger"
                                    data-bs-toggle="modal" data-bs-target="#deletePost"
                                    style="border-radius:8px">
                                <i class="far fa-trash-alt me-2"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Change status modal -->
                <div class="modal fade" id="changeStatus">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow">
                            <div class="modal-header border-0 pb-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-5">
                                <span class="fa-stack h6">
                                <i class="fa-solid fa-circle fa-stack-2x text-accent"></i>
                                <i class="far fa-tag fa-flip-horizontal fa-stack-1x text-white"></i>
                              </span>
                                <h5>Change status</h5>
                                <p class="small">Add a status to this post to add it to the feedback roadmap.</p>

                                <form method="post">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="status"
                                               id="default_status" value="0" <?= !isset(Post::getPost($_GET['post_slug'])->status->id) ? "checked" : "" ?>>
                                        <label class="form-check-label" for="default_status">
                                            No status
                                        </label>
                                    </div>
                                    <?php foreach(Statuses::getStatuses() as $status) { ?>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="status"
                                                   id="<?= $status->status_id ?>" value="<?= $status->status_id ?>" <?= isset(Post::getPost($_GET['post_slug'])->status->id) ? (($status->status_id === Post::getPost($_GET['post_slug'])->status->id) ? "checked" : "") : "" ?>>
                                            <label class="form-check-label" for="<?= $status->status_id ?>">
                                                <?= $status->name ?>
                                            </label>
                                        </div>
                                    <?php } ?>

                                    <div class="my-4">
                                        <button type="submit" name="changeStatus"
                                                class="btn bg-accent text-white me-1"
                                                style="border-radius:8px">Change status
                                        </button>
                                        <button type="button" class="btn btn-white border"
                                                style="border-radius:8px">Cancel
                                        </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Move post modal -->
                <div class="modal fade" id="movePost">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow">
                            <div class="modal-header border-0 pb-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-5">
                                <span class="fa-stack h6">
                                <i class="fa-solid fa-circle fa-stack-2x text-accent"></i>
                                <i class="far fa-arrow-right-arrow-left fa-stack-1x text-white"></i>
                              </span>
                                <h5>Move post</h5>
                                <p class="small">If this post was published to the wrong board, you can move it to another and retain all post, upvote, and comment data. The post URL will remain unchanged.</p>

                                <form method="post">
                                <?php foreach(Boards::getBoards() as $board) { ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="board"
                                               id="<?= $board->board_id ?>" value="<?= $board->board_id ?>" <?= ($board->board_id === Post::getPost($_GET['post_slug'])->board->board_id) ? "checked" : "" ?>>
                                        <label class="form-check-label" for="<?= $board->board_id ?>">
                                            <?= $board->name ?>
                                        </label>
                                    </div>
                                <?php } ?>

                                <div class="my-4">
                                        <button type="submit" name="movePost"
                                                class="btn bg-accent text-white me-1"
                                                style="border-radius:8px">Move to board
                                        </button>
                                        <button type="button" class="btn btn-white border"
                                                style="border-radius:8px">Cancel
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete post modal -->
                <div class="modal fade" id="deletePost">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow">
                            <div class="modal-header border-0 pb-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-5">
                                <span class="fa-stack h6">
                                <i class="fa-solid fa-circle fa-stack-2x text-danger"></i>
                                <i class="far fa-trash-alt fa-stack-1x text-white"></i>
                              </span>
                                <h5>Delete this post?</h5>
                                <p class="small">Deleting a post is permanent and cannot be
                                    reversed. All upvotes and comments will also be removed.</p>
                                <div class="mb-4">
                                    <form method="post">
                                        <button type="submit" name="deletePost"
                                                class="btn btn-danger me-1"
                                                style="border-radius:8px">Delete forever
                                        </button>
                                        <button type="button" class="btn btn-white border"
                                                style="border-radius:8px">Cancel
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card-body px-5">

                    <p class="fw-bold mb-2">Description</p>
                    <p class="post-content mb-3"></p>

                    <p class="fw-bold mb-2">Voters</p>
                    <div class="d-flex">
                        <div class="d-inline-block" id="voterList"></div>

                        <div style="width:30px;height:30px;line-height:30px"
                             class="bg-light other-upvotes rounded-circle text-center small border"></div>
                    </div>

                </div>

                <div class="bg-light border-top p-4">
                    <div class="toggle-co-area">
                        <div class="card"
                             id="leave-comment">
                            <div class="card-body text-muted py-2"
                                 style="font-size:14px">
                                Leave a comment...
                            </div>
                        </div>
                    </div>

                    <div id="comment-area" style="display:none">
                        <textarea id="editor"></textarea>
                        <div class="float-end">
                            <button class="btn btn-light border toggle-co-area">
                                Cancel
                            </button>
                            <button class="btn btn-accent">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col"></div>
</div>

<script>
    let post_id = null;
    let post_slug = '<?= $_GET['post_slug'] ?>';
</script>
<?= Render::footer(); ?>
<script src="<?= Settings::getSettings("site_url") ?>/assets/js/post.js"></script>
</body>
</html>