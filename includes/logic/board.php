<?php

$updateError = false;
$name_err = '';
$slug_err = '';

if (isset($_POST['updateBoard'])) {

    $check_board = Board::getBoard($_POST['slug']);

    // If name is empty
    if (empty(trim($_POST['name']))) {
        $updateError = true;
        $name_err = "Please enter a title.";
    } else {
        $name = $_POST['name'];
    }

    // If icon is empty
    if (empty(trim($_POST['icon']))) {
        $updateError = false;
        $icon = "comments";
    } else {
        $icon = $_POST['icon'];
    }

    // If slug is empty
    if (empty(trim($_POST['slug']))) {
        $updateError = true;
        $slug_err = "Please enter a slug.";
    }
    // If slug does not match format
    else if (!preg_match("/^[a-z0-9]+(?:-[a-z0-9]+)*$/", $_POST['slug'])) {
        $updateError = true;
        $slug_err = "Only letters, numbers, and dashes are allowed.";
    }
    // If slug is taken
    elseif (isset($check_board->name) && $check_board->slug !== $_GET['board_slug']) {
        $updateError = true;
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

    if(!$updateError) {
        Board::updateBoard($board->board_id, $name, $icon, $slug, $description, $visibility, $rules);
    }

}