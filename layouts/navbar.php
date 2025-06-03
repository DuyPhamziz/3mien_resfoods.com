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
                <ul>
                    <?php if (isset($_SESSION['user'])): ?>
                        <li>👤 Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong></li>
                        <li><a href="logout.php">Đăng xuất</a></li>
                    <?php else: ?>
                        <li><a href="register.php">Đăng ký</a></li>
                        <li><a href="login.php">Đăng nhập</a></li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-cente">

        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">3 Miền Foods</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Trang chủ<br></a></li>
                    <li><a href="#about">Giới thiệu </a></li>

                    <li><a href="#events">Sự kiện</a></li>
                    <li><a href="#chefs">Đầu bếp</a></li>

                    <li class="dropdown"><a href="#"><span>Thực đơn</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="#">Món chính</a></li>
                            <li class="dropdown"><a href="#"><span>Ba miền</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul>
                                    <li><a href="#">Miền Bắc</a></li>
                                    <li><a href="#">Miền Trung</a></li>
                                    <li><a href="#">Miền Nam</a></li>

                                </ul>
                            </li>
                            <li><a href="#">Món khai vị</a></li>
                            <li><a href="#">Tráng miệng</a></li>
                            <li><a href="#">Món nước</a></li>
                        </ul>
                    </li>
                    <li><a href="#contact">Liên hệ</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list">Menu</i></i>
            </nav>

            <a class="btn-book-a-table d-none d-xl-block" href="#book-a-table">Đặt bàn ngay</a>

        </div>

    </div>

</header>