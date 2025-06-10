<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sửa thông tin nhân viên</title>
    <?php include_once __DIR__ . '/../../../layouts/style.php'; ?>
</head>

<body>
    <?php include_once __DIR__ . '/../../layouts/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../../layouts/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Sửa thông tin nhân viên</h1>
                </div>

                <?php
                include_once __DIR__ . '/../../../dbconnect.php';

                $id = $_GET['id'];
                $sql = "SELECT * FROM staff WHERE id = $id";
                $result = mysqli_query($conn, $sql);
                $staff = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $name_old = $staff['name'];
                ?>

                <div class="container">
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label"><strong>Họ tên</strong></label>
                            <input value="<?= htmlspecialchars($staff['name']) ?>" type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label"><strong>Chức vụ</strong></label>
                            <input value="<?= htmlspecialchars($staff['role']) ?>" type="text" class="form-control" id="role" name="role">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label"><strong>Số điện thoại</strong></label>
                            <input value="<?= htmlspecialchars($staff['phone']) ?>" type="text" class="form-control" id="phone" name="phone">
                        </div>

                        <div class="mb-3">
                            <label for="img" class="form-label"><strong>Ảnh đại diện</strong></label>
                            <input type="file" class="form-control" id="img" name="img">
                            <?php if ($staff['img']): ?>
                                <p class="mt-2">Ảnh hiện tại:</p>
                                <img src="/assets/uploads/staff/<?= htmlspecialchars($staff['img']) ?>" width="120" class="img-thumbnail">
                            <?php endif; ?>
                        </div>

                        <a href="index.php" class="btn btn-secondary">Quay về danh sách</a>
                        <button type="submit" class="btn btn-primary" name="btnSave">Lưu</button>
                    </form>
                </div>

                <?php
                if (isset($_POST['btnSave'])) {
                    $name = $_POST['name'];
                    $role = $_POST['role'];
                    $phone = $_POST['phone'];

                    $img = $staff['img']; 
                    if ($_FILES['img']['size'] > 0) {
                        $uploadDir = __DIR__ . '/../../../assets/uploads/staff/';
                        $fileName = uniqid() . '-' . basename($_FILES['img']['name']);
                        $uploadPath = $uploadDir . $fileName;

                        move_uploaded_file($_FILES['img']['tmp_name'], $uploadPath);
                        $img = $fileName;
                    }

                    $sqlUpdate = "UPDATE staff SET
                        name = '$name',
                        role = '$role',
                        img = " . ($img ? "'$img'" : "NULL") . ",
                        phone = '$phone'
                        WHERE id = $id";

                    mysqli_query($conn, $sqlUpdate);

                    $_SESSION['flash_msg'] = "Đã cập nhật thông tin nhân viên <b>$name_old</b>!";
                    $_SESSION['flash_context'] = 'info';
                    echo '<script>location.href="index.php"</script>';
                }
                ?>
            </main>
        </div>
    </div>

    <?php include_once __DIR__ . '/../../../layouts/script.php'; ?>
</body>
</html>
