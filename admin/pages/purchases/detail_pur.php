<?php
        session_start();
        if (!isset($_SESSION['staff'])) {
            header('Location: /3mien_resfoods.com/login.php');
            exit();
        }
include_once __DIR__ . '/../../../dbconnect.php';

$pur_id = isset($_GET['pur_id']) ? (int)$_GET['pur_id'] : 0;

if ($pur_id <= 0) {
    die('ID phiếu nhập không hợp lệ');
}

$sql = "SELECT i.inv_name, pd.pur_item_soluong, pd.pur_item_dongia
        FROM purchase_detail pd
        JOIN inventory i ON pd.pur_item_inv_id = i.inv_id
        WHERE pd.pur_item_pur_id = $pur_id";

$result = mysqli_query($conn, $sql);
?>

<h3>Chi tiết phiếu nhập #<?= htmlspecialchars($pur_id) ?></h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nguyên liệu</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Tổng tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) === 0): ?>
            <tr>
                <td colspan="4" class="text-center">Không có dữ liệu</td>
            </tr>
        <?php else: ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['inv_name']) ?></td>
                    <td><?= (int)$row['pur_item_soluong'] ?></td>
                    <td><?= number_format($row['pur_item_dongia']) ?>đ</td>
                    <td><?= number_format($row['pur_item_dongia'] * $row['pur_item_soluong']) ?>đ</td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </tbody>
</table>