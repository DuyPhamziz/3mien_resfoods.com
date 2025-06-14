<?php
session_start();
include_once __DIR__ . '/../../../dbconnect.php';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Cập nhật trạng thái đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['status_id'])) {
    $orderId = $_POST['order_id'];
    $statusId = $_POST['status_id'];

    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $statusId, $orderId);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF'] . "?page=" . $page);
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Trang thanh toán & quản lý</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once __DIR__ . '/../../../layouts/style.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .nav-tabs .nav-link.active {
            background-color: #ffc107;
            color: black;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include_once __DIR__ . '/../../layouts/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../../layouts/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
                <ul class="nav nav-tabs mb-4" id="tabMenu" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="checkout-tab" data-bs-toggle="tab" data-bs-target="#user-checkout" type="button" role="tab">Người dùng: Xác nhận thanh toán</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin-orders" type="button" role="tab">Admin: Quản lý đơn hàng</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment-management" type="button" role="tab">Admin: Quản lý thanh toán</button>
                    </li>
                </ul>

                <div class="tab-content" id="tabContent">
                    <!-- TAB 1: Người dùng xác nhận thanh toán -->
                    <div class="tab-pane fade show active" id="user-checkout" role="tabpanel">
                        <?php
                        $sql = "SELECT * FROM orders WHERE status = 1"; // trạng thái chờ thanh toán
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0): ?>
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Số điện thoại</th>
                                        <th>Số bàn</th>
                                        <th>Thời gian đặt</th>
                                        <th>Ghi chú</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($order = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?= $order['id'] ?></td>
                                            <td><?= $order['customer_id'] ?></td>
                                            <td>...</td>
                                            <td><?= $order['table_id'] ?></td>
                                            <td><?= $order['booking_time'] ?></td>
                                            <td><?= $order['note'] ?></td>
                                            <td>Chờ thanh toán</td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-muted">Không có đơn hàng nào đang chờ thanh toán.</p>
                        <?php endif; ?>
                    </div>

                    <!-- TAB 2: Admin quản lý đơn hàng -->
                    <div class="tab-pane fade" id="admin-orders" role="tabpanel">
                        <?php
                        $sqlSelectDonHang = "SELECT 
                            o.id AS order_id,
                            cus.fullname AS customer,
                            cus.phone AS phone,
                            o.table_id AS table_number,
                            o.booking_time AS booking,
                            o.note AS notes,
                            o.order_time AS order_time,
                            os.status AS status,
                            os.id AS status_id
                            FROM orders o
                            JOIN order_status os ON o.status = os.id
                            JOIN customers cus ON cus.id = o.customer_id
                            ORDER BY o.id DESC
                            LIMIT $limit OFFSET $offset";

                        $result = mysqli_query($conn, $sqlSelectDonHang);
                        $arrDonHang = [];
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $arrDonHang[] = $row;
                        }

                        $resultStatus = mysqli_query($conn, "SELECT * FROM order_status");
                        $arrStatus = [];
                        while ($row = mysqli_fetch_array($resultStatus, MYSQLI_ASSOC)) {
                            $arrStatus[] = $row;
                        }

                        $rowCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders"));
                        $totalOrders = $rowCount['total'];
                        $totalPages = ceil($totalOrders / $limit);
                        ?>

                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên khách</th>
                                    <th>Bàn</th>
                                    <th>Thời gian</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($arrDonHang as $index => $p): ?>
                                    <tr>
                                        <td><?= ($offset + $index + 1) ?></td>
                                        <td><?= $p['order_id'] ?></td>
                                        <td><?= $p['customer'] ?><br>(<?= $p['phone'] ?>)</td>
                                        <td><?= $p['table_number'] ?></td>
                                        <td><?= $p['booking'] ?></td>
                                        <td>
                                            <form method="post">
                                                <input type="hidden" name="order_id" value="<?= $p['order_id'] ?>">
                                                <select name="status_id" onchange="this.form.submit()">
                                                    <option value="">-- Chọn --</option>
                                                    <?php foreach ($arrStatus as $sta): ?>
                                                        <option value="<?= $sta['id'] ?>" <?= ($p['status_id'] == $sta['id']) ? 'selected' : '' ?>>
                                                            <?= $sta['status'] ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="get_order_detail.php?pur_ma=<?= $p['order_id'] ?>" class="btn btn-sm btn-warning">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <!-- Phân trang -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    </div>

                    <!-- TAB 3: Admin quản lý thanh toán -->
                    <div class="tab-pane fade" id="payment-management" role="tabpanel">
                        <?php
                        $sqlPayments = "SELECT 
                            p.id AS payment_id, p.order_id, p.amount, 
                            p.payment_method, p.status,
                            o.booking_time, o.table_id, 
                            c.fullname 
                        FROM payments p
                        JOIN orders o ON p.order_id = o.id
                        LEFT JOIN customers c ON o.customer_id = c.id
                        ORDER BY p.id DESC";

                        $resultPayments = mysqli_query($conn, $sqlPayments);
                        ?>

                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Mã đơn hàng</th>
                                    <th>Khách hàng</th>
                                    <th>Bàn</th>
                                    <th>Thời gian đặt</th>
                                    <th>Số tiền</th>
                                    <th>Phương thức</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                while ($row = mysqli_fetch_assoc($resultPayments)): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td>#<?= $row['order_id'] ?></td>
                                        <td><?= htmlspecialchars($row['fullname'] ?? 'Khách lẻ') ?></td>
                                        <td><?= $row['table_id'] ?></td>
                                        <td><?= $row['booking_time'] ?></td>
                                        <td class="text-danger fw-bold"><?= number_format($row['amount'], 0, ',', '.') ?> đ</td>
                                        <td><?= ucfirst($row['payment_method']) ?></td>
                                        <td>
                                            <?php if ($row['status'] == 'paid'): ?>
                                                <span class="badge bg-success">Đã thanh toán</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?= $row['status'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>