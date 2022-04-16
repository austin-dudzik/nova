<?php

$error = false;
$title_err = '';
$desc_err = '';

if (isset($_POST['submit'])) {

    // If title is empty
    if (empty(trim($_POST['title']))) {
        $error = true;
        $title_err = "Please enter a title";
    } else {
        $title = $_POST['title'];
    }

    $slug = strtolower((preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['title']))) . '-' . rand(0, 9999);

    // If description is empty
    if (empty(trim($_POST['description']))) {
        $error = true;
        $desc_err = "Please enter a description";
    } else {
        $description = $_POST['description'];
    }

    if (!$error) {
        if (Post::updatePost($title, $description, $post->post_id)) {
            header("Location: " . SITE_URL . '/p/' . $post->slug);
        }
    }

}