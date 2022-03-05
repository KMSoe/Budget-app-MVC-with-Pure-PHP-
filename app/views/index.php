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
<?php if (isset($_GET['login'])) : ?>
    <div class="alert alert-success">
        Login successful.
    </div>
<?php endif ?>
<?php if (isset($_GET['invalid'])) : ?>
    <div class="alert alert-warning">
        Request Month and Year are invalid
    </div>
<?php endif ?>
<?php if (isset($_GET['error'])) : ?>
    <div class="alert alert-warning">
        Error!!!
    </div>
<?php endif ?>
<?php if (isset($_GET['deleted'])) : ?>
    <div class="alert alert-danger">
        Deleted.
    </div>
<?php endif ?>
<?php if (isset($_GET['added'])) : ?>
    <?php if ($_GET['type'] === "income") : ?>
        <div class="alert alert-success">
            Income amount is successfully added.
        </div>
    <?php elseif ($_GET['type'] === "expense") : ?>
        <div class="alert alert-danger">
            Expense amount is added.
        </div>
    <?php endif ?>
<?php endif ?>
<a href="" type="button" class="back-to-top rounded d-lg-none">
    <span class="up-arrow mx-auto"></span>
</a>
<!-- Select Month modal -->
<div class="modal" id="select-month">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="ps-3 py-3">
                <h5 class="modal-title text-center">Select a month</h5>
            </div>
            <div class="modal-body">
                <form action="<?= htmlspecialchars(URLROOT) ?>home" method="GET" id="select-month-form">
                    <input type="text" name="time" id="monthpicker" placeholder="Select a month" class="form-control" autocomplete="off" onkeyup="disableButtonSelectMonth(this)">
                </form>
            </div>
            <div class="text-center pt-2 pb-3">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button class="ms-3 btn btn-primary" form="select-month-form" id="btnsubmit" type="submit">
                    Ok
                </button>
            </div>
        </div>
    </div>
