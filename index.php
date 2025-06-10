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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
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
        </div>
      </div>

    </section><!-- /Hero Section -->
    <section id="about" class="container py-5">
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
      <h2 id="events" class="text-center py-5" style="scroll-margin-top: 100px;" data-aos="fade-up" data-aos-delay="100">
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
    <section id="chefs" class="container-fluid px-0">
      <h2 class="text-center mb-4" data-aos="fade-up" data-aos-delay="100">
        <span>ĐẦU BẾP</span>
      </h2>

      <div class="container">
        <div class="row justify-content-center">
          <?php foreach ($arr as $chef): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex justify-content-center">
              <div class="card bg-transparent text-center border-0" style="width: 100%; max-width: 250px;">
                <img src="assets/img/chef/<?= $chef['img'] ?>" class="img-fluid rounded-circle mx-auto" style="width: 100%; max-width: 200px;">
                <div class="card-body">
                  <h5 class="card-title text-white"><?= $chef['name_chef'] ?></h5>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

  

    
  <?php
  include_once __DIR__ . '/dbconnect.php';

  // Lấy categories
  $sqlCategories = "SELECT id, name FROM categories ORDER BY id ASC";
  $resultCategories = mysqli_query($conn, $sqlCategories);
  $categories = [];
  while ($row = mysqli_fetch_assoc($resultCategories)) {
      $categories[] = $row;
  }
  ?>
    <section id="menu" class="container py-5" style="scroll-margin-top: 100px;">
      <h2 class="text-center mb-4" data-aos="fade-up" data-aos-delay="100"><span>THỰC ĐƠN</span></h2>
      <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
          <ul class="navbar-nav mx-auto nav nav-pills">
            <li class="nav-item">
              <a class="nav-link active bg-warning text-dark" href="#" data-category="all">Tất cả</a>
            </li>
            <?php foreach ($categories as $cat): ?>
              <li class="nav-item ">
                <a class="nav-link" href="#" data-category="<?= $cat['id'] ?>">
                  <?= htmlspecialchars($cat['name']) ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </nav>

  <?php
    // Lấy danh sách món ăn từ DB
    $sqlMenuItems = "
                      SELECT mi.*, GROUP_CONCAT(mic.category_id) AS category_ids
                      FROM menu_items mi
                      LEFT JOIN menu_item_categories mic ON mi.id = mic.menu_item_id
                      GROUP BY mi.id
                      ORDER BY mi.id DESC
                      LIMIT 20
                    ";

    $resultMenu = $conn->query($sqlMenuItems);
    $arrMenuItems = [];
    while ($row = $resultMenu->fetch_assoc()) {
      $arrMenuItems[] = $row;
    }
  ?>

      <div class="row row-cols-1 row-cols-md-6 g-4" id="menuList">
        <?php foreach ($arrMenuItems as $item): ?>
          <div class="col menu-item" data-category="<?= $item['category_ids'] ?>">
            <div class="card h-100 d-flex flex-column shadow-sm rounded-3 border-0" style="min-height: 350px;">
              <div class="card-img-wrapper flex-grow-0 flex-shrink-0" style="flex-basis: 55%;">
                <img src="<?= htmlspecialchars($item['img']) ?>" class="w-100 h-100 object-fit-cover" alt="<?= htmlspecialchars($item['menu_name']) ?>">
              </div>
              <div class="card-body flex-grow-0 flex-shrink-0" style="flex-basis: 35%; overflow: hidden;">
                <strong class="card-title fs-5"><?= htmlspecialchars($item['menu_name']) ?></strong>
                <p class="card-text fs-7"><?= nl2br(htmlspecialchars($item['description'])) ?></p>
              </div>
              <div class="card-footer text-end flex-grow-0 flex-shrink-0 bg-white border-0" style="flex-basis: 10%;">
                <strong><?= number_format($item['price'], 0, ',', '.') ?>₫</strong>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>



    <section class="container py-5">
      <?php
        $resultTables = $conn->query("
                SELECT t.id, t.table_number, t.capacity, t.img, t.status, sta.statu
                FROM `TABLES` t
                JOIN status_tables sta ON sta.id = t.status
            ");

          $arrTable = [];
          while ($row = $resultTables->fetch_assoc()) {
            $arrTable[] = [
              'id' => $row['id'],
              'table_number' => $row['table_number'],
              'capacity' => $row['capacity'],
              'img' => $row['img'],
              'status' => $row['status'],   // trường status của bảng TABLES
              'statu' => $row['statu'],     // trường statu của bảng status_tables
            ];
          }
      ?>
      <h3 id="book-a-table"class="text-center mb-4">Đặt bàn</h3>
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
              $disabled = 'disabled';
              break;
            case 3:
              $btnClass .= 'btn-outline-warning';
              $disabled = 'disabled';
              break;
            default:
              $btnClass .= 'btn-light';
          }
        ?>
          <div class="col text-center">
            <img src="assets/img/table/<?= $table['img'] ?>" class="img-fluid" />

            <?php if (isset($_SESSION['user'])): ?>

              <form action="reservations.php" method="POST">
                <input type="hidden" name="table_id" value="<?= $table['id'] ?>">
                <button type="submit" class="btn <?= $btnClass ?> px-3 py-2 w-100" <?= $disabled ?>>
                  <?= $table['table_number'] ?><br><small><?= $table['capacity'] ?> người</small>
                </button>
              </form>
            <?php else: ?>

              <a type="button" class="btn <?= $btnClass ?> px-3 py-2 w-100 btn-alert-datban" <?= $disabled ?>>
                <?= $table['table_number'] ?><br><small><?= $table['capacity'] ?> người</small><br>
              </a>
            <?php endif; ?>

          </div>
        <?php endforeach; ?>

      </div>
      <div class=" text-center mt-4">
        <span class="badge bg-success">Trống</span>
        <span class="badge bg-warning text-dark">Đã đặt</span>
        <span class="badge bg-secondary">Đã lấy</span>
      </div>
    </section>

    <section id="contact"></section>
  </main>
  <?php
  include_once __DIR__ . '/layouts/footer.php';
  ?>

  <script src="/3mien_resfoods.com/assets/js/main.js"></script>
  <?php
  include_once __DIR__ . '/layouts/script.php';
  ?>

  <script>
    AOS.init({
      duration: 1000,
      easing: 'ease-in-out',
      once: true,
    });
  </script>
  <script>
    document.querySelectorAll('.btn-alert-datban').forEach(btn => {
      btn.addEventListener('click', () => {
        Swal.fire({
          icon: 'error',
          title: 'Bạn chưa đăng nhập!',
          text: 'Vui lòng đăng nhập để đặt bàn.',
          confirmButtonText: 'Đăng nhập ngay',
          footer: '<a href="login.php">Chưa có tài khoản? Đăng ký</a>'
        }).then(result => {
          if (result.isConfirmed) {
            window.location.href = 'login.php';
          }
        });
      });
    });
  </script>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll(".nav-link[data-category]");
    const menuItems = document.querySelectorAll(".menu-item");

    navLinks.forEach(link => {
      link.addEventListener("click", function (e) {
        e.preventDefault();

        // Xóa class màu cũ
        navLinks.forEach(l => {
          l.classList.remove("active", "bg-warning", "text-dark");
        });

        // Thêm class màu vàng khi active
        this.classList.add("active", "bg-warning", "text-dark");

        const selectedCategory = this.getAttribute("data-category");

        menuItems.forEach(item => {
          const itemCategory = item.getAttribute("data-category");
          if (
            selectedCategory === "all" ||
            itemCategory.split(",").includes(selectedCategory)
          ) {
            item.style.display = "";
            item.classList.add("fade-in");
          } else {
            item.style.display = "none";
          }
        });
      });
    });
  });
</script>



</body>

</html>