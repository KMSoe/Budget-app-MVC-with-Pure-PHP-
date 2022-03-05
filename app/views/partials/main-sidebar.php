<!-- Main Sidebar Start -->
<aside class="main-sidebar">
    <span class="close-sidebar-btn">
        <i class="fas fa-times"></i>
    </span>
    <div class="side-inner">
        <div class="profile mx-auto text-center">
            <img src="<?= empty($data["user"]->photo) ? htmlspecialchars(URLROOT . "images/profile.svg") : htmlspecialchars(URLROOT . "images/" . $data["user"]->photo) ?>" alt="<?= htmlspecialchars($data["user"]->name) ?>" class="img-fluid">
            <h3 class="name"><?= htmlspecialchars($data["user"]->name) ?></h3>
            <span class="email text-muted"><?= htmlspecialchars($data["user"]->email) ?></span>
            <!-- <a href="#" class="align-self-center btn btn-primary mt-2">Profile</a> -->
        </div>

        <div class="nav-menu">
            <ul>
                <li class="<?= htmlspecialchars($data["page"] === "home" ? "active" : "") ?>"><a href="<?= htmlspecialchars(URLROOT) ?>"><i class="fas fa-home me-2"></i>Dashboard</a></li>
                <li class="<?= htmlspecialchars($data["page"] === "profile" ? "active" : "") ?>"><a href="<?= htmlspecialchars(URLROOT) ?>profile"><i class="fas fa-user me-2"></i></i>Profile</a></li>
                <li class="<?= htmlspecialchars($data["page"] === "categories" ? "active" : "") ?>"><a href="<?= htmlspecialchars(URLROOT) ?>categories"><i class="fas fa-th-large me-2"></i>Categories</a></li>
                <li class="<?= htmlspecialchars($data["page"] === "statistics" ? "active" : "") ?>"><a href="<?= htmlspecialchars(URLROOT) ?>statistics"><i class="fas fa-chart-line me-2"></i></i>Statistics</a></li>

                <li><a href="<?= htmlspecialchars(URLROOT) ?>auth/signout"><i class="fas fa-sign-out-alt me-2"></i>Sign out</a></li>
            </ul>

            <ul class="mt-3 border-top border-color-muted">
                <li>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#share">
                        <i class="fas fa-share-alt me-2"></i>Share Budget
                    </a>
                </li>
                <li>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#rate">
                        <i class="fas fa-star me-2"></i>Rate Budget
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>

<!-- Main Sidebar End -->