</div>
<!-- main section start -->
<main class="container-fluid">
    <div class="row g-0">
        <div class="col-lg-3 d-none d-lg-block">
            <?php
            include_once "../app/views/partials/main-sidebar.php";
            ?>
        </div>
        <div class="col-md-12 col-lg-9">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Total balance Section Start -->
                    <section class="total-balance-section py-3 px-4">
                        <div class="row justify-content-center justify-content-lg-start">
                            <div class="col-sm-10 col-md-8 col-lg-10 col-xl-8 mb-3" style="background-color: unset;">
                                <a class="btn bg-active text-white select-btn py-1 px-3 my-2" data-bs-toggle="modal" data-bs-target="#select-month">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    <span id="year-month"><?= htmlspecialchars($data["total"]["time"]) ?></span>
                                </a>

                                <div class="card-body">
                                    <h3 class="h5">Total Balance</h3>
                                    <div class="d-flex">
                                        <div class="flex-fill">
                                            <span class="total-balance font-weight-bold text-white">
                                                <?= htmlspecialchars($data["total"]["net_budget"]) ?> ks
                                            </span>
                                            <p class="minus">You spent <span id="percentage"><?= htmlspecialchars($data["total"]["percentage"]) ?></span>&percnt; of your
                                                income</p>
                                        </div>
                                        <div class="add-button">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#choose" class=" d-block w-100 h-100 position-relative">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Total balance Section End -->

                    <!-- Total Income, Expense Section Start -->
                    <section class="total-value-section px-1 px-lg-3">
                        <div class="row d-flex justify-content-center justify-content-lg-start align-items-stretched">
                            <div class="col-6 col-sm-4 col-lg-5 col-xl-4">
                                <div class="card mx-auto w-100 h-100 mb-3" style="background-color: unset;">
                                    <div class="bg-plus card-body position-relative">
                                        <h3 class="card-title h4">Total Income</h3>
                                        <span class="total-income-value font-weight-bold text-white">
                                            <?= htmlspecialchars($data["total"]["income"]) ?> ks
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 col-lg-5 col-xl-4">
                                <div class="card mx-auto w-100 h-100 mb-3" style="background-color: unset;">
                                    <div class="bg-minus card-body position-relative">
                                        <h3 class="card-title h4">Total Expense</h3>
                                        <span class="total-expense-value font-weight-bold text-white">
                                            <?= htmlspecialchars($data["total"]["expense"]) ?> ks
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Total Income, Expense Section End -->

                    <!-- Daily statistics Section Start-->
                    <section class="daily-stat-section py-5 px-1 px-lg-3">
                        <div class="row px-2 justify-content-center justify-content-lg-start">
                            <div class="col-sm-10 col-md-8 col-lg-10 col-xl-8">
                                <h4 class="h5 mb-3">Daily Budgets</h4>
                                <?php if(count($data["budget_cards"]) > 0): ?>
                                <?php foreach ($data["budget_cards"] as $card) : ?>
                                    <div class="card daily-stat-card rounded mb-3">
                                        <div class="card-header d-flex px-2">
                                            <span class="flex-fill me-2"><?= htmlspecialchars($card->day) ?></span>
                                            <span class="me-2">income: <?= htmlspecialchars($card->income) ?>ks</span>
                                            <span class="me-2">expense: <?= htmlspecialchars($card->expense) ?>ks</span>
                                        </div>
                                        <div class="card-body p-0">
                                            <ul class="mb-0 px-0">
                                                <?php foreach ($card->budget_items as $item) : ?>
                                                    <li class="d-flex py-2 px-3">
                                                        <i class="cat-icon <?= htmlspecialchars($item->icon->class) ?> me-3 my-auto" style="background-color: <?= htmlspecialchars($item->icon->color) ?>;"></i>
                                                        <span class="flex-fill my-auto"><?= htmlspecialchars($item->category_name) ?> <br> <span class="text-muted"><?= htmlspecialchars($item->remark) ?></span></span>
                                                        <span class="<?= htmlspecialchars($item->amount) > 0 ? "plus" : "minus"  ?> my-auto"><?= htmlspecialchars($item->amount > 0 ? "+" . $item->amount : "" . $item->amount) ?>&nbsp;ks</span>
                                                        <!-- <span class="my-auto ms-2" style="width: 40px;height: 40px;">
                                                    <i class="cat-icon fas fa-times-circle"></i>
                                                </span> -->
                                                        <?php
                                                        session_start();
                                                        $token = sha1(rand(1, 1000) . "csrf secret");
                                                        $_SESSION[$item->id . "_token"] = $token;
                                                        ?>
                                                        <form action="<?= htmlspecialchars(URLROOT) ?>budget/delete" method="POST" class="my-auto text-end" style="box-sizing: border-box;width: 40px;height: 40px;">
                                                            <input type="hidden" name="budget-id" value="<?= htmlspecialchars($item->id) ?>">
                                                            <input type="hidden" name="user-id" value="<?= htmlspecialchars($item->user_id) ?>">
                                                            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                                                            <button style="outline: none;border: none;background-color: unset;" type="submit">
                                                                <i class="cat-icon fas fa-times-circle my-auto"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                <?php endforeach ?>
                                            </ul>
                                        </div>
                                        <div class="card-footer">
                                            <p class="mb-0">
                                                <?= htmlspecialchars($card->percentage) ?>&percnt; of your monthly income was spent.
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                                <?php else: ?>
                                    <p class="text-center text-muted mt-5">You have neither income nor expense </p>
                                <?php endif ?>
                            </div>
                        </div>

                    </section>
                    <!-- Daily statistics Section End-->
                </div>
                <div class="col-lg-4">
                    <section class="py-3">
                        <div class="row">
                            <div class="col-sm-10 col-md-8 col-lg-12 mx-auto">
                                <div class="py-3 ps-2 mobile-sticky-nav" style="background-color: #1a252f;">
                                    <h4>Amount Detail on Category</h4>
                                    <div class="swip-nav d-flex justify-content-flex-start mt-4 mb-md-3">
                                        <a class="income-category-pie-nav active btn text-white select-btn me-3 py-1 px-3">
                                            <i class="fas fa-check me-2"></i>Income
                                        </a>
                                        <a class="expense-category-pie-nav btn text-white select-btn me-3 py-1 px-3">
                                            <i class="fas fa-check me-2"></i>Expense
                                        </a>
                                    </div>
                                </div>

                                <div class="income-category-pie-container mt-5">
                                    <h5 class="mb-4 text-center text-md-start">Income Category Pie Graph</h5>
                                    <div class="income-expense-pie-container position-relative mx-auto ms-md-auto" id="pie-small">
                                        <canvas id="income-category-pie"></canvas>
                                    </div>
                                    <div class="text-center mx-auto mt-4">
                                        <?php if ($data["total"]["income"] > 0) : ?>
                                            <p>Total Income: <?= htmlspecialchars($data["total"]["income"]) ?> ks</p>
                                        <?php else : ?>
                                            <p>You have No Income</p>
                                        <?php endif ?>
                                    </div>
                                    <ul class="income-categories mt-4 ps-0 w-100 w-md-50 w-lg-100 px-lg-1 px-xl-3">
                                        <?php foreach ($data["category_detail"][0][0] as $item) : ?>
                                            <li class="d-flex py-1 text-white">
                                                <i class="fas fa-square me-3 my-auto" style="color: <?= htmlspecialchars($item->color) ?>;font-size: 22px;"></i>
                                                <span class="flex-fill my-auto"><span class="d-inline-block mb-2"><?= htmlspecialchars($item->name) ?></span><br><span class="border-top border-secondary pt-2"><?= htmlspecialchars($item->amount) ?>ks</span></span>
                                                <span class="my-auto"><?= htmlspecialchars($item->percentage) ?>&percnt;</span>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                                <div class="expense-category-pie-container mt-5">
                                    <h5 class="mb-4 text-center text-md-start">Expense Category Pie Graph</h5>
                                    <div class="income-expense-pie-container position-relative mx-auto ms-md-auto" id="pie-small">
                                        <canvas id="expense-category-pie"></canvas>
                                    </div>
                                    <div class="text-center mx-auto mt-4">
                                        <?php if ($data["total"]["expense"] > 0) : ?>
                                            <p>Total Expense: <?= htmlspecialchars($data["total"]["expense"]) ?> ks</p>
                                        <?php else : ?>
                                            <p>You have No Expense</p>
                                        <?php endif ?>
                                    </div>
                                    <ul class="expense-categories mx-auto mt-4 ps-0 w-100 w-md-50 w-lg-100 px-lg-1 px-xl-3">
                                        <?php foreach ($data["category_detail"][1][0] as $item) : ?>
                                            <li class="d-flex py-1 text-white mb-2">
                                                <i class="fas fa-square me-3 my-auto" style="color: <?= htmlspecialchars($item->color) ?>;font-size: 22px;"></i>
                                                <span class="flex-fill my-auto"><span class="d-inline-block mb-2"><?= htmlspecialchars($item->name) ?></span><br><span class="border-top border-secondary pt-2"><?= htmlspecialchars($item->amount) ?>ks</span></span>
                                                <span class="my-auto"><?= htmlspecialchars($item->percentage) ?>&percnt;</span>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
