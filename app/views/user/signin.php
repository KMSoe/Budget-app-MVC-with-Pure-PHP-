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
    <?php if (isset($_GET['account_created'])) : ?>
        <div class="alert alert-success">
            Account created. Please Login.
        </div>
    <?php endif ?>
    <?php if (isset($_GET['changed'])) : ?>
        <div class="alert alert-success">
            Password changed. Login again.
        </div>
    <?php endif ?>
    <?php if (isset($_GET['incorrect'])) : ?>
        <div class="alert alert-danger">
            Incorrect Email or Password!!!
        </div>
    <?php endif ?>
    <?php if (isset($_GET['activated'])) : ?>
        <div class="alert alert-success">
            Successfully Activated. Login here.
        </div>
    <?php endif ?>
    <?php if (isset($_GET['notactivated'])) : ?>
        <div class="alert alert-warning">
            The account is not activated yet. Check mail.
        </div>
    <?php endif ?>
    <?php if (isset($_GET['suspended'])) : ?>
        <div class="alert alert-danger">
            Your account was suspended.
        </div>
    <?php endif ?>
    <?php if (isset($_GET['login'])) : ?>
        <?php if ($_GET['login'] === "false") : ?>
            <div class="alert alert-warning">
                You are not login. Please Login.
            </div>
        <?php endif ?>
    <?php endif ?>
    <?php if (isset($_GET['logout'])) : ?>
        <div class="alert alert-danger">
            Successfully logout
        </div>
    <?php endif ?>
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-form-card">
                        <h1 class="text-center my-3">Budget</h1>
                        <h3 class="text-center mt-5 mb-1">Welcome Back</h3>
                        <form action="<?= htmlspecialchars(URLROOT) ?>auth/signin" method="POST" class="mt-5">
                            <div class="form-floating mb-3 position-relative">
                                <i class="fas fa-envelope position-absolute input-field-symbol"></i>
                                <input type="email" id="email" class="form-control" name="email" placeholder="Email" onkeyup="disableButtonLoginPage(this)">
                                <label for="email">Email</label>
                                <!-- <small>Email is required!</small> -->
                            </div>
                            <div class="form-floating mb-3 position-relative">
                                <i class="toggle-password fas fa-eye-slash position-absolute input-field-symbol" style="cursor: pointer;">
                                </i>
                                <input type="password" id="password" class="form-control" name="password" placeholder="password" onkeyup="disableButtonLoginPage(this)">

                                <label for="password">Password</label>
                                <!-- <small>Password is required!</small> -->
                            </div>
                            <div class="text-end"><a href="<?= htmlspecialchars(URLROOT) ?>auth/forgot" class="text-primary">Forgot Password?</a></div>
                            <button type="submit" id="btnsubmit" class="btn btn-primary rounded" >Sign in</button>
                        </form>
                        <p class="text-center mt-4">
                            Don't have an account? Register <a href="<?= htmlspecialchars(URLROOT) ?>auth/register" class=" text-primary text-decoration-underline">here.</a>
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