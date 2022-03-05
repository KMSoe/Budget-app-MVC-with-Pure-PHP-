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
    <?php if (isset($_GET['already'])) : ?>
        <div class="alert alert-warning">
            Already exist
        </div>
    <?php endif ?>
    <section class="register-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-form-card">
                        <h1 class="text-center my-3">Welcome to Budget</h1>
                        <form action="<?= htmlspecialchars(URLROOT) ?>auth/register" method="POST" class="mt-5">
                            <div class="form-floating mb-3 position-relative">
                                <i class="fas fa-user position-absolute input-field-symbol">
                                </i>
                                <input type="text" id="username" class="form-control" name="username" placeholder="username" onkeyup="disableButtonRegisterPage()">
                                <label for="username">Your Name</label>
                                <small>Name is required!</small>
                            </div>
                            <div class="form-floating mb-3 position-relative">
                                <i class="fas fa-envelope position-absolute input-field-symbol"></i>
                                <input type="email" id="email" class="form-control" name="email" placeholder="Email" onkeyup="disableButtonRegisterPage()">
                                <label for="email">Email</label>
                                <small>Email is required!</small>
                            </div>
                            <div class="form-floating mb-3 position-relative">
                                <i class="toggle-password fas fa-eye-slash position-absolute input-field-symbol" style="cursor: pointer;">
                                </i>
                                <input type="password" id="password" class="form-control" name="password" placeholder="password" onkeyup="disableButtonRegisterPage()">

                                <label for="password">Password</label>
                                <small>At least 6 characters</small>
                            </div>
                            <div class="form-floating mb-3 position-relative">
                                <i class="toggle-password fas fa-eye-slash position-absolute input-field-symbol" style="cursor: pointer;">
                                </i>
                                <input type="password" id="confirmPassword" class="form-control" name="confirmPassword" placeholder="confirmPassword" onkeyup="disableButtonRegisterPage()">

                                <label for="password">Confirm Password</label>
                                <small></small>
                            </div>
                            <button type="submit" id="btnsubmit" class="btn btn-primary rounded">Register</button>
                        </form>
                        <p class="text-center mt-4">
                            Already have an account? Sign in <a href="<?= htmlspecialchars(URLROOT) ?>auth/signin" class="text-primary text-decoration-underline">here.</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= htmlspecialchars(URLROOT) ?>bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= htmlspecialchars(URLROOT) ?>/js/app.js"></script>
</body>

</html>