<?php
// Include config file
include "includes/config.php";
?>
<!doctype html>
<html lang="en">
<?php echo Render::header('Log in'); ?>
<body class="bg-light">
<?php echo Render::navigation('login'); ?>

<div class="mx-auto border p-5 m-5 rounded bg-white"
     style="width:40%">
    <h1 class="mb-2">👋</h1>
    <h2>Welcome back!</h2>
    <p>Please fill in your credentials to
        login.</p>

    <div class="alert alert-danger"
         id="msg"></div>

    <form>
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" id="email"
                   class="form-control">
        </div>
        <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" id="password"
                   class="form-control">
        </div>
        <div class="form-group mb-3">
            <button type="button"
                    class="btn btn-accent w-100"
                    id="submitLogin">Log in
            </button>
        </div>
        <p class="text-center">Don't have an
            account? <a
                    href="register.php" class="text-accent">Sign up
                now</a>.</p>
    </form>
</div>
<?php echo Render::footer(); ?>
<script src="assets/js/login.js"></script>
</body>
</html>