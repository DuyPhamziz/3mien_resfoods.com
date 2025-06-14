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
                    <h1 class="h2">Danh mục</h1>
                </div>
                <?php
                include_once __DIR__ . '/../../../dbconnect.php';

                $sqlSelectCategory = "SELECT * FROM categories;";

                $resultCategory = mysqli_query($conn, $sqlSelectCategory);

                $arrCategory = [];
                while ($row = mysqli_fetch_array($resultCategory, MYSQLI_ASSOC)) {
                    $arrCategory[] = array(
                        'lsp_ma' => $row['id'],
                        'lsp_ten' => $row['name'],
                        'lsp_mota' => $row['description'],
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
                            <th scope="col">Loại món ăn</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Hành động</th>
                        </thead>
                        <tbody>
                            <?php foreach ($arrCategory as $lsp): ?>
                                <tr>
                                    <td>LSP<?= $lsp['lsp_ma'] ?></td>
                                    <td><?= $lsp['lsp_ten'] ?></td>
                                    <td><?= $lsp['lsp_mota'] ?></td>
                                    <td>
                                        <a href="edit.php?lsp_ma=<?= $lsp['lsp_ma'] ?>" type="button" class="btn btn-warning">
                                            <i class="fa-solid fa-pencil"></i></a>
                                        <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $lsp['lsp_ma'] ?>">
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
                            Bạn có chắc muốn xóa Loại món ăn này?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a id="confirmDeleteBtn" href="#" type="button" class="btn btn-primary">Xác nhận XÓA</a>
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
    <script>
        const deleteModal = document.getElementById('exampleModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            confirmBtn.href = 'delete.php?lsp_ma=' + id;
        });
    </script>

</body>

</html>