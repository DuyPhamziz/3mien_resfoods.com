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
                    <h1 class="h2">Sửa thông tin bàn</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <div class="dropdown show">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-cannabis"></i> This week
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                include_once __DIR__ . '/../../../dbconnect.php';
                $t_ma = $_GET['t_ma'];
                $sqlSelectTables = "SELECT * FROM tables WHERE id=$t_ma;";

                $rowDulieuCuTables = mysqli_fetch_array(mysqli_query($conn, $sqlSelectTables), MYSQLI_ASSOC);
                $t_tencu = $rowDulieuCuTables['table_number'];
                ?>
                <div class="container">

                    <form action="" method="post">

                        <div class="mb-3">
                            <label for="lsp_ten" class="form-label">Tên bàn</label>
                            <input value="<?= $rowDulieuCuTables['table_number'] ?>" id="t_so" name="t_so" type="text" class="form-control">
                            <div class="form-text">Sửa thông tin bàn</div>
                        </div>
                        <div class="mb-3">
                            <label for="t_soluong" class="form-label">Số lượng</label>
                            <input value="<?= $rowDulieuCuTables['capacity'] ?>" type="text" class="form-control" id="t_soluong" name="t_soluong">
                        </div>

                        <a href="index.php" class="btn btn-secondary"> Quay về trang chủ</a>
                        <button class="btn btn-primary" name="btnSave">Lưu</button>

                    </form>
                </div>
                <?php
                if (isset($_POST['btnSave'])) {

                    $t_so = $_POST['t_so'];
                    $t_soluong = $_POST['t_soluong'];

                    $sqlUpdateLSP = "UPDATE `tables`
	                                SET
		                            table_number='$t_so',
		                            capacity=$t_soluong
	                                WHERE id=$t_ma";

                    mysqli_query($conn, $sqlUpdateLSP);

                    $_SESSION['flash_msg'] = "Đã sửa bàn <b>$t_tencu</b>!";
                    $_SESSION['flash_context'] = 'warning';
                    echo '<script>location.href="index.php"</script>';
                }
                ?>

            </main>

        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../../layouts/script.php';
    ?>
    <script src="assets/js/main.js"></script>

</body>

</html>