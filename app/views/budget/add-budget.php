<?php
include_once "../app/views/partials/head.php";
?>
<link rel="stylesheet" href="<?= htmlspecialchars(URLROOT) ?>css/jquery-ui.min.css">
<?php if (isset($_GET['error'])) : ?>
    <div class="alert alert-danger">
        Error!!!
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
            <!-- Main Sidebar Start -->
            <?php
            include_once "../app/views/partials/main-sidebar.php";
            ?>
            <!-- Main Sidebar End -->
        </div>
        <div class="col-md-12 col-lg-9">
            <!-- Breadcrumb Section Start -->
            <section class="breadcrumb-section row justify-content-center pt-4 pb-1">
                <div class="col-md-12 col-lg-10">
                    <ol class="breadcrumb px-2 py-3 mx-3 mb-3">
                        <li class="breadcrumb-item"><a href="<?= htmlspecialchars(URLROOT) ?>" class=""><i class="fas fa-home me-2"></i>Home</a></li>
                        <li class="breadcrumb-item active"><a href="#" class=""><i class="fas fa-plus-circle me-2"></i>Add Income</a></li>
                    </ol>
                </div>
            </section>
            <!-- Breadcrumb Section End -->

            <!-- Add Income Section Start -->
            <section class="add-budget-section row justify-content-center pt-1 pb-4">
                <div class="col-sm-11 col-md-8 col-lg-7 col-xl-6 px-4">
                    <h4 class="text-center mb-4">
                        <i class="<?= htmlspecialchars($data['type'] === "Income" ? 'plus' : 'minus')  ?> fas fa-dollar-sign me-2"></i>
                        Add <?= htmlspecialchars(ucfirst($data['type'])) ?>
                    </h4>
                    <form action="<?= htmlspecialchars(URLROOT) ?>budget/add" class="add-item-form" method="POST">
                        <div class="row g-0 mb-3">
                            <div class="col-sm-3 my-auto">
                                <i class="fas fa-calendar-alt text-white me-1"></i>
                                <label for="date" class="text-white">Date</label>
                            </div>
                            <div class="col-sm-9 form-group position-relative">
                                <!-- <input type="date" class="form-control" id="pick-date" placeholder="Today" value=""> -->
                                <input type="text" id="datepicker" name="date" class="form-control" placeholder="Today" autocomplete="off">
                                <i class="fas fa-calendar-alt text-white position-absolute input-field-symbol"></i>
                            </div>
                        </div>
                        <div class="row g-0 mb-3">
                            <div class="col-sm-3 my-auto">
                                <i class="fas fa-th-large text-white me-1"></i>
                                <label for="category-id" class="text-white">Category</label>
                            </div>
                            <div class="col-sm-9">
                                <select id="category-id" name="category-id" class="w-100 form-select text-white">
                                    <?php foreach ($data['categories'] as $cat) : ?>
                                        <option value="<?= htmlspecialchars($cat->id) ?>"><?= htmlspecialchars($cat->name) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="other-category-input row g-0 mb-3">
                                <div class="col-sm-3 my-auto">
                                    <i class="fas fa-calendar-alt text-white me-1"></i>
                                    <label for="category" class="text-white">Remark</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="category" class="form-control d-inline-block"
                                        placeholder="Add category name you like">
                                </div>
                            </div> -->
                        <div class="row g-0 mb-3">
                            <div class="col-sm-3 my-auto">
                                <i class="fas fa-pen text-white me-1"></i>
                                <label for="remark" class="text-white">Remark</label>
                                <br class="d-none d-md-inline-block">&nbsp;
                            </div>
                            <div class="col-sm-9">
                                <input type="hidden" name="type" value="<?= htmlspecialchars(strtolower($data["type"])) ?>">
                                <input type="text" id="remark" name="remark" class="form-control d-inline-block" placeholder="Write a remark">
                                <span class="text-muted">Optional</span>
                            </div>
                        </div>
                        <div class="row g-0 mb-3">
                            <div class="col-sm-3 my-auto">
                                <i class="<?= htmlspecialchars($data['type'] === "Income" ? 'plus' : 'minus')  ?> fas fa-dollar-sign me-1"></i>
                                <label for="amount" class="text-white">Amount</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" id="amount" name="amount" class="form-control d-inline-block" step="0.01" placeholder="Enter amount" onkeyup="disableButtonAddBudget(this)">
                            </div>
                        </div>
                        <div class="row g-0 my-3">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button type="submit" id="btnsubmit" class="btn <?= htmlspecialchars($data['btn-class']) ?> rounded mt-3">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <!-- Add Income Section End -->
        </div>
    </div>
</main>
<!-- main section end -->
<?php
include_once "../app/views/partials/footer.php";
?>

<?php
include_once "../app/views/partials/end.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(function(){
        $("#datepicker").datepicker();
    });
</script>