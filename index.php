<?php
// Initialize the session
session_start();

include "includes/config.php";

//if(!isLoggedIn()){
//    header("location: login.php");
//    exit;
//}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<style>
    .list-group-item {
        border: 0;
        background: #efefef;
    }
    body {
        font-family: 'Be Vietnam Pro', sans-serif;
    }
    .text-primary {
        color: #f0513c!important;
    }
    .bg-primary {
        background-color: #f0513c!important;
    }
    .btn-primary {
        background-color: #f0513c!important;
        border-color: #f0513c!important;
    }
</style>
<body>

<?php include "includes/navigation.php"; ?>

<div class="bg-dark text-white p-5">
    <div class="container p-5 py-3">
        <h1>Your Feedback Matters to Us!</h1>
        <p class="mb-4">We're here to build a better experience for you.</p>
        <input type="search" class="form-control w-50" placeholder="Search for ideas, updates, users, and more...">
    </div>
</div>

<div class="container mt-5 px-5">
    <h6 class="mb-4 mt-4"><svg xmlns="http://www.w3.org/2000/svg" class="d-inline me-2" style="height:20px;width:20px" viewBox="0 0 20 20" fill="currentColor">
            <path d="M2 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zM8 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H9a1 1 0 01-1-1V4zM15 3a1 1 0 00-1 1v12a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-2z" />
        </svg> Boards</h6>
    <div class="row mb-5">
        <div class="col-md-3 mb-4">
            <div class="card border-none" style="background:#efefef">
                <div class="card-body text-center">
        <i class="fas fa-smile fa-2x d-block mb-2 text-primary"></i>
        <p class="mb-0" style="font-weight: 600;font-size: 15px;line-height: 22px">MapQuest</p>
        <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">1.3K posts</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-none" style="background:#efefef">
                <div class="card-body text-center">
                    <i class="fas fa-puzzle-piece fa-2x d-block mb-2 text-primary"></i>
                    <p class="mb-0" style="font-weight: 600;font-size: 15px;line-height: 22px">MapQuest</p>
                    <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">1.3K posts</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-none" style="background:#efefef">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 my-auto">
                            <i class="fas fa-puzzle-piece fa-2x d-block mb-2 text-primary"></i>
                        </div>
                        <div class="col-md-10 ps-3">
                            <p class="mb-0" style="font-weight: 600;font-size: 15px;line-height: 22px">MapQuest</p>
                            <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">1.3K posts</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-none" style="background:#efefef">
                <div class="card-body py-2">
                    <div class="row mt-1">
                        <div class="col-md-1 my-auto">
                            <i class="fas fa-puzzle-piece fa-2x d-block mb-2 text-primary" style="font-size:20px"></i>
                        </div>
                        <div class="col-md-8 ps-4">
                            <p class="mb-0" style="font-weight: 600;font-size: 15px;line-height: 22px">Popular Actions</p>
                        </div>
                        <div class="col float-end">
                            <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase" class="float-end mt-1">1.3K</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-none" style="background:#efefef">
                <div class="card-body text-center">
                    <i class="fas fa-smile fa-2x d-block mb-2 text-primary"></i>
                    <p class="mb-0" style="font-weight: 600;font-size: 15px;line-height: 22px">Integrations</p>
                    <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">1.3K posts</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-none" style="background:#efefef">
                <div class="card-body text-center">
                    <i class="fas fa-smile fa-2x d-block mb-2 text-primary"></i>
                    <p class="mb-0" style="font-weight: 600;font-size: 15px;line-height: 22px">MapQuest</p>
                    <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">1.3K posts</small>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4 d-none">
            <p class="text-center">View all <i class="fas fa-angle-down ms-1"></i></p>
        </div>
    </div>

    <h6 class="mb-4 mt-4">

        <svg xmlns="http://www.w3.org/2000/svg" class="d-inline me-2" style="height:20px;width:20px" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z" clip-rule="evenodd" />
        </svg> Roadmap</h6>
<div class="row mb-5">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header py-3" style="border:0;background:#efefef;font-weight:700;font-size:15px">
                <i class="fas fa-circle me-2" style="font-size:10px;vertical-align:middle;color:#ff6e07"></i> Under Review
            </div>
            <div class="card-body p-0" style="background:#f5f5f5;max-height:250px;overflow-y:auto">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-2 my-auto">
                                <button class="btn btn-primary border px-2">
                                    <i class="fas fa-caret-up d-block"></i>
                                    <p class="mb-0">101</p>
                                </button>
                            </div>
                            <div class="col-md-10">
                                <p class="mb-0 mt-1" style="font-weight: 600; font-size: 15px; line-height: 22px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word">Ability to see categories in Intercom app selector</p>
                                <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">FEATURE REQUESTS</small>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-2 my-auto">
                                <button class="btn btn-light border px-2">
                                    <i class="fas fa-caret-up d-block"></i>
                                    <p class="mb-0">101</p>
                                </button>
                            </div>
                            <div class="col-md-10">
                                <p class="mb-0 mt-1" style="font-weight: 600; font-size: 15px; line-height: 22px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word">Ability to see categories in Intercom app selector</p>
                                <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">FEATURE REQUESTS</small>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-2 my-auto">
                                <button class="btn btn-light border px-2">
                                    <i class="fas fa-caret-up d-block"></i>
                                    <p class="mb-0">101</p>
                                </button>
                            </div>
                            <div class="col-md-10">
                                <p class="mb-0 mt-1" style="font-weight: 600; font-size: 15px; line-height: 22px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word">Ability to see categories in Intercom app selector</p>
                                <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">FEATURE REQUESTS</small>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header py-3" style="border:0;background:#efefef;font-weight:700;font-size:15px">
                <i class="fas fa-circle me-2" style="font-size:10px;vertical-align:middle;color:#01a6ff"></i> In Progress
            </div>
            <div class="card-body pt-1" style="background:#efefef;max-height:250px;overflow-y:auto">
                <p style="font-weight:500;color:#999" class="ms-4 my-auto">Nothing here, yet. Check back soon!</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header py-3" style="border:0;background:#efefef;font-weight:700;font-size:15px">
                <i class="fas fa-circle me-2" style="font-size:10px;vertical-align:middle;color:#05e02a"></i> Completed
            </div>
            <div class="card-body pt-1" style="background:#efefef;max-height:250px;overflow-y:auto">
                <p style="font-weight:500;color:#999" class="ms-4">Nothing here, yet. Check back soon!</p>
            </div>
        </div>
    </div>
</div>

</div>

<footer class="bg-light border text-center py-4">
    <div class="container px-5">
        <p class="float-start mb-0">&copy; <?= date('Y') ?> Hexagonal, all rights reserved.</p>
        <p class="float-end mb-0">🚀 Powered by Nova</p>
        <div class="clearfix"></div>
    </div>
</footer>

<script>
    const site_name = '<?= $site_name ?>';
    const site_url = '<?= $site_url ?>';
    const csrf_token = '<?= generate_token() ?>';
</script>

<script
<script src="<?= $site_url ?>/assets/libs/jquery/jquery-3.6.0.min.js"></script>
<script src="<?= $site_url ?>/assets/libs/bootstrap-5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="<?= $site_url ?>/assets/js/main.js"></script>
</body>
</html>