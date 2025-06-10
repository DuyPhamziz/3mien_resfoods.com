<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Danh sách nhân viên</title>
    <?php include_once __DIR__ . '/../../../layouts/style.php'; ?>
</head>

<body>
    <?php include_once __DIR__ . '/../../layouts/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../../layouts/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Danh sách nhân viên</h1>
                </div>

                <?php
                include_once __DIR__ . '/../../../dbconnect.php';

                $sql = "SELECT * FROM staff ORDER BY id ASC";
                $result = mysqli_query($conn, $sql);

                $staffs = [];
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $staffs[] = $row;
                }
                ?>

                <a href="create.php" class="btn btn-primary mb-2">
                    <i class="fa-solid fa-plus"></i> Thêm nhân viên
                </a>

                <table class="table table-striped table-bordered">
                    <thead class="table-warning text-center">
                        <tr>
                            <th>Họ tên</th>
                            <th>Chức vụ</th>
                            <th>Ảnh</th>
                            <th>SĐT</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($staffs as $staff): ?>
                            <tr>
                                <td><?= htmlspecialchars($staff['name']) ?></td>
                                <td><?= htmlspecialchars($staff['role']) ?></td>
                                <td class="text-center">
                                    <?php if ($staff['img']): ?>
                                        <img src="../../../assets/img/chef/<?= htmlspecialchars($staff['img']) ?>" alt="<?= $staff['name'] ?>" width="60" class="img-thumbnail">
                                    <?php else: ?>
                                        <span class="text-muted">Không có</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($staff['phone']) ?></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $staff['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <a href="delete.php?id=<?= $staff['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>
    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
        });
    </script>
</body>

</html>
