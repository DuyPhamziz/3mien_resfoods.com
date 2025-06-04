<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng nhập</title>
    <?php include_once __DIR__ . '/layouts/style.php'; ?>
</head>

<body class="container">
    <section class="vh-100 container d-flex justify-content-center align-items-center">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">

                    <?php
                        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && isset($_GET['registered']) && $_GET['registered'] == 'success') {
                            echo "<div class='alert alert-success alert-dismissible fade show text-center' role='alert'>
                                                Đăng ký thành công! Vui lòng đăng nhập.
                                            </div>";
                        }


                     include_once __DIR__ . '/dbconnect.php';

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $username = trim($_POST['username']);
                        $password = trim($_POST['password']);

                        $sql = "SELECT * FROM customers WHERE username = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows === 1) {
                            $user = $result->fetch_assoc();

                            if (password_verify($password, $user['password'])) {
                                $_SESSION['user'] = $user;
                                $_SESSION['customer_id'] = $user['id'];
                                header("Location: index.php");
                                exit();
                            } else {
                                echo "<div class='alert alert-danger text-center alert-dismissible fade show'>Sai mật khẩu.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger text-center alert-dismissible fade show'>Tên đăng nhập không tồn tại.</div>";
                        }
                    }
                   
                    ?>

                    <form method="POST">
                        <div class="d-flex flex-row align-items-center justify-content-center">
                            <h3 class="mb-4 text-center">Chào mừng đến với <strong>3 Miền Foods</strong></h3>
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label">Tên đăng nhập</label>
                            <input type="text" name="username" required class="form-control form-control-lg"
                                placeholder="Nhập tên đăng nhập" />
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" name="password" required class="form-control form-control-lg"
                                placeholder="Nhập mật khẩu" />
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input me-2" type="checkbox" value="" id="rememberMe" />
                                <label class="form-check-label" for="rememberMe">Nhớ tôi</label>
                            </div>
                            <a href="#" class="text-decoration-none">Quên mật khẩu?</a>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                Đăng nhập
                            </button>
                            <p class="small mt-3 mb-0">Chưa có tài khoản?
                                <a href="register.php" class="link-danger">Đăng ký</a>
                            </p>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <?php include_once __DIR__ . '/layouts/script.php'; ?>
    <script>
        
        setTimeout(function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('hide');
                
                setTimeout(() => alert.remove(), 1000);
            }
        }, 3000);
    </script>
</body>

</html>