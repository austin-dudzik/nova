<?php
// Start session
session_start();
// Include config file
include "includes/config.php";

require_once "classes/Render.php";

// Define required parameters
$post_slug = $_GET['post_slug'];

function slugify ($string) {
    $string = utf8_encode($string);
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    $string = preg_replace('/[^a-z0-9- ]/i', '', $string);
    $string = str_replace(' ', '-', $string);
    $string = trim($string, '-');
    $string = strtolower($string);

    if (empty($string)) {
        return 'n-a';
    }

    return $string;
}

//echo slugify("Add the ability to add new tag's to already existing posts.");

?>
<!doctype html>
<html lang="en">
<?php echo Render::header(); ?>
<body>

<?php include "includes/navigation.php" ?>

<div class="container my-5 px-5">

    <div class="card w-75 mx-auto p-4" id="404-holder" style="display:none">
        <div class="card-body">
            <h5>Post Not Found</h5>
            <p>Sorry, we couldn't find a post located at the specified URL.</p>
            <p class="fw-bold">It may have been moved, deleted, or may have never existed.</p>
            <a href="<?= $site_url ?>" class="btn btn-accent">Go back home</a>
        </div>
    </div>

    <div class="row" id="post-holder">


        <div class="col-md-3">

            <div class="ph-item mb-3">
                <div class="ph-col-12">
                    <div class="ph-row">
                        <div class="ph-col-12" style="height:125px"></div>
                    </div>
                </div>
            </div>

            <div class="card" style="background:#eee">
                <div class="card-body text-muted">
                    <h6 style="font-weight:500;font-size:14px">Voters</h6>
                    <ul class="list-group list-group-flush" id="voterList"></ul>
                </div>
            </div>

            <?php if(isAdmin()) { ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mt-2 small">Admin Tools</h6>
                </div>
                    <div class="card-body">
                    <p class="small"><i class="fas fa-pencil me-2"></i> Edit Post</p>
                    <p class="small"><i class="fas fa-comment-slash me-2"></i> Disable Comments</p>
                    <p class="small"><i class="fas fa-eye-slash me-2"></i> Make Private</p>
                    <p class="small text-danger"><i class="fas fa-trash me-2 text-danger"></i> Delete Post</p>
                </div>
            </div>
            <?php } ?>

        </div>
        <div class="col ms-3">

            <div class="row" id="post-wrapper">
                <div class="col-md-1">

                    <div class="ph-item mb-3">
                        <div class="ph-col-12">
                            <div class="ph-row">
                                <div class="ph-col-12" style="height:52px"></div>
                            </div>
                        </div>
                    </div>

                    <div class="ph-item mb-3">
                        <div class="ph-col-12">
                            <div class="ph-row">
                                <div class="ph-col-12" style="height:36px"></div>
                            </div>
                        </div>
                    </div>

                    <div class="upvote">
                        <button class="btn border px-3">
                        <i class="fas fa-caret-up d-block"></i>
                        <p class="mb-0">0</p>
                        </button>
                    </div>

                    <button class="btn border px-3 mt-3 lz-load" id="favoritePost">
                        <i class="far fa-star d-block py-1"></i>
                    </button>

                </div>
                <div class="col-md-10">


                    <div class="ph-item m-0 p-0 border-0 mb-3">
                        <div class="ph-col-12 m-0 p-0">
                            <div class="ph-row m-0 p-0">
                                <div class="ph-col-4"
                                     style="height:20px"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row d-inline-block mb-3 small">
                        <p class="d-inline pe-0 text-muted">
                            <a href="<?= $site_url ?>" class="text-accent text-decoration-none">Home</a>
                            <i class="fas fa-caret-right ms-2"></i>
                        </p>
                        <p class="d-inline pe-0 text-muted">
                            <a href="#" class="text-accent post-board text-decoration-none"></a>
                            <i class="fas fa-caret-right ms-2"></i>
                        </p>
                        <p class="d-inline pe-0 text-muted post-title"></p>
                    </div>


                    <div class="ph-item m-0 p-0 border-0 mb-3">
                        <div class="ph-col-12 m-0 p-0">
                            <div class="ph-row m-0 p-0">
                                <div class="ph-col-10 m-0 p-0"
                                     style="height:30px"></div>
                            </div>
                        </div>
                    </div>

                    <h4 style="font-weight:700"
                        class="post-title"></h4>

                    <a href="#"
                       class="small text-decoration-none"
                       style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase"
                       id="post-status"></a>


                    <div class="ph-item mb-4">
                        <div class="ph-col-12">
                            <div class="ph-row">
                                <div class="ph-col-12"
                                     style="height:15px"></div>
                                <div class="ph-col-12"
                                     style="height:15px"></div>
                                <div class="ph-col-12"
                                     style="height:15px"></div>
                                <div class="ph-col-12"
                                     style="height:15px"></div>
                                <div class="ph-col-12"
                                     style="height:15px"></div>
                                <div class="ph-col-12"
                                     style="height:15px"></div>
                                <div class="ph-col-12"
                                     style="height:15px"></div>
                                <div class="ph-col-12"
                                     style="height:15px"></div>
                            </div>
                        </div>
                    </div>


                    <p class="post-content"></p>

                    <div class="mb-4">
                        <img src="https://gravatar.com/avatar/<?php echo md5("austin.dudzik@gmail.com") ?>"
                             class="rounded-circle"
                             style="width:25px;height:25px;font-weight:700">
                        <span class="mb-0">Austin Dudzik</span>
                    </div>
                    <div class="toggle-co-area">
                        <div class="card"
                             id="leave-comment">
                            <div class="card-body text-muted py-2"
                                 style="font-size:14px">
                                Leave a comment...
                            </div>
                        </div>
                    </div>

                    <div id="comment-area"
                         style="display:none">
                        <textarea
                                id="editor"></textarea>
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

                <div class="border-bottom my-4"></div>

                <div>
                    <div clas="float-start">
                        Comments
                    </div>
                    <div class="float-end">
                        hi
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    let post_id = null;
    let post_slug = '<?= $_GET['post_slug'] ?>';
</script>
<?php echo Render::footer(); ?>
<script src="<?= $site_url ?>/assets/js/post.js"></script>
</body>
</html>