<?php
// Include config file
include "includes/config.php";

if (!isAdmin()) {
    header("location: index.php");
}

include "includes/logic/settings.php";

if (isset($_POST['updateRole'])) {
    User::updateRole($_POST['user_id'], (int)$_POST['updateRole']);
}

if (isset($_POST['deleteUser'])) {
    User::deleteUser($_POST['user_id']);
}

?>
<!doctype html>
<html lang="en">
<?= Render::header('Users') ?>
<body>
<?= Render::navigation() ?>
<div class="row mt-5">
    <div class="col"></div>
    <div class="col-md-6">

        <div>
            <p class="d-inline-block pe-0 text-muted mb-3">
                <a href="<?= SITE_URL ?>"
                   class="text-accent text-decoration-none">
                    Home
                </a>
                <i class="fas fa-caret-right mx-2"></i>
            </p>
            <p class="d-inline pe-0 text-muted">Users</p>

            <div class="card shadow round">
                <div class="card-header bg-accent text-white p-5 round-top">
                    <div class="d-flex">
                        <div>
                            <h5><i class="fas fa-users me-3"></i></h5>
                        </div>
                        <div>
                            <h1 class="h5">Users</h1>
                            <p class="small mb-0">Users are those who have accounts within your application, including contributors who are those who have posting access, and administrators who can manage and moderate the application.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-light border-bottom px-5 py-3 d-flex justify-content-between">
                    <nav>
                        <div class="nav nav-pills" id="boardsBtn" role="tablist">
                            <button class="nav-link small active round" data-bs-toggle="tab"
                                    data-bs-target="#boards" type="button">
                                <i class="fas fa-pen me-2"></i> Contributors
                            </button>
                            <button class="nav-link small round" id="roadmapBtn" data-bs-toggle="tab"
                                    data-bs-target="#roadmap" type="button">
                                <i class="fas fa-crown me-2"></i> Administrators
                            </button>
                        </div>
                    </nav>
                    <div class="my-auto">
                        <a href="#" id="toggleSearch" class="text-dark text-decoration-none">
                     <span class="fa-stack" data-toggle="tooltip" data-bs-placement="left"
                           title="Search <?= Settings::getSettings('site_title') ?>">
                        <i class="fa-solid fa-circle fa-stack-2x text-accent"></i>
                        <i class="far fa-magnifying-glass fa-stack-1x text-white"></i>
                     </span>
                        </a>
                    </div>
                </div>


                <div class="bg-white border-bottom" id="searchHolder" style="display:none">
                    <div class="input-icons input-group px-5" id="searchPageContainer">
                        <i class="far fa-magnifying-glass text-dark"></i>
                        <input class="search form-control ps-5" type="text" id="searchPage"
                               placeholder="Search for ideas, updates, users, and more...">
                    </div>
                </div>

                <div class="card-body px-5">
                    <div class="tab-content mt-3">
                        <div class="tab-pane fade show active" id="boards">
                            <?php if (isset(Users::getAllUsers()->code) && Users::getAllUsers()->code === 204) {
                                echo '<div class="alert alert-warning">Your site has no contributors, yet!</div>';
                            } else {
                            foreach (Users::getAllUsers() as $contributor) { ?>
                            <div class="card mb-3 round">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex">
                                            <a href="<?= $contributor->url ?>" class="d-flex text-reset text-decoration-none">
                                            <div>
                                                <img src="<?= $contributor->avatar ?>"
                                                     height="50"
                                                     class="rounded-circle me-3">
                                            </div>
                                            <div>
                                                <h6 class="mb-1"><?= $contributor->name ?></h6>
                                                <p class="text-muted mb-0">
                                                    @<?= $contributor->username ?></p>
                                            </div>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="#" data-bs-toggle="modal"
                                               data-bs-target="#promote-<?= $contributor->user_id ?>"
                                               class="btn btn-white border me-1"><i
                                                        class="far fa-crown me-2"></i>
                                                Promote
                                            </a>

                                            <!-- Promote user modal -->
                                            <div class="modal fade"
                                                 id="promote-<?= $contributor->user_id ?>">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content shadow">
                                                        <div class="modal-header border-0 pb-0">
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body px-5">
                                <span class="fa-stack h6">
                                <i class="fa-solid fa-circle fa-stack-2x text-accent"></i>
                                <i class="far fa-crown fa-stack-1x text-white"></i>
                              </span>
                                                            <h5>Promote user?</h5>
                                                            <p class="small">This user will gain all
                                                                administrative privileges to the
                                                                application, such as creating new
                                                                boards, editing posts, and promoting
                                                                and demoting other users.</p>

                                                            <form method="post">

                                                                <div class="my-4">
                                                                    <input type="hidden"
                                                                           name="user_id"
                                                                           value="<?= $contributor->user_id ?>">
                                                                    <button type="submit"
                                                                            name="updateRole"
                                                                            value="1"
                                                                            class="btn bg-accent text-white me-1 round">
                                                                        Promote user
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-white border round"
                                                                            data-bs-dismiss="modal">
                                                                        Cancel
                                                                    </button>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="<?= SITE_URL ?>/account/<?= $contributor->username ?>" class="btn btn-white border me-1"><i
                                                    class="far fa-pencil"></i>
                                        </a>
                                        <a href="#" data-bs-toggle="modal"
                                           data-bs-target="#delete-<?= $contributor->user_id ?>" class="btn btn-danger"><i
                                                    class="far fa-trash-alt"></i>
                                        </a>
                                        <!-- Delete user modal -->
                                        <div class="modal fade"
                                             id="delete-<?= $contributor->user_id ?>">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content shadow">
                                                    <div class="modal-header border-0 pb-0">
                                                        <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body px-5">
                                <span class="fa-stack h6">
                                <i class="fa-solid fa-circle fa-stack-2x text-danger"></i>
                                <i class="far fa-exclamation-triangle fa-stack-1x text-white"></i>
                              </span>
                                                        <h5>Delete user?</h5>
                                                        <p class="small">Are you sure you want to remove this user? Continuing will delete all posts, comments, and upvotes associated with the user, which might not be what you want.</p>

                                                        <form method="post">

                                                            <div class="my-4">
                                                                <input type="hidden"
                                                                       name="user_id"
                                                                       value="<?= $contributor->user_id ?>">
                                                                <button type="submit"
                                                                        name="deleteUser"
                                                                        class="btn btn-danger me-1 round">
                                                                    Delete user
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-white border round"
                                                                        data-bs-dismiss="modal">
                                                                    Cancel
                                                                </button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        }
                        ?>
                    </div>
                    <div class="tab-pane fade" id="roadmap">
                        <?php if (isset(Users::getAllUsers(1)->code) && Users::getAllUsers(1)->code === 204) {
                            echo '<div class="alert alert-warning">Your site has no administrators, yet!</div>';
                        } else {
                        foreach (Users::getAllUsers(1) as $admin) { ?>
                        <div class="card mb-3 round">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <a href="<?= $admin->url ?>" class="d-flex text-reset text-decoration-none">
                                        <div>
                                            <img src="<?= $admin->avatar ?>"
                                                 height="50"
                                                 class="rounded-circle me-3">
                                        </div>
                                        <div>
                                            <h6 class="mb-1"><?= $admin->name ?></h6>
                                            <p class="text-muted mb-0">
                                                @<?= $admin->username ?></p>
                                        </div>
                                        </a>
                                    </div>
                                    <?php if ($admin->user_id !== $user->id) { ?>
                                    <div>
                                        <a href="#" data-bs-toggle="modal"
                                           data-bs-target="#demote-<?= $admin->user_id ?>"
                                           class="btn btn-white border me-1"><i
                                                    class="far fa-down me-2"></i>
                                            Demote
                                        </a>

                                        <!-- Demote user modal -->
                                        <div class="modal fade" id="demote-<?= $admin->user_id ?>">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content shadow">
                                                    <div class="modal-header border-0 pb-0">
                                                        <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body px-5">
                                <span class="fa-stack h6">
                                <i class="fa-solid fa-circle fa-stack-2x text-warning"></i>
                                <i class="far fa-down fa-stack-1x text-black"></i>
                              </span>
                                                        <h5>Demote user?</h5>
                                                        <p class="small">This user will lose all
                                                            administrative access to the application
                                                            on their next login This could lead to
                                                            some unexpected surprises if you're not
                                                            sure what you're doing.</p>

                                                        <form method="post">

                                                            <div class="my-4">
                                                                <input type="hidden" name="user_id"
                                                                       value="<?= $admin->user_id ?>">
                                                                <button type="submit"
                                                                        name="updateRole" value="0"
                                                                        class="btn btn-warning me-1 round">
                                                                    Demote user
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-white border round"
                                                                        data-bs-dismiss="modal">
                                                                    Cancel
                                                                </button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="<?= $site_url ?>/account/<?= $admin->username ?>" class="btn btn-white border me-1"><i
                                                class="far fa-pencil"></i>
                                    </a>
                                    <a href="#" data-bs-toggle="modal"
                                       data-bs-target="#delete-<?= $admin->user_id ?>" class="btn btn-danger"><i
                                                class="far fa-trash-alt"></i>
                                    </a>
                                    <!-- Delete user modal -->
                                    <div class="modal fade"
                                         id="delete-<?= $admin->user_id ?>">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content shadow">
                                                <div class="modal-header border-0 pb-0">
                                                    <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body px-5">
                                <span class="fa-stack h6">
                                <i class="fa-solid fa-circle fa-stack-2x text-danger"></i>
                                <i class="far fa-exclamation-triangle fa-stack-1x text-white"></i>
                              </span>
                                                    <h5>Delete user?</h5>
                                                    <p class="small">Are you sure you want to remove this user? Continuing will delete all posts, comments, and upvotes associated with the user, which might not be what you want.</p>

                                                    <form method="post">

                                                        <div class="my-4">
                                                            <input type="hidden"
                                                                   name="user_id"
                                                                   value="<?= $admin->user_id ?>">
                                                            <button type="submit"
                                                                    name="deleteUser"
                                                                    class="btn btn-danger me-1 round">
                                                                Delete user
                                                            </button>
                                                            <button type="button"
                                                                    class="btn btn-white border round"
                                                                    data-bs-dismiss="modal">
                                                                Cancel
                                                            </button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<div class="col"></div>
</div>

<?= Render::footer(); ?>
</body>
</html>