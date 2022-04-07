<?php
// Include config file
include "includes/config.php";

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
<body class="bg-light">
<?php echo Render::navigation(); ?>

<div class="row mt-5">
    <div class="col"></div>
    <div class="col-md-6">
            <p class="d-inline-block pe-0 text-muted mb-3">
                <a href="<?= Settings::getSettings("site_url") ?>" class="text-accent text-decoration-none">Home</a>
                <i class="fas fa-caret-right mx-2"></i>
            </p>
            <p class="d-inline pe-0 text-muted">
                <a href="#" class="text-accent post-board text-decoration-none"></a>
                <i class="fas fa-caret-right mx-2"></i>
            </p>
            <p class="d-inline pe-0 text-muted post-title"></p>

        <p class="d-inline pe-0 text-muted board-name"></p>
        <div class="card shadow rounded-lg" style="border-radius:8px">
            <div class="card-header bg-accent text-white p-5" style="border-top-left-radius:8px;border-top-right-radius:8px">

                <div class="d-flex" id="post-wrapper">
                    <div class="me-1">

                        <div class="upvote">
                            <button class="btn border px-3">
                                <i class="fas fa-caret-up d-block"></i>
                                <p class="mb-0">0</p>
                            </button>
                        </div>

                    </div>
                    <div>

                        <h4 style="font-weight:700" class="post-title"></h4>

                        <p class="small"><span class="post-date"> &centerdot;

                        <a href="#" class="small text-decoration-none" id="post-status"></a>

                        </p>

                        <div class="mb-0">
                            <img src="https://gravatar.com/avatar/<?php echo md5("austin.dudzik@gmail.com") ?>"
                                 class="rounded-circle me-1"
                                 style="width:25px;height:25px;font-weight:700">
                            <span class="mb-0">Austin Dudzik</span>
                        </div>

                    </div>

                </div>


            </div>
            <div class="card-body px-5">

                <p class="fw-bold mb-2">Description</p>
                <p class="post-content mb-3"></p>

                <p class="fw-bold mb-2">Voters</p>
                <div class="d-flex">
                <div class="d-inline-block" id="voterList"></div>

                <div style="width:30px;height:30px;line-height:30px" class="bg-light other-upvotes rounded-circle text-center small border"></div>
                </div>

            </div>

            <div class="bg-light border-top p-4">
                <div class="toggle-co-area">
                    <div class="card"
                         id="leave-comment">
                        <div class="card-body text-muted py-2"
                             style="font-size:14px">
                            Leave a comment...
                        </div>
                    </div>
                </div>

                <div id="comment-area" style="display:none">
                        <textarea id="editor"></textarea>
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

        </div>
    </div>
    <div class="col"></div>
</div>

<script>
    let post_id = null;
    let post_slug = '<?= $_GET['post_slug'] ?>';
</script>
<?php echo Render::footer(); ?>
<script src="<?= Settings::getSettings("site_url") ?>/assets/js/post.js"></script>
</body>
</html>