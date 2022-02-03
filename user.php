<?php
// Start session
session_start();
// Include config file
include "includes/config.php";

// Define required parameters
$user_slug = $_GET['user_slug'];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Loading...</title>
    <link rel="stylesheet"
          href="<?= $site_url ?>/assets/libs/bootstrap-5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="<?= $site_url ?>/assets/libs/font-awesome-v6.0.0-beta3/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet"
          href="<?= $site_url ?>/assets/libs/simplemde/css/simplemde.min.css">
    <link rel="stylesheet"
          href="<?= $site_url ?>/assets/css/styles.css">
</head>
<body>

<?php include "includes/navigation.php" ?>

<div class="container my-5 px-5">

    <div class="card w-50 mx-auto p-4"
         id="404-holder" style="display:none">
        <div class="card-body">
            <h5>User Not Found</h5>
            <p>Sorry, we couldn't find a user
                located at the specified URL.</p>
            <p class="fw-bold">The page may have been
                moved, deleted, or may have never
                existed.</p>
            <a href="<?= $site_url ?>"
               class="btn btn-primary">Go back
                home</a>
        </div>
    </div>

    <div class="row" id="user-holder">

        <div class="col-md-4">

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
                <div class="card-body p-4">

                    <img class="user-avatar rounded mb-3"
                         height="70">

                    <h5 class="user-name"></h5>
                    <p class="user-username small text-muted"></p>

                    <div class="mx-2 mt-2">
                        <h6 style="font-weight:700"
                            class="board-name"></h6>
                        <p class="small text-muted board-desc"></p>


                                <button type="button"
                                        class="btn btn-light w-100 border btn-sm mb-2">
                                    <i class="fas fa-pencil me-2"></i>
                                    Edit profile
                                </button>

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


                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Posts</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Upvotes</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Favorites</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">...</div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
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
                            <h5>No posts to be
                                found here...</h5>
                            <p>It appears no posts
                                have been
                                published to this
                                board yet.</p>
                            <button type="button"
                                    class="btn btn-primary btn-sm px-4 me-2">
                                <i class="far fa-plus"></i>
                                New post
                            </button>
                            <button type="button"
                                    class="btn btn-light border btn-sm px-4">
                                Go back
                            </button>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush posts-list w-100 lz-load"></ul>

                    <div class="btm-hold text-center">
                        <button type="button"
                                class="btn btn-light px-5 border btn-sm mb-2 loadMore lz-load">
                            <i class="fas fa-plus me-2"></i>
                            Load more
                        </button>
                        <p class="text-muted small fst-italic">
                            🎈 You've reached the
                            end</p>
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
                <h5 class="modal-title"
                    id="exampleModalLabel"></h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <span class="fa-stack ms-1 fa-2x">
                      <i class="fas fa-square fa-stack-2x text-primary"></i>
                      <i class="fas fa-stack-1x fa-inverse"></i>
                    </span>
                <h3>Please Sign In</h3>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button"
                        class="btn btn-primary">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>

<footer class="bg-light border text-center py-4">
    <div class="container px-5">
        <p class="float-start mb-0">
            &copy; <?= date('Y') ?> Hexagonal, all
            rights reserved.</p>
        <p class="float-end mb-0">🚀 Powered by
            Nova</p>
        <div class="clearfix"></div>
    </div>
</footer>

<script>
    let site_name = '<?= $site_name ?>';
    let user_id = null;
    let csrf_token = '<?= generate_token() ?>';
    let userSlug = '<?= $user_slug ?>';
</script>

<script src="<?= $site_url ?>/assets/libs/jquery/jquery-3.6.0.min.js"></script>
<script src="<?= $site_url ?>/assets/libs/bootstrap-5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="<?= $site_url ?>/assets/libs/simplemde/js/simplemde.min.js"></script>
<script src="<?= $site_url ?>/assets/js/main.js"></script>
<script src="<?= $site_url ?>/assets/js/user.js"></script>

</body>
</html>