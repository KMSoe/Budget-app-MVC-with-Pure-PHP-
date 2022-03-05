<?php
include_once "../app/views/partials/head.php";
?>
<div id="overlay"></div>

<?php
include_once "../app/views/partials/sidebar.php";
?>
<style>
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<?php
include_once "../app/views/partials/header.php";
?>
<!-- Select A Year modal -->
<div class="modal" id="select-year">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="ps-3 py-3">
                <h5 class="modal-title text-center">Select a year</h5>
            </div>
            <div class="modal-body">
                <form action="<?= htmlspecialchars(URLROOT) ?>statistics" method="GET" id="select-year-form">
                    <input type="text" name="year" id="yearpicker" placeholder="Select a year" class="form-control" autocomplete="off">
                </form>
            </div>
            <div class="text-center pt-2 pb-3">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button class="ms-3 btn btn-primary" form="select-year-form" type="submit">
                    Ok
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Select dates modal -->
<div class="modal" id="select-dates">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="ps-3 py-3">
                <h5 class="modal-title text-center">Select Dates</h5>
            </div>
            <div class="modal-body">
                <form action="<?= htmlspecialchars(URLROOT) ?>statistics" method="GET" id="select-dates-form">
                    <div class="mb-4">
                        <input type="text" name="first-date" id="firstdatepicker" placeholder="Select Start Date" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="second-date" id="seconddatepicker" placeholder="Select End Date" class="form-control" autocomplete="off">
                    </div>
                </form>
            </div>
            <div class="text-center pt-2 pb-3">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button class="ms-3 btn btn-primary" form="select-dates-form" type="submit">
                    Ok
                </button>
            </div>
        </div>
    </div>
</div>
<?php if (isset($_GET['invalid'])) : ?>
    <div class="alert alert-warning">
        Invalid Request Time
    </div>
<?php endif ?>
<a href="" type="button" class="back-to-top rounded d-lg-none">
    <span class="up-arrow mx-auto"></span>
