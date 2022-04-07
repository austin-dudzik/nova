<?php
// Include config file
include "includes/config.php";
?>
<!doctype html>
<html lang="en">
<?php echo Render::header(); ?>
<body>
<?php echo Render::navigation('board'); ?>

<div class="container p-0 my-md-5 px-md-5">

    <h6 class="mb-4 mt-4">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="d-inline me-2"
             style="height:20px;width:20px"
             viewBox="0 0 20 20"
             fill="currentColor">
            <path d="M2 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zM8 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H9a1 1 0 01-1-1V4zM15 3a1 1 0 00-1 1v12a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-2z"/>
        </svg>
        <?= __('boards') ?>
    </h6>

    <div class="row" id="boards-container"></div>
</div>
<?php echo Render::footer(); ?>
<script src="<?= Settings::getSettings("site_url") ?>/assets/js/boards.js"></script>
</body>
</html>