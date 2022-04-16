<?php
// Include config file
include "includes/config.php";

// Define required parameters
$username = $_GET['username'];

// Get the user
$page_user = User::getUser($username);

// If user not found
if (isset($page_user->code) && $page_user->code === 204) {
    header("Location: ../index.php");
    die();
}

if ($page_user->user_id != $user->id) {
    if (!isAdmin()) {
        header("Location: ../index.php");
        die();
    }
}

include "includes/logic/account.php";

?>
<!doctype html>
<html lang="en">
<?= Render::header('Edit post'); ?>
<body>
<?= Render::navigation(); ?>
<div class="row mt-5">
    <div class="col"></div>
    <div class="col-md-6">

        <p class="d-inline-block pe-0 mb-3">
            <a href="<?= SITE_URL ?>"
               class="text-accent text-decoration-none">
                Home
            </a>
            <i class="fas fa-caret-right mx-2"></i>
        </p>
        <a href="<?= $page_user->url ?>"
           class="text-accent text-decoration-none">
            <?= $page_user->name ?>
        </a>
        <i class="fas fa-caret-right mx-2 text-muted"></i>
        <p class="d-inline pe-0 text-muted">Account</p>

        <div class="card shadow round">
            <div class="card-header bg-accent text-white px-5 py-3 round-top">
                <div class="d-flex">
                    <a href="<?= $page_user->url ?>">
                        <i class="fas fa-long-arrow-left h6 me-3 mb-0 mt-2 text-white"></i>
                    </a>
                    <div>
                        <h1 class="h6 mb-0 mt-1">Edit Account</h1>
                    </div>
                </div>
            </div>


            <div class="card-body px-5 py-4">

                <form method="post">

                    <?php if($updateError || $passwordError) { ?>
                    <div class="alert bg-danger text-white round"><?= $error ?></div>
                    <?php } ?>

                    <h6>Update Profile</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" name="firstName"
                                       class="form-control" value="<?= $_POST['firstName'] ?? $page_user->first_name ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" name="lastName"
                                       class="form-control" value="<?= $_POST['lastName'] ?? $page_user->last_name ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="username">Username</label>
                        <input type="hidden" name="cur_username" value="<?= $page_user->username ?>">
                        <input type="text" id="username" name="username"
                               class="form-control" value="<?= $_POST['username'] ?? $page_user->username ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="hidden" name="cur_email" value="<?= $page_user->email ?>">
                        <input type="email" id="email" name="email"
                               class="form-control" value="<?= $_POST['email'] ?? $page_user->email ?>" required>
                    </div>
                    <input type="hidden" name="user_id" value="<?= $page_user->user_id ?>">
                    <button type="submit" name="updateAccount" class="btn bg-accent text-white px-3 roun">Save changes
                    </button>
                    <p class="small text-muted mt-2 mb-3">You'll be required to log back in after updating your account.</p>
                </form>
                <hr>
                <h6>Change Password</h6>
                <form method="post" class="mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="password">New Password</label>
                                <input type="password" id="password" name="password"
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" id="confirm_password" name="confirmPassword"
                                       class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="<?= $page_user->user_id ?>">
                    <button type="submit" name="changePassword" class="btn bg-accent text-white px-3 round">Change password
                    </button>
                    <p class="small text-muted mt-2 mb-3">You'll be required to log back in after updating your password.</p>
                </form>
            </div>
        </div>
    </div>
    <div class="col"></div>
</div>
<?= Render::footer(); ?>
</body>
</html>