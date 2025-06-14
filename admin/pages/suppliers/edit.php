<?php
include_once __DIR__ . '/../../layouts/check_login.php';
include_once __DIR__ . '/../../../dbconnect.php';

// --- Lấy sup_id
$sup_id = $_GET['sup_id'] ?? null;
if (!$sup_id || !is_numeric($sup_id)) {
    header("Location: index.php");
    exit();
}

// --- Xử lý khi nhấn Lưu (Đặt TRƯỚC HTML)
if (isset($_POST['btnSave'])) {
    $ten_moi = mysqli_real_escape_string($conn, $_POST['sup_ten']);
    $sdt_moi = mysqli_real_escape_string($conn, $_POST['sup_phone']);

    $sqlUpdate = "UPDATE suppliers SET sup_ten = '$ten_moi', sup_phone = '$sdt_moi' WHERE sup_id = $sup_id";
    mysqli_query($conn, $sqlUpdate);

    $_SESSION['flash_msg'] = "Đã sửa nhà cung cấp <b>$ten_moi</b>!";
    $_SESSION['flash_context'] = 'warning';

    header("Location: index.php"); // GỌI TRƯỚC KHI CÓ HTML
    exit();
}

// --- Lấy dữ liệu để hiển thị form
$sql = "SELECT * FROM suppliers WHERE sup_id = $sup_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if (!$row) {
    echo "Không tìm thấy nhà cung cấp.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sửa nhà cung cấp</title>
    <?php include_once __DIR__ . '/../../../layouts/style.php'; ?>
</head>

<body>
    <?php include_once __DIR__ . '/../../layouts/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../../layouts/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Sửa thông tin nhà cung cấp</h1>
                </div>

                <div class="container">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="sup_ten" class="form-label">Tên nhà cung cấp</label>
                            <input value="<?= htmlspecialchars($row['sup_ten']) ?>" id="sup_ten" name="sup_ten" type="text" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="sup_phone" class="form-label">Số điện thoại</label>
                            <input value="<?= htmlspecialchars($row['sup_phone']) ?>" id="sup_phone" name="sup_phone" type="text" class="form-control" required>
                        </div>

                        <a href="index.php" class="btn btn-secondary">Quay về danh sách</a>
                        <button class="btn btn-primary" name="btnSave">Lưu thay đổi</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>
</body>

</html>