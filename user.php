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


        <!-- Page loader -->
        <div class="card border-0 bg-transparent" id="loading">
            <div class="card-body p-4 text-center">
                Loading...
            </div>
        </div>


        <div id="user-holder">
            <p class="d-inline-block pe-0 text-muted mb-3">
                <a href="<?= SITE_URL ?>"
                   class="text-accent text-decoration-none">Home</a>
                <i class="fas fa-caret-right mx-2"></i>
            </p>
            <p class="d-inline pe-0 text-muted user-name"></p>

            <p class="d-inline pe-0 text-muted board-name"></p>
            <div class="card shadow round">
                <div class="card-header bg-accent text-white p-5 round-top">

                    <div class="d-flex">
                        <img class="user-avatar round mb-3 me-3" height="70">

                        <div class="my-auto">
                            <h5 class="user-name"></h5>
                            <p class="user-username small"></p>
                        </div>
                    </div>

                </div>


                <div class="bg-light border-bottom px-5 py-3 d-flex justify-content-between">
                    <div class="nav nav-pills">
                        <?php if((isset($user) && $user_slug === $user->username) || isAdmin()) { ?>
                        <a href="<?= SITE_URL ?>/account/<?= $user_slug ?>"
                           class="round nav-link small active">
                            <i class="far fa-pencil me-2"></i> Edit profile
                        </a>
                        <?php } ?>
                    </div>
                    <div>
                        <a href="#" id="toggleSearch" class="my-auto text-dark">
                     <span class="fa-stack" data-toggle="tooltip" data-bs-placement="left"
                           title="Search <?= Settings::getSettings('site_title') ?>">
                        <i class="fa-solid fa-circle fa-stack-2x text-accent"></i>
                        <i class="far fa-magnifying-glass fa-stack-1x text-white"></i>
                      </span>
                        </a>
                    </div>
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

                    <div class="p-4 no-posts-holder d-none-ni">
                        <i class="far fa-comments text-muted fa-2x mb-3"></i>
                        <h6>Looks like there's no feedback yet</h6>
                        <p>This user has yet to share feedback. Once they do, it'll show up here.</p>
                    </div>

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


        <div class="p-4 card shadow round" style="display:none"
             id="404-holder">
            <div class="card-body">
                <h5>User Not Found</h5>
                <p>Sorry, we couldn't find a user
                    located at the specified URL.</p>
                <p class="fw-bold">The page may have
                    been
                    moved, deleted, or may have never
                    existed.</p>
                <a href="<?= SITE_URL ?>"
                   class="btn btn-accent">Go back
                    home</a>
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
<script src="<?= SITE_URL ?>/assets/js/user.js"></script>
</body>
</html>