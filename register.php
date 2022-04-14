<?php
// Include config file
include "includes/config.php";
?>
<!doctype html>
<html lang="en">
<?= Render::header('Create account'); ?>
<body class="bg-light">
<?= Render::navigation('register'); ?>

<div class="mx-auto border p-5 m-5 round bg-white"
     style="width:40%">
    <h1 class="mb-2">🔐</h1>
    <h2>Create an Account</h2>
    <p>Please fill out the fields below to sign up.</p>

    <div class="alert alert-danger"
         id="msg"></div>

    <form id="register">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName"
                           class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName"
                           class="form-control" required>
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="email">Username</label>
            <input type="text" id="username"
                   class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" id="email"
                   class="form-control" required>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" id="password"
                           class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password"
                           class="form-control" required>
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <button type="submit" class="btn btn-accent w-100">Create account</button>
        </div>
        <p class="text-center">Already have an
            account? <a
                    href="login.php" class="text-accent text-decoration-none">Log in</a></p>
    </form>
</div>
<?= Render::footer(); ?>
<script src="assets/js/register.js"></script>
</body>
</html>