<?php
include_once "../app/views/partials/end.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script src="<?= htmlspecialchars(URLROOT) ?>js/pickers.js"></script>
<script>
    // Income Category Pie
    const income_category_names = '<?= implode(',', $data["category_detail"][0][1][0]) ?>'.split(",");
    const income_category_percentages = '<?= implode(',', $data["category_detail"][0][1][1]) ?>'.split(",");
    const income_category_colors = '<?= implode(',', $data["category_detail"][0][1][2]) ?>'.split(",");

    const total_inc_cat_pie_data = {
        labels: income_category_names,
        datasets: [{
            backgroundColor: income_category_colors,
            data: income_category_percentages,
            hoverOffset: 1
        }]
    };

    const total_inc_cat_config_pie = {
        type: "doughnut",
        data: total_inc_cat_pie_data,
        options: {
            aspectRatio: .8,
        }
    };

    var total_inc_cat_pie_chart = new Chart(
        document.getElementById("income-category-pie"),
        total_inc_cat_config_pie
    );

    // Expense Category Pie
    const expense_category_names = '<?= implode(',', $data["category_detail"][1][1][0]) ?>'.split(",");
    const expense_category_percentages = '<?= implode(',', $data["category_detail"][1][1][1]) ?>'.split(",");
    const expense_category_colors = '<?= implode(',', $data["category_detail"][1][1][2]) ?>'.split(",");

    const total_exp_cat_pie_data = {
        labels: expense_category_names,
        datasets: [{
            backgroundColor: expense_category_colors,
            data: expense_category_percentages,
            hoverOffset: 1,
        }]
    };

    const total_exp_cat_config_pie = {
        type: "doughnut",
        data: total_exp_cat_pie_data,
        options: {
            aspectRatio: .8,
        }
    };

    var total_inc_exp_pie_chart = new Chart(
        document.getElementById("expense-category-pie"),
        total_exp_cat_config_pie
    );
</script>