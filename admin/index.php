<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trang quản trị</title>
    <?php
    include_once __DIR__ . '/../layouts/style.php';
    ?>
</head>

<body>
    <?php
    include_once __DIR__ . '/layouts/header.php'
    ?>

    <div class="container-fluid">
        <div class="row">
            <?php
            include_once __DIR__ . '/layouts/sidebar.php'
            ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Tổng quan</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                    </div>
                </div>
                <?php
                include_once __DIR__ . '/../dbconnect.php';

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
                    <a href="create.php" type="button" class="btn btn-primary">
                        Thêm mới <i class="fa-solid fa-plus"></i>
                    </a>
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
                                        <a href="edit.php" type="button" class="btn btn-warning">
                                            <i class="fa-solid fa-pencil"></i></a>
                                        <a href="delete.php" type="button" class="btn btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>
    <?php
    include_once __DIR__ . '/../layouts/script.php';
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