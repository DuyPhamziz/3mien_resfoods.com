<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Thêm nhân viên</title>
    <?php include_once __DIR__ . '/../../../layouts/style.php'; ?>
</head>

<body>
    <?php include_once __DIR__ . '/../../layouts/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once __DIR__ . '/../../layouts/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Thêm nhân viên</h1>
                </div>

                <div class="container">
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label"><strong>Họ tên</strong></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label"><strong>Chức vụ</strong></label>
                            <input type="text" class="form-control" id="role" name="role">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label"><strong>Số điện thoại</strong></label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>

                        <div class="mb-3">
                            <label for="img" class="form-label"><strong>Ảnh đại diện</strong></label>
                            <input type="file" class="form-control" id="img" name="img">
                        </div>

                        <a href="index.php" class="btn btn-secondary">Quay về danh sách</a>
                        <button type="submit" class="btn btn-primary" name="btnSave">Lưu</button>
                    </form>
                </div>

                <?php
                if (isset($_POST['btnSave'])) {
                    include_once __DIR__ . '/../../../dbconnect.php';

                    $name = $_POST['name'];
                    $role = $_POST['role'];
                    $phone = $_POST['phone'];
                    $img = NULL;

                    if ($_FILES['img']['size'] > 0) {
                        $uploadDir = __DIR__ . '/../../../assets/uploads/staff/';
                        $fileName = uniqid() . '-' . basename($_FILES['img']['name']);
                        $uploadPath = $uploadDir . $fileName;

                        move_uploaded_file($_FILES['img']['tmp_name'], $uploadPath);
                        $img = $fileName;
                    }

                    $sqlInsert = "INSERT INTO staff (name, role, phone, img)
                                  VALUES ('$name', '$role', '$phone', " . ($img ? "'$img'" : "NULL") . ")";
                    mysqli_query($conn, $sqlInsert);

                    $_SESSION['flash_msg'] = "Đã thêm nhân viên <b>$name</b>!";
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
