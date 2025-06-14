<?php 
session_start();
    if (!isset($_SESSION['staff'])) {
        header('Location: /3mien_resfoods.com/login.php');
        exit();
    } ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm khách hàng</title>
    <?php
    include_once __DIR__ . '/../../../layouts/style.php';
    ?>
</head>
<body>
    <?php
    include_once __DIR__ . '/../../../dbconnect.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $phone = $_POST['phone'];

        $sql = "INSERT INTO customers (fullname, username, password, phone) 
                VALUES ('$fullname', '$username', '$password', '$phone')";

        mysqli_query($conn, $sql);
        header("Location: index.php");
        exit();
    }
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4 text-center text-primary">Thêm khách hàng mới</h2>
                <form method="POST" class="border rounded p-4 shadow-sm bg-light">
                    <div class="mb-3">
                        <label for="fullname" class="form-label"><i class="fa-solid fa-circle-user"></i> Họ và tên</label>
                        <input type="text" name="fullname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label"><i class="fa-solid fa-user"></i> Tên đăng nhập</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"><i class="fa-solid fa-eye-slash"></i> Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label"><i class="fa-solid fa-phone"></i> Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary"><i class="fa-solid fa-rotate-left"></i> Quay lại</a>
                        <button type="submit" class="btn btn-success">Thêm khách hàng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
