<?php
include_once __DIR__ . '/../../../dbconnect.php';

$orderId = $_GET['pur_ma'] ?? 0;

$sqlItems = "SELECT 
                menu.menu_name AS menu_name,
                menu.img AS menu_img,
                menu.price AS menu_price,
                SUM(ot.quantity) AS quantity
            FROM order_items ot
            JOIN menu_items menu ON ot.menu_item_id = menu.id
            WHERE ot.order_id = ?
            GROUP BY menu.id, menu.menu_name, menu.img, menu.price";

$stmt = $conn->prepare($sqlItems);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$resultItems = $stmt->get_result();

$grandTotal = 0;
?>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>#</th>
                <th>Tên món</th>
                <th>Hình ảnh</th>
                <th>Giá (vnđ)</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php $i = 1; ?>
            <?php while ($item = $resultItems->fetch_assoc()): ?>
                <?php
                $total = $item['menu_price'] * $item['quantity'];
                $grandTotal += $total;
                ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($item['menu_name']) ?></td>
                    <td>
                        <img src="<?= htmlspecialchars($item['menu_img']) ?>" class="img-thumbnail" style="width: 70px; height: 70px; object-fit: cover;">
                    </td>
                    <td><?= number_format($item['menu_price'], 0, ',', '.') ?>đ</td>
                    <td><?= $item['quantity'] ?></td>
                    <td><strong><?= number_format($total, 0, ',', '.') ?>đ</strong></td>
                </tr>
            <?php endwhile; ?>
            <tr class="table-warning fw-bold">
                <td colspan="5" class="text-end">Tổng cộng:</td>
                <td><?= number_format($grandTotal, 0, ',', '.') ?>đ</td>
            </tr>
        </tbody>
    </table>
</div>