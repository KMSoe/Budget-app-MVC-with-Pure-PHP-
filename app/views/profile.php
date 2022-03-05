<?php
include_once "../app/views/partials/head.php";
?>
<div id="overlay"></div>

<?php
include_once "../app/views/partials/sidebar.php";
?>

<?php
include_once "../app/views/partials/header.php";
?>

<?php if (isset($_GET['error'])) : ?>
    <div class="alert alert-warning">
        Error!!!
    </div>
<?php endif ?>

<?php if (isset($_GET['uploaded'])) : ?>
    <div class="alert alert-success">
        Profile Picture is successfully uploaded.
    </div>
<?php endif ?>
<a href="" type="button" class="back-to-top rounded d-lg-none">
    <span class="up-arrow mx-auto"></span>
</a>

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
                        <li class="breadcrumb-item active"><a href="#" class=""><i class="fas fa-user me-2"></i>Profile</a></li>
                    </ol>
                </div>
            </section>
            <!-- Breadcrumb Section End -->
            <section class="user-info-section my-3">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <h1 class="mb-3"><?= htmlspecialchars($data["user"]->name) ?></h1>
                            <?php if (!empty($data["user"]->photo)) : ?>
                                <img src="<?= htmlspecialchars(URLROOT) ?>images/<?= htmlspecialchars($data["user"]->photo) ?>" alt="<?= htmlspecialchars($data["user"]->name) ?>" class="img-thumbnail bg-main mb-3" style="height: 150px;">
                            <?php endif ?>
                            <form action="<?= htmlspecialchars(URLROOT) ?>profile/upload" method="POST" enctype="multipart/form-data" class="mb-3">
                                <div class="input-group mb-3">
                                    <input type="file" id="photo" name="photo" placeholder="Upload Profile Picture" class="form-control" onkeyup="disableButton(this)">
                                    <button type="submit" id="btnsubmit" class="btn bg-active text-white">Upload</button>
                                </div>
                            </form>
                            <!-- <?php
                            $token = sha1(rand(1, 1000) . "secret");
                            session_start();
                            $_SESSION["changePassword_csrf"] = $token;
                            ?> -->
                            <a href="<?= htmlspecialchars(URLROOT . "auth/changePassword?id=" . $data["user"]->id . "&csrf=" .  $token) ?>" class="btn bg-active text-white"><i class="fas fa-key me-1"></i>Change Password</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Yearly Balance Brief Section Start -->
            <section class="yearly-balance-section my-5">
                <div class="container">
                    <div class="col-lg-8 mx-auto">
                        <?php foreach ($data["result"] as $yearly_result) : ?>
                            <article class="py-4">
                                <h5 class="mb-4 pe-1">
                                    <?= htmlspecialchars($yearly_result[1]["year"]) ?>
                                    <span class="d-inline-block float-end <?= htmlspecialchars($yearly_result[1]["net_budget"] >= 0 ? "plus" : "minus") ?>"><?= htmlspecialchars($yearly_result[1]["net_budget"] >= 0 ? "+" : "") ?><?= htmlspecialchars($yearly_result[1]["net_budget"]) ?> ks</span>
                                </h5>
                                <table class="table table-bordered border-secondary text-white text-center" id="income-expense-table">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Income</th>
                                            <th>Expense</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($yearly_result[0] as $res) : ?>
                                            <tr>
                                                <td class="text-active"><?= htmlspecialchars($res["month"]) ?></td>
                                                <td class="plus"><?= htmlspecialchars($res["income"] > 0 ? "+" : "") ?><?= htmlspecialchars($res["income"]) ?></td>
                                                <td class="minus"><?= htmlspecialchars($res["expense"]) ?></td>
                                                <td class="<?= htmlspecialchars($res["net_budget"] >= 0 ? "plus" : "minus") ?>"><?= htmlspecialchars($res["net_budget"] > 0 ? "+" : "") ?><?= htmlspecialchars($res["net_budget"]) ?></td>
                                            </tr>
                                        <?php endforeach ?>

                                    </tbody>
                                    <tfoot class="font-weight-bold">
                                        <tr>
                                            <td>Total</td>
                                            <td class="plus">+<?= htmlspecialchars($yearly_result[1]["total_income"]) ?> ks</td>
                                            <td class="minus"><?= htmlspecialchars($yearly_result[1]["total_expense"]) ?> ks</td>
                                            <td class="<?= htmlspecialchars($yearly_result[1]["net_budget"] >= 0 ? "plus" : "minus") ?>"><?= htmlspecialchars($yearly_result[1]["net_budget"] >= 0 ? "+" : "") ?><?= htmlspecialchars($yearly_result[1]["net_budget"]) ?> ks</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <a href="<?= htmlspecialchars(URLROOT . "statistics?year=" . $yearly_result[1]["year"]) ?>" class="btn bg-active text-white rounded">See Detail</a>
                            </article>
                        <?php endforeach ?>
                    </div>
                </div>
            </section>
            <!-- Yearly Balance Brief Section End -->

        </div>
    </div>
</main>
<!-- main section end -->

<?php
include_once "../app/views/partials/choose-modal.php";
?>
<?php
include_once "../app/views/partials/footer.php";
?>
<?php
include_once "../app/views/partials/end.php";
?>