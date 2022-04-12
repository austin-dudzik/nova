<?php
// Include config file
include "includes/config.php";
?>
<!doctype html>
<html lang="en">
<?= Render::header('Log in'); ?>
<body class="bg-light">
<?= Render::navigation(); ?>

<div class="row">
    <div class="col"></div>
    <div class="col-12 col-md-7 col-lg-5 col-xl-4">
            <div class="card border-0 my-5 round shadow">
                <div class="bg-accent text-white round-top py-4 text-center">
                    <h6 class="mb-0">
                        <i class="fas fa-key me-2"></i> Log in to <?= Settings::getSettings('site_title') ?>
                    </h6>
                </div>
                <div class="card-body mx-3 mx-md-0 px-4 px-md-5 py-4">

                    <div class="alert bg-danger text-white" id="msg"></div>

                    <form method="post" id="login">
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" id="email"
                                   class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password"
                                   id="password"
                                   class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit"
                                    class="btn btn-accent w-100">Log
                                in
                            </button>
                        </div>
                        <p class="text-center">Don't have an account? <a
                                    href="register.php"
                                    class="text-accent d-block d-lg-inline-block">Sign up now</a></p>
                    </form>
                </div>
            </div>
    </div>
    <div class="col"></div>
</div>
<?= Render::footer(); ?>
<script src="assets/js/login.js"></script>
</body>
</html>