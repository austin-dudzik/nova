<?php
// Include config file
include "includes/config.php";

if(!isAdmin()){
    header("location: index.php");
}

include "includes/logic/settings.php";

?>
<!doctype html>
<html lang="en">
<?= Render::header('Settings') ?>
<body>
<?= Render::navigation() ?>
<div class="row mt-5">
    <div class="col"></div>
    <div class="col-md-6">

        <div>
            <p class="d-inline-block pe-0 text-muted mb-3">
                <a href="<?= Settings::getSettings("site_url") ?>"
                   class="text-accent text-decoration-none">
                    Home
                </a>
                <i class="fas fa-caret-right mx-2"></i>
            </p>
            <p class="d-inline pe-0 text-muted">Settings</p>

            <div class="card shadow rounded-lg" style="border-radius:8px">
                <div class="card-header bg-accent text-white p-5"
                     style="border-top-left-radius:8px;border-top-right-radius:8px">
                    <div class="d-flex">
                        <div>
                            <h5><i class="fas fa-gear me-3"></i></h5>
                        </div>
                        <div>
                            <h1 class="h5">Settings</h1>
                            <p class="small mb-0">Configure site name, appearance, language, and more.</p>
                        </div>
                    </div>
                </div>

            <div class="card-body px-5">

                <form method="post" enctype="multipart/form-data">
                    <label for="site_name" class="mb-1" style="font-weight:500">Site Name</label>
                    <input type="text" name="site_name" class="form-control p-2 px-3 mb-3" id="site_name"
                           placeholder="i.e. Acme Company" style="border-radius:8px" value="<?= Settings::getSettings('site_title') ?? "" ?>">
                    <p class="small text-danger"><?= $site_name_err ?></p>

                    <div class="row">
                        <div class="col-md-8">
                            <label for="logo" class="form-label" style="font-weight:500">Logo</label>
                            <input type="file" id="logo" class="form-control" name="logo" accept="image/*">
                            <p class="small text-danger"><?= $logo_err ?></p>
                        </div>
                        <div class="col-md-4">
                            <p style="font-weight:500" class="mb-2">Current Logo</p>
                            <img src="uploads/logo.png?v=<?= rand() ?>" style="height:30px" alt="">
                        </div>
                        <div class="col-md-8">
                            <label for="favicon" class="form-label" style="font-weight:500">Favicon</label>
                            <input type="file" id="favicon" class="form-control" name="favicon" accept="image/*">
                            <p class="small text-danger"><?= $favicon_err ?></p>
                        </div>
                        <div class="col-md-4">
                            <p style="font-weight:500" class="mb-2">Current Favicon</p>
                            <img src="uploads/favicon.png?v=<?= rand() ?>" style="height:30px" alt="">
                        </div>
                    </div>

                    <label for="accent" class="form-label" style="font-weight:500">Accent color</label>
                    <input type="color" class="form-control form-control-color" id="accent" name="accent" value="<?= Settings::getSettings('accent_color') ?? "" ?>">

                    <label for="feed_type" class="form-label d-block" style="font-weight:500">Feed Type</label>
                    <div class="btn-group round" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" checked>
                        <label class="btn btn-outline-primary" for="btnradio1">Small</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2">
                        <label class="btn btn-outline-primary" for="btnradio2">Medium</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3">
                        <label class="btn btn-outline-primary" for="btnradio3">Large</label>
                    </div>



            </div>

                <div class="bg-light border-top px-5 py-3 d-flex justify-content-between round-bottom">
                    <div class="nav nav-pills">
                        <button type="submit" name="submit" class="round nav-link small active">
                            Save changes
                        </button>
                    </div>
                    </form>

                </div>

        </div>
    </div>
</div>
<div class="col"></div>
</div>

<?= Render::footer(); ?>
</body>
</html>