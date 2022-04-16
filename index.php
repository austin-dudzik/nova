<?php
// Include config file
include "includes/config.php";

include "includes/logic/feed.php";

?>
<!doctype html>
<html lang="en">
<?= Render::header('Feed'); ?>
<body>
<?= Render::navigation(); ?>
<div class="row my-5 mb-3">
    <div class="col"></div>
    <div class="col-md-6">

        <!-- Page loader -->
        <div class="card border-0" id="loading">
            <div class="card-body p-4 text-center">
                Loading...
            </div>
        </div>

        <div id="page">
            <div class="card shadow round">
                <div class="card-header bg-accent text-white p-5"
                     style="border-top-left-radius:8px;border-top-right-radius:8px">
                    <h1 class="h3 "><?= Settings::getSettings('site_title') ?></h1>
                    <p class="mb-0 small"><?= Settings::getSettings('site_desc') ?></p>
                </div>

                <div class="bg-light border-bottom px-5 py-3 d-flex justify-content-between">
                    <nav>
                        <div class="nav nav-pills" id="boardsBtn" role="tablist">
                            <button class="nav-link small active round" data-bs-toggle="tab"
                                    data-bs-target="#boards" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="d-inline me-2"
                                     style="height:20px;width:20px"
                                     viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path d="M2 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zM8 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H9a1 1 0 01-1-1V4zM15 3a1 1 0 00-1 1v12a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-2z"/>
                                </svg>
                                Boards
                            </button>
                            <button class="nav-link small round" id="roadmapBtn" data-bs-toggle="tab"
                                    data-bs-target="#roadmap" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="d-inline me-2"
                                     style="height:20px;width:20px"
                                     viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z"
                                          clip-rule="evenodd"/>
                                </svg>
                                Roadmap
                            </button>
                        </div>
                    </nav>
                    <div class="my-auto">
                        <a href="#" id="toggleSearch" class="text-dark text-decoration-none">
                     <span class="fa-stack" data-toggle="tooltip" data-bs-placement="left"
                           title="Search <?= Settings::getSettings('site_title') ?>">
                        <i class="fa-solid fa-circle fa-stack-2x text-accent"></i>
                        <i class="far fa-magnifying-glass fa-stack-1x text-white"></i>
                     </span>
                        </a>
                        <?php if (isAdmin()) { ?>
                        <div class="dropdown d-inline-block">
                            <a href="#" class="text-dark text-decoration-none"
                               data-bs-toggle="dropdown">
                     <span class="fa-stack" data-toggle="tooltip" data-bs-placement="left"
                           title="New">
                        <i class="fa-solid fa-circle fa-stack-2x text-dark"></i>
                        <i class="far fa-plus fa-stack-1x text-white"></i>
                     </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">

                                <li><a href="#" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#createBoard">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="d-inline me-2"
                                         style="height:20px;width:20px"
                                         viewBox="0 0 20 20"
                                         fill="currentColor">
                                        <path d="M2 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zM8 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H9a1 1 0 01-1-1V4zM15 3a1 1 0 00-1 1v12a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-2z"/>
                                    </svg>
                                    Board
                                </a></li>
                                <hr class="my-2">
                                <li><a href="#" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#createStatus"><i
                                            class="fas fa-tag me-3 fa-flip-horizontal"></i> Status
                                </a></li>

                            </ul>
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="bg-white border-bottom" id="searchHolder" style="display:none">
                    <div class="input-icons input-group px-5" id="searchPageContainer">
                        <i class="far fa-magnifying-glass text-dark"></i>
                        <input class="search form-control ps-5" type="text" id="searchPage"
                               placeholder="Search for ideas, updates, users, and more...">
                    </div>
                </div>

                <div class="card-body px-5">
                    <div class="tab-content mt-3">
                        <div class="tab-pane fade show active" id="boards">
                            <div class="row" id="boards-container"></div>
                        </div>
                        <div class="tab-pane fade" id="roadmap">
                            <div class="row" id="feed-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col"></div>

    <!-- Create Board Modal -->
    <div class="modal fade" id="createBoard">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow round">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body px-5">
                                <span class="fa-stack h6">
                                <i class="fa-solid fa-circle fa-stack-2x text-accent"></i>
                                <i class="far fa-plus fa-stack-1x text-white"></i>
                              </span>
                    <h5>New Board</h5>
                    <p class="small">Boards allow you to easily categorize feedback by their
                        type.</p>
                    <form method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="board_name" class="mb-2">Name</label>
                                <input type="text" name="name" id="board_name"
                                       class="form-control mb-1" value="<?= $_POST['name'] ?? '' ?>"
                                       required>
                                <p class="small text-danger"><?= $name_err ?></p>

                                <label for="board_icon" class="mb-2">Icon</label>
                                <input type="text" name="icon" id="board_icon"
                                       class="form-control mb-1"
                                       value="<?= $_POST['icon'] ?? '' ?>">
                                <p class="small text-muted"> Available icons and their names can be
                                    found on <a href="https://fontawesome.com/icons" target="_blank"
                                                class="link">Font Awesome</a>. (i.e.
                                    <code>comments</code>)</p>

                                <label for="board_slug" class="mb-2">Slug</label>
                                <div class="input-group mb-1">
                                    <span class="input-group-text bg-light small"><?= preg_replace("(^https?://)", "", SITE_URL) ?>/b/</span>
                                    <input type="text" name="slug" id="board_slug"
                                           class="form-control" value="<?= $_POST['slug'] ?? '' ?>"
                                           required>
                                </div>
                                <p class="small text-danger"><?= $slug_err ?></p>

                                <label for="board_desc" class="mb-1">Description</label>
                                <textarea name="description" id="board_desc"
                                          class="form-control mb-3"
                                          rows="4"><?= $_POST['description'] ?? '' ?></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="feed_type" class="d-block mb-1">Visibility</label>
                                <div id="visibility" class="btn-group round mb-3" role="group">
                                    <input type="radio" class="btn-check" name="visibility"
                                           id="public" value="1" checked>
                                    <label class="btn btn-outline-primary me-2" for="public"
                                           data-toggle="tooltip" data-bs-placement="top"
                                           title="Visible & accessible to all users">
                                        <i class="fas fa-eye me-2"></i> Public
                                    </label>

                                    <input type="radio" class="btn-check" name="visibility"
                                           id="private" value="2">
                                    <label class="btn btn-outline-primary me-2" for="private"
                                           data-toggle="tooltip" data-bs-placement="top"
                                           title="Visible & accessible to only specified users">
                                        <i class="fas fa-lock me-2"></i> Private
                                    </label>

                                    <input type="radio" class="btn-check" name="visibility"
                                           id="unlisted" value="0">
                                    <label class="btn btn-outline-primary" for="unlisted"
                                           data-toggle="tooltip" data-bs-placement="top"
                                           title="Accessible by URL, but not visible on homepage">
                                        <i class="fas fa-eye-slash me-2"></i> Unlisted
                                    </label>
                                </div>


                                <div id="rules-section" style="display:none">
                                    <label for="rules" class="mb-1">Invite users via email:</label>
                                    <input type="text" name="rules" id="rules"
                                           class="form-control mb-1"
                                           value="<?= $_POST['rules'] ?? '' ?>"
                                           placeholder="Email addresses, seperated by commas">
                                    <small>
                                        <p>Need to allow users from an entire domain? Use an
                                            asterisk (*) in place of a name. (i.e.
                                            <code>*@acme.io</code>)</p>
                                    </small>
                                </div>


                            </div>
                        </div>

                        <div class="mb-4">

                            <button type="submit" name="createBoard"
                                    class="btn bg-accent text-white me-1 round">Create board
                            </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Status Modal -->
<div class="modal fade" id="createStatus">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow round">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body px-5">
                                <span class="fa-stack h6">
                                <i class="fa-solid fa-circle fa-stack-2x text-accent"></i>
                                <i class="far fa-plus fa-stack-1x text-white"></i>
                              </span>
                <h5>New Status</h5>
                <p class="small">Boards allow you to easily categorize feedback by their
                    type.</p>

                <form method="post">
                    <label for="statusName">Name</label>
                    <input type="text" class="form-control mb-2" name="statusName" id="statusName"
                           value="<?= $_POST['statusName'] ?? '' ?>">
                    <p class="small text-danger"><?= $statusName_err ?></p>
                    <label for="statusColor">Color</label>
                    <input type="color" class="form-control mb-3" name="statusColor" id="statusColor"
                           value="<?= $_POST['statusColor'] ?? '' ?>">
                    <button type="submit" name="createStatus" class="btn bg-accent text-white round border">Create status
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
</div>


<?= Render::footer(); ?>
<script src="<?= SITE_URL ?>/assets/js/feed.js"></script>
<?php if ($createError) { ?>
    <script>
        $(document).ready(function () {
            $('#createBoard').modal('show');
        });
    </script>
<?php } ?>
<?php if ($statusCreateError) { ?>
    <script>
        $(document).ready(function () {
            $('#createStatus').modal('show');
        });
    </script>
<?php } ?>
<?php if ($updateError) { ?>
    <script>
        $(document).ajaxStop(function () {
            $("#roadmapBtn").trigger("click");
            $('#editStatus<?= $_POST['id'] ?>').modal('show');
            $('#name-<?= $_POST['id'] ?>').val('<?= $_POST['name'] ?>');
            $('#color-<?= $_POST['id'] ?>').val('<?= $_POST['color'] ?>');
            $('#nameError<?= $_POST['id'] ?>').show();
        });
    </script>
<?php } ?>
</body>
</html>