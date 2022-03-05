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

    <?php if (isset($_GET['notExist'])) : ?>
        <div class="alert alert-danger">
            This email don't match any account on Budget.
        </div>
    <?php endif ?>
    <?php if (isset($_GET['mailError'])) : ?>
        <div class="alert alert-danger">
            Error on sending mail. Try again!
        </div>
    <?php endif ?>
    <section class="forgot-password-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-form-card">
                        <h1 class="text-center my-3">Budget</h1>
                        <h3 class="text-center mt-5 mb-1">Forgot Password?</h3>
                        <form action="<?= htmlspecialchars(URLROOT) ?>auth/forgot" method="POST" class="mt-5">
                            <div class="form-floating mb-4 position-relative">
                                <i class="fas fa-envelope position-absolute input-field-symbol"></i>
                                <input type="email" id="email" class="form-control" name="email" placeholder="Email" onkeyup="disableButtonSubmitEmail(this)">
                                <label for="email">Enter Email</label>
                                <!-- <small>Email is required!</small> -->
                            </div>
                            <button type="submit" id="btnsubmit" class="btn btn-primary rounded">Send Password Reset Link</button>
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