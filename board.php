<?php
// Include config file
include "includes/config.php";

// Define required parameters
$board_slug = $_GET['board_slug'];
//$sort_by = $_GET['sort'];

?>
<!doctype html>
<html lang="en">
<?php echo Render::header(); ?>
<body>
<?php echo Render::navigation('board'); ?>


<div class="row mt-5">
    <div class="col"></div>
    <div class="col-md-6">

        <div class="card border-0" id="loading">
            <div class="card-body p-4 text-center">
                Loading...
            </div>
        </div>

        <div id="page">
            <p class="d-inline-block pe-0 text-muted mb-3">
                <a href="<?= Settings::getSettings("site_url") ?>"
                   class="text-accent text-decoration-none">
                    Home
                </a>
                <i class="fas fa-caret-right mx-2"></i>
            </p>
            <p class="d-inline pe-0 text-muted board-name"></p>
        <div class="card shadow rounded-lg" style="border-radius:8px">
            <div class="card-header bg-accent text-white p-5" style="border-top-left-radius:8px;border-top-right-radius:8px">
                <?php if(isAdmin()) { ?>
                <div class="d-flex justify-content-end small">
                    <div><i class="fas fa-gear me-1"></i> Manage board</div>
                </div>
                <?php } ?>
                <i class="fas fa-2x mb-3 board-icon"></i>
                <h1 class="h5 board-name"></h1>
                <p class="board-desc small mb-0"></p>
            </div>


            <div class="bg-light border-bottom px-5 py-3 d-flex justify-content-between">
                    <div class="nav nav-pills">
                        <button class="nav-link small active" style="border-radius:8px">
                            <i class="far fa-plus me-2"></i> New suggestion
                        </button>
                    </div>
                <a href="#" id="toggleSearch" class="my-auto text-dark">
                     <span class="fa-stack" data-toggle="tooltip" data-bs-placement="left"
                           title="Search <?= Settings::getSettings('site_title') ?>">
    <i class="fa-solid fa-circle fa-stack-2x"></i>
    <i class="far fa-magnifying-glass fa-stack-1x text-white"></i>
  </span>
                </a>
            </div>


            <div class="card-body px-5">
                    <ul class="list-group list-group-flush posts-list"></ul>


                <div id="posts-wrapper">

                    <div class="btm-hold text-center">
                        <button type="button" class="btn btn-light px-5 border btn-sm mb-2 loadMore">
                            <i class="fas fa-plus me-2"></i>
                            <?= __("load_more") ?>
                        </button>
                        <p class="text-muted small fst-italic">
                            🎈 <?= __('reached_end') ?></p>
                    </div>

                </div>


            </div>
        </div>
        </div>
    </div>
    <div class="col"></div>
</div>

<div class="container-fluid p-0 my-md-5 px-md-5">

    <div class="row" id="board-holder">

        <div class="col m-3 m-md-0 ms-md-3">

                <div class="col-md-4" id="sidebar">

                    <div class="sticky-top lz-load"
                         style="top:150px">
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="fw-bold mb-2 small">
                                    <i class="fas fa-filter text-muted me-2"></i>
                                    <?= __("filter") ?>
                                </p>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="one" value="1" name="filter">
                                    <label class="form-check-label" for="one">
                                        Under
                                        Review
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="two" value="2" name="filter">
                                    <label class="form-check-label" for="two">
                                        Planned
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="three" value="3" name="filter">
                                    <label class="form-check-label" for="three">
                                        Fixed
                                    </label>
                                </div>


                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <p class="fw-bold mb-2 small">
                                    <i class="fas fa-circle-sort text-muted me-2"></i>
                                    <?= __("sort") ?>
                                </p>

                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           id="exampleRadios1"
                                           value="new"
                                           name="sort"
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
                                           name="sort"
                                           value="top">
                                    <label class="form-check-label"
                                           for="exampleRadios2">
                                        Top
                                    </label>
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