<?php

class Render
{

    public static function header(string $title = null): string
    {

        if (!isset($title)) {
            $title = __("loading");
        }

        return '<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>' . $title . ' | ' . Settings::getSettings("site_title") . '</title>
    <link rel="icon" type="image/png" href="' . Settings::getSettings("site_url") . '/uploads/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap">    
    <link rel="stylesheet" href="' . Settings::getSettings("site_url") . '/assets/css/styles.css">
    <style>
    :root {
      --accent-color: ' . Settings::getSettings("accent_color") . ';
      --accent-color-light: ' . Settings::getSettings("accent_color") . '20;
    }
</style>
    </head>
    ';
    }

    public static function navigation(): string
    {

        global $user;

        return '<div class="sticky-top">
    <nav class="navbar navbar-light navbar-expand-lg" id="navigation">
        <div class="container py-2">
        
        <div>
        <span class="fa-stack fa-2x d-inline-block me-2 d-lg-none" id="openNav" data-bs-toggle="collapse" data-bs-target="#navExtra">
                      <i class="fas fa-circle fa-stack-2x"></i>
                      <i class="far fa-bars fa-stack-1x fa-inverse"></i>
                </span>
                
              
            <a class="navbar-brand" href="' . Settings::getSettings("site_url") . '">
                <img src="' . Settings::getSettings("site_url") . '/uploads/logo.png" alt="" style="height:30px">
            </a>
            </div>
            <div>'
            . (isset($_SESSION['user']) && isAdmin() ?
                '<a href="' . Settings::getSettings("site_url") . '/users.php" class="nav-link d-inline btn-sm pe-2 text-dark" style="font-weight:500">Users</a>
            <a href="' . Settings::getSettings("site_url") . '/settings.php" class="nav-link d-inline btn-sm pe-4 text-dark" style="font-weight:500">Settings</a>' : null) .
            '<span class="fa-stack fa-2x" id="openSearch">
                      <i class="fas fa-circle fa-stack-2x"></i>
                      <i class="far fa-magnifying-glass fa-stack-1x fa-inverse"></i>
                </span>
            ' . (isset($_SESSION['user']) ?
                '<div class="dropdown d-inline-block">
                    <img src="https://gravatar.com/avatar/' . md5($user->email) . '?d=mp" alt="" class="avatar" data-bs-toggle="dropdown">
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item"
                               href="' . Settings::getSettings("site_url") . '/u/' . $user->username . '">' . __("profile") . '</a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="' . Settings::getSettings("site_url") . '/account/' . $user->username . '">Edit Account</a>
                        </li>
                        <li>
                            <a class="dropdown-item logout" href="javascript:void()">' . __("logout") . '</a>
                        </li>
                    </ul>
                </div>' :
                '<a href="' . Settings::getSettings("site_url") . '/login.php" class="btn btn-light border me-2">' . __("login") . '</a>
                <a href="' . Settings::getSettings("site_url") . '/register.php" class="btn btn-accent">' . __("signup") . '</a>') .
            '</div>
        </div>

    </nav>
</div>';

    }

    public static function footer(): string
    {

        global $lang;

        return '<footer class="text-center pb-4 mt-4">
        <p class="mb-0">&copy; ' . date('Y') . ' ' . Settings::getSettings("site_title") . ', all rights reserved.</p>
        <p class="mb-0 badge bg-secondary text-white">🚀 ' . __('powered_by') . ' <a href="https://github.com/austin-dudzik/nova" class="text-white text-decoration-none">Nova</a></p>
</footer>

<!-- Search modal -->
<div class="modal fade mt-5" id="searchModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <div class="input-icons input-group" id="searchInModal">
                    <i class="far fa-magnifying-glass"></i>
                    <input type="text" class="search form-control ps-5 round" placeholder="' . __('search_text') . '">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const site_name = \'' . Settings::getSettings("site_title") . '\';
    const site_url = \'' . Settings::getSettings("site_url") . '\';
    const terms = ' . json_encode($lang, JSON_PRETTY_PRINT) . ';
    const feed_type = ' . Settings::getSettings("feed_type") . ';
    const csrf_token = \'' . generate_token() . '\';
</script>

<script src="' . Settings::getSettings("site_url") . '/assets/libs/jquery/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<script src="' . Settings::getSettings("site_url") . '/assets/libs/bootstrap-5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="http://timeago.yarp.com/jquery.timeago.js"></script>
<script src="' . Settings::getSettings("site_url") . '/assets/js/main.js"></script>
';
    }

}