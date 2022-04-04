<?php
// Include config file
include "includes/config.php";
?>
<!doctype html>
<html lang="en">
<?php echo Render::header('Log in'); ?>
<body class="bg-light">
<?php echo Render::navigation('login'); ?>

<div class="row">
    <div class="col"></div>
    <div class="col-12 col-md-7 col-lg-5 col-xl-4">
        <div class="border p-4 p-md-5 my-5 rounded bg-white mx-3 mx-md-0">
            <h1 class="mb-2">👋</h1>
            <h2>Welcome back!</h2>
            <p>Please fill in your credentials to
                login.</p>

            <div class="alert alert-danger"
                 id="msg"></div>

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
                <p class="text-center">Don't have
                    an
                    account? <a
                            href="register.php"
                            class="text-accent d-block d-lg-inline-block">Sign
                        up
                        now</a></p>
            </form>
        </div>
    </div>
    <div class="col"></div>
</div>
<?php echo Render::footer(); ?>
<script src="assets/js/login.js"></script>
</body>
</html>