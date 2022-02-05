<?php
// Start session
session_start();

// Include config file
include "includes/config.php";

// Define required parameters
$board_slug = $_GET['board_slug'];

?>
<!doctype html>
<html lang="en">
<?php echo Render::header(); ?>
<body>
<?php echo Render::navigation('board'); ?>

<div class="container-fluid my-5 px-5">

    <div class="card w-50 mx-auto p-4"
         id="404-holder" style="display:none">
        <div class="card-body">
            <h5>Board Not Found</h5>
            <p>Sorry, we couldn't find a board
                located at the specified URL.</p>
            <p class="fw-bold">It may have been
                moved, deleted, or may have never
                existed.</p>
            <a href="<?= $site_url ?>" class="btn btn-primary">Go back
                home</a>
        </div>
    </div>

    <div class="row" id="board-holder">

        <div class="col-md-3">

            <div class="ph-item mb-3">
                <div class="ph-col-12">
                    <div class="ph-row">
                        <div class="ph-col-12"
                             style="height:300px"></div>
                    </div>
                </div>
            </div>

            <div class="card sticky-top lz-load"
                 style="top:150px">
                <div class="card-body">

                    <span class="fa-stack ms-1"
                          style="font-size:22px">
                      <i class="fas fa-square fa-stack-2x text-primary"></i>
                      <i class="fas fa-stack-1x fa-inverse board-icon"></i>
                    </span>

                    <div class="mx-2 mt-2">
                        <h6 style="font-weight:700"
                            class="board-name"></h6>
                        <p class="small text-muted board-desc"></p>

                        <div class="row">
                            <div class="col">
                                <button type="button"
                                        class="btn btn-primary w-100 border btn-sm mb-2">
                                    <i class="far fa-plus me-2"></i>
                                    New post
                                </button>
                            </div>
                            <div class="col">
                                <button type="button"
                                        class="btn btn-light w-100 border btn-sm mb-2">
                                    <i class="far fa-rss me-2"></i>
                                    Subscribe
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


            <div class="row" id="post-wrapper">


                <div class="col">

                    <div class="ph-item mb-3">
                        <div class="ph-col-12">
                            <div class="ph-row">
                                <div class="ph-col-12"
                                     style="height:30px"></div>
                            </div>
                        </div>
                    </div>


                    <div class="mb-3 small lz-load">
                        <span class="float-start">
                        <p class="d-inline pe-0 text-muted">
                            <a href="<?= $site_url ?>" class="text-primary text-decoration-none">Boards</a>
                            <i class="fas fa-caret-right mx-2"></i>
                        </p>
                        <p class="d-inline pe-0 text-muted board-name">Feature Requests</p>
                            </span>

                        <p class="float-end"
                           id="toggle-sidebar"
                           role="button">
                            <i class="fas fa-right-from-line me-2"></i>
                            Options
                        </p>

                    </div>

                    <div class="clearfix"></div>


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

                    <div class="card no-posts-holder">
                        <div class="card-body p-5">
                            <h1>🦄</h1>
                            <h5>No posts to be found here...</h5>
                            <p>It appears no posts have been published to this board yet.</p>
                            <button type="button" class="btn btn-primary btn-sm px-4 me-2">
                                <i class="far fa-plus"></i>
                                New post</button>
                            <button type="button" class="btn btn-light border btn-sm px-4">
                                Go back</button>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush posts-list w-100 lz-load"></ul>

                    <div class="btm-hold text-center">
                    <button type="button"
                            class="btn btn-light px-5 border btn-sm mb-2 loadMore lz-load">
                        <i class="fas fa-plus me-2"></i>
                        Load more
                        </button>
                        <p class="text-muted small fst-italic">🎈 You've reached the end</p>
                </div>
                </div>

                <div class="col-md-4"
                     id="sidebar">

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
                                    Filter</p>

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
                                    Sort</p>

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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <span class="fa-stack ms-1 fa-2x">
                      <i class="fas fa-square fa-stack-2x text-primary"></i>
                      <i class="fas fa-stack-1x fa-inverse"></i>
                    </span>
                <h3>Please Sign In</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    let board_id = null;
    let boardSlug = '<?= $board_slug ?>';
</script>
<?php echo Render::footer(); ?>
<script src="<?= $site_url ?>/assets/js/board.js"></script>
</body>
</html>