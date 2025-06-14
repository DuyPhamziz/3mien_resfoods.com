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
                    <h1 class="h2">Quản trị bàn</h1>    
                </div>
                <?php
                include_once __DIR__ . '/../../../dbconnect.php';

                $sqlSelectTables = "SELECT * FROM tables;";

                $resultTables = mysqli_query($conn, $sqlSelectTables);

                $arrTable = [];
                while ($row = mysqli_fetch_array($resultTables, MYSQLI_ASSOC)) {
                    $arrTable[] = array(
                        't_ma' => $row['id'],
                        't_so' => $row['table_number'],
                        't_soluong' => $row['capacity'],
                        't_trangthai' => $row['status'],
                    );
                }
                ?>
                <div class="container">
                    <a href="create.php" type="button" class="btn btn-primary ">
                        Thêm mới <i class="fa-solid fa-plus"></i>
                    </a>
                    <?php if (isset($_SESSION['flash_msg'])): ?>
                        <div data-aos="zoom-in" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out" class="alert alert-<?= $_SESSION['flash_context'] ?>" role="alert">
                            <?= $_SESSION['flash_msg'] ?>
                        </div>
                        <?php unset($_SESSION['flash_msg']) ?>
                    <?php endif; ?>
                    <table class="table table-striped">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Tên bàn</th>
                            <th scope="col">Số người</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Hành động</th>
                        </thead>
                        <tbody>
                            <?php foreach ($arrTable as $t): ?>
                                <tr class="text-center">
                                    <td><?= $t['t_ma'] ?></td>
                                    <td><?= $t['t_so'] ?></td>
                                    <td><?= $t['t_soluong'] ?></td>
                                    <td><?= $t['t_trangthai'] ?></td>
                                    <td>
                                        <a href="edit.php?t_ma=<?= $t['t_ma'] ?>" type="button" class="btn btn-warning">
                                            <i class="fa-solid fa-pencil"></i></a>
                                        <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </main>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Cảnh báo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc muốn xóa Bàn này?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="delete.php?t_ma=<?= $t['t_ma'] ?>" type="button" class="btn btn-primary">Xác nhận XÓA</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../../layouts/script.php';
    ?>
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