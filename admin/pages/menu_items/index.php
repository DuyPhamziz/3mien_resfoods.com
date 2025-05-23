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
                    <h1 class="h2">Thực đơn</h1>

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

                $sqlSelectMenuItems = "SELECT mt.`id`, mt.`name` AS menu_name, mt.`img`, mt.`description`, mt.price, c.`name` AS cate_name
                                    FROM menu_items mt
                                    JOIN categories c ON mt.category_id = c.id;";

                $result = mysqli_query($conn, $sqlSelectMenuItems);

                $arrMenuItems = [];
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $arrMenuItems[] = array(
                        'menu_id' => $row['id'],
                        'menu_ten' => $row['menu_name'],
                        'menu_img' => $row['img'],
                        'menu_mota' => $row['description'],
                        'menu_gia' => $row['price'],
                        'menu_loai' => $row['cate_name'],
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
                            <th scope="col">Tên món</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Loại thực phẩm</th>
                            <th scope="col">Hành động</th>
                        </thead>
                        <tbody>
                            <?php foreach ($arrMenuItems as $menu): ?>
                                <tr>
                                    <td><?= $menu['menu_id'] ?></td>
                                    <td><?= $menu['menu_ten'] ?></td>
                                    <td>
                                        <img src="<?= $menu['menu_img'] ?>" class="img-fluid" style="width: 200px; height: auto;" />
                                    </td>
                                    <td><?= $menu['menu_mota'] ?></td>
                                    <td><?= $menu['menu_gia'] ?></td>
                                    <td><?= $menu['menu_loai'] ?></td>
                                    <td>

                                        <a href="edit.php?menu_ma=<?= $menu['menu_id'] ?>" type="button" class="btn btn-warning">
                                            <i class="fa-solid fa-pencil"></i></a>
                                        <a href="#" class="btn btn-danger btn-open-modal"
                                            data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                                            data-id="<?= intval($menu['menu_id']) ?>"
                                            data-name="<?= htmlspecialchars($menu['menu_ten'], ENT_QUOTES, 'UTF-8') ?>">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </main>
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Cảnh báo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc muốn xóa Món này?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a id="btn-confirm-delete" href="delete.php?menu_ma=<?= $menu['menu_id'] ?>" class="btn btn-danger">Xác nhận XÓA</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../../layouts/script.php';
    ?>
    <script>
        document.querySelectorAll('.btn-open-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                document.getElementById('btn-confirm-delete').href = `delete.php?menu_ma=${id}`;

            });
        });
    </script>

    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
        });
    </script>
</body>

</html>