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
            <section class="breadcrumb-section row justify-content-center pt-4 pb-2">
                <div class="col-md-12 col-lg-10">
                    <ol class="breadcrumb px-2 py-3 mx-3 mb-3">
                        <li class="breadcrumb-item"><a href="<?= htmlspecialchars(URLROOT) ?>" class=""><i class="fas fa-home me-2"></i>Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= htmlspecialchars(URLROOT) ?>categories" class=""><i class="fas fa-th-large me-2"></i>Categories</a></li>
                        <li class="breadcrumb-item active"><a href="#" class=""><i class="fas fa-plus-circle me-2"></i>Add <?= htmlspecialchars($data["type"]) ?> Category</a></li>
                    </ol>
                </div>
            </section>
            <!-- Breadcrumb Section End -->

            <!-- Add Categories Section Start -->
            <section class="add-categories-section row justify-content-center">
                <div class="col-sm-11 col-md-8 col-lg-7 col-xl-6 px-4">
                    <h4 class="mt-2">
                        <i class="fas fa-file-invoice-dollar <?= htmlspecialchars($data["type"]) === "Income" ? 'plus' : 'minus' ?> me-2"></i>
                        <?= htmlspecialchars($data["type"]) ?> Category
                    </h4>
                    <form action="" method="post" class="my-3 py-2">
                        <div class="icons-container d-flex flex-wrap p-2 mb-3 mx-auto">
                            <?php foreach ($data["icons"] as $icon) : ?>
                                <i class="cat-icon <?= htmlspecialchars($icon->class) ?> mx-2 my-2" style="background-color: <?= htmlspecialchars($icon->color) ?>;" data-id="<?= htmlspecialchars($icon->id) ?>"></i>
                            <?php endforeach ?>
                        </div>
                        <div class="row g-0">
                            <div class="col-3 input-group mb-3">
                                <span class="input-group-text" id="selected-icon"><i class="cat-icon health fas fa-first-aid"></i></span>
                                <input type="hidden" id="icon-id" class="form-control" name="icon-id" value="">
                                <input type="hidden" class="form-control" name="type" value="<?= htmlspecialchars(strtolower($data["type"])) ?>">
                            </div>
                            <div class="col-9 form-floating mb-3">

                                <input type="hidden" value="<?= htmlspecialchars(strtolower($data["type"])) ?>">
                                <input type="text" class="form-control mb-1" id="name" name="name" placeholder="category name" autocomplete="off">
                                <small>0-15 letters</small>
                                <label for="name">category name</label>
                            </div>
                        </div>
                        <div class="row g-0">
                            <div class="col-3"></div>
                            <div class="col-9">
                                <button class="btn <?= htmlspecialchars($data["btn-class"]) ?> ms-2">Add</button>

                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <!-- Add Categories Section Start -->
        </div>
    </div>
</main>
<!-- main section end -->

<!-- Share App modal -->
<div class="modal" id="select-icon">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="py-3">
                <h5 class="modal-title text-black text-center">Share on</h5>
            </div>
            <div class="modal-body">
                <a href="#">
                    <i class="fab fa-facebook"></i>
                    <p class="text-black">facebook</p>
                </a>

            </div>
            <div class="pt-2 pb-3 text-center">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel</button>
            </div>
        </div>
    </div>
</div>
<?php
include_once "../app/views/partials/footer.php";
?>
<?php
include_once "../app/views/partials/end.php";
?>