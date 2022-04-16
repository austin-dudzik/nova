<?php
// Include config file
include "includes/config.php";

// Define required parameters
$board_slug = $_GET['board_slug'];

$board = Board::getBoard($board_slug);

$notFound = (isset($board->code) && $board->code === 204);

include "includes/logic/board.php";

?>
<!doctype html>
<html lang="en">
<?= Render::header() ?>
<body>
<?= Render::navigation() ?>
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
                <h5>Board Not Found</h5>
                <p>Sorry, we couldn't find a board located at the specified URL</p>
                <p class="fw-bold">The page may have been moved, deleted, or may have never existed.</p>
                <a href="<?= SITE_URL ?>"
                   class="btn btn-accent">Go back home</a>
            </div>
        </div>

        <div id="page">
            <p class="d-inline-block pe-0 text-muted mb-3">
                <a href="<?= SITE_URL ?>"
                   class="text-accent text-decoration-none">
                    Home
                </a>
                <i class="fas fa-caret-right mx-2"></i>
            </p>
            <p class="d-inline pe-0 text-muted board-name"></p>

            <div class="card shadow round">
                <div class="card-header bg-accent text-white p-5 round-top">

                    <div class="d-flex">
                        <div class="me-4">
                            <i class="fas fa-2x mb-3 board-icon mt-1"></i>
                        </div>
                        <div>
                            <h1 class="h5 board-name"></h1>
                            <p class="board-desc small mb-0"></p>
                            <p class="board-visibility mb-0 small mt-2"></p>
                        </div>
                    </div>

                </div>

                <div class="bg-light border-bottom px-5 py-3 d-flex justify-content-between">
                    <div class="nav nav-pills">
                        <a href="<?= SITE_URL ?>/new/<?= $_GET['board_slug'] ?>"
                           class="round nav-link small active">
                            <i class="far fa-plus me-2"></i> New suggestion
                        </a>
                        <?php if (isAdmin()) { ?>
                            <button class="nav-link small mx-0 pe-2 text-dark"
                                    data-bs-toggle="modal"
                                    data-bs-target="#manageBoard">
                                <i class="far fa-gear me-2"></i> Manage board
                            </button>
                        <?php } ?>
                    </div>


                    <?php if (isAdmin()) { ?>
                        <div class="modal fade" id="manageBoard">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow round">
                                    <div class="modal-header border-0 pb-0">
                                        <button type="button" class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body px-5">
                                <span class="fa-stack h6">
                                <i class="fa-solid fa-circle fa-stack-2x text-accent"></i>
                                <i class="far fa-gear fa-stack-1x text-white"></i>
                              </span>
                                        <h5>Manage Board</h5>
                                        <p class="small">Deleting a post is permanent and cannot be
                                            reversed. All upvotes and comments will also be
                                            removed.</p>

                                        <form method="post">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="board_name"
                                                           class="mb-2">Name</label>
                                                    <input type="text" name="name" id="board_name"
                                                           class="form-control mb-1"
                                                           value="<?= $_POST['name'] ?? $board->name ?>"
                                                           required>
                                                    <p class="small text-danger"><?= $name_err ?></p>

                                                    <label for="board_icon"
                                                           class="mb-2">Icon</label>
                                                    <input type="text" name="icon" id="board_icon"
                                                           class="form-control mb-1"
                                                           value="<?= $_POST['icon'] ?? $board->icon ?>">
                                                    <p class="small text-muted"> Available icons and
                                                        their names can be found on <a
                                                                href="https://fontawesome.com/icons"
                                                                target="_blank" class="link">Font
                                                            Awesome</a>. (i.e. <code>comments</code>)
                                                    </p>

                                                    <label for="board_slug"
                                                           class="mb-2">Slug</label>
                                                    <div class="input-group mb-1">
                                                        <span class="input-group-text bg-light small"><?= preg_replace("(^https?://)", "", SITE_URL) ?>/b/</span>
                                                        <input type="text" name="slug"
                                                               id="board_slug"
                                                               class="form-control"
                                                               value="<?= $_POST['slug'] ?? $board->slug ?>"
                                                               required>
                                                    </div>
                                                    <p class="small text-danger"><?= $slug_err ?></p>

                                                    <label for="board_desc"
                                                           class="mb-1">Description</label>
                                                    <textarea name="description" id="board_desc"
                                                              class="form-control mb-3"
                                                              rows="4"><?= $_POST['description'] ?? $board->description ?></textarea>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="d-block mb-1">Visibility</label>
                                                    <div id="visibility"
                                                         class="btn-group round mb-3"
                                                         role="group">
                                                        <input type="radio" class="btn-check"
                                                               name="visibility" id="public"
                                                               value="1" <?= $board->visibility === 1 ? 'checked' : '' ?>>
                                                        <label class="btn btn-outline-primary me-2"
                                                               for="public" data-toggle="tooltip"
                                                               data-bs-placement="top"
                                                               title="Visible & accessible to all users">
                                                            <i class="fas fa-eye me-2"></i> Public
                                                        </label>

                                                        <input type="radio" class="btn-check"
                                                               name="visibility" id="private"
                                                               value="2" <?= $board->visibility === 2 ? 'checked' : '' ?>>
                                                        <label class="btn btn-outline-primary me-2"
                                                               for="private" data-toggle="tooltip"
                                                               data-bs-placement="top"
                                                               title="Visible & accessible to only specified users">
                                                            <i class="fas fa-lock me-2"></i> Private
                                                        </label>

                                                        <input type="radio" class="btn-check"
                                                               name="visibility" id="unlisted"
                                                               value="0" <?= $board->visibility === 0 ? 'checked' : '' ?>>
                                                        <label class="btn btn-outline-primary"
                                                               for="unlisted" data-toggle="tooltip"
                                                               data-bs-placement="top"
                                                               title="Accessible by URL, but not visible on homepage">
                                                            <i class="fas fa-eye-slash me-2"></i>
                                                            Unlisted
                                                        </label>
                                                    </div>


                                                    <div id="rules-section"
                                                         style="display:<?= $board->visibility === 2 ? 'block' : 'none' ?>">
                                                        <label for="rules" class="mb-1">Invite users
                                                            via
                                                            email:</label>
                                                        <input type="text" name="rules" id="rules"
                                                               class="form-control mb-1"
                                                               value="<?= $_POST['rules'] ?? implode(',', json_decode($board->rules)) ?>"
                                                               placeholder="Email addresses, seperated by commas">
                                                        <p class="small">Need to allow users from an
                                                            entire
                                                            domain? Use an asterisk (*) in place
                                                            of
                                                            a name. (i.e. <code>*@acme.io</code>)
                                                        </p>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="mb-4 d-flex justify-content-between">

                                                <button type="submit" name="updateBoard"
                                                        class="btn bg-accent text-white me-1 round">Update board
                                                </button>

                                                <div>
                                                    <a href="#" data-bs-toggle="modal"
                                                       data-bs-target="#deleteBoard"
                                                       class="btn btn-outline-danger border round"><i
                                                                class="far fa-trash-alt me-2"></i>
                                                        Delete
                                                    </a>
                                                </div>

                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="deleteBoard">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow round">
                                    <div class="modal-header border-0 pb-0">
                                        <button type="button" class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body px-5">
                                <span class="fa-stack h6">
                                <i class="fa-solid fa-circle fa-stack-2x text-danger"></i>
                                <i class="far fa-exclamation-triangle fa-stack-1x text-white"></i>
                              </span>
                                        <h5>Delete Board</h5>
                                        <p class="small">Are you sure you want to delete this feedback board? All posts, upvotes, and comments associated with the content in this board will also be removed. This is irreversible.</p>

                                        <form method="post">
                                            <div class="mb-4 d-flex justify-content-between">
                                                <button type="submit" name="deleteBoard"
                                                        class="btn btn-danger me-1 round">Delete board
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                    <?php if (!$notFound) { ?>
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
                                            <input class="form-check-input" type="checkbox"
                                                   id="<?= $filter->id ?>"
                                                   value="<?= $filter->id ?>"
                                                   name="filter">
                                            <label class="form-check-label"
                                                   for="<?= $filter->id ?>">
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
                                        <input class="form-check-input" type="radio"
                                               id="new"
                                               value="new" name="sort" checked>
                                        <label class="form-check-label" for="new">
                                            New
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                               id="top"
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
                        <i class="fa-solid fa-circle fa-stack-2x text-accent"></i>
                        <i class="far fa-magnifying-glass fa-stack-1x text-white"></i>
                      </span>
                            </a>

                        </div>
                    <?php } ?>
                </div>


                <div class="bg-white border-bottom" id="searchHolder"
                     style="display:none">
                    <div class="input-icons input-group px-5" id="searchPageContainer">
                        <i class="far fa-magnifying-glass text-dark"></i>
                        <input class="search form-control ps-5" type="text"
                               id="searchPage"
                               placeholder="Search for ideas, updates, users, and more...">
                    </div>
                </div>

                <div class="card-body px-5">
                    <ul class="list-group list-group-flush posts-list"></ul>

                    <div id="posts-wrapper">

                        <div class="btm-hold text-center">
                            <button type="button"
                                    class="btn btn-light px-5 border btn-sm mb-2 loadMore">
                                <i class="fas fa-plus me-2"></i>
                                Load more
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
<?= Render::footer(); ?>
<script src="<?= SITE_URL ?>/assets/js/board.js"></script>
<?php if ($updateError) { ?>
    <script>
        $(document).ready(function () {
            $('#manageBoard').modal('show');
        });
    </script>
<?php } ?>

</body>
</html>