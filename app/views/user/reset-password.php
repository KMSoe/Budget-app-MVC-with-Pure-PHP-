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
    <?php if (isset($_GET['token_expire'])) : ?>
        <div class="alert alert-danger">
            Reset mail is Expired. Try again!
        </div>
    <?php endif ?>
    <section class="reset-password-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-form-card">
                        <h1 class="text-center my-3">Welcome to Budget</h1>
                        <form action="<?= htmlspecialchars(URLROOT) ?>auth/reset" method="POST" class="mt-5">
                            <div class="form-floating mb-3 position-relative">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($data["id"]) ?>">
                                <input type="hidden" name="token" value="<?= htmlspecialchars($data["token"]) ?>">
                                <input type="hidden" name="csrf" value="<?= htmlspecialchars($data["csrf"]) ?>">
                                <i class="toggle-password fas fa-eye-slash position-absolute input-field-symbol" style="cursor: pointer;">
                                </i>
                                <input type="password" id="new-password" class="form-control" name="password" placeholder="New Password" onkeyup="disableButtonResetPassword(this)">

                                <label for="password">New Password</label>
                                <small>At least 6 characters</small>
                            </div>
                            <div class="form-floating mb-3 position-relative">
                                <i class="toggle-password fas fa-eye-slash position-absolute input-field-symbol" style="cursor: pointer;">
                                </i>
                                <input type="password" id="confirmPassword" class="form-control" name="confirmPassword" placeholder="confirmPassword" onkeyup="disableButtonResetPassword(this)">

                                <label for="password">Confirm Password</label>
                                <small></small>
                            </div>
                            <button type="submit" id="btnsubmit" class="btn btn-primary rounded">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= htmlspecialchars(URLROOT) ?>bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= htmlspecialchars(URLROOT) ?>/js/app.js"></script>
</body>

</html>