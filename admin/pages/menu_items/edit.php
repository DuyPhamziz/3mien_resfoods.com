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
                    <h1 class="h2">Sửa loại sản phẩm</h1>
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
                $menu_ma = $_GET['menu_ma'];
                $sqlSelectMenu = "SELECT * FROM menu_items WHERE id=$menu_ma;";



                $sqlSelectCate = "SELECT * FROM categories";

                $result = mysqli_query($conn, $sqlSelectCate);
                $arrCate = [];
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $arrCate[] = array(
                        'cate_id' => $row['id'],
                        'cate_ten' => $row['name'],
                    );
                }

                $rowDulieuCuMenu = mysqli_fetch_array(mysqli_query($conn, $sqlSelectMenu), MYSQLI_ASSOC);
                $menu_tencu = $rowDulieuCuMenu['name'];
                ?>
                <div class="container">

                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="mb-3 row">
                            <div class="col-5">
                                <label for="menu_ten" class="form-label">Tên Món ăn</label>
                                <input value="<?= $rowDulieuCuMenu['name'] ?>" id="menu_ten" name="menu_ten" type="text" class="form-control">
                                <div class="form-text">Điều chỉnh món ăn.</div>
                                <label for="menu_gia" class="form-label">Giá</label>
                                <input value="<?= $rowDulieuCuMenu['price'] ?>" step="0.01" min="0" type="number" class="form-control" id="menu_gia" name="menu_gia">
                                <label for="menu_img" class="form-label">Hình</label>
                                <input type="text" class="form-control" id="menu_slug" value="<?= basename($rowDulieuCuMenu['img']) ?>" name="menu_slug">
                                <input type="file" class="form-control" id="menu_img" name="menu_img">

                            </div>
                            <div class="col-3 img-container-old">
                                <label>Hình cũ</label>
                                <img name="img_old" class="img-fluid" style="width: 200px; height: auto;" src="<?= $rowDulieuCuMenu['img'] ?>" alt="" />
                            </div>
                            <div class="col-3 img-container-new">
                                <label>Hình mới</label>
                                <img id="preview-img" class="img-fluid" style="width: 200px; height: auto;" src="/3mien_resfoods.com/admin/upload/img/no-img.jpg" alt="" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="menu_mota" class="form-label">Mô tả</label>
                            <input value="<?= $rowDulieuCuMenu['description'] ?>" type="text" class="form-control" id="menu_mota" name="menu_mota">
                        </div>
                        <div class="mb-3">
                            <label for="menu_loai" class="form-label">Loại thực đơn</label>
                            <select name="menu_loai" id="menu_loai" class="form-select">
                                <?php foreach ($arrCate as $cate): ?>
                                    <option value="<?= $cate['cate_id'] ?>" <?= $cate['cate_id'] ==  $rowDulieuCuMenu['category_id'] ? 'selected' : '' ?>>
                                        <?= $cate['cate_ten'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <a href="index.php" class="btn btn-secondary"> Quay về trang chủ</a>
                        <button class="btn btn-primary" name="btnSave">Lưu</button>

                    </form>
                </div>
                <?php
                if (isset($_POST['btnSave'])) {

                    $img_old = $_POST['img_old'];
                    $menu_slug = $_POST['menu_slug'];
                    $menu_ten = $_POST['menu_ten'];
                    $menu_gia = $_POST['menu_gia'];
                    $menu_mota = $_POST['menu_mota'];
                    $menu_loai = $_POST['menu_loai'];
                    $imgFileName = $img_old;

                    if (isset($_FILES['menu_img']) && !empty($_FILES['menu_img']['name'])) {
                        $upload_DIR = __DIR__ . '/../../upload/img/';
                        $ext = pathinfo($_FILES['menu_img']['name'], PATHINFO_EXTENSION);
                        $newFileName = $menu_slug . '-' . date('Ymd_His') . '.' . $ext;
                        $uploadPath = $upload_DIR . $newFileName;
                        move_uploaded_file($_FILES['menu_img']['tmp_name'], $uploadPath);

                        $imgFileName = '/3mien_resfoods.com/admin/upload/img/' . $newFileName;

                        $oldFilePath = $_SERVER['DOCUMENT_ROOT'] . $img_old; // chuyển từ đường dẫn tuyệt đối URL sang đường dẫn vật lý
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }

                    $sqlUpdateMenu = "UPDATE menu_items
	                                  SET
		                             `name`='$menu_ten',
		                            `description`='$menu_mota',
		                            price=$menu_gia,
		                            img='$imgFileName',
		                            category_id=$menu_loai
	                                WHERE id=$menu_ma;";

                    mysqli_query($conn, $sqlUpdateMenu);

                    $_SESSION['flash_msg'] = "Đã điều chỉnh món ăn <b>$menu_tencu</b>!";
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
    <script>
        const reader = new FileReader();
        const fileInput = document.getElementById('menu_img');
        const img = document.getElementById('preview-img');
        reader.onload = e => {
            img.src = e.target.result;
        }
        fileInput.addEventListener('change', e => {
            const f = e.target.files[0];
            reader.readAsDataURL(f);
        })
    </script>

</body>

</html>