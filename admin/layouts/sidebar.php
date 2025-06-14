<?php
$currentPath = $_SERVER['REQUEST_URI'];
?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($currentPath, '/tongquan/') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../tongquan/index.php">
                    <i class="fa-solid fa-house fa-fw"></i> Tổng quan
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($currentPath, '/category/') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../category/index.php">
                    <i class="fa-solid fa-th-large fa-fw"></i> Danh mục
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($currentPath, '/orders/') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../orders/index.php">
                    <i class="fa-solid fa-receipt fa-fw"></i> Đơn hàng
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($currentPath, '/menu_items/') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../menu_items/index.php">
                    <i class="fa-solid fa-utensils fa-fw"></i> Thực đơn
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($currentPath, '/customers/') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../customers/index.php">
                    <i class="fa-solid fa-users fa-fw"></i> Khách hàng
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($currentPath, '/oders/') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../orders/index.php">
                    <i class="fa-solid fa-cart-shopping fa-fw"></i> Đặt hàng
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($currentPath, '/staff/') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../staff/index.php">
                    <i class="fa-solid fa-user-tie fa-fw"></i> Nhân viên
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($currentPath, '/suppliers/') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../suppliers/index.php">
                    <i class="fa-solid fa-truck fa-fw"></i> Nhà cung cấp
                </a>
            </li>

            <li class="nav-item mb-2">
                <a class="nav-link <?= str_contains($currentPath, '/table/') ? 'active bg-warning text-dark' : 'text-dark' ?> rounded d-flex align-items-center gap-2 px-3 py-2" href="../table/index.php">
                    <i class="fa-solid fa-chair fa-fw"></i> Bàn ăn
                </a>
            </li>

        </ul>
    </div>
</nav>
