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
                    <h1 class="h2">Danh sách khách hàng</h1>

                </div>
                <?php
                include_once __DIR__ . '/../../../dbconnect.php';

                    $sql = "SELECT c.id, c.fullname, c.username, c.phone, c.created_at, r.name AS rank_name
                            FROM customers c
                            JOIN ranks r ON c.rank_id = r.id
                            ORDER BY c.created_at ASC";

                    $result = mysqli_query($conn, $sql);

                    $arrCustomers = [];
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $arrCustomers[] = $row;
                    }
                ?>

                    <a href="create.php" class="btn btn-primary mb-2"><i class="fa-solid fa-plus"></i> Thêm khách hàng</a>
                    <table class="table table-striped table-bordered">
                        <thead class="table-warning text-center">
                            <tr>
                                <th>Mã</th>
                                <th>Họ tên</th>
                                <th>Tên đăng nhập</th>
                                <th>Số điện thoại</th>
                                <th>Hạng</th>
                                <th>Ngày đăng ký</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($arrCustomers as $cus): ?>
                                <tr>
                                    <td class="text-center"><?= $cus['id'] ?></td>
                                    <td><?= htmlspecialchars($cus['fullname']) ?></td>
                                    <td><?= htmlspecialchars($cus['username']) ?></td>
                                    <td><?= htmlspecialchars($cus['phone']) ?></td>
                                    <td><?= htmlspecialchars($cus['rank_name']) ?></td>
                                    <td><?= $cus['created_at'] ?></td>
                                    <td class="text-center">
                                        <a href="edit.php?id=<?= $cus['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="delete.php?id=<?= $cus['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
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
    include_once __DIR__ . '/../../../layouts/script.php';
    ?>
    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
        });
    </script>
</body>

</html>