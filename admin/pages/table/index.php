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
    <title>Trang quản trị bàn</title>
    <?php include_once __DIR__ . '/../../../layouts/style.php'; ?>
    <style>
        .status-1 {
            color: green;
            font-weight: bold;
        }

        .status-2 {
            color: orange;
            font-weight: bold;
        }

        .status-3 {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include_once __DIR__ . '/../../layouts/header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../../layouts/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Quản trị bàn</h1>
                </div>
                <?php
                include_once __DIR__ . '/../../../dbconnect.php';
                $sqlSelectTables = "SELECT * FROM tables;";
                $resultTables = mysqli_query($conn, $sqlSelectTables);

                $arrTable = [];
                while ($row = mysqli_fetch_array($resultTables, MYSQLI_ASSOC)) {
                    $arrTable[] = [
                        't_ma' => $row['id'],
                        't_so' => $row['table_number'],
                        't_soluong' => $row['capacity'],
                        't_trangthai' => $row['status'],
                    ];
                }

                function status_text($s)
                {
                    return match ((int)$s) {
                        1 => "<span class='status-1'>Trống</span>",
                        2 => "<span class='status-2'>Đã đặt</span>",
                        3 => "<span class='status-3'>Đã lấy</span>",
                        default => "<span class='text-muted'>Không rõ</span>"
                    };
                }
                ?>
                <div class="container">
                    <a href="create.php" class="btn btn-primary mb-3">
                        Thêm mới <i class="fa-solid fa-plus"></i>
                    </a>

                    <?php if (isset($_SESSION['flash_msg'])): ?>
                        <div class="alert alert-<?= $_SESSION['flash_context'] ?>" role="alert" data-aos="zoom-in">
                            <?= $_SESSION['flash_msg'] ?>
                        </div>
                        <?php unset($_SESSION['flash_msg']) ?>
                    <?php endif; ?>

                    <table class="table table-striped text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Tên bàn</th>
                                <th>Số người</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($arrTable as $t): ?>
                                <tr>
                                    <td><?= $t['t_ma'] ?></td>
                                    <td><?= $t['t_so'] ?></td>
                                    <td><?= $t['t_soluong'] ?></td>
                                    <td><?= status_text($t['t_trangthai']) ?></td>
                                    <td>
                                        <a href="edit.php?t_ma=<?= $t['t_ma'] ?>" class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $t['t_ma'] ?>">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal<?= $t['t_ma'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $t['t_ma'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel<?= $t['t_ma'] ?>">Xác nhận xóa</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Bạn có chắc muốn xóa bàn <strong><?= $t['t_so'] ?></strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                        <a href="delete.php?t_ma=<?= $t['t_ma'] ?>" class="btn btn-danger">Xác nhận xóa</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>
    <script src="assets/js/main.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
        });
    </script>
</body>

</html>