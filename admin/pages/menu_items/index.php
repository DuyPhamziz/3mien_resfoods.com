<?php
session_start();
    if (!isset($_SESSION['staff'])) {
        header('Location: /3mien_resfoods.com/login.php');
        exit();
    }
    include_once __DIR__ . '/../../../dbconnect.php';

// ====== CẤU HÌNH PHÂN TRANG ======
$limit = 5; // Số món mỗi trang
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// ====== LẤY TỔNG SỐ MÓN ======
$sqlCount = "SELECT COUNT(DISTINCT mt.id) AS total FROM menu_items mt";
$totalResult = mysqli_query($conn, $sqlCount);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalItems = $totalRow['total'];
$totalPages = ceil($totalItems / $limit);

// ====== LẤY DỮ LIỆU TRANG HIỆN TẠI ======
$sqlSelectMenuItems = "
    SELECT 
        mt.id, 
        mt.menu_name AS menu_name, 
        mt.img, 
        mt.description, 
        mt.price, 
        GROUP_CONCAT(c.name SEPARATOR ', ') AS cate_name
    FROM 
        menu_items mt
    JOIN 
        menu_item_categories mic ON mt.id = mic.menu_item_id
    JOIN 
        categories c ON mic.category_id = c.id
    GROUP BY 
        mt.id, mt.menu_name, mt.img, mt.description, mt.price
    LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $sqlSelectMenuItems);
$arrMenuItems = [];
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $arrMenuItems[] = [
        'menu_id' => $row['id'],
        'menu_ten' => $row['menu_name'],
        'menu_img' => $row['img'],
        'menu_mota' => $row['description'],
        'menu_gia' => $row['price'],
        'menu_loai' => $row['cate_name'],
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trang quản trị - Món ăn</title>
    <?php include_once __DIR__ . '/../../../layouts/style.php'; ?>
</head>

<body>
    <?php include_once __DIR__ . '/../../layouts/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../../layouts/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Danh sách món ăn</h1>
                    <a href="create.php" class="btn btn-primary">Thêm mới <i class="fa-solid fa-plus"></i></a>
                </div>

                <?php if (isset($_SESSION['flash_msg'])): ?>
                    <div class="alert alert-<?= $_SESSION['flash_context'] ?>" role="alert">
                        <?= $_SESSION['flash_msg'] ?>
                    </div>
                    <?php unset($_SESSION['flash_msg']); ?>
                <?php endif; ?>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="table-warning">
                            <th>#</th>
                            <th>Tên món</th>
                            <th>Ảnh</th>
                            <th>Mô tả</th>
                            <th>Giá</th>
                            <th>Loại</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($arrMenuItems as $menu): ?>
                            <tr>
                                <td><?= $menu['menu_id'] ?></td>
                                <td><strong><?= htmlspecialchars($menu['menu_ten']) ?></strong></td>
                                <td class="text-center"><img src="<?= $menu['menu_img'] ?>" class="img-fluid" style="width: 150px;" /></td>
                                <td><i><?= htmlspecialchars($menu['menu_mota']) ?></i></td>
                                <td><?= number_format($menu['menu_gia'], 0, ',', '.') ?> đ</td>
                                <td><?= htmlspecialchars($menu['menu_loai']) ?></td>
                                <td>
                                    <a href="edit.php?menu_ma=<?= $menu['menu_id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm btn-open-modal" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                                        data-id="<?= $menu['menu_id'] ?>" data-name="<?= htmlspecialchars($menu['menu_ten']) ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- PHÂN TRANG -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">Trước</a>
                        </li>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">Sau</a>
                        </li>
                    </ul>
                </nav>
            </main>

            <!-- Modal xác nhận xoá -->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Xác nhận xoá</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">Bạn có chắc chắn muốn xoá món này?</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                            <a id="btn-confirm-delete" href="#" class="btn btn-danger">Xác nhận xoá</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>

    <script>
        document.querySelectorAll('.btn-open-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('btn-confirm-delete').href = `delete.php?menu_ma=${id}`;
            });
        });
    </script>
</body>

</html>