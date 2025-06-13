<?php
session_start();
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
                    <h1 class="h2">Quản lý nhà sản xuất</h1>

                </div>
                <?php
                include_once __DIR__ . '/../../../dbconnect.php';

                $sqlSelectPhieuNhap = "SELECT 
                                    p.pur_id, s.sup_ten, s.sup_phone, p.pur_ngay, 
                                    SUM(pd.pur_item_soluong * pd.pur_item_dongia) AS tong_tien
                                FROM purchases p
                                JOIN suppliers s ON p.pur_sup_id = s.sup_id
                                JOIN purchase_detail pd ON pd.pur_item_pur_id = p.pur_id
                                GROUP BY p.pur_id, s.sup_ten, p.pur_ngay;";

                $result = mysqli_query($conn, $sqlSelectPhieuNhap);

                $arrPhieuNhap = [];
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $arrPhieuNhap[] = array(
                        'pur_id' => $row['pur_id'],
                        'sup_ten' => $row['sup_ten'],
                        'sup_phone' => $row['sup_phone'],
                        'pur_ngay' => $row['pur_ngay'],
                        'tong_tien' => $row['tong_tien'],
                    );
                }
                ?>
                <div class="container">
                    <a href="create.php" type="button" class="btn btn-primary ">
                        Thêm mới <i class="fa-solid fa-plus"></i>
                    </a>
                    <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalInventory">
                        Tồn kho <i class="fa-solid fa-warehouse"></i>
                    </button>
                    <a href="create.php" type="button" class="btn bg-primary-subtle">
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
                            <th scope="col">#</th>
                            <th scope="col">Tên nhà cung cấp</th>
                            <th scope="col">Ngày giao dịch</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Hành động</th>

                        </thead>
                        <tbody>
                            <?php foreach ($arrPhieuNhap as $index => $p): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $p['sup_ten'] ?> <br />(<?= $p['sup_phone'] ?>)</td>
                                    <td><?= $p['pur_ngay'] ?></td>
                                    <td><?= $p['tong_tien'] ?></td>
                                    <td>

                                        <a href="edit.php?pur_ma=<?= $p['pur_id'] ?>" type="button" class="btn btn-warning">
                                            <i class="fa-solid fa-pencil"></i></a>
                                        <a href="#" class="btn btn-danger btn-open-modal"
                                            data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                                            data-id="<?= intval($p['pur_id']) ?>"
                                            data-name="<?= htmlspecialchars($p['sup_ten'], ENT_QUOTES, 'UTF-8') ?>">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </main>
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Cảnh báo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc muốn xóa Nhà cung cấp này?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a id="btn-confirm-delete" class="btn btn-danger">Xác nhận XÓA</a>
                        </div>
                    </div>
                </div>
            </div>
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