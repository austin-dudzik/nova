<?php

$error = false;
$logo_err = "";
$favicon_err = "";
$site_name_err = "";

if (isset($_POST["submit"])) {

    // If site name is empty
    if (empty(trim($_POST['site_name']))) {
        $error = true;
        $site_name_err = "Please enter a site name";
    } else {
        $site_name = $_POST['site_name'];
    }

    $accent = $_POST['accent'];


    if(!empty($_FILES['logo']['name'])) {

        $target_file = "uploads/" . basename("logo") . ".png";

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["logo"]["tmp_name"]);

        if ($check === false) {
            $error = true;
            $logo_err = "File is not an image.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $error = true;
            $logo_err = "Sorry, only JPG, JPEG & PNG files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk !== 0) {
            if (!move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                $error = true;
                $logo_err = "Sorry, there was an error uploading your file.";
            }
        }

    }

    if(!empty($_FILES['favicon']['name'])) {

        $target_file = "uploads/" . basename("favicon") . ".png";

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["favicon"]["tmp_name"]);

        if ($check === false) {
            $error = true;
            $favicon_err = "File is not an image.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $error = true;
            $favicon_err = "Sorry, only JPG, JPEG & PNG files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk !== 0) {
            if (!move_uploaded_file($_FILES["favicon"]["tmp_name"], $target_file)) {
                $error = true;
                $favicon_err = "Sorry, there was an error uploading your file.";
            }
        }

    }

    if (!$error) {
        Settings::saveSettings($site_name, $accent);
    }

}