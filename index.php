<?php
// Initialize the session
session_start();

include "includes/config.php";
?>
<!doctype html>
<html lang="en">
<?php echo Render::header('Home'); ?>
<body>
<?php echo Render::navigation('feed'); ?>

<div class="bg-accent text-white p-md-5 p-3">
    <div class="container p-5 py-3">
        <h1 class="text-center">Your Feedback
            Matters to Us!</h1>
        <p class="mb-4 text-center">We're here to
            build a
            better experience for you.</p>

        <div class="input-icons input-group mb-3 w-50-auto mx-auto"
             id="searchPageContainer">
            <i class="far fa-magnifying-glass text-white"></i>
            <input class="search form-control ps-5"
                   type="text" id="searchPage"
                   placeholder="Search for ideas, updates, users, and more...">
        </div>

    </div>
</div>

<div class="container mt-5 px-5">
    <h6 class="mb-4 mt-4">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="d-inline me-2"
             style="height:20px;width:20px"
             viewBox="0 0 20 20"
             fill="currentColor">
            <path d="M2 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zM8 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H9a1 1 0 01-1-1V4zM15 3a1 1 0 00-1 1v12a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-2z"/>
        </svg>
        Boards
        <p class="float-end text-muted">
            <a href="<?= $site_url ?>/boards" class="text-reset text-decoration-none">
            View all <i class="fas fa-angle-right ms-2"></i>
            </a>
        </p>
    </h6>
    <div class="row"
         id="boards-container"></div>


    <h6 class="my-4">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="d-inline me-2 align-middle"
             style="height:24px;width:24px"
             viewBox="0 0 20 20"
             fill="currentColor">
            <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/>
        </svg>
        <span class="align-middle">Changelog</span>

        <p class="float-end text-muted">
            <a href="<?= $site_url ?>/changelog" class="text-reset text-decoration-none">
                View all <i class="fas fa-angle-right ms-2"></i>
            </a>
        </p>
    </h6>

    <div class="row mb-5">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5>Discord Integration</h5>
                    <p class="small text-muted mb-2">Our Discord Integration is live! Your team can connect Canny with Discord text channels to get instant notifications from specific boards and select events.
                    </p>
                    <div class="badge bg-danger text-white">Updates</div>
                </div>
                <div class="card-footer py-3 text-center">
                    <p class="text-muted mb-0" style="font-size:12px">
                        <i class="fas fa-calendar-alt me-2"></i> December 15th 2021
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5>Test</h5>
                    <p class="small text-muted mb-2">Lorem ipsum blah blah blah</p>
                    <div class="badge bg-success text-white">Fixes</div>
                </div>
                <div class="card-footer py-3 text-center">
                    <p class="text-muted mb-0" style="font-size:12px">
                        <i class="fas fa-calendar-alt me-2"></i> February 20th 2022
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h6 class="my-4">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="d-inline me-2"
             style="height:20px;width:20px"
             viewBox="0 0 20 20"
             fill="currentColor">
            <path fill-rule="evenodd"
                  d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z"
                  clip-rule="evenodd"/>
        </svg>
        Roadmap

        <p class="float-end text-muted">
            <a href="<?= $site_url ?>/roadmap" class="text-reset text-decoration-none">
                View all <i class="fas fa-angle-right ms-2"></i>
            </a>
        </p>
    </h6>

    <div class="row mb-5" id="feed-container"></div>

</div>

><?php echo Render::footer(); ?>
<script>
    const feedType = 3;
</script>
<script src="<?= $site_url ?>/assets/js/feed.js"></script>
</body>
</html>