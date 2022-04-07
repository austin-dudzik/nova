<?php
// Include config file
include "includes/config.php";

// Define required parameters
$board_slug = $_GET['board_slug'];

$board = Board::getBoard($_GET['board_slug']);

if (isset($_POST["submit"])) {

    $title = $_POST['title'];
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['title']))) . '-' . rand(0, 9999);
    $content = $_POST['description'];

    global $conn;
    $stmt = $conn->prepare("INSERT INTO nova_posts (user_id, title, slug, content, board_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $user->id, $title, $slug, $content, $board->board_id);
    $stmt->execute();

    if ($stmt->error) {
        echo $stmt->error;
    }

    if ($stmt->affected_rows > 0) {
        header("Location: " . Settings::getSettings('site_url') . '/p/' . $slug);
    } else {
        echo "error";
    }

}

?>
<!doctype html>
<html lang="en">
<?php echo Render::header(); ?>
<body>
<?php echo Render::navigation(); ?>
<div class="row mt-5">
    <div class="col"></div>
    <div class="col-md-6">

        <p class="d-inline-block pe-0 text-muted mb-3">
            <a href="<?= Settings::getSettings("site_url") ?>"
               class="text-accent text-decoration-none">
                Home
            </a>
            <i class="fas fa-caret-right mx-2"></i>
        </p>
        <p class="d-inline pe-0 text-muted"> <?= Board::getBoard($_GET['board_slug'])->name ?></p>
        <i class="fas fa-caret-right mx-2 text-muted"></i>
        <p class="d-inline pe-0">New suggestion</p>


        <div class="card shadow rounded-lg" style="border-radius:8px">
            <div class="card-header bg-accent text-white p-5"
                 style="border-top-left-radius:8px;border-top-right-radius:8px">
                <div class="d-flex">
                    <i class="fas fa-plus-circle me-2 h5 me-3 mt-1"></i>
                    <div>
                        <h1 class="h5">New Suggestion</h1>
                        <p class="small mb-0">test here</p>
                    </div>
                </div>
            </div>


            <div class="card-body px-5 py-4">

                <p>Posting to: <?= Board::getBoard($_GET['board_slug'])->name ?></p>

                <form method="post">
                    <label for="suggestion" class="fw-bold">Title</label>
                    <input type="text" class="form-control p-2 px-3 mb-3" id="suggestion"
                           placeholder="A short, descriptive title" style="border-radius:8px"
                           name="title">
                    <label for="details" class="fw-bold">Details</label>
                    <textarea placeholder="Description" class="form-control p-2 px-3 mb-3"
                              id="description"
                              rows="6" style="border-radius:8px" name="description"></textarea>
                    <button type="submit" name="submit" class="btn bg-accent text-white px-3"
                            style="border-radius:8px">Create post
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col"></div>
</div>
<?php echo Render::footer(); ?>
</body>
</html>