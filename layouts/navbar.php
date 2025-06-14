<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../dbconnect.php';
?>
<header id="header" class="header fixed-top">
    <div class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center">
                    <a href="mailto:3mien.resfoods@gmail.com">3mien.resfoods@gmail.com</a>
                </i>
                <i class="bi bi-phone d-flex align-items-center ms-4">
                    <span>+1 5555 55455 55</span>
                </i>
            </div>
            <div class="languages d-none d-md-flex align-items-center position-relative">
                <ul class="navbar-nav mb-0">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item me-3">
                            <div id="toggleUserMenu" class="nav-link text-white" style="cursor: pointer;">
                                👤 Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong>
                            </div>

                           
                            <div id="userMenu" class="bg-dark text-white rounded shadow position-absolute mt-2 p-2"
                                style="top: 100%; right: 0; display: none; min-width: 220px; z-index: 999;">

                                <a class="dropdown-item custom-hover text-white mb-2" href="#" data-bs-toggle="offcanvas" data-bs-target="#bookingHistory">
                                    Lịch sử đặt bàn
                                </a>

                                <a class="dropdown-item custom-hover text-white mb-2" href="#" data-bs-toggle="offcanvas" data-bs-target="#paymentHistory">
                                    Lịch sử thanh toán
                                </a>

                                <hr class="dropdown-divider border-light">

                                <a class="dropdown-item custom-hover text-danger" href="logout.php">Đăng xuất</a>
                            </div>



                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link text-white" href="register.php">Đăng ký</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="login.php">Đăng nhập</a></li>
                    <?php endif; ?>
                </ul>
            </div>



        </div>
    </div>

    <div class="branding py-3">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <a href="index.php" class="d-flex align-items-center me-3">
                    <img src="assets/img/logo.png" alt="Logo 3 Mien Foods" style="width: 80px; height: 80px;">
                </a>
                <a href="index.php" class="text-decoration-none">
                    <h1 class="sitename mb-0 text-warning">3 Miền Foods</h1>
                </a>
            </div>

            <nav class="navbar navbar-expand-xl p-0">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="bi bi-list text-white"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                    <ul class="navbar-nav gap-3">
                        <li class="nav-item"><a class="nav-link text-white active" href="#hero">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="#about">Giới thiệu</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="#events">Sự kiện</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="#chefs">Đầu bếp</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="#menu">Thực đơn</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="#contact">Liên hệ</a></li>
                    </ul>
                </div>
            </nav>

            <div class="d-none d-xl-block">
                <a class="btn btn-outline-warning" href="#book-a-table">Đặt bàn ngay</a>
            </div>
        </div>
    </div>
</header>

<?php if (isset($_SESSION['user'])): ?>
   
    <div class="offcanvas offcanvas-end" tabindex="-1" id="bookingHistory" aria-labelledby="bookingHistoryLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="bookingHistoryLabel">📅 Lịch sử đặt bàn</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <?php
            $userId = (int)$_SESSION['user']['id'];
            $sql = "SELECT b.table_number, o.order_time, os.status
                    FROM orders o
                    JOIN tables b ON o.table_id = b.id
                    JOIN order_status os ON os.id = o.`status`
                    WHERE o.customer_id = $userId
                    ORDER BY o.order_time DESC";
            $result = mysqli_query($conn, $sql);
            ?>
            <ul class="list-group">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)): ?>
                        <li class="list-group-item">
                            🪑 Bàn số <?= htmlspecialchars($row['table_number']) ?> | 🕒 <?= $row['order_time'] ?><br>
                            Trạng thái: <span class="badge bg-info"><?= htmlspecialchars($row['status']) ?></span>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li class="list-group-item text-muted">Bạn chưa có lịch sử đặt bàn nào.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Offcanvas: Lịch sử thanh toán -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="paymentHistory" aria-labelledby="paymentHistoryLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="paymentHistoryLabel">💳 Lịch sử thanh toán</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <?php
            $sql = "SELECT p.amount, p.payment_time, p.payment_method, p.status
                    FROM payments p
                    JOIN orders o ON p.order_id = o.id
                    WHERE o.customer_id = $userId
                    ORDER BY p.payment_time DESC";
            $result = mysqli_query($conn, $sql);
            ?>
            <ul class="list-group">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)): ?>
                        <li class="list-group-item">
                            💰 <?= number_format($row['amount'], 0, ',', '.') ?>đ | 🕒 <?= $row['payment_time'] ?><br>
                            Phương thức: <?= ucfirst(htmlspecialchars($row['payment_method'])) ?> -
                            Trạng thái: <span class="badge bg-<?= $row['status'] === 'paid' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($row['status']) ?></span>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li class="list-group-item text-muted">Chưa có thanh toán nào được ghi nhận.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>