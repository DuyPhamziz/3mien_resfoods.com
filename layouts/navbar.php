<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header id="header" class="header fixed-top">

    <div class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">3mien.resfoods@gmail.com</a></i>
                <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5555 55455 55</span></i>
            </div>
            <div class="languages d-none d-md-flex align-items-center">
                <ul class="list-unstyled d-flex mb-0">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="me-3">👤 Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong></li>
                        <li><a href="logout.php">Đăng xuất</a></li>
                    <?php else: ?>
                        <li class="me-3"><a href="register.php">Đăng ký</a></li>
                        <li><a href="login.php">Đăng nhập</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">

        <div class="container position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename mb-0">3 Miền Foods</h1>
            </a>

            <!-- Bootstrap Navbar -->
            <nav id="navmenu" class="navbar navbar-expand-xl p-0">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="bi bi-list"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto text-white">
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="#hero">Trang chủ</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="#about">Giới thiệu</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="#events">Sự kiện</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="#chefs">Đầu bếp</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#menu">Thực đơn</a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link text-white" href="#contact">Liên hệ</a>
                        </li>

                    </ul>
                </div>
            </nav>

            <a class="cta-btn d-none d-xl-block btn btn-outline-warning" href="#book-a-table">Đặt bàn ngay</a>

        </div>

    </div>

</header>