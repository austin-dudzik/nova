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
<?= Render::header('Users') ?>
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
            <p class="d-inline pe-0 text-muted">Users</p>

            <div class="card shadow rounded-lg" style="border-radius:8px">
                <div class="card-header bg-accent text-white p-5"
                     style="border-top-left-radius:8px;border-top-right-radius:8px">
                    <div class="d-flex">
                        <div>
                            <h5><i class="fas fa-users me-3"></i></h5>
                        </div>
                        <div>
                            <h1 class="h5">Users</h1>
                            <p class="small mb-0">Configure site name, appearance, language, and more.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body px-5">

                    <?php foreach(Users::getAllUsers() as $user) { ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                <div>
                                    <img src="<?= $user->avatar ?>" height="50" class="rounded-circle me-3">
                                </div>
                                <div>
                                    <h6 class="mb-1"><?= $user->name ?></h6>
                                    <p class="text-muted">@<?= $user->username ?></p>
                                </div>
                                </div>
                                <div>
                                    <button class="btn btn-light border">View <i class="far fa-long-arrow-right ms-1"></i></button>
                                    <button class="btn btn-danger"><i class="far fa-trash-alt me-1"></i> Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                </div>

            </div>
        </div>
    </div>
    <div class="col"></div>
</div>

<?= Render::footer(); ?>
</body>
</html>