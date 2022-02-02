<?php
// Start session
session_start();
// Include config file
include "includes/config.php";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Log In | <?= $site_name ?></title>
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
<body class="bg-light">
<?php include "includes/navigation.php" ?>
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
                    class="btn btn-primary w-100"
                    id="submitLogin">Log in
            </button>
        </div>
        <p class="text-center">Don't have an account? <a
                    href="register.php">Sign up
                now</a>.</p>
        <p id="text"></p>
    </form>
</div>
<script src="<?= $site_url ?>/assets/libs/jquery/jquery-3.6.0.min.js"></script>

<script>
    let site_name = '<?= $site_name ?>';
    let csrf_token = '<?= generate_token() ?>';
</script>

<script>
    $("#msg").hide();

    $("#submitLogin").on("click", function () {

        if ($("#email").val() || $("#password").val()) {

            $("#msg").hide();

            $.ajax({
                url: "http://localhost/feedback/api.php",
                method: "GET",
                data: {
                    type: "authenticateUser",
                    csrf_token: csrf_token,
                    email: $("#email").val(),
                    password: $("#password").val()
                },
                success: (data) => {
                    if (data.code === 204) {
                        $("#msg").show().text("Sorry, the login details you entered are incorrect. Please try again.");
                    } else {
                        $("#msg").hide();
                        $("#text").html(JSON.stringify(data));
                    }
                }
            })
        } else {
            $("#msg").show().text("Both email and password are required fields.");
        }

        $("input").keypress(() => {
            $("#msg").hide();
        });

    });
</script>
</body>
</html>