</a>
<!-- main section start -->
<main class="container-fluid">
    <div class="row g-0">
        <div class="col-lg-3 d-none d-lg-block">
            <!-- Main Sidebar Start -->
            <?php
            include_once "../app/views/partials/main-sidebar.php";
            ?>
            <!-- Main Sidebar End -->
        </div>
        <div class="col-md-12 col-lg-9">
            <!-- Breadcrumb Section Start -->
            <section class="breadcrumb-section row justify-content-center pt-4">
                <div class="col-md-12 col-lg-10">
                    <ol class="breadcrumb px-2 py-3 mx-3 mb-3">
                        <li class="breadcrumb-item"><a href="<?= htmlspecialchars(URLROOT) ?>" class=""><i class="fas fa-home me-2"></i>Home</a></li>
                        <li class="breadcrumb-item active"><a href="#" class=""><i class="fas fa-chart-line me-2"></i>Statistics</a></li>
                    </ol>
                </div>
            </section>
            <!-- Breadcrumb Section End -->

            <!-- income-expense-yearly Section Start -->
            <section class="income-expense-yearly-section py-3 px-1 px-lg-3 px-xl-4">
                <div class="mb-4">
                    <a href="#" class="select-btn bg-active text-white d-inline-block py-1 px-3 mb-4" data-bs-toggle="modal" data-bs-target="#select-year">
                        <i class="fas fa-calendar-alt me-2"></i>
                        <span id="current-year"><?= htmlspecialchars($data["yearly_results"][1]["year"]) ?></span>
                    </a>

                    <h3 class="mb-4">Income Expense Line Graph</h3>
                    <canvas id="income-expense-multi-line" style="height: 300px;"></canvas>
                </div>
                <div class="row py-3">
                    <div class="col-12 col-xl-6 mb-5">
                        <h5 class="mb-4">Income Expense Table</h5>
                        <table class="table table-bordered text-white text-center" id="income-expense-table">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Income</th>
                                    <th>Expense</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($data["yearly_results"][0] as $res) : ?>
                                    <tr>
                                        <td class="text-active"><?= htmlspecialchars($res["month"]) ?></td>
                                        <td class="plus"><?= htmlspecialchars($res["income"] > 0 ? "+" . $res["income"] : $res["income"]) ?></td>
                                        <td class="minus"><?= htmlspecialchars($res["expense"]) ?></td>
                                        <td class="<?= htmlspecialchars($res["net_budget"] >= 0 ? "plus" : "minus") ?>"><?= htmlspecialchars($res["net_budget"] > 0 ? "+" . $res["net_budget"] : "" . $res["net_budget"]) ?></td>
                                    </tr>
                                <?php endforeach ?>

                            </tbody>
                            <tfoot class="font-weight-bold">
                                <tr>
                                    <td>Total</td>
                                    <td class="plus">+<?= htmlspecialchars($data["yearly_results"][1]["total_income"]) ?> ks</td>
                                    <td class="minus"><?= htmlspecialchars($data["yearly_results"][1]["total_expense"]) ?> ks</td>
                                    <td class="<?= htmlspecialchars($data["yearly_results"][1]["net_budget"] >= 0 ? "plus" : "minus") ?>"><?= htmlspecialchars($data["yearly_results"][1]["net_budget"] >= 0 ? "+" : "") ?><?= htmlspecialchars($data["yearly_results"][1]["net_budget"]) ?> ks</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-12 col-xl-6 my-auto">
                        <div class="total-income-expenses-graph-container row">
                            <h5 class="text-center mb-4">Income Expense Progress Bar</h5>
                            <div class="col-md-12 col-xl-12 d-flex flex-column justify-content-center align-items-center">
                                <div class="total-income-amount progress mb-4 mt-2" style="height: 25px">
                                    <div class="total-expense-amount progress-bar bg-minus" style="width: <?= htmlspecialchars($data["yearly_results"][1]["percentage"]) ?>%;"></div>
                                </div>
                                <div class="text-center text-md-start text-xl-center">
                                    <?php if ($data["yearly_results"][1]["total_income"] == 0 && $data["yearly_results"][1]["total_expense"] == 0): ?>
                                        <p>You have No Income, Expense</p>
                                    <?php elseif ($data["yearly_results"][1]["total_income"] == 0) : ?>
                                        <p>You have No Income</p>
                                    <?php else: ?>
                                        <p><i class="fas fa-chart-line me-2"></i>
                                        <?= htmlspecialchars($data["yearly_results"][1]["percentage"]) ?>&percnt; of your income was spent.</p>
                                    <?php endif ?>

                                </div>

                            </div>
                        </div>
                    </div>
            </section>
            <!-- income-expense-yearly Section Start -->

            <!-- Income Expense Category graph- Section Start -->
            <section class="income-expense-category-pie-graph-section">
                <div class="row">
                    <div class="col-12 my-3 py-3 ps-2 sticky-top" style="background-color: #1a252f;">
                        <h4 class="mb-3">Amount Detail on Category</h4>
                        <a href="#" class="select-btn bg-active text-white d-inline-block py-1 px-3" data-bs-toggle="modal" data-bs-target="#select-dates">
                            <i class="fas fa-calendar-alt me-2"></i>
                            <span><?= htmlspecialchars($data["category_detail"][2]) ?></span>
                        </a>


                        <div class="swip-nav d-md-none d-flex justify-content-flex-start mt-4 mt-md-5 mb-md-3">
                            <a class="income-category-pie-nav active btn text-white select-btn me-3 py-1 px-3">
                                <i class="fas fa-check me-2"></i>Income
                            </a>
                            <a class="expense-category-pie-nav btn text-white select-btn me-3 py-1 px-3">
                                <i class="fas fa-check me-2"></i>Expense
                            </a>
                        </div>


                    </div>

                    <div class="col-12 col-md-6 income-category-pie-container ">
                        <h5 class="mb-4 text-center text-md-start">Income Category Pie Graph</h5>
                        <div class="income-expense-pie-container position-relative mx-auto ms-md-auto">
                            <canvas id="income-category-pie"></canvas>
                        </div>
                        <div class="text-center mx-auto mt-4">
                            <?php if ($data["category_detail"][0][1][3] > 0) : ?>
                                <p>Total Income: <?= htmlspecialchars($data["category_detail"][0][1][3]) ?> ks</p>
                            <?php else : ?>
                                <p>You have No Income</p>
                            <?php endif ?>
                        </div>
                        <ul class="income-categories mx-auto mt-4">
                            <?php foreach ($data["category_detail"][0][0] as $item) : ?>
                                <li class="d-flex py-1 text-white">
                                    <i class="fas fa-square me-3 my-auto" style="color: <?= htmlspecialchars($item->color) ?>;font-size: 22px;"></i>
                                    <span class="flex-fill my-auto"><span class="d-inline-block mb-2"><?= htmlspecialchars($item->name) ?></span><br><span class="border-top border-secondary pt-2"><?= htmlspecialchars($item->amount) ?>ks</span></span>
                                    <span class="my-auto"><?= htmlspecialchars($item->percentage) ?>&percnt;</span>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <div class="col-12 col-md-6 expense-category-pie-container">
                        <h5 class="mb-4 text-center text-md-start">Expense Category Pie Graph</h5>
                        <div class="income-expense-pie-container position-relative mx-auto ms-md-auto">
                            <canvas id="expense-category-pie"></canvas>
                        </div>
                        <div class="text-center mx-auto mt-4">
                            <?php if ($data["category_detail"][1][1][3] > 0) : ?>
                                <p>Total Expense: <?= htmlspecialchars($data["category_detail"][1][1][3]) ?> ks</p>
                            <?php else : ?>
                                <p>You have No Expense</p>
                            <?php endif ?>
                        </div>
                        <ul class="expense-categories mx-auto mt-4">
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
            </section>
            <!-- Income Expense Category graph- Section Start -->

        </div>
    </div>
</main>
<!-- main section end -->

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
    const months = '<?= implode(',', $data["yearly_results"][2]) ?>'.split(",");
    const incomes = '<?= implode(',', $data["yearly_results"][3]) ?>'.split(",");
    const expenses = '<?= implode(',', $data["yearly_results"][4]) ?>'.split(",");

    // Income, Expense Multiple Line Graph
    const labels = [
        "",
        ...months
    ];

    const data = {
        labels: labels,
        datasets: [{
                label: "Income",
                backgroundColor: "#08fa08",
                borderColor: "#08fa08",
                data: [0, ...incomes],
            },
            {
                label: "Expense",
                backgroundColor: "#fa0808",
                borderColor: "#fa0808",
                data: [0, ...expenses],
            },
        ]
    };

    const table_config = {
        type: "line",
        data,
    };

    var table = new Chart(
        document.getElementById("income-expense-multi-line"),
        table_config,
    );

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