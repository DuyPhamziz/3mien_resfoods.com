<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>3 Miền Restarant</title>

  <?php
  include_once __DIR__ . '/layouts/style.php';
  ?>
  <link rel="stylesheet" type="text/css" href="/3mien_resfoods.com/assets/css/main.css">
</head>

<body>
  <?php
  include_once __DIR__ . '/layouts/navbar.php';
  ?>

  <main class="container-fluid main">
    <section id="hero" class="hero section dark-background w-100">

      <img src="assets/img/banner_1.jpg" class="img-fluid w-100" alt="" data-aos="fade-in">
     
      <div class="container">
        <div class="row">
          <div class="col-lg-8 d-flex flex-column align-items-center align-items-lg-start">
            <h2 data-aos="fade-up" data-aos-delay="100">Welcome to <span>3 Miền quán</span></h2>
            <p data-aos="fade-up" data-aos-delay="200">Cung cấp thực phẩm tuyệt vời trong hơn 18 năm!</p>
            <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
              <a href="#menu" class="cta-btn">Menu</a>
              <a href="#book-a-table" class="cta-btn">Đặt bàn</a>
            </div>
          </div>
          <div class="col-lg-4 d-flex align-items-center justify-content-center mt-5 mt-lg-0">
            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->
    <section>
      <img src="assets/img/about-img.jpg" alt="" class="img-fluid w-50" />

    </section><!-- about Section  -->

  </main>
  <?php
  include_once __DIR__ . '/layouts/footer.php';
  ?>

  <?php
  include_once __DIR__ . '/layouts/script.php';
  ?>
  <script src="/3mien_resfoods.com/assets/js/main.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      easing: 'ease-in-out',
      once: true,
    });
  </script>
</body>

</html>