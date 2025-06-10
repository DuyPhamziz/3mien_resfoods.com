<?php
session_start();
include_once __DIR__ . '/../../../dbconnect.php';

// Lấy danh sách loại món ăn
$sqlCate = "SELECT * FROM categories";
$result = mysqli_query($conn, $sqlCate);
$arrCate = [];
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $arrCate[] = [
        'id' => $row['id'],
        'name' => $row['name']
    ];
}

// Xử lý form khi submit
if (isset($_POST['btnSave'])) {
    $menu_ten = $_POST['menu_ten'];
    $menu_gia = $_POST['menu_gia'];
    $menu_mota = $_POST['menu_mota'];
    $menu_slug = $_POST['menu_slug'];
    $menu_loais = $_POST['menu_loai'] ?? [];

    // Xử lý ảnh
    $imgFileName = '/3mien_resfoods.com/admin/upload/img/no-img.jpg';
    if (!empty($_FILES['menu_img']['name'])) {
        $upload_DIR = __DIR__ . '/../../upload/img/';
        $ext = pathinfo($_FILES['menu_img']['name'], PATHINFO_EXTENSION);
        $newFileName = $menu_slug . '-' . date('Ymd_His') . '.' . $ext;
        $uploadPath = $upload_DIR . $newFileName;

        if (move_uploaded_file($_FILES['menu_img']['tmp_name'], $uploadPath)) {
            $imgFileName = '/3mien_resfoods.com/admin/upload/img/' . $newFileName;
        }
    }

    // Thêm vào bảng menu_items
    $sqlInsert = "INSERT INTO menu_items (menu_name, description, price, img) 
                  VALUES ('$menu_ten', '$menu_mota', $menu_gia, '$imgFileName')";
    mysqli_query($conn, $sqlInsert);
    $menu_id = mysqli_insert_id($conn);

    // Thêm vào bảng trung gian menu_item_categories
    foreach ($menu_loais as $cate_id) {
        $sqlCateInsert = "INSERT INTO menu_item_categories (menu_item_id, category_id)
                          VALUES ($menu_id, $cate_id)";
        mysqli_query($conn, $sqlCateInsert);
    }

    $_SESSION['flash_msg'] = "Đã thêm món <b>$menu_ten</b>!";
    $_SESSION['flash_context'] = 'success';
    echo '<script>location.href="index.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm món ăn</title>
    <?php include_once __DIR__ . '/../../../layouts/style.php'; ?>
</head>

<body>
<?php include_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include_once __DIR__ . '/../../layouts/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Thêm món ăn mới</h1>
            </div>

            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="menu_ten" class="form-label">Tên món</label>
                    <input required type="text" class="form-control" id="menu_ten" name="menu_ten">
                </div>
                <div class="mb-3">
                    <label for="menu_img" class="form-label">Ảnh món ăn</label>
                    <input type="file" class="form-control" id="menu_img" name="menu_img">
                </div>
                <div class="mb-3">
                    <label for="menu_slug" class="form-label">Slug (tên file ảnh)</label>
                    <input type="text" class="form-control" id="menu_slug" name="menu_slug" placeholder="vd: ca-kho-to">
                </div>
                <div class="mb-3">
                    <label for="menu_gia" class="form-label">Giá</label>
                    <input required type="number" step="0.01" min="0" class="form-control" id="menu_gia" name="menu_gia">
                </div>
                <div class="mb-3">
                    <label for="menu_mota" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="menu_mota" name="menu_mota" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Chọn loại món ăn</label>
                    <div class="form-check">
                        <?php foreach ($arrCate as $cate): ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="menu_loai[]"
                                       id="cate<?= $cate['id'] ?>" value="<?= $cate['id'] ?>">
                                <label class="form-check-label" for="cate<?= $cate['id'] ?>"><?= $cate['name'] ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <a href="index.php" class="btn btn-secondary">Quay lại</a>
                <button type="submit" name="btnSave" class="btn btn-primary">Lưu</button>
            </form>
        </main>
    </div>
</div>
<?php include_once __DIR__ . '/../../../layouts/script.php'; ?>
</body>
</html>
