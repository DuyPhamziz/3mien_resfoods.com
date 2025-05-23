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
            include_once __DIR__ . '/../../layouts/sidebar.php';
            include_once __DIR__ . '/../../../dbconnect.php';

            $sqlInsertCate = "SELECT * FROM categories";

            $result = mysqli_query($conn, $sqlInsertCate);
            $arrCate = [];
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $arr[] = array(
                    'cate_id' => $row['id'],
                    'cate_name' => $row['name'],
                );
            }
            ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Thêm Món ăn mới</h1>
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
                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="mb-3 row">
                            <div class="col">
                                <label for="menu_ten" class="form-label">Tên Món</label>
                                <input id="menu_ten" name="menu_ten" type="text" class="form-control">
                                <div class="form-text">Thêm món ăn mới vào cửa hàng.</div>
                                <label for="menu_img" class="form-label">Hình</label>
                                <input id="menu_img" name="menu_img" type="file" class="form-control">
                                <label for="menu_slug" class="form-label">Slug</label>
                                <input id="menu_slug" name="menu_slug" type="text" class="form-control">
                                <div class="form-text">Đặt slug cho hình sản phẩm.</div>
                            </div>
                            <div class="col preview-img-container">
                                <img id="preview-img" src="/3mien_resfoods.com/admin/upload/img/no-img.jpg" class="img-fluid" style="width: 300px; height: auto;" />
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="menu_gia" class="form-label">Giá</label>
                            <input id="menu_gia" name="menu_gia" type="number" class="form-control">
                            <div class="form-text">Chào một cái giá thật hợp lí nhé!!.</div>
                        </div>
                        <div class="mb-3">
                            <label for="menu_mota" class="form-label">Mô tả</label>
                            <input id="menu_mota" name="menu_mota" type="text" class="form-control">

                        </div>
                        <div class="mb-3">
                            <label for="menu_loai" class="form-label">Loại thực đơn</label>
                            <select id="menu_loai" name="menu_loai" class="form-select">
                                <?php foreach ($arr as $cate): ?>
                                    <option value="<?= $cate['cate_id'] ?>">
                                        <?= $cate['cate_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <a href="index.php" class="btn btn-secondary"> Quay về trang chủ</a>
                        <button class="btn btn-primary" name="btnSave">Lưu</button>

                    </form>
                </div>
                <?php

                if (isset($_POST['btnSave'])) {
                    if (isset($_FILES['menu_img']) && $_FILES['menu_img']['error'] == 0) {
                        $uploadDir = __DIR__ . '/../../upload/img/';
                        // Lấy phần mở rộng file gốc
                        $ext = pathinfo($_FILES['menu_img']['name'], PATHINFO_EXTENSION);

                        $slug = $_POST['menu_slug'];

                        $newFileName = $slug . '-' . date('Ymd_His') . '.' . $ext;

                        $uploadPath = $uploadDir . $newFileName;

                        move_uploaded_file($_FILES['menu_img']['tmp_name'], $uploadPath);

                        $menu_ten = $_POST['menu_ten'];
                        $menu_gia = $_POST['menu_gia'];
                        $menu_mota = $_POST['menu_mota'];
                        $menu_loai = $_POST['menu_loai'];
                        $imgFileName = '/3mien_resfoods.com/admin/upload/img/' . $newFileName;

                        $sqlInsertMenu = "INSERT INTO menu_items
	                                    (`name`, `description`, price, img, category_id)
	                                    VALUES ('$menu_ten', '$menu_mota', $menu_gia, '$imgFileName', $menu_loai)";
                        mysqli_query($conn, $sqlInsertMenu) or die(mysqli_error($conn));
                    }
                    $_SESSION['flash_msg'] = "Đã thêm món mới vào cửa hàng!!";
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

        const reader = new FileReader();
        const fileInput = document.getElementById('menu_img');
        const img = document.getElementById('preview-img');
            reader.onload = e => {
                img.src = e.target.result;
            }
            fileInput.addEventListener('change', e =>{
                const f = e.target.files[0];
                reader.readAsDataURL(f);
            })
    </script>
</body>

</html>