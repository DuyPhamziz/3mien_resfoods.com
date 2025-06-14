<?php
session_start();
if (!isset($_SESSION['staff'])) {
    header('Location: /3mien_resfoods.com/login.php');
    exit();
}
include_once __DIR__ . '/../../../dbconnect.php';

$menu_ma = $_GET['menu_ma'] ?? null;

// Lấy dữ liệu món ăn hiện tại
$sqlSelect = "SELECT * FROM menu_items WHERE id = $menu_ma";
$result = mysqli_query($conn, $sqlSelect);
$menu = mysqli_fetch_array($result, MYSQLI_ASSOC);

// Lấy danh sách loại
$sqlCate = "SELECT * FROM categories";
$resultCate = mysqli_query($conn, $sqlCate);
$arrCate = [];
while ($row = mysqli_fetch_array($resultCate, MYSQLI_ASSOC)) {
    $arrCate[] = $row;
}

// Lấy các loại của món ăn này (many-to-many)
$sqlMenuCate = "SELECT category_id FROM menu_item_categories WHERE menu_item_id = $menu_ma";
$resultMenuCate = mysqli_query($conn, $sqlMenuCate);
$arrCateSelected = [];
while ($row = mysqli_fetch_array($resultMenuCate, MYSQLI_ASSOC)) {
    $arrCateSelected[] = $row['category_id'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa món ăn</title>
    <?php include_once __DIR__ . '/../../../layouts/style.php'; ?>
</head>
<body>
<?php include_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include_once __DIR__ . '/../../layouts/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2 class="mt-4">Chỉnh sửa món ăn</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="menu_name" class="form-label">Tên món ăn</label>
                    <input type="text" class="form-control" id="menu_name" name="menu_name" value="<?= htmlspecialchars($menu['menu_name']) ?>">
                </div>
                
                <div class="mb-3">
                    <label for="menu_img" class="form-label">Hình ảnh</label><br>
                    <img src="<?= $menu['img'] ?>" alt="Ảnh cũ" style="width:150px"><br>
                    <input class="form-control" type="file" name="menu_img" id="menu_img">
                </div>

                <div class="mb-3">
                    <label for="menu_price" class="form-label">Giá</label>
                    <input type="number" step="0.01" min="0" class="form-control" id="menu_price" name="menu_price" value="<?= $menu['price'] ?>">
                </div>

                <div class="mb-3">
                    <label for="menu_description" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="menu_description" name="menu_description"><?= htmlspecialchars($menu['description']) ?></textarea>
                </div>

                

                <div class="mb-3">
                    <label class="form-label">Loại món ăn</label>
                    <div class="row">
                        <?php foreach ($arrCate as $cate): ?>
                            <div class="form-check col-md-3">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="menu_loai[]" 
                                    value="<?= $cate['id'] ?>" 
                                    id="cate<?= $cate['id'] ?>"
                                    <?= in_array($cate['id'], $arrCateSelected) ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="cate<?= $cate['id'] ?>">
                                    <?= htmlspecialchars($cate['name']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>


                <a href="index.php" class="btn btn-secondary">Quay lại</a>
                <button type="submit" name="btnSave" class="btn btn-primary">Lưu thay đổi</button>
            </form>

            <?php
            if (isset($_POST['btnSave'])) {
                $menu_name = $_POST['menu_name'];
                $menu_price = $_POST['menu_price'];
                $menu_description = $_POST['menu_description'];
                $menu_loai = $_POST['menu_loai'] ?? [];

                $imgPath = $menu['img'];

                // Nếu có hình mới
                if (!empty($_FILES['menu_img']['name'])) {
                    $ext = pathinfo($_FILES['menu_img']['name'], PATHINFO_EXTENSION);
                    $newFileName = 'menu_' . time() . '.' . $ext;
                    $uploadPath = __DIR__ . '/../../upload/img/' . $newFileName;
                    $imgPath = '/3mien_resfoods.com/admin/upload/img/' . $newFileName;

                    if (move_uploaded_file($_FILES['menu_img']['tmp_name'], $uploadPath)) {
                        $oldPath = $_SERVER['DOCUMENT_ROOT'] . $menu['img'];
                        if (file_exists($oldPath)) unlink($oldPath);
                    }
                }

                // Cập nhật bảng menu_items
                $sqlUpdate = "UPDATE menu_items SET 
                    menu_name = '$menu_name', 
                    price = $menu_price, 
                    description = '$menu_description',
                    img = '$imgPath'
                    WHERE id = $menu_ma";
                mysqli_query($conn, $sqlUpdate);

                // Cập nhật lại các loại (xóa cũ -> thêm mới)
                mysqli_query($conn, "DELETE FROM menu_item_categories WHERE menu_item_id = $menu_ma");
                foreach ($menu_loai as $cate_id) {
                    mysqli_query($conn, "INSERT INTO menu_item_categories (menu_item_id, category_id) VALUES ($menu_ma, $cate_id)");
                }

                $_SESSION['flash_msg'] = "Đã cập nhật món ăn <b>$menu_name</b>";
                $_SESSION['flash_context'] = 'success';
                echo '<script>location.href="index.php"</script>';
            }
            ?>
        </main>
    </div>
</div>
<?php include_once __DIR__ . '/../../../layouts/script.php'; ?>
</body>
</html>
