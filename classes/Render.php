<?php

class Render
{

    public static function header(string $title = null): string
    {

        if(!isset($title)) {
            $title = __("loading");
        }

        return '<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>' . $title . ' | ' . Settings::getSettings("site_title") . '</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap">    
    <link rel="stylesheet" href="' . Settings::getSettings("site_url") . '/assets/css/styles.css">
    </head>
    <style>
    :root {
      --accent-color: ' . Settings::getSettings("accent_color") . ';
    }
</style>
    ';
    }

    public static function navigation(string $page_id): string
    {

        global $user;

        return '<div class="sticky-top">
    <nav class="navbar navbar-light bg-light navbar-expand-lg" id="navigation">
        <div class="container py-2">
            <a class="navbar-brand" href="' . Settings::getSettings("site_url") . '">
                <img src="' . Settings::getSettings("site_url") . '/logo.svg" alt="">
            </a>
            <div>' . (isset($_SESSION['user']) ?
                '<span class="fa-stack fa-2x" id="openSearch">
                      <i class="fas fa-circle fa-stack-2x"></i>
                      <i class="far fa-magnifying-glass fa-stack-1x fa-inverse"></i>
                </span>

                <div class="dropdown d-inline-block">
                 <span class="fa-stack fa-2x" id="openNotifications" data-bs-toggle="dropdown">
                      <i class="fas fa-circle fa-stack-2x"></i>
                      <i class="fas fa-bell fa-stack-1x fa-inverse"></i>
                 </span>

                    <div class="dropdown-menu dropdown-menu-end">
                        <p>test</p>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">New around here? Sign up</a>
                        <a class="dropdown-item" href="#">Forgot password?</a>
                    </div>
                </div>

                <div class="dropdown d-inline-block">
                    <img src="https://gravatar.com/avatar/' . md5($user->email) . '" alt="" class="avatar" data-bs-toggle="dropdown">
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item"
                               href="' . Settings::getSettings("site_url") . '/u/' . $user->username . '">' . __("profile") . '</a>
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

    <nav class="navbar navbar-expand-lg navbar-light bg-light pt-0 border-bottom">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-2">
                        <a class="nav-link page-icon" href="' . Settings::getSettings("site_url") . '">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"' . ($page_id === "feed" ? 'fill="var(--accent-color)"' : 'fill="rgba(0, 0, 0, 0.55)"') . '>
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                            </svg>
                            </svg>
                            <span class="ms-2" style="' . ($page_id === "feed" ? 'font-weight:600;color:var(--accent-color)' : '') . '">' . __('feed') . '</span>
                        </a>
                    </li>

                    <li class="nav-item border-end m-2"></li>

                    <li class="nav-item me-2">
                        <a class="nav-link page-icon" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zM8 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H9a1 1 0 01-1-1V4zM15 3a1 1 0 00-1 1v12a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-2z"/>
                            </svg>
                            <span class="ms-2">' . __('boards') . '</span>
                        </a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link page-icon" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span class="ms-2">' . __('roadmap') . '</span>
                        </a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link page-icon" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/>
                            </svg>
                            <span class="ms-2">' . __('changelog') . '</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>' . (Settings::getSettings("read_only") ?
'<div class="read-only py-3 small">
    <i class="fas fa-exclamation-triangle me-2"></i>
    ' . __('readonly_mode') . '
</div>' : '');

    }

