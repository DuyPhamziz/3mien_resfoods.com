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
                    <h1 class="h2">Thêm mới Loại sản phẩm</h1>
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
                            <label for="lsp_ten" class="form-label">Tên loại sản phẩm</label>
                            <input id="lsp_ten" name="lsp_ten" type="text" class="form-control" id="exampleInputEmail1">
                            <div class="form-text">Thêm vào loại món ăn vào thực đơn.</div>
                        </div>
                        <div class="mb-3">
                            <label for="lsp_mota" class="form-label">Mô tả</label>
                            <input type="text" class="form-control" id="lsp_mota" name="lsp_mota">
                        </div>
                        <a href="index.php" class="btn btn-secondary"> Quay về trang chủ</a>
                        <button class="btn btn-primary" name="btnSave">Lưu</button>

                    </form>
                </div>
                <?php
                if (isset($_POST['btnSave'])) {
                    include_once __DIR__ . '/../../../dbconnect.php';
                    
                    $lsp_ten = $_POST['lsp_ten'];
                    $lsp_mota = $_POST['lsp_mota'];

                    $sqlInsertLSP = "INSERT INTO categories
	                                (`name`, `description`)
	                                VALUES ('$lsp_ten', '$lsp_mota');";

                    mysqli_query($conn, $sqlInsertLSP);

                    $_SESSION['flash_msg'] = "Đã thêm loại món ăn <b>$lsp_ten</b> vào thực đơn!";
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