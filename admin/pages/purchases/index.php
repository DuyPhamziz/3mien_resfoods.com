<?php
session_start();
if (!isset($_SESSION['staff'])) {
    header('Location: /3mien_resfoods.com/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trang quản trị</title>
    <?php
    include_once __DIR__ . '/../../../layouts/style.php';
    ?>
</head>

<body>
    <?php
    include_once __DIR__ . '/../../layouts/header.php'
    ?>

    <div class="container-fluid">
        <div class="row">
            <?php
            include_once __DIR__ . '/../../layouts/sidebar.php'
            ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Quản lý kho</h1>

                </div>
                <?php
                include_once __DIR__ . '/../../../dbconnect.php';

                $sqlSelectPhieuNhap = "SELECT 
                                            p.pur_id,
                                            s.sup_ten,
                                            s.sup_phone,
                                            p.pur_ngay
                                            
                                        FROM purchases p
                                        JOIN suppliers s ON p.pur_sup_id = s.sup_id
                                        JOIN purchase_detail d ON p.pur_id = d.pur_item_pur_id
                                        GROUP BY p.pur_id, s.sup_ten, s.sup_phone, p.pur_ngay
                                        ORDER BY p.pur_ngay DESC";

                $result = mysqli_query($conn, $sqlSelectPhieuNhap);

                $arrPhieuNhap = [];
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $arrPhieuNhap[] = array(
                        'pur_id' => $row['pur_id'],
                        'sup_ten' => $row['sup_ten'],
                        'sup_phone' => $row['sup_phone'],
                        'pur_ngay' => $row['pur_ngay'],
                    );
                }

                ?>
                <div class="container">

                    <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalInventory">
                        Tồn kho <i class="fa-solid fa-warehouse"></i>
                    </button>
                    <a href="purIventory.php" type="button" class="btn bg-primary-subtle">
                        Nhập/xuất Nguyên liệu <i class="fa-solid fa-plus"></i>
                    </a>
                    <?php if (isset($_SESSION['flash_msg'])): ?>
                        <div data-aos="zoom-in" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out" class="alert alert-<?= $_SESSION['flash_context'] ?>" role="alert">
                            <?= $_SESSION['flash_msg'] ?>
                        </div>
                        <?php unset($_SESSION['flash_msg']) ?>
                    <?php endif; ?>
                    <table class="table table-striped">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên nhà cung cấp</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Ngày giao dịch</th>
                                <th scope="col">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($arrPhieuNhap as $index => $p): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($p['sup_ten']) ?></td>
                                    <td><?= htmlspecialchars($p['sup_phone']) ?></td>
                                    <td><?= htmlspecialchars($p['pur_ngay']) ?></td>
                                    <td class="text-center">
                                        <a href="detail_pur.php?pur_id=<?= urlencode($p['pur_id']) ?>" class="btn btn-sm btn-outline-primary">Chi tiết</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>

            </main>

            <?php
            $sqlSelectInventory = "SELECT 
                                        i.inv_id, i.inv_name, i.inv_donvi,
                                        SUM(CASE WHEN t.inv_trans_loai = 'nhap' THEN t.inv_trans_soluong
                                                WHEN t.inv_trans_loai = 'xuat' THEN -t.inv_trans_soluong ELSE 0 END) AS ton_kho
                                    FROM inventory i
                                    LEFT JOIN inventory_transactions t ON i.inv_id = t.inv_trans_inv_id
                                    GROUP BY i.inv_id, i.inv_name, i.inv_donvi;";
            $resultInven = mysqli_query($conn, $sqlSelectInventory);
            $arrInven = [];
            while ($rowi = mysqli_fetch_array($resultInven, MYSQLI_ASSOC)) {
                $arrInven[] = array(
                    'inv_id' => $rowi['inv_id'],
                    'inv_name' => $rowi['inv_name'],
                    'inv_donvi' => $rowi['inv_donvi'],
                    'ton_kho' => $rowi['ton_kho'],
                );
            }
            ?>
            <div class="modal fade" id="modalInventory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tồn kho</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped">
                                <thead class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">Tên nguyên liệu</th>
                                    <th scope="col">Đơn vị</th>
                                    <th scope="col">Tồn kho</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($arrInven as $index => $i): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= $i['inv_name'] ?></td>
                                            <td><?= $i['inv_donvi'] ?></td>
                                            <td><?= $i['ton_kho'] ?></td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../../layouts/script.php';
    ?>
    <script>
        document.querySelectorAll('.btn-open-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                document.getElementById('btn-confirm-delete').href = `delete.php?sup_id=${id}`;

            });
        });
    </script>

    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
        });
    </script>
</body>

</html>