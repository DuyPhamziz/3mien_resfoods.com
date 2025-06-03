<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng Ký</title>
    <?php
    include_once __DIR__ . '/layouts/style.php';
    ?>
</head>

<body class="conainer bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Đăng ký tài khoản</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" onsubmit="return validatePassword()">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" required>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required pattern="[0-9]{10}" />
                                <div class="form-text">Số điện thoại phải đúng 10 chữ số, chỉ được nhập số.</div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" required minlength="6">
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="confirm_password" required>
                                <div class="form-text text-danger" id="passwordMismatch" style="display: none;">
                                    Mật khẩu không khớp.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        Đã có tài khoản? <a href="login.php">Đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

    include_once __DIR__ . '/dbconnect.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fullname = trim($_POST['fullname']);
        $phone = trim($_POST['phone']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Kiểm tra username đã tồn tại chưa
        $check = $conn->prepare("SELECT * FROM customers WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo "<div class='alert alert-danger text-center mt-3'>Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.</div>";
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO customers
                                (fullname, username, `password`, phone)
                                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullname, $username, $hashedPassword, $phone);

        if ($stmt->execute()) {
            header("Location: login.php?registered=success");
            exit();
        } else {
            echo "<div class='alert alert-danger text-center mt-3'>Lỗi đăng ký: " . $conn->error . "</div>";
        }
        $stmt->close();
    }

    $conn->close();

    ?>
    <script>
        function validatePassword() {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('confirm_password').value;
            const mismatch = document.getElementById('passwordMismatch');

            if (password !== confirm) {
                mismatch.style.display = 'block';
                return false;
            }

            mismatch.style.display = 'none';
            return true;
        }
    </script>

    <?php
    include_once __DIR__ . '/layouts/script.php';
    ?>
    <script>
        // Tự động ẩn alert sau 3 giây
        setTimeout(function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('hide');
                // Optionally, remove alert from DOM after 1s
                setTimeout(() => alert.remove(), 1000);
            }
        }, 3000);
    </script>
</body>

</html>