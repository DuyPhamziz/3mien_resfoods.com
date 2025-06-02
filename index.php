<?php session_start(); ?>
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
  <link rel="stylesheet" type="text/css" href="/3mien_resfoods.com/assets/css/style.css">
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
            <h2 data-aos="fade-up" data-aos-delay="100">Welcome to <span>3 Miền Quán</span></h2>
            <p data-aos="fade-up" data-aos-delay="200">Hơn 18 năm phục vụ hàng triệu thực khách bằng tình yêu quê hương trong từng món ăn.</p>
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
    <section class="container py-5">
      <h2 class="text-center mb-4" data-aos="fade-up" data-aos-delay="100">
        <span>GIỚI THIỆU</span>
      </h2>

      <div class="row align-items-center">

        <div class="col-md-6 text-center mb-4 mb-md-0">
          <img src="assets/img/about-img.jpg" alt="Ảnh giới thiệu" class="img-fluid rounded-circle w-75 shadow">
        </div>


        <div class="col-md-6">
          <p class="card-text fs-5">
            <strong>3mien_resfoods.com</strong> là nhà hàng cơm quê mang hương vị truyền thống ba miền Bắc – Trung – Nam.
            Chúng tôi mang đến những món ăn dân dã, đậm đà như cơm mẹ nấu, được chế biến từ nguyên liệu tươi ngon, giữ trọn bản sắc quê hương.
            Với không gian mộc mạc, ấm cúng và dịch vụ thân thiện, 3 Miền Resfoods là điểm đến lý tưởng cho những ai yêu thích ẩm thực Việt đích thực.
          </p>
        </div>
      </div>
    </section>
    <section class="container-fluid px-0">
      <h2 class="text-center py-5" data-aos="fade-up" data-aos-delay="100">
        <span>SỰ KIỆN</span>
      </h2>

      <div class="parallax container-fluid">
        <div class="overlay-text">
          <h2>Mừng khai trương 3 Miền Foods <span>giảm 20%</span> cho đơn đặt từ 4 người.</h2>
          <p>Ẩm thực quê hương ba miền Việt Nam</p>
        </div>
      </div>
    </section>
    <?php
    include_once __DIR__ . '/dbconnect.php';

    $sqlSelectChef = "SELECT * FROM staff WHERE ROLE='chef';";

    $resultChef = mysqli_query($conn, $sqlSelectChef);
    $arr = [];
    while ($row = mysqli_fetch_array($resultChef, MYSQLI_ASSOC)) {
      $arr[] = array(
        'name_chef' => $row['name'],
        'img' => $row['img'],
      );
    }
    ?>
    <section class="container-fluid px-0">
      <h2 class="text-center mb-4" data-aos="fade-up" data-aos-delay="100">
        <span>ĐẦU BẾP</span>
      </h2>

      <div class="card-group container d-flex justify-content-center bg-transparent">
        <?php foreach ($arr as $chef): ?>
          <div class="card m-5 bg-transparent" style="max-width: 300px;">
            <img src="assets/img/chef/<?= $chef['img'] ?>" class="img-fluid rounded-circle" style="max-width: 300px;">
            <div class="card-body">
              <h5 class="card-title text-center text-white"><?= $chef['name_chef'] ?></h5>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </section>

    <section class="container py-5">
      <?php
      $resultTables = $conn->query("
              SELECT * FROM TABLES t JOIN status_tables sta ON sta.id = t.`status`
            ");
      $arrTable = [];
      while ($row = mysqli_fetch_array($resultTables, MYSQLI_ASSOC)) {
        $arrTable[] = array(
          'id' => $row['id'],
          'table_number' => $row['table_number'],
          'capacity' => $row['capacity'],
          'img' => $row['img'],
          'status' => $row['status'],
          'statu' => $row['statu'],
        );
        $svgContent = [];
      }
      ?>
      <h3 class="text-center mb-4">Đặt bàn</h3>
      <div class="row row-cols-1 row-cols-md-6 g-3 justify-content-center" id="tableList">
        <?php foreach ($arrTable as $table):

          $btnClass = 'btn ';
          $disabled = '';

          switch ($table['status']) {
            case 1:
              $btnClass .= 'btn-outline-success';
              break;
            case 2:
              $btnClass .= 'btn-outline-secondary';
              $disabled = 'disable';
              break;
            case 3:
              $btnClass .= 'btn-outline-warning';
              $disabled = 'disable';
              break;
            default:
              $btnClass .= 'btn-light';
          }
        ?>
          <div class="col text-center">
            <img src="assets/img/table/<?= $table['img'] ?>" class="img-fluid" />
            <form action="datban.php" method="POST">
              <input type="hidden" name="table_id" value="<?= $table['id'] ?>">
              <button class="btn <?= $btnClass ?> px-3 py-2 w-100" <?= $disabled ?>>
                <?= $table['table_number'] ?><br><small><?= $table['capacity'] ?> người</small>
              </button>
            </form>
          </div>
        <?php endforeach; ?>

      </div>
      <div class="text-center mt-4">
        <span class="badge bg-success">Trống</span>
        <span class="badge bg-warning text-dark">Đã đặt</span>
        <span class="badge bg-secondary">Đã lấy</span>
      </div>
    </section>

  </main>
  <?php
  include_once __DIR__ . '/layouts/footer.php';
  ?>
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
  <script src="/3mien_resfoods.com/assets/js/main.js"></script>
 
</body>

</html>


</body>

</html>