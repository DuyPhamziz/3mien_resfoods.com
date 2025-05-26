<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trang quản trị</title>
    <?php
    include_once __DIR__ . '/../../../layouts/style.php';
    ?>
</head>

<body>
    <?php
    include_once __DIR__ . '/../../layouts/header.php'
    ?>

    <div class="container-fluid">
        <div class="row">
            <?php
            include_once __DIR__ . '/../../layouts/sidebar.php'
            ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Đơn đặt bàn</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <div class="dropdown show">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-cannabis"></i> This week
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                include_once __DIR__ . '/../../../dbconnect.php';
                $sqlSelectOrders = "SELECT o.id AS order_id,
                                        cus.`name` AS cus_name,
                                        cus.`phone` AS cus_phone,  
                                        t.table_number AS table_name, 
                                        o.order_time AS or_time,
                                        o.status AS o_status, 
                                        SUM(ot.quantity) AS total_quantity                                     
                                    FROM orders o
                                    JOIN order_items ot ON ot.order_id = o.id
                                    JOIN TABLES t ON t.id = o.table_id
                                    JOIN customers cus ON cus.id = o.customer_id
                                    GROUP BY o.id, o.customer_id, t.table_number, o.order_time, o.status;";

                $resultSelectOrders = mysqli_query($conn, $sqlSelectOrders);

                $arrOrders = [];
                while ($row = mysqli_fetch_array($resultSelectOrders, MYSQLI_ASSOC)) {
                    $arrOrders[] = array(
                        'order_id' => $row['order_id'],
                        'cus_name' => $row['cus_name'],
                        'cus_phone' => $row['cus_phone'],
                        'table_name' => $row['table_name'],
                        'or_time' => $row['or_time'],
                        'o_status' => $row['o_status'],
                        'total_quantity' => $row['total_quantity'],
                    );
                }

                ?>
                <div class="container">
                    <a href="create.php" type="button" class="btn btn-primary ">
                        Thêm mới <i class="fa-solid fa-plus"></i>
                    </a>
                    <?php if (isset($_SESSION['flash_msg'])): ?>
                        <div data-aos="zoom-in" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out" class="alert alert-<?= $_SESSION['flash_context'] ?>" role="alert">
                            <?= $_SESSION['flash_msg'] ?>
                        </div>
                        <?php unset($_SESSION['flash_msg']) ?>
                    <?php endif; ?>
                    <table class="table table-striped">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Tên khách đặt bàn</th>
                            <th scope="col">Tên bàn</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Xem món</th>
                            <th scope="col">Hành động</th>
                        </thead>
                        <tbody>
                            <?php foreach ($arrOrders as $index => $o): ?>
                                <tr>

                                    <td><?= $index + 1 ?></td>
                                    <td><?= $o['cus_name'] ?>
                                        <br /> <?= $o['cus_phone'] ?>
                                    </td>
                                    <td><?= $o['table_name'] ?></td>
                                    <td><?= $o['or_time'] ?></td>
                                    <td><?= $o['o_status'] ?></td>

                                    <td>
                                        <button type="button" class="btn btn-info btn-view-order" data-bs-toggle="modal" data-order-id="<?= $o['order_id'] ?>" data-bs-target=" #seeMenuModal">
                                            <i class="fa-solid fa-eye"></i></button>
                                    </td>
                                    <td>
                                        <a href="edit.php?order_id=<?= $o['order_id'] ?>" type="button" class="btn btn-warning">
                                            <i class="fa-solid fa-pencil"></i></a>
                                        <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#trashModal">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </main>
            <div class="modal fade" id="trashModal" tabindex="-1" aria-labelledby="trashModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="trashModalLabel">Cảnh báo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc muốn xóa Đơn này?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="delete.php?order_id=<?= $o['order_id'] ?>" type="button" class="btn btn-primary">Xác nhận XÓA</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="seeMenuModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-bg-secondary">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Các món đã đặt</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="order-detail-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../../layouts/script.php';
    ?>
    <script src="assets/js/main.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const buttons = document.querySelectorAll(".btn-view-order");
            buttons.forEach(function(btn) {
                btn.addEventListener("click", function() {
                    const orderId = this.getAttribute("data-order-id");
                    const modalBody = document.getElementById("order-detail-body");
                    modalBody.innerHTML = "Đang tải dữ liệu...";

                    fetch("get_order_detail.php?order_id=" + orderId)
                        .then(response => response.text())
                        .then(data => {
                            modalBody.innerHTML = data;
                        })
                        .catch(error => {
                            modalBody.innerHTML = "<p class='text-danger'>Lỗi khi tải dữ liệu!</p>";
                        });
                });
            });
        });
    </script>

</body>

</html>
<?php
if (ob_get_length()) {
    ob_end_flush();
}
?>