<?php
session_start();

if (!isset($_SESSION['staff'])) {
    header('Location: ');
    exit();
}



include_once __DIR__ . '/../../../dbconnect.php';

// Xử lý ngày lọc
$startDate = $_GET['start_date'] ?? date('Y-m-01');
$endDate = $_GET['end_date'] ?? date('Y-m-d');

// Truy vấn doanh thu
$sqlRevenue = "
    SELECT DATE(payment_time) AS day, SUM(amount) AS total
    FROM payments
    WHERE status = 'paid'
      AND DATE(payment_time) BETWEEN '$startDate' AND '$endDate'
    GROUP BY day
    ORDER BY day ASC;
";
$resultRevenue = mysqli_query($conn, $sqlRevenue);

$labels = [];
$data = [];
while ($row = mysqli_fetch_array($resultRevenue, MYSQLI_ASSOC)) {
    $labels[] = $row['day'];
    $data[] = $row['total'];
}
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
                function getCount($conn, $table)
                {
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

                <div class="row g-4 mb-4">
                    <?php foreach ($cards as $c): ?>
                        <div class="col-md-6 col-xl-4">
                            <div class="card shadow-sm h-100 border-0 position-relative bg-<?= $c['color'] ?> bg-opacity-10">
                                <div class="card-body position-relative">
                                    <i class="fa <?= $c['icon'] ?> fa-5x text-<?= $c['color'] ?> position-absolute top-50 end-0 translate-middle opacity-10" style="z-index: 0;"></i>
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

                <!-- Biểu đồ doanh thu -->
                <div class="card mb-5">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Biểu đồ doanh thu theo ngày</h5>
                    </div>
                    <div class="card-body">
                        <form class="row g-3 mb-4" method="get">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label">Từ ngày</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $startDate ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label">Đến ngày</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $endDate ?>">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Lọc</button>
                            </div>
                        </form>
                        <canvas id="revenueChart" height="100"></canvas>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: <?= json_encode($data) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN').format(value);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return new Intl.NumberFormat('vi-VN').format(context.parsed.y) + ' VNĐ';
                            }
                        }
                    }
                }
            }
        });
    </script>
    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true
        });
    </script>
</body>

</html>