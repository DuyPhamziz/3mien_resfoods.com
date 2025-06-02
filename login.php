<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng nhập</title>
    <?php
    include_once __DIR__ . '/layouts/style.php';
    ?>
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
                    <form method="POST">
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <h3 class="mb-0 me-3 p-3">WellCome to <span>3 Miền foods</span></h3>
                        </div>

                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="form3Example3">Tên đăng nhập</label>
                            <input type="text" name="username" required class="form-control form-control-lg"
                                placeholder="Tên đăng nhập của bạn" />

                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-3">
                            <label class="form-label" for="form3Example4">Mật khẩu</label>
                            <input type="password" name="password" required class="form-control form-control-lg"
                                placeholder="Enter password" />

                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <div class="form-check mb-0">
                                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                                <label class="form-check-label" for="form2Example3">
                                    Nhớ tôi
                                </label>
                            </div>
                            <a href="#!" class="text-body">Quên mật khẩu?</a>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Bạn không có tài khoản? <a href="#!"
                                    class="link-danger">Đăng kí</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php

    include_once __DIR__ . '/dbconnect.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM customers WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit();
        } else {
            echo "Sai mật khẩu.";
        }
    } else {
        echo "Tên đăng nhập không tồn tại.";
    }
    ?>
    <?php
    include_once __DIR__ . '/layouts/script.php';
    ?>
</body>

</html>