<?php
session_start();
include_once __DIR__ . '/dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnSave'])) {
    if (!isset($_SESSION['order_data'])) {
        die("Không có dữ liệu đơn hàng để thanh toán.");
    }

    $order_data = $_SESSION['order_data'];
    $menu_ids = $order_data['menu_ids'];
    $quantities = $order_data['quantities'];
    $notes = $order_data['notes'];
    $booking_time = str_replace('T', ' ', $order_data['booking_time']);
    $table_id = intval($order_data['table_id']);
    $note_order = implode("; ", $notes);
    $customer_id = $_SESSION['customer_id'] ?? 0;

    $booking_time = $conn->real_escape_string($booking_time);
    $note_order = $conn->real_escape_string($note_order);

    $sqlInsertOrder = "INSERT INTO orders (customer_id, table_id, booking_time, note)
                       VALUES ($customer_id, $table_id, '$booking_time', '$note_order')";

    if (!$conn->query($sqlInsertOrder)) {
        die("Lỗi khi tạo đơn hàng: " . $conn->error);
    }

    $order_id = $conn->insert_id;
    $total_price = 0;

    for ($i = 0; $i < count($menu_ids); $i++) {
        $menu_id = intval($menu_ids[$i]);
        $quantity = intval($quantities[$i] ?? 0);
        $note_item = $conn->real_escape_string($notes[$i] ?? "");

        $resultPrice = $conn->query("SELECT price FROM menu_items WHERE id = $menu_id");
        $price = ($resultPrice && $rowPrice = $resultPrice->fetch_assoc()) ? $rowPrice['price'] : 0;

        $total_price += $price * $quantity;

        $sqlInsertOrderItem = "INSERT INTO order_items (order_id, menu_item_id, note, quantity, price)
                               VALUES ($order_id, $menu_id, '$note_item', $quantity, $price)";
        $conn->query($sqlInsertOrderItem);
    }

    unset($_SESSION['order_data']);

    echo "<!DOCTYPE html>";
    echo "<html lang='vi'>";
    echo "<head>";
    echo "  <meta charset='UTF-8'>";
    echo "  <meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "  <title>Đơn hàng thành công</title>";
    echo "  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>";
    echo "  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container mt-5'>";
    echo "<div class='alert alert-light border border-warning shadow-lg p-5 rounded text-center'>";
    echo "<h3 class='text-warning'><i class='fas fa-check-circle me-2'></i>Đơn hàng #$order_id đã được tạo thành công!</h3>";
    echo "<p class='fs-5 mt-3'><i class='fas fa-money-bill-wave me-2 text-success'></i><strong>Tổng tiền:</strong> " . number_format($total_price, 0, ',', '.') . " đ</p>";
    echo "<a href='index.php' class='btn btn-warning mt-3'><i class='fas fa-home me-1'></i>Về trang chủ</a>";
    echo "</div>";
    echo "</div>";
    exit();
    echo "</body>";
    echo "</html>";  
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_ids = $_POST['menu_id'] ?? [];
    $quantities = $_POST['quantity'] ?? [];
    $notes = $_POST['note'] ?? [];
    $booking_time = $_POST['booking_time'] ?? null;
    $table_id = intval($_POST['table_id'] ?? 0);

    $_SESSION['order_data'] = [
        'menu_ids' => $menu_ids,
        'quantities' => $quantities,
        'notes' => $notes,
        'booking_time' => $booking_time,
        'table_id' => $table_id,
    ];
}

if (!isset($_SESSION['order_data'])) {
    die("Không có dữ liệu đơn hàng.");
}

$order_data = $_SESSION['order_data'];
$menu_ids = $order_data['menu_ids'];
$quantities = $order_data['quantities'];
$notes = $order_data['notes'];
$booking_time = $order_data['booking_time'];
$table_id = $order_data['table_id'];
$customer_id = $_SESSION['customer_id'] ?? 0;
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng</title>
    <?php include_once __DIR__ . '/layouts/style.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #fffef5;
        }

        .table th {
            background-color: #f4c10f;
            color: #000;
        }

        .btn-warning {
            background-color: #f4c10f;
            border-color: #f4c10f;
            color: #000;
        }

        .btn-warning:hover {
            background-color: #e0af00;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="bg-light p-4 rounded shadow">
            <h2 class="mb-4 fw-bold text-center text-warning">Xác nhận đơn hàng</h2>

            <p><strong><i class="fas fa-clock"></i> Thời gian đặt:</strong> <?= htmlspecialchars(str_replace('T', ' ', $booking_time)) ?></p>
            <p><strong><i class="fa-solid fa-chair"></i> Bàn số:</strong> <?= htmlspecialchars($table_id) ?></p>

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-hover align-middle text-center shadow-sm">
                    <thead>
                        <tr>
                            <th>Tên món</th>
                            <th>Số lượng</th>
                            <th>Ghi chú</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_price = 0;
                        foreach ($menu_ids as $index => $menu_id):
                            $quantity = intval($quantities[$index] ?? 0);
                            $note_item = $notes[$index] ?? '';

                            $result = $conn->query("SELECT menu_name, price FROM menu_items WHERE id = " . intval($menu_id));
                            if ($result && $menu = $result->fetch_assoc()):
                                $item_total = $menu['price'] * $quantity;
                                $total_price += $item_total;
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($menu['menu_name']) ?></td>
                                <td><?= $quantity ?></td>
                                <td><?= htmlspecialchars($note_item) ?></td>
                                <td><?= number_format($menu['price'], 0, ',', '.') ?> đ</td>
                                <td class="fw-bold text-danger"><?= number_format($item_total, 0, ',', '.') ?> đ</td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-danger">Món ăn không tồn tại (ID: <?= htmlspecialchars($menu_id) ?>)</td>
                            </tr>
                        <?php endif; endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-warning fw-bold">
                            <td colspan="4" class="text-end">Tổng cộng:</td>
                            <td><?= number_format($total_price, 0, ',', '.') ?> đ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="reservations.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại chọn món
                </a>
                <form action="" method="post">
                    <button type="submit" name="btnSave" class="btn btn-warning">
                        <i class="fas fa-check-circle"></i> Xác nhận & Thanh toán
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
