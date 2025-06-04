<?php
$currentDir = basename(dirname($_SERVER['PHP_SELF']));
?>


<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">

            <li class="nav-item mb-2">
                <a class="nav-link <?= $currentPage == 'index.php' ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="index.php">
                    <i class="fa-solid fa-house fa-fw"></i> Tổng quan
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= $currentPage == 'index.php' && str_contains($_SERVER['REQUEST_URI'], 'categories') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../category/index.php">
                    <i class="fa-solid fa-th-large fa-fw"></i> Danh mục
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], 'orders') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../orders/index.php">
                    <i class="fa-solid fa-receipt fa-fw"></i> Đơn hàng
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], 'menu_items') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../menu_items/index.php">
                    <i class="fa-solid fa-utensils fa-fw"></i> Thực đơn
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], 'customers') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../customers/index.php">
                    <i class="fa-solid fa-users fa-fw"></i> Khách hàng
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], 'transactions') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../transactions/index.php">
                    <i class="fa-solid fa-exchange-alt fa-fw"></i> Giao dịch
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], 'bookings') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../bookings/index.php">
                    <i class="fa-solid fa-cart-shopping fa-fw"></i> Đặt hàng
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], 'staff') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../staff/index.php">
                    <i class="fa-solid fa-user-tie fa-fw"></i> Nhân viên
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], 'suppliers') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../suppliers/index.php">
                    <i class="fa-solid fa-truck fa-fw"></i> Nhà cung cấp
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], 'tables') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../tables/index.php">
                    <i class="fa-solid fa-chair fa-fw"></i> Bàn ăn
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], 'revenue') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../revenue/index.php">
                    <i class="fa-solid fa-chart-line fa-fw"></i> Doanh thu
                </a>
            </li>

        </ul>
    </div>
</nav>
