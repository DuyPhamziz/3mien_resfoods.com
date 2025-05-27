<?php
session_start();
include_once __DIR__ . '/../../../dbconnect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Danh sách Phiếu Xuất</title>
    <?php include_once __DIR__ . '/../../../layouts/style.php'; ?>
</head>

<body>
    <?php include_once __DIR__ . '/../../layouts/header.php'; ?>

    <div class="container mt-4">
        <h1>Danh sách Phiếu Xuất</h1>

        <?php
        $sql = "SELECT 
        e.exp_id,
        e.exp_ngay,
        e.exp_ghichu,
        i.inv_id,
        i.inv_name,
        i.inv_donvi,
        t.inv_trans_soluong,
        t.inv_trans_ghichu as trans_ghichu
    FROM exports e
    JOIN inventory_transactions t ON e.exp_id = t.inv_trans_exp_id
    JOIN inventory i ON t.inv_trans_inv_id = i.inv_id
    ORDER BY e.exp_ngay DESC, e.exp_id, i.inv_name";

        $result = mysqli_query($conn, $sql);

        $currentExpId = null;
        while ($row = mysqli_fetch_assoc($result)) {
            if ($currentExpId !== $row['exp_id']) {
                if ($currentExpId !== null) {
                    // Đóng bảng chi tiết của phiếu trước
                    echo "</tbody></table><hr>";
                }
                $currentExpId = $row['exp_id'];
                echo "<h3>Phiếu xuất #{$row['exp_id']} - Ngày: {$row['exp_ngay']}</h3>";
                echo "<p>Ghi chú: " . nl2br(htmlspecialchars($row['exp_ghichu'])) . "</p>";
                echo "<table class='table table-bordered'>";
                echo "<thead><tr>
            <th>Tên nguyên liệu</th>
            <th>Đơn vị</th>
            <th>Số lượng xuất</th>
            <th>Ghi chú chi tiết</th>
          </tr></thead><tbody>";
            }

            echo "<tr>
        <td>" . htmlspecialchars($row['inv_name']) . "</td>
        <td>" . htmlspecialchars($row['inv_donvi']) . "</td>
        <td>" . htmlspecialchars($row['inv_trans_soluong']) . "</td>
        <td>" . htmlspecialchars($row['trans_ghichu']) . "</td>
      </tr>";
        }

        if ($currentExpId !== null) {
            echo "</tbody></table>";
        }

        ?>


    </div>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>
</body>

</html>