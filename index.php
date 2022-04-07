<?php
// Include config file
include "includes/config.php";

?>
<!doctype html>
<html lang="en">
<?php echo Render::header(__('feed')); ?>
<body>
<?php echo Render::navigation(); ?>

<div class="row my-5">
    <div class="col"></div>
    <div class="col-md-6">


        <div class="card border-0" id="loading">
            <div class="card-body p-4 text-center">
                Loading...
            </div>
        </div>

        <div id="page">
        <div class="card shadow rounded-lg" style="border-radius:8px">
            <div class="card-header bg-accent text-white p-5"
                 style="border-top-left-radius:8px;border-top-right-radius:8px">
                <h1 class="h3 mt-1">Hexagonal</h1>
                <p class="mb-1 small">We're here to
                    build a better experience for you.</p>
            </div>

            <div class="bg-light border-bottom px-5 py-3 d-flex justify-content-between">
                <nav>
                    <div class="nav nav-pills" id="nav-tab" role="tablist">
                        <button class="nav-link small active" id="nav-home-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-home" type="button" style="border-radius:8px">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="d-inline me-2"
                                 style="height:20px;width:20px"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path d="M2 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zM8 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H9a1 1 0 01-1-1V4zM15 3a1 1 0 00-1 1v12a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-2z"/>
                            </svg>
                            <?= __('boards') ?>
                        </button>
                        <button class="nav-link small" id="nav-profile-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-profile" type="button"
                                style="border-radius:8px">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="d-inline me-2"
                                 style="height:20px;width:20px"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <?= __('roadmap') ?>
                        </button>
                    </div>
                </nav>
                <a href="#" id="toggleSearch" class="my-auto text-dark">
                     <span class="fa-stack" data-toggle="tooltip" data-bs-placement="left"
                           title="Search <?= Settings::getSettings('site_title') ?>">
    <i class="fa-solid fa-circle fa-stack-2x"></i>
    <i class="far fa-magnifying-glass fa-stack-1x text-white"></i>
  </span>
                </a>
            </div>

            <div class="bg-white border-bottom" id="searchHolder" style="display:none">
                <div class="input-icons input-group px-5" id="searchPageContainer">
                    <i class="far fa-magnifying-glass text-dark"></i>
                    <input class="search form-control ps-5" type="text" id="searchPage"
                           placeholder="<?= __('search_text') ?>">
                </div>
            </div>

            <div class="card-body px-5">


                <div class="tab-content mt-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home">
                        <div class="row" id="boards-container"></div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile">
                        <div class="row mb-5" id="feed-container"></div>
                    </div>
                </div>

            </div>
        </div>
        </div>
    </div>
    <div class="col"></div>
</div>
<?php echo Render::footer(); ?>
<script src="<?= Settings::getSettings("site_url") ?>/assets/js/feed.js"></script>
</body>
</html>