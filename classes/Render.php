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
    <link href="http://fonts.cdnfonts.com/css/sf-ui-display" rel="stylesheet">
    
    <link rel="stylesheet" href="' . $site_url . '/assets/css/styles.css">
    </head>
    ';
    }

    public static function navigation(string $page_id): string
    {

        global $site_url;

        return '<div class="sticky-top">
    <nav class="navbar navbar-light bg-light navbar-expand-lg"
         id="navigation">
        <div class="container py-2">
            <a class="navbar-brand" href="' . $site_url . '">
                <img src="' . $site_url . '/logo.svg"
                     alt="Logo">
            </a>
            <div>' . (isset($_SESSION['user']) ?
            '<span class="fa-stack fa-2x" id="openSearchModal"
              style="font-size:18px">
  <i class="fas fa-circle fa-stack-2x"
     style="color:hsla(0,0%,39.2%,.1)"></i>
  <i class="far fa-magnifying-glass fa-stack-1x fa-inverse"
     style="color:#aaa"></i>
</span>

                <div class="dropdown d-inline-block">
                 <span class="fa-stack fa-2x"
                       style="font-size:18px"
                       data-bs-toggle="dropdown">
  <i class="fas fa-circle fa-stack-2x"
     style="color:hsla(0,0%,39.2%,.1)"></i>
  <i class="fas fa-bell fa-stack-1x fa-inverse"
     style="color:#aaa"></i>
                 </span>

                    <div class="dropdown-menu dropdown-menu-end">
                        <p>test</p>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"
                           href="#">New around
                            here?
                            Sign up</a>
                        <a class="dropdown-item"
                           href="#">Forgot
                            password?</a>
                    </div>
                </div>


                <div class="dropdown d-inline-block">
                    <img src="https://gravatar.com/avatar/<?php echo md5($user->email) ?>"
                         alt=""
                         class="rounded-circle"
                         style="width:35px;cursor:pointer"
                         data-bs-toggle="dropdown">
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item"
                               href="<?= $site_url ?>/u/<?= $user->username ?>">Profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item logout" href="javascript:void()">Log out</a>
                        </li>
                    </ul>
                </div>' :
            '<a href="<?= $site_url ?>/login.php" class="btn btn-light border me-2">Log in</a>
                <a href="<?= $site_url ?>/register.php" class="btn btn-primary">Create account</a>') .
        '</div>
        </div>

    </nav>

    <nav class="navbar navbar-expand-lg navbar-light bg-light pt-0 border-bottom">
        <div class="container">
            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse"
                 id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-2">
                        <a class="nav-link" href="' . $site_url . '">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="d-inline"
                                 style="height:20px;width:20px"
                                 viewBox="0 0 20 20"' . ($page_id === "feed" ? 'fill="#f0513c"' : 'fill="rgba(0, 0, 0, 0.55)"') . '>
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                            </svg>
                            </svg>
                            <span class="align-middle ms-2"
                                  style="font-weight:600;' . ($page_id === "feed" ? 'color:#f0513c' : '') . '">Feed</span>
                        </a>
                    </li>

                    <li class="nav-item border-end m-2">
                    </li>

                    <li class="nav-item me-2">
                        <a class="nav-link"
                           href="#">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="d-inline"
                                 style="height:20px;width:20px"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path d="M2 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zM8 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H9a1 1 0 01-1-1V4zM15 3a1 1 0 00-1 1v12a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-2z"/>
                            </svg>
                            <span class="align-middle ms-2"
                                  style="font-weight:600">Boards</span>
                        </a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link"
                           href="#">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="d-inline"
                                 style="height:20px;width:20px"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span class="align-middle ms-2"
                                  style="font-weight:500">Roadmap</span>
                        </a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link"
                           href="#">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="d-inline"
                                 style="height:20px;width:20px"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/>
                            </svg>
                            <span class="align-middle ms-2"
                                  style="font-weight:500">Changelog</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<div style="background:#FFE8C3;color:#ab6a00"
     class="text-center py-3 small">
    <i class="fas fa-exclamation-triangle me-2"></i>
    This feedback portal is currently in read-only
    mode and not accepting new ideas or upvotes.
</div>';

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

<!-- Search modal -->
<div class="modal fade mt-5" id="searchModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <div class="input-icons input-group" id="searchInModal">
                    <i class="far fa-magnifying-glass text-white"></i>
                    <input type="text" class="search form-control ps-5" placeholder="Search for ideas, updates, users, and more...">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const site_name = \'' . $site_name . '\';
    const site_url = \'' . $site_url . '\';
    const csrf_token = \'' . generate_token() . '\';
</script>

<script src="' . $site_url . '/assets/libs/jquery/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<script src="' . $site_url . '/assets/libs/bootstrap-5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="' . $site_url . '/assets/libs/simplemde/js/simplemde.min.js"></script>
<script src="' . $site_url . '/assets/js/main.js"></script>
';
    }

}