    public static function footer(): string
    {

        global $lang;

        return '<footer class="bg-light border text-center py-4">
    <div class="container px-5">
        <p class="float-start mb-0">&copy;' . date('Y') . ' ' . Settings::getSettings("site_title") . ', all rights reserved.</p>
        <p class="float-end mb-0">🚀 Powered by Nova</p>
        <div class="clearfix"></div>
    </div>
</footer>

<!-- Search modal -->
<div class="modal fade mt-5" id="searchModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <div class="input-icons input-group" id="searchInModal">
                    <i class="far fa-magnifying-glass text-white"></i>
                    <input type="text" class="search form-control ps-5" placeholder="' . __('search_text') . '">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mustSignInModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title"
                    id="exampleModalLabel"></h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-5">
                <div class="row pb-4">
                    <div class="col-md-5 d-none">
                        <div class="card mx-auto">
                            <div class="card-body">
                                <p class="mb-3">Do more with an account...</p>
                                <ul class="list-group small no-gutters m-0 p-0">


                                    <li class="list-group-item bg-white p-0 m-0">
                            <span class="fa-stack me-1">
                          <i class="fas fa-square fa-stack-2x text-accent"></i>
                          <i class="fas fa-message fa-stack-1x fa-inverse"></i>
                        </span>Post comments
                                    </li>
                                    <li class="list-group-item bg-white p-0 m-0 mt-2">
                              <span class="fa-stack me-1">
                              <i class="fas fa-square fa-stack-2x text-accent"></i>
                              <i class="fas fa-caret-up fa-stack-1x fa-inverse"></i>
                            </span>Upvote posts
                                    </li>
                                    <li class="list-group-item bg-white p-0 m-0 mt-2">
                              <span class="fa-stack me-1">
                              <i class="fas fa-square fa-stack-2x text-accent"></i>
                              <i class="fas fa-copy fa-stack-1x fa-inverse"></i>
                            </span>Share ideas
                                    </li>
                                    <li class="list-group-item bg-white p-0 m-0 mt-2">
                              <span class="fa-stack me-1">
                              <i class="fas fa-square fa-stack-2x text-accent"></i>
                              <i class="fas fa-bell fa-stack-1x fa-inverse"></i>
                            </span>Receive notifications
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                        <div class="col-md-12 mx-auto">
                        <img src="' . Settings::getSettings("site_url") . '/logo.svg" width="180" class="mb-4">

                        <h5 class="mb-3">Please log in to continue...</h5>

                            <div class="alert alert-danger" id="msg"></div>

                        <form>
                            <div class="form-group mb-3">
                                <label for="email">' . __('email') . '</label>
                                <input type="email" id="email" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">' . __('password') . '</label>
                                <input type="password" id="password" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <button type="button" class="btn btn-accent w-100" id="submitLogin">' . __('login') . '
                                </button>
                            </div>
                        </form>
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-3">Do more with an account...</p>
                                <div class="row small">
                                    <div class="col-6 mb-2">
                                        <span class="fa-stack me-1">
                          <i class="fas fa-square fa-stack-2x text-accent"></i>
                          <i class="fas fa-message fa-stack-1x fa-inverse"></i>
                        </span>Post comments
                                    </div>
                                    <div class="col-6 mb-2">
                            <span class="fa-stack me-1">
                              <i class="fas fa-square fa-stack-2x text-accent"></i>
                              <i class="fas fa-caret-up fa-stack-1x fa-inverse"></i>
                            </span>Upvote posts
                                    </div>
                                    <div class="col-6 mb-2">
                            <span class="fa-stack me-1">
                              <i class="fas fa-square fa-stack-2x text-accent"></i>
                              <i class="fas fa-copy fa-stack-1x fa-inverse"></i>
                            </span>Share ideas
                                    </div>
                                    <div class="col-6 mb-2">
                            <span class="fa-stack me-1">
                              <i class="fas fa-square fa-stack-2x text-accent"></i>
                              <i class="fas fa-bell fa-stack-1x fa-inverse"></i>
                            </span>Get notifications
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center small py-2">
                                <a href="register.php" class="text-accent text-decoration-none">Create account <i class="far fa-long-arrow-right ms-1"></i></a>
                            </div>
                        </div>

                    </div>
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
<script src="' . Settings::getSettings("site_url") . '/assets/libs/simplemde/js/simplemde.min.js"></script>
<script src="' . Settings::getSettings("site_url") . '/assets/js/main.js"></script>
<script src="' . Settings::getSettings("site_url") . '/assets/js/login.js"></script>
';
    }

}