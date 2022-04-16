<?php

$updateError = false;
$passwordError = false;

if (isset($_POST['updateAccount'])) {

    // Check if all inputs are filled out
    $user_id = $_POST['user_id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    if ($firstName == "" || $lastName == "" || $username == "" || $email == "") {
        $updateError = true;
        $error = "Please fill out all fields";
    }
    // Check if username meets requirements
    if (!preg_match("^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$^", $username)) {
        $updateError = true;
        $error = "Sorry, username does not meet requirements";
    } // Check if email meets requirements
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $updateError = true;
        $error = "Sorry, you must enter a valid email address";
    }

    if (!$updateError) {

        if ($_POST['cur_username'] !== $_POST['username']) {

            $stmt = $conn->prepare("SELECT COUNT(us.id) FROM  " . DB_PREFIX . "users us WHERE us.username = ? GROUP BY us.id");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Username already exists
                $updateError = true;
                $error = "Sorry, that username is already taken";
            }

        }

    }

    if (!$updateError) {

        if ($_POST['cur_email'] !== $_POST['email']) {

            $stmt = $conn->prepare("SELECT COUNT(us.id) FROM  " . DB_PREFIX . "users us WHERE us.email = ? GROUP BY us.id");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Email already exists
                $updateError = true;
                $error = "Sorry, that email is already taken";
            }

        }

    }

    if (!$updateError) {

        $stmt = $conn->prepare("UPDATE " . DB_PREFIX . "users SET first_name = ?, last_name = ?, username = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $firstName, $lastName, $username, $email, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            unset($_SESSION['user']);
            header("Location:" .  SITE_URL . "/login.php");
        }

    }


}

    if (isset($_POST['changePassword'])) {

        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        if ($password !== $confirmPassword) {
            $passwordError = true;
            $error = "Sorry, passwords do not match";
        } // Check if password meets requirements
        elseif (!preg_match("^(?=.{6,99}$)^", $password)) {
            $passwordError = true;
            $error = "Sorry, password does not meet requirements";
        }

        if (!$passwordError) {

            $user_id = $_POST['user_id'];

            // Hash the password
            $password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("UPDATE " . DB_PREFIX . "users SET password = ? WHERE id = ?");
            $stmt->bind_param("ss", $password, $user_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                unset($_SESSION['user']);
                header("Location:" .  SITE_URL . "/login.php");
            }

        }

    }