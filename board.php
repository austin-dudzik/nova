<?php
// Include config file
include "includes/config.php";

// Define required parameters
$board_slug = $_GET['board_slug'];

$board = Board::getBoard($board_slug);

if (isset($_POST['updateBoard'])) {
    Board::updateBoard($board->board_id, $_POST['name'], $_POST['icon'], $_POST['description']);
}

?>
<!doctype html>
<html lang="en">
<?php echo Render::header() ?>
<body>
<?php echo Render::navigation() ?>
<div class="row mt-5">
    <div class="col"></div>
    <div class="col-md-6">

        <!-- Loading -->
        <div class="card border-0" id="loading">
            <div class="card-body p-4 text-center">
                Loading...
            </div>
        </div>

        <div class="card p-4" id="board-not-found" style="display:none">
            <div class="card-body">
                <h5><?= __('board_not_found') ?></h5>
                <p><?= __('board_not_found_msg') ?></p>
                <p class="fw-bold"><?= __('not_found_reason') ?></p>
                <a href="<?= Settings::getSettings('site_url') ?>>" class="btn btn-accent"><?= __('return_home') ?></a>
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
                <div class="card-header bg-accent text-white p-5"
                     style="border-top-left-radius:8px;border-top-right-radius:8px">
                    <i class="fas fa-2x mb-3 board-icon"></i>
                    <h1 class="h5 board-name"></h1>
                    <p class="board-desc small mb-0"></p>
                </div>

                <div class="bg-light border-bottom px-5 py-3 d-flex justify-content-between">
                    <div class="nav nav-pills">
                        <a href="<?= Settings::getSettings('site_url') ?>/new/<?= $_GET['board_slug'] ?>" class="round nav-link small active">
                            <i class="far fa-plus me-2"></i> New suggestion
                        </a>
                        <?php if (isAdmin()) { ?>
                            <button class="nav-link small mx-0 pe-2" data-bs-toggle="modal" data-bs-target="#manageBoard">
                                <i class="far fa-gear me-2"></i> Manage board
                            </button>
                        <?php } ?>
                    </div>


                    <div class="modal fade" id="manageBoard">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow">
                                <div class="modal-header border-0 pb-0">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-5">
                                <span class="fa-stack h6">
                                <i class="fa-solid fa-circle fa-stack-2x text-accent"></i>
                                <i class="far fa-pencil fa-stack-1x text-white"></i>
                              </span>
                                    <h5>Edit Board</h5>
                                    <p class="small">Deleting a post is permanent and cannot be
                                        reversed. All upvotes and comments will also be removed.</p>
                                    <form method="post">
                                        <label for="board_name">Name</label>
                                        <input type="text" name="name" id="board_name" class="form-control mb-2" required>
                                        <label for="board_icon">Icon</label>
                                        <input type="text" name="icon" id="board_icon" class="form-control mb-2" required>
                                        <label for="board_desc">Description</label>
                                        <textarea name="description" id="board_desc" class="form-control mb-3" rows="4" required></textarea>
                                    <div class="mb-4 d-flex justify-content-between">

                                        <div>
                                            <button type="submit" name="updateBoard"
                                                    class="btn bg-accent text-white me-1"
                                                    style="border-radius:8px">Update board
                                            </button>
                                        </div>
                                    </form>

                                    <div>
                                            <button type="button" class="btn btn-outline-danger border"
                                                    style="border-radius:8px"><i class="far fa-trash-alt me-2"></i> Delete
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div>

                        <div class="dropdown d-inline-block">
                 <span class="fa-stack fa-2x iconCircle" data-bs-toggle="dropdown"
                       data-toggle="tooltip" data-bs-placement="left" title="Filter">
                      <i class="fas fa-circle fa-stack-2x"></i>
                      <i class="fas fa-filter fa-stack-1x fa-inverse"></i>
                 </span>

                            <div class="dropdown-menu dropdown-menu-end p-3">
                                <p class="mb-2">Filter</p>


                                <?php foreach (Status::getStatuses() as $filter) { ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="<?= $filter->slug ?>"
                                               value="<?= $filter->id ?>"
                                               name="filter">
                                        <label class="form-check-label" for="<?= $filter->slug ?>">
                                            <?= $filter->name ?>
                                        </label>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                 <span class="fa-stack fa-2x iconCircle" data-bs-toggle="dropdown"
                       data-toggle="tooltip" data-bs-placement="left"
                       title="Sort">
                      <i class="fas fa-circle fa-stack-2x"></i>
                      <i class="fas fa-sort fa-stack-1x fa-inverse"></i>
                 </span>

                            <div class="dropdown-menu dropdown-menu-end p-3">
                                <p class="mb-2">Sort</p>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="new"
                                           value="new" name="sort" checked>
                                    <label class="form-check-label" for="new">
                                        New
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="top"
                                           value="top" name="sort">
                                    <label class="form-check-label" for="top">
                                        Top
                                    </label>
                                </div>

                            </div>
                        </div>

                        <a href="#" id="toggleSearch" class="my-auto text-dark">
                     <span class="fa-stack" data-toggle="tooltip" data-bs-placement="left"
                           title="Search <?= Settings::getSettings('site_title') ?>">
                        <i class="fa-solid fa-circle fa-stack-2x"></i>
                        <i class="far fa-magnifying-glass fa-stack-1x text-white"></i>
                      </span>
                        </a>

                    </div>
                </div>


                <div class="bg-white border-bottom" id="searchHolder" style="display:none">
                    <div class="input-icons input-group px-5" id="searchPageContainer">
                        <i class="far fa-magnifying-glass text-dark"></i>
                        <input class="search form-control ps-5" type="text" id="searchPage"
                               placeholder="<?= __('search_text') ?>">
                    </div>
                </div>

                <div class="card-body px-5">
                    <ul class="list-group list-group-flush posts-list"></ul>

                    <div id="posts-wrapper">

                        <div class="btm-hold text-center">
                            <button type="button"
                                    class="btn btn-light px-5 border btn-sm mb-2 loadMore">
                                <i class="fas fa-plus me-2"></i>
                                <?= __("load_more") ?>
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
    let board_id = null;
    let boardSlug = '<?= $board_slug ?>';
</script>
<?php echo Render::footer(); ?>
<script src="<?= Settings::getSettings("site_url") ?>/assets/js/board.js"></script>
</body>
</html>