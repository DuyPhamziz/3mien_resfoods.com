<?php session_start(); ?>
<?php
require_once __DIR__ . '/dbconnect.php';

$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if ($name && $email && $subject && $message) {
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        $stmt->execute();
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Liên hệ - 3 Miền Resfoods</title>

  <?php include_once __DIR__ . '/layouts/style.php'; ?>
  <link rel="stylesheet" href="/3mien_resfoods.com/assets/css/style.css">
</head>

<body class="contact-section bg-dark text-white">
  <main class="container py-5">
    <h2 class="text-center mb-5" data-aos="fade-up"><span><b>LIÊN HỆ VỚI CHÚNG TÔI</b></span></h2>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <form method="POST" id="contactForm" data-aos="fade-up" data-aos-delay="200">
          <div class="mb-3">
            <label for="name" class="form-label">Họ tên</label>
            <input type="text" class="form-control bg-dark text-white border-light" id="name" name="name" required />
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email liên hệ</label>
            <input type="email" class="form-control bg-dark text-white border-light" id="email" name="email" required />
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label">Tiêu đề</label>
            <input type="text" class="form-control bg-dark text-white border-light" id="subject" name="subject" required />
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Nội dung</label>
            <textarea class="form-control bg-dark text-white border-light" id="message" name="message" rows="5" required></textarea>
          </div>
          <div class="text-center">
            <button type="submit" name="send" class="btn btn-warning px-4">Gửi liên hệ</button>
          </div>
        </form>

        <a href="index.php" class="btn btn-outline-warning mt-3"><i class="bi bi-arrow-left"></i> Quay về Trang chủ</a>
      </div>
    </div>
  </main>

  <?php include_once __DIR__ . '/layouts/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/3mien_resfoods.com/assets/js/main.js"></script>
  <?php include_once __DIR__ . '/layouts/script.php'; ?>
  <script>
    AOS.init({ duration: 1000, easing: 'ease-in-out', once: true });

    <?php if ($success): ?>
      Swal.fire({
        icon: 'success',
        title: 'Cảm ơn bạn đã liên hệ!',
        text: 'Chúng tôi sẽ phản hồi sớm nhất có thể.',
        timer: 2000,
        showConfirmButton: false
      }).then(() => {
        window.location.href = 'index.php';
      });
    <?php endif; ?>
  </script>
</body>

</html>
