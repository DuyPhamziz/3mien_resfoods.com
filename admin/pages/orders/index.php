<?php
session_start();
    include_once __DIR__ . '/../../../dbconnect.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $orderId = $_POST['order_id'] ?? '';
        $statusId = $_POST['status_id'] ?? '';

        if (!empty($orderId) && !empty($statusId)) {
            $sql = "UPDATE orders SET status = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $statusId, $orderId);
            $stmt->execute();
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
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
                    <h1 class="h2">Quản lý đơn hàng</h1>

                </div>
                <?php
                
                $sqlSelectDonHang = "SELECT 
                                    o.id AS order_id,
                                    cus.fullname AS customer,
                                    cus.phone AS phone,
                                    o.table_id AS table_number,
                                    o.booking_time AS booking,
                                    o.note AS notes,
                                    o.order_time AS order_time,
                                    os.status AS status,
                                    os.id AS status_id
                                    FROM orders o
                                    JOIN order_status os ON o.status = os.id
                                    JOIN customers cus ON cus.id = o.customer_id";

                $result = mysqli_query($conn, $sqlSelectDonHang);

                $arrDonHang = [];
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $arrDonHang[] = array(
                        'order_id' => $row['order_id'],
                        'customer' => $row['customer'],
                        'phone' => $row['phone'],
                        'table_number' => $row['table_number'],
                        'booking' => $row['booking'],
                        'status' => $row['status'],
                        'status_id' => $row['status_id'],

                    );
                }

                $sqlStatus = "SELECT id, `status`
	                        FROM order_status";
                $resultStatus = mysqli_query($conn, $sqlStatus);

                $arrStatus = [];
                while ($row = mysqli_fetch_array($resultStatus, MYSQLI_ASSOC)) {
                    $arrStatus[] = array(
                        'id' => $row['id'],
                        'status' => $row['status'],
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
                        <thead class="text-center">
                            <th scope="col">#</th>
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Tên khách dặt bàn</th>
                            <th scope="col">Tên bàn</th>
                            <th scope="col">Thời gian lên bàn</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Hành động</th>

                        </thead>
                        <tbody class="text-center">
                            <?php foreach ($arrDonHang as $index => $p): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $p['order_id'] ?></td>
                                    <td><?= $p['customer'] ?> <br /> (<?= $p['phone'] ?>) </td>
                                    <td><?= $p['table_number'] ?></td>
                                    <td><?= $p['booking'] ?></td>
                                    <td>

                                        <form action="" method="post">
                                            <input type="hidden" name="order_id" value="<?= $p['order_id'] ?>">
                                            <select name="status_id" id="status_order" onchange="this.form.submit()">
                                                <option value="">--Chọn trạng thái---</option>
                                                <?php foreach ($arrStatus as $sta): ?>
                                                    <option value="<?= htmlspecialchars($sta['id']) ?>" <?= ($p['status_id'] == $sta['id']) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($sta['status']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </form>

                                    </td>
                                    <td>
                                        <a href="get_order_detail.php?pur_ma=<?= $p['order_id'] ?>" type="button" class="btn btn-warning">
                                            <i class="fa-solid fa-pencil"></i></a>
                                        
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </main>
           

        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../../layouts/script.php';
    ?>

    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
        });
    </script>
</body>

</html>