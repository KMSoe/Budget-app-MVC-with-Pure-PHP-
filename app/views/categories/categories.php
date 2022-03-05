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
<?php if (isset($_GET['deleted'])) : ?>
    <div class="alert alert-danger">
        Deleted.
    </div>
<?php endif ?>
<?php if (isset($_GET['added'])) : ?>
    <?php if ($_GET['type'] === "income") : ?>
        <div class="alert alert-success">
            Income Category is successfully added.
        </div>
    <?php elseif ($_GET['type'] === "expense") : ?>
        <div class="alert alert-danger">
            Expense Category is added.
        </div>
    <?php endif ?>
<?php endif ?>
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
                        <li class="breadcrumb-item active"><a href="#" class=""><i class="fas fa-th-large me-2"></i>Categories</a></li>
                    </ol>
                </div>
            </section>
            <!-- Breadcrumb Section End -->

            <!-- Categories Section Start -->
            <section class="categories-section row justify-content-center py-4">
                <h3 class="text-center">Categories</h3>
                <div class="col-md-9 col-lg-12 px-3 px-lg-5">
                    <div class="swip-nav d-lg-none d-flex justify-content-center my-3">
                        <a class="income-nav active btn text-white select-btn me-3 py-1 px-3">
                            <i class="fas fa-check me-2"></i>Income
                        </a>
                        <a class="expense-nav btn text-white select-btn me-3 py-1 px-3">
                            <i class="fas fa-check me-2"></i>Expense
                        </a>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-6 income-categories-container">
                            <h5 class="mb-3 ps-5">Income Categories</h5>
                            <ul class="income-categories pe-4">
                                <?php if (count($data['income-categories']) > 0) : ?>
                                    <?php foreach ($data['income-categories'] as $cat) : ?>
                                        <li class="d-flex py-2">
                                            <i class="cat-icon <?= htmlspecialchars($cat->class) ?> me-3 my-auto" style="background-color: <?= htmlspecialchars($cat->color) ?>;"></i>
                                            <span class="flex-fill my-auto text-end text-lg-center"><?= htmlspecialchars(ucwords($cat->name)) ?></span>
                                            <?php if ($data["user"]->role === "admin") : ?>
                                                <!-- <i class="cat-icon fas fa-minus-circle my-auto"></i> -->
                                                <form action="" class="mt-2" style="box-sizing: border-box;">
                                                    <button class="my-auto" style="outline: none;border: none;background-color: unset;" type="submit"><i class="cat-icon fas fa-minus-circle"></i></button>
                                                </form>
                                            <?php endif ?>
                                        </li>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <p class="text-center text-muted mt-5">No category</p>
                                <?php endif ?>
                            </ul>
                            <a href="<?= htmlspecialchars(URLROOT) ?>categories/add?type=income" class="my-3 ms-4 btn bg-active text-white">
                                <i class="fas fa-plus"></i>
                                <span class="text-uppercase">Add Income Category</span>
                            </a>
                        </div>
                        <div class="col-lg-6 expense-categories-container">
                            <h5 class="mb-3 ps-5">Expense Categories</h5>
                            <ul class="expense-categories pe-4">
                                <?php if (count($data['expense-categories']) > 0) : ?>
                                    <?php foreach ($data['expense-categories'] as $cat) : ?>
                                        <li class="d-flex py-2">
                                            <i class="cat-icon <?= htmlspecialchars($cat->class) ?> me-3 my-auto" style="background-color: <?= htmlspecialchars($cat->color) ?>;"></i>
                                            <span class="flex-fill my-auto text-end text-lg-center"><?= htmlspecialchars(ucwords($cat->name)) ?></span>
                                            <?php if ($data["user"]->role === "admin") : ?>
                                                <!-- <i class="cat-icon fas fa-minus-circle my-auto"></i> -->
                                                <form action="" class="mt-2" style="box-sizing: border-box;">
                                                    <button class="my-auto" style="outline: none;border: none;background-color: unset;" type="submit"><i class="cat-icon fas fa-minus-circle"></i></button>
                                                </form>
                                            <?php endif ?>
                                        </li>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <p class="text-center text-muted mt-5">No category</p>
                                <?php endif ?>

                            </ul>

                            <a href="<?= htmlspecialchars(URLROOT) ?>categories/add?type=expense" class="my-3 ms-4 btn btn-danger">
                                <i class="fas fa-plus"></i>
                                <span class="text-uppercase">Add Expense Category</span>
                            </a>

                        </div>
                    </div>
                </div>
            </section>
            <!-- Categories Section Start -->
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