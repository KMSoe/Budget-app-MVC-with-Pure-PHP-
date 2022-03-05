<!-- header start -->
<header>
    <div class="container-fluid px-0">
        <nav class="">
            <div class="row g-0">
                <div class="col-12 col-lg-12">
                    <div class="main-nav d-flex">
                        <div class="ms-2">
                            <a href="#" type="button" class="menu-toggle d-lg-none">
                                <i class="fas fa-bars"></i>
                            </a>
                            <a href="<?= htmlspecialchars(URLROOT) ?>" class="navbar-brand ms-2">
                                Budget
                            </a>
                        </div>

                        <ul class="nav py-2">
                            <li class="nav-item dropdown">
                                <a href="#" style="box-sizing: border-box;" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                    <img src="<?= empty($data["user"]->photo) ? htmlspecialchars(URLROOT . "images/profile.svg") : htmlspecialchars(URLROOT . "images/" . $data["user"]->photo) ?>" alt="<?= htmlspecialchars($data["user"]->name) ?>" class="img-fluid profile-img"> <span class="username text-white px-2 py-2 d-none d-lg-inline-block"><?= htmlspecialchars($data["user"]->name) ?></span>
                                </a>
                                <ul class="dropdown-menu bg-main">
                                    <li class="">
                                        <a href="<?= htmlspecialchars(URLROOT) ?>profile" class="dropdown-item text-white hover-customise">User Profile</a>
                                    </li>
                                    <li>
                                        <a href="<?= htmlspecialchars(URLROOT) ?>auth/signout" class="dropdown-item text-white hover-customise">Sign out</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </nav>
    </div>
</header>
<!-- header end -->