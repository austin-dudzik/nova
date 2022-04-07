<?php
// Include config file
include "includes/config.php";

// Define required parameters
$user_slug = $_GET['user_slug'];

?>
<!doctype html>
<html lang="en">
<?= Render::header() ?>
<body>
<?= Render::navigation() ?>

<div class="row mt-5">
    <div class="col"></div>
    <div class="col-md-6">


        <div class="p-4 card shadow rounded-lg d-none" style="border-radius:8px"
             id="404-holder">
            <div class="card-body text-center">
                Loading...
            </div>
        </div>


        <div id="user-holder">
            <p class="d-inline-block pe-0 text-muted mb-3">
                <a href="<?= Settings::getSettings("site_url") ?>"
                   class="text-accent text-decoration-none">Home</a>
                <i class="fas fa-caret-right mx-2"></i>
            </p>
            <p class="d-inline pe-0 text-muted">
                <a href="#" class="text-accent post-board text-decoration-none"></a>
                <i class="fas fa-caret-right mx-2"></i>
            </p>
            <p class="d-inline pe-0 text-muted post-title"></p>

            <p class="d-inline pe-0 text-muted board-name"></p>
            <div class="card shadow rounded-lg" style="border-radius:8px">
                <div class="card-header bg-accent text-white p-5"
                     style="border-top-left-radius:8px;border-top-right-radius:8px">

                    <div class="d-flex">
                        <img class="user-avatar rounded mb-3 me-3" height="70">

                        <div class="my-auto">
                            <h5 class="user-name"></h5>
                            <p class="user-username small text-muted"></p>
                        </div>
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
                            <p class="text-muted small fst-italic">
                                🎈 <?= __('reached_end') ?></p>
                        </div>

                    </div>

                    <p class="fw-bold mb-2">Description</p>
                    <p class="post-content mb-3"></p>

                    <p class="fw-bold mb-2">Voters</p>
                    <div class="d-flex">
                        <div class="d-inline-block" id="voterList"></div>

                        <div style="width:30px;height:30px;line-height:30px"
                             class="bg-light other-upvotes rounded-circle text-center small border"></div>
                    </div>

                </div>

            </div>
        </div>


        <div class="p-4 card shadow rounded-lg" style="display:none;border-radius:8px"
             id="404-holder">
            <div class="card-body">
                <h5>User Not Found</h5>
                <p>Sorry, we couldn't find a user
                    located at the specified URL.</p>
                <p class="fw-bold">The page may have
                    been
                    moved, deleted, or may have never
                    existed.</p>
                <a href="<?= Settings::getSettings("site_url") ?>"
                   class="btn btn-accent">Go back
                    home</a>
            </div>
        </div>


        <div class="card no-posts-holder">
            <div class="card-body p-5">
                <h1>🦄</h1>
                <h5>No posts to be
                    found here...</h5>
                <p>It appears no posts
                    have been
                    published to this
                    board yet.</p>
                <button type="button"
                        class="btn btn-accent btn-sm px-4 me-2">
                    <i class="far fa-plus"></i>
                    New post
                </button>
                <button type="button"
                        class="btn btn-light border btn-sm px-4">
                    Go back
                </button>
            </div>
        </div>

    </div>
    <div class="col"></div>
</div>
<script>
    let user_id = null;
    let userSlug = '<?= $user_slug ?>';
</script>
<?= Render::footer(); ?>
<script src="<?= Settings::getSettings("site_url") ?>/assets/js/user.js"></script>
</body>
</html>