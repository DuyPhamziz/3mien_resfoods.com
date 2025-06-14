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
                    <h1 class="h2">Thêm mới Bàn</h1>
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
                <div class="container">
                    <form action="" method="post">

                        <div class="mb-3">
                            <label for="lsp_ten" class="form-label">Tên Bàn</label>
                            <input id="t_so" name="t_so" type="text" class="form-control">
                            <div class="form-text">Thêm bàn mới vào cửa hàng.</div>
                        </div>
                        <div class="mb-3">
                            <label for="t_soluong" class="form-label">Số lượng</label>
                            <select id="max_num" name="t_soluong" class="form-select">
                                <option value="2">2</option>
                                <option value="4">4</option>
                                <option value="8">8</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                        <a href="index.php" class="btn btn-secondary"> Quay về trang chủ</a>
                        <button class="btn btn-primary" name="btnSave">Lưu</button>

                    </form>
                </div>
                <?php
                if (isset($_POST['btnSave'])) {
                    include_once __DIR__ . '/../../../dbconnect.php';

                    $t_so = $_POST['t_so'];
                    $t_soluong = $_POST['t_soluong'];

                    $sqlInsertTables = "INSERT INTO `tables`
	                                (table_number, capacity)
	                                VALUES ('$t_so', $t_soluong)";

                    mysqli_query($conn, $sqlInsertTables);

                    $_SESSION['flash_msg'] = "Đã thêm bàn mới vào cửa hàng!!";
                    $_SESSION['flash_context'] = 'success';
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
    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
        });
    </script>
</body>

</html>