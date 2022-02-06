<?php
// Include config file
include "includes/config.php";

// Define required parameters
$board_slug = $_GET['board_slug'];
$sort_by = $_GET['sort'];

?>
<!doctype html>
<html lang="en">
<?php echo Render::header(); ?>
<body>
<?php echo Render::navigation('board'); ?>

<div class="container-fluid my-5 px-5">

    <div class="row" id="board-holder">

        <div class="col-md-3">

            <div class="ph-item mb-3">
                <div class="ph-col-12">
                    <div class="ph-row">
                        <div class="ph-col-12" style="height:300px"></div>
                    </div>
                </div>
            </div>

            <div class="card sticky-top lz-load" style="top:150px">
                <div class="card-body">

                    <span class="fa-stack ms-1"
                          style="font-size:22px">
                      <i class="fas fa-square fa-stack-2x text-accent"></i>
                      <i class="fas fa-stack-1x fa-inverse board-icon"></i>
                    </span>

                    <div class="mx-2 mt-2">
                        <h6 class="board-name"></h6>
                        <p class="small text-muted board-desc"></p>

                        <div class="row">
                            <div class="col">
                                <button type="button"
                                        class="btn btn-accent w-100 border btn-sm mb-2">
                                    <i class="far fa-plus me-2"></i>
                                    <?= __("new_post") ?>
                                </button>
                            </div>
                            <div class="col">
                                <button type="button"
                                        class="btn btn-light w-100 border btn-sm mb-2">
                                    <i class="far fa-rss me-2"></i>
                                    <?= __("subscribe") ?>
                                </button>
                            </div>
                        </div>

                        <p class="small mt-2 mb-0"
                           style="font-size:11px">
                            <i class="fas fa-copy me-2"></i>
                            <span class="board-posts">
                        </p>
                        <p class="small mt-2 mb-0"
                           style="font-size:11px">
                            <i class="fas fa-users me-2"></i>
                            <span class="board-subscribers">
                        </p>
                        <p class="small mt-2 mb-0"
                           style="font-size:11px">
                            <i class="fas fa-caret-up me-2"></i>
                            <span class="board-upvotes">
                        </p>

                    </div>

                </div>
            </div>

        </div>
        <div class="col ms-3">

            <div class="row">

                <div class="col">

                    <div class="ph-item mb-3">
                        <div class="ph-col-12">
                            <div class="ph-row">
                                <div class="ph-col-12"
                                     style="height:30px"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Breadcrumbs -->
                    <div class="mb-3 small lz-load">
                        <span class="float-start">
                        <p class="d-inline pe-0 text-muted">
                            <a href="<?= Settings::getSettings("site_url") ?>"
                               class="text-accent text-decoration-none">
                                <?= __("boards") ?>
                            </a>
                            <i class="fas fa-caret-right mx-2"></i>
                        </p>
                        <p class="d-inline pe-0 text-muted board-name"></p>
                            </span>

                        <p class="float-end"
                           id="toggle-sidebar"
                           role="button">
                            <i class="fas fa-right-from-line me-2"></i>
                            <?= __("options") ?>
                        </p>

                    </div>

                    <div class="clearfix"></div>


                    <div id="posts-wrapper">

                        <div class="ph-item mb-3">
                            <div class="ph-col-12">
                                <div class="ph-row">
                                    <div class="ph-col-12"
                                         style="height:96px"></div>
                                </div>
                            </div>
                        </div>

                        <div class="ph-item mb-3">
                            <div class="ph-col-12">
                                <div class="ph-row">
                                    <div class="ph-col-12"
                                         style="height:96px"></div>
                                </div>
                            </div>
                        </div>

                        <div class="ph-item mb-3">
                            <div class="ph-col-12">
                                <div class="ph-row">
                                    <div class="ph-col-12"
                                         style="height:96px"></div>
                                </div>
                            </div>
                        </div>

                        <div class="ph-item mb-3">
                            <div class="ph-col-12">
                                <div class="ph-row">
                                    <div class="ph-col-12"
                                         style="height:96px"></div>
                                </div>
                            </div>
                        </div>

                        <div class="ph-item mb-3">
                            <div class="ph-col-12">
                                <div class="ph-row">
                                    <div class="ph-col-12"
                                         style="height:96px"></div>
                                </div>
                            </div>
                        </div>

                        <ul class="list-group list-group-flush posts-list w-100 lz-load"></ul>

                        <div class="btm-hold text-center">
                            <button type="button" class="btn btn-light px-5 border btn-sm mb-2 loadMore lz-load">
                                <i class="fas fa-plus me-2"></i>
                                <?= __("load_more") ?>
                            </button>
                            <p class="text-muted small fst-italic">
                                🎈 <?= __('reached_end') ?></p>
                        </div>

                    </div>

                </div>

                <div class="col-md-4" id="sidebar">

                    <div class="ph-item mb-3">
                        <div class="ph-col-12">
                            <div class="ph-row">
                                <div class="ph-col-12"
                                     style="height:200px"></div>
                            </div>
                        </div>
                    </div>

                    <div class="ph-item mb-3">
                        <div class="ph-col-12">
                            <div class="ph-row">
                                <div class="ph-col-12"
                                     style="height:200px"></div>
                            </div>
                        </div>
                    </div>


                    <div class="sticky-top lz-load"
                         style="top:150px">
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="fw-bold mb-2">
                                    <i class="fas fa-filter text-muted me-2"></i>
                                    <?= __("filter") ?>
                                </p>

                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           id="exampleRadios1"
                                           value="option1"
                                           checked>
                                    <label class="form-check-label"
                                           for="exampleRadios1">
                                        Under
                                        Review
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           id="exampleRadios2"
                                           value="option2">
                                    <label class="form-check-label"
                                           for="exampleRadios2">
                                        Planned
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           id="exampleRadios2"
                                           value="option2">
                                    <label class="form-check-label"
                                           for="exampleRadios2">
                                        Fixed
                                    </label>
                                </div>


                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <p class="fw-bold mb-2">
                                    <i class="fas fa-circle-sort text-muted me-2"></i>
                                    <?= __("sort") ?>
                                </p>

                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           id="exampleRadios1"
                                           value="option1"
                                           checked>
                                    <label class="form-check-label"
                                           for="exampleRadios1">
                                        New
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           id="exampleRadios2"
                                           value="option2">
                                    <label class="form-check-label"
                                           for="exampleRadios2">
                                        Top
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           id="exampleRadios2"
                                           value="option2">
                                    <label class="form-check-label"
                                           for="exampleRadios2">
                                        Fixed
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mustSignInModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title"
                    id="exampleModalLabel"></h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body px-5">


                <div class="row pb-4">
                    <div class="col-md-5 d-none">
                        <div class="card mx-auto">
                            <div class="card-body">
                                <p class="mb-3">Do more with an account...</p>
                                <ul class="list-group small no-gutters m-0 p-0">


                                    <li class="list-group-item bg-white p-0 m-0">
                            <span class="fa-stack me-1">
                          <i class="fas fa-square fa-stack-2x text-accent"></i>
                          <i class="fas fa-message fa-stack-1x fa-inverse"></i>
                        </span>Post comments
                                    </li>
                                    <li class="list-group-item bg-white p-0 m-0 mt-2">
                              <span class="fa-stack me-1">
                              <i class="fas fa-square fa-stack-2x text-accent"></i>
                              <i class="fas fa-caret-up fa-stack-1x fa-inverse"></i>
                            </span>Upvote posts
                                    </li>
                                    <li class="list-group-item bg-white p-0 m-0 mt-2">
                              <span class="fa-stack me-1">
                              <i class="fas fa-square fa-stack-2x text-accent"></i>
                              <i class="fas fa-copy fa-stack-1x fa-inverse"></i>
                            </span>Share ideas
                                    </li>
                                    <li class="list-group-item bg-white p-0 m-0 mt-2">
                              <span class="fa-stack me-1">
                              <i class="fas fa-square fa-stack-2x text-accent"></i>
                              <i class="fas fa-bell fa-stack-1x fa-inverse"></i>
                            </span>Receive notifications
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
<!--                    <div class="col-md-12 mx-auto ps-5">-->
                        <div class="col-md-12 mx-auto">
                        <img src="../logo.svg" width="180" class="mb-4">

                        <h5 class="mb-3">Please log in to continue...</h5>

                            <div class="alert alert-danger" id="msg"></div>

                        <form>
                            <div class="form-group mb-3">
                                <label for="email"><?= __('email') ?></label>
                                <input type="email" id="email" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password"><?= __('password') ?></label>
                                <input type="password" id="password" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <button type="button" class="btn btn-accent w-100" id="submitLogin"><?= __('login') ?>
                                </button>
                            </div>
                        </form>


                        <div class="card">
                            <div class="card-body">
                                <p class="mb-3">Do more with an account...</p>
                                <div class="row small">
                                    <div class="col-6 mb-2">
                                        <span class="fa-stack me-1">
                          <i class="fas fa-square fa-stack-2x text-accent"></i>
                          <i class="fas fa-message fa-stack-1x fa-inverse"></i>
                        </span>Post comments
                                    </div>
                                    <div class="col-6 mb-2">
                            <span class="fa-stack me-1">
                              <i class="fas fa-square fa-stack-2x text-accent"></i>
                              <i class="fas fa-caret-up fa-stack-1x fa-inverse"></i>
                            </span>Upvote posts
                                    </div>
                                    <div class="col-6 mb-2">
                            <span class="fa-stack me-1">
                              <i class="fas fa-square fa-stack-2x text-accent"></i>
                              <i class="fas fa-copy fa-stack-1x fa-inverse"></i>
                            </span>Share ideas
                                    </div>
                                    <div class="col-6 mb-2">
                            <span class="fa-stack me-1">
                              <i class="fas fa-square fa-stack-2x text-accent"></i>
                              <i class="fas fa-bell fa-stack-1x fa-inverse"></i>
                            </span>Get notifications
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center small py-2">
                                <a href="register.php" class="text-accent text-decoration-none">Create account <i class="far fa-long-arrow-right ms-1"></i></a>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script>
    let board_id = null;
    let boardSlug = '<?= $board_slug ?>';
</script>
<?php echo Render::footer(); ?>
<script src="<?= Settings::getSettings("site_url") ?>/assets/js/board.js"></script>
</body>
</html>