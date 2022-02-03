<?php

class Render
{

    public static function header(string $title = 'Loading...'): string
    {

        global $site_name;
        global $site_url;

        return '<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>' . $title . ' | ' . $site_name . '</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="' . $site_url . '/assets/css/styles.css">
    </head>
    ';
    }

    public static function footer(): string
    {

        global $site_name;
        global $site_url;

        return '<footer class="bg-light border text-center py-4">
    <div class="container px-5">
        <p class="float-start mb-0">&copy;' . date('Y') . ' ' . $site_name . ', all rights reserved.</p>
        <p class="float-end mb-0">🚀 Powered by Nova</p>
        <div class="clearfix"></div>
    </div>
</footer>

<script>
    const site_name = \'' . $site_name . '\';
    const site_url = \'' . $site_url . '\';
    const csrf_token = \'' . generate_token() . '\';
</script>

<script src="' . $site_url . '/assets/libs/jquery/jquery-3.6.0.min.js"></script>
<script src="' . $site_url . '/assets/libs/bootstrap-5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="' . $site_url . '/assets/libs/simplemde/js/simplemde.min.js"></script>
<script src="' . $site_url . '/assets/js/main.js"></script>
';
    }

}