<?php
session_start();
include_once __DIR__ . '/../../../dbconnect.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <title>Trang tổng quan quản trị</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include_once __DIR__ . '/../../../layouts/style.php'; ?>
</head>

<body>
    <?php include_once __DIR__ . '/../../layouts/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../../layouts/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Tổng quan quản trị</h1>
                </div>

                <?php
                function getCount($conn, $table) {
                    $sql = "SELECT COUNT(*) AS total FROM $table";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    return $row['total'];
                }

                $cards = [
                                ['title' => 'Khách hàng', 'value' => getCount($conn, 'customers'), 'unit' => 'người', 'color' => 'primary', 'icon' => 'fa-users', 'link' => '../customers'],
                                ['title' => 'Bàn', 'value' => getCount($conn, 'tables'), 'unit' => 'bàn', 'color' => 'success', 'icon' => 'fa-chair', 'link' => '../table'],
                                ['title' => 'Món ăn', 'value' => getCount($conn, 'menu_items'), 'unit' => 'món', 'color' => 'warning', 'icon' => 'fa-utensils', 'link' => '../menu_items'],
                                ['title' => 'Danh mục', 'value' => getCount($conn, 'categories'), 'unit' => 'loại', 'color' => 'info', 'icon' => 'fa-list', 'link' => '../category'],
                                ['title' => 'Nhân viên', 'value' => getCount($conn, 'staff'), 'unit' => 'người', 'color' => 'secondary', 'icon' => 'fa-user-tie', 'link' => '../staff'],
                                ['title' => 'Đơn hàng', 'value' => getCount($conn, 'orders'), 'unit' => 'đơn', 'color' => 'dark', 'icon' => 'fa-receipt', 'link' => '../orders'],
                                ['title' => 'Liên hệ', 'value' => getCount($conn, 'contacts'), 'unit' => 'lượt', 'color' => 'danger', 'icon' => 'fa-envelope', 'link' => '../contact'],
                                ['title' => 'Nhà cung cấp', 'value' => getCount($conn, 'inventory'), 'unit' => 'đơn vị', 'color' => 'secondary', 'icon' => 'fa-truck', 'link' => '../suppliers'],
                            ];

                ?>

                <div class="row g-4">
                    <?php foreach ($cards as $c): ?>
                        <div class="col-md-6 col-xl-4">
                            <div class="card shadow-sm h-100 border-0 position-relative bg-<?= $c['color'] ?> bg-opacity-10">
                                <div class="card-body position-relative">
                                    <!-- Icon nền mờ -->
                                    <i class="fa <?= isset($c['icon']) ? $c['icon'] : 'fa-database' ?> fa-5x text-<?= $c['color'] ?> position-absolute top-50 end-0 translate-middle opacity-10" style="z-index: 0;"></i>
                                    
                                    <!-- Nội dung chính -->
                                    <h5 class="card-title text-<?= $c['color'] ?> fw-bold" style="z-index: 1; position: relative;">
                                        <?= htmlspecialchars($c['title']) ?>
                                    </h5>
                                    <p class="card-text fs-3 fw-bold" style="z-index: 1; position: relative;">
                                        <?= $c['value'] ?> <small class="text-muted fs-6"><?= $c['unit'] ?></small>
                                    </p>
                                    <a href="<?= $c['link'] ?>" class="btn btn-outline-<?= $c['color'] ?> btn-sm" style="z-index: 1; position: relative;">
                                        Xem chi tiết <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </main>
        </div>
    </div>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>
    <script>
        AOS.init({ duration: 1000, easing: 'ease-in-out', once: true });
    </script>
</body>

</html>
