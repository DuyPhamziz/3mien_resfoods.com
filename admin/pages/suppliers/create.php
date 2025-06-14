<?php
session_start();
if (!isset($_SESSION['staff'])) {
    header('Location: /3mien_resfoods.com/login.php');
    exit();
}
include_once __DIR__ . '/../../../dbconnect.php';

// Xử lý khi form được submit
if (isset($_POST['btnSave'])) {
    $ten = trim($_POST['sup_ten']);
    $sdt = trim($_POST['sup_phone']);

    // Kiểm tra rỗng
    if ($ten == '' || $sdt == '') {
        $_SESSION['flash_msg'] = 'Vui lòng nhập đầy đủ thông tin!';
        $_SESSION['flash_context'] = 'danger';
    } else {
        // Thêm vào DB
        $sql = "INSERT INTO suppliers (sup_ten, sup_phone) VALUES ('$ten', '$sdt')";
        mysqli_query($conn, $sql);

        $_SESSION['flash_msg'] = "Đã thêm nhà cung cấp <b>$ten</b>!";
        $_SESSION['flash_context'] = 'success';

        // Chuyển hướng về danh sách
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm nhà cung cấp</title>
    <?php include_once __DIR__ . '/../../../layouts/style.php'; ?>
</head>

<body>
    <?php include_once __DIR__ . '/../../layouts/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../../layouts/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Thêm nhà cung cấp</h1>
                </div>

                <div class="container">
                    <?php if (isset($_SESSION['flash_msg'])): ?>
                        <div class="alert alert-<?= $_SESSION['flash_context'] ?>">
                            <?= $_SESSION['flash_msg'] ?>
                        </div>
                        <?php unset($_SESSION['flash_msg']); ?>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label for="sup_ten" class="form-label">Tên nhà cung cấp</label>
                            <input type="text" class="form-control" id="sup_ten" name="sup_ten" required>
                        </div>

                        <div class="mb-3">
                            <label for="sup_phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="sup_phone" name="sup_phone" required>
                        </div>

                        <a href="index.php" class="btn btn-secondary">Quay về</a>
                        <button type="submit" name="btnSave" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>
</body>

</html>