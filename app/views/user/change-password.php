<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= htmlspecialchars(URLROOT) ?>bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= htmlspecialchars(URLROOT) ?>css/style.css">
    <title>Budget App | <?= htmlspecialchars($data["title"]) ?></title>
</head>

<body>
    <?php if (isset($_GET['error'])) : ?>
        <div class="alert alert-warning">
            Error!!!
        </div>
    <?php endif ?>
    <?php if (isset($_GET['notequal'])) : ?>
        <div class="alert alert-danger">
            Current Password is incorrect!!!
        </div>
    <?php endif ?>
    <div id="overlay"></div>

    <?php
    include_once "../app/views/partials/sidebar.php";
    ?>
    <?php
    include_once "../app/views/partials/header.php";
    ?>
    <!-- main section start -->
    <main class="container-fluid">
        <div class="row g-0">
            <div class="col-lg-3 d-none d-lg-block">
                <?php
                include_once "../app/views/partials/main-sidebar.php";
                ?>
            </div>
            <div class="col-md-12 col-lg-9">
                <!-- Breadcrumb Section Start -->
                <section class="breadcrumb-section row justify-content-center pt-4">
                    <div class="col-md-12 col-lg-10">
                        <ol class="breadcrumb px-2 py-3 mx-3 mb-3">
                            <li class="breadcrumb-item"><a href="<?= htmlspecialchars(URLROOT) ?>" class=""><i class="fas fa-home me-2"></i>Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= htmlspecialchars(URLROOT) ?>profile" class=""><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li class="breadcrumb-item active"><a href="#" class=""><i class="fas fa-key me-2"></i></i>Change Password</a></li>
                        </ol>
                    </div>
                </section>
                <!-- Breadcrumb Section End -->

                <section class="change-password-section">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="login-form-card">
                                    <h1 class="text-center my-3">Change Password</h1>
                                    <form action="<?= htmlspecialchars(URLROOT) ?>auth/changePassword" method="POST" class="mt-5">
                                        <div class="form-floating mb-3 position-relative">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($data["id"]) ?>">
                                            <input type="hidden" name="csrf" value="<?= htmlspecialchars($data["csrf"]) ?>">
                                            <i class="toggle-password fas fa-eye-slash position-absolute input-field-symbol" style="cursor: pointer;">
                                            </i>
                                            <input type="password" id="current-password" class="form-control" name="current-password" placeholder="CurrentPpassword" onkeyup="disableButtonChangePassword(this)">

                                            <label for="current-password">Current Password</label>
                                            <!-- <small>At least 6 characters</small> -->
                                        </div>
                                        <div class="form-floating mb-3 position-relative">
                                            <i class="toggle-password fas fa-eye-slash position-absolute input-field-symbol" style="cursor: pointer;">
                                            </i>
                                            <input type="password" id="new-password" class="form-control" name="new-password" placeholder="New Password" onkeyup="disableButtonChangePassword(this)">

                                            <label for="password">New Password</label>
                                            <small>At least 6 characters</small>
                                        </div>
                                        <div class="form-floating mb-3 position-relative">
                                            <i class="toggle-password fas fa-eye-slash position-absolute input-field-symbol" style="cursor: pointer;">
                                            </i>
                                            <input type="password" id="confirmPassword" class="form-control" name="confirmPassword" placeholder="confirmPassword" onkeyup="disableButtonChangePassword(this)">

                                            <label for="password">Confirm Password</label>
                                            <small></small>
                                        </div>
                                        <button type="submit" id="btnsubmit" class="btn btn-primary rounded">Change</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </main>
    <!-- main section end -->

    <script src="<?= htmlspecialchars(URLROOT) ?>bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= htmlspecialchars(URLROOT) ?>/js/app.js"></script>
</body>

</html>