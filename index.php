<?php
// Initialize the session
session_start();

include "includes/config.php";
?>
<!doctype html>
<html lang="en">
<?php echo Render::header('Home'); ?>
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
    <div class="row mb-5" id="boards-container"></div>

    <h6 class="mb-4 mt-4">

        <svg xmlns="http://www.w3.org/2000/svg" class="d-inline me-2" style="height:20px;width:20px" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z" clip-rule="evenodd" />
        </svg> Roadmap</h6>

    <div class="row mb-5" id="feed-container"></div>

</div>

<?php echo Render::footer(); ?>
<script>
    const feedType = 1;
</script>
<script src="<?= $site_url ?>/assets/js/feed.js"></script>
</body>
</html>