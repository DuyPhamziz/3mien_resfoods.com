<?php
session_start();
include_once __DIR__ . '/dbconnect.php';

// Nếu là POST từ nút "Thanh toán"
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

    // Tạo đơn hàng
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
        if ($resultPrice && $rowPrice = $resultPrice->fetch_assoc()) {
            $price = $rowPrice['price'];
        } else {
            $price = 0;
        }

        $total_price += $price * $quantity;

        $sqlInsertOrderItem = "INSERT INTO order_items (order_id, menu_item_id, note, quantity, price)
                               VALUES ($order_id, $menu_id, '$note_item', $quantity, $price)";
        $conn->query($sqlInsertOrderItem);
    }

    unset($_SESSION['order_data']);

    echo "<h3>Đơn hàng #$order_id đã được tạo thành công.</h3>";
    echo "<p>Tổng tiền: " . number_format($total_price, 0, ',', '.') . " đ</p>";
    echo "<a href='index.php' class='btn btn-secondary'>Quay lại trang chủ</a>";
    exit();
}

// Nếu là POST từ trang đặt món -> lưu vào session
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

// Nếu không có session, thoát
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
    <link rel="stylesheet" href="/3mien_resfoods.com/assets/css/main.css">
</head>

<body>
    <h2>Xác nhận đơn hàng</h2>
    <p>Thời gian đặt: <?= htmlspecialchars(str_replace('T', ' ', $booking_time)) ?></p>
    <p>Bàn: <?= htmlspecialchars($table_id) ?></p>

    <table>
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
            foreach ($menu_ids as $index => $menu_id) {
                $quantity = intval($quantities[$index] ?? 0);
                $note_item = $notes[$index] ?? '';

                $result = $conn->query("SELECT menu_name, price FROM menu_items WHERE id = " . intval($menu_id));
                if ($result && $menu = $result->fetch_assoc()) {
                    $item_total = $menu['price'] * $quantity;
                    $total_price += $item_total;
            ?>
                    <tr>
                        <td><?= htmlspecialchars($menu['menu_name']) ?></td>
                        <td><?= $quantity ?></td>
                        <td><?= htmlspecialchars($note_item) ?></td>
                        <td><?= number_format($menu['price'], 0, ',', '.') ?> đ</td>
                        <td><?= number_format($item_total, 0, ',', '.') ?> đ</td>
                    </tr>
            <?php
                } else {
                    echo "<tr><td colspan='5'>Món ăn không tồn tại (ID: " . htmlspecialchars($menu_id) . ")</td></tr>";
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Tổng cộng:</th>
                <th><?= number_format($total_price, 0, ',', '.') ?> đ</th>
            </tr>
        </tfoot>
    </table>

    <a href="reservations.php" class="btn btn-secondary">Quay lại chọn món</a>

    <!-- Form thanh toán -->
    <form action="" method="post" style="display:inline;">
        <button type="submit" class="btn btn-primary" name="btnSave">Thanh toán</button>
    </form>
</body>

</html>