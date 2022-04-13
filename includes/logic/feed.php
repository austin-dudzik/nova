<?php

$createError = false;
$statusCreateError = false;
$updateError = false;
$name_err = '';
$slug_err = '';
$statusName_err = '';

if (isset($_POST['createBoard']) && isAdmin()) {

    $check_board = Board::getBoard($_POST['slug']);

    // If name is empty
    if (empty(trim($_POST['name']))) {
        $createError = true;
        $name_err = "Please enter a title.";
    } else {
        $name = $_POST['name'];
    }

    // If icon is empty
    if (empty(trim($_POST['icon']))) {
        $createError = false;
        $icon = "comments";
    } else {
        $icon = $_POST['icon'];
    }

    // If slug is empty
    if (empty(trim($_POST['slug']))) {
        $createError = true;
        $slug_err = "Please enter a slug.";
    } // If slug does not match format
    else if (!preg_match("/^[a-z0-9]+(?:-[a-z0-9]+)*$/", $_POST['slug'])) {
        $createError = true;
        $slug_err = "Only letters, numbers, and dashes are allowed.";
    } // If slug is taken
    elseif (isset($check_board->name)) {
        $createError = true;
        $slug_err = "Slug is already taken";
    } else {
        $icon = $_POST['icon'];
    }

    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $visibility = $_POST['visibility'];

    // Build our own fake array
    $rules = str_replace(' ', '', $_POST['rules']);
    $rules = explode(',', $rules);
    $rules_s = '';
    foreach ($rules as $key => $rule) {
        $rules_s .= '"' . $rule . '"' . ($key === array_key_last($rules) ? '' : ',');
    }
    $rules = "[" . $rules_s . "]";

    if (!$createError) {
        Board::createBoard($name, $icon, $slug, $description, $visibility, $rules);
    }

}

if (isset($_POST['createStatus']) && isAdmin()) {

    // If name is empty
    if (empty(trim($_POST['statusName']))) {
        $statusCreateError = true;
        $statusName_err = "Please enter a status name";
    } else {
        $name = $_POST['statusName'];
    }

    $color = $_POST['statusColor'];

    if (!$statusCreateError) {
        Status::createStatus($name, $color);
    }

}

if (isset($_POST['updateStatus']) && isAdmin()) {

    // If name is empty
    if (empty(trim($_POST['name']))) {
        $updateError = true;
        $s_name_err = "Please enter a name";
    } else {
        $name = $_POST['name'];
    }

    $id = (int)$_POST['id'];
    $color = $_POST['color'];

    if (!$updateError) {
        Status::updateStatus($id, $name, $color);
    }

}

if (isset($_POST['deleteStatus']) && isAdmin()) {

    $id = (int)$_POST['id'];

    Status::deleteStatus($id);

}