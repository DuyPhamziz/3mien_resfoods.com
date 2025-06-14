<?php
    session_start();
    if (!isset($_SESSION['staff'])) {
        header('Location: /3mien_resfoods.com/login.php');
        exit();
    }
    ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật khách hàng</title>
    
    <?php
    include_once __DIR__ . '/../../../layouts/style.php';
    ?>
</head>
<body>
    <?php
    include_once __DIR__ . '/../../../dbconnect.php';
    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        if (!empty($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE customers SET fullname='$fullname', username='$username', phone='$phone', password='$password' WHERE id=$id";
        } else {
            $sql = "UPDATE customers SET fullname='$fullname', username='$username', phone='$phone' WHERE id=$id";
        }

        mysqli_query($conn, $sql);
        header("Location: index.php");
        exit();
    }

    $sqlGet = "SELECT * FROM customers WHERE id=$id";
    $result = mysqli_query($conn, $sqlGet);
    $cus = mysqli_fetch_assoc($result);
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4 text-center text-primary">Cập nhật khách hàng</h2>
                <form method="POST" class="border rounded p-4 shadow-sm bg-light">
                    <div class="mb-3">
                        <label class="form-label">Họ tên</label>
                        <input name="fullname" value="<?= htmlspecialchars($cus['fullname']) ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên đăng nhập</label>
                        <input name="username" value="<?= htmlspecialchars($cus['username']) ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input name="phone" value="<?= htmlspecialchars($cus['phone']) ?>" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-warning">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
