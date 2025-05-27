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

                <div class="container py-4">
                    <h1 class="mb-4">Quản lý Nhập - Xuất Nguyên Liệu</h1>

                    <ul class="nav nav-tabs mb-4" id="tabMenu">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#nhap">Nhập nguyên liệu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#xuat">Xuất nguyên liệu</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Nhập nguyên liệu -->
                        <div class="tab-pane fade show active" id="nhap">
                            <form id="formNhap" action="handle_nhap.php" method="post">
                                <div class="mb-3">
                                    <label for="supplier" class="form-label">Nhà cung cấp</label>
                                    <select class="form-select" id="supplier" name="supplier" required>
                                        <option value="">-- Chọn nhà cung cấp --</option>
                                        <option value="1">Công ty ABC</option>
                                        <option value="2">Công ty XYZ</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="ngayNhap" class="form-label">Ngày nhập</label>
                                    <input type="date" class="form-control" id="ngayNhap" name="ngayNhap" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nguyên liệu</label>
                                    <table class="table table-bordered" id="nhapTable">
                                        <thead>
                                            <tr>
                                                <th>Tên nguyên liệu</th>
                                                <th>Số lượng</th>
                                                <th>Đơn giá</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <button type="button" class="btn btn-secondary" onclick="themDongNhap()">+ Thêm nguyên liệu</button>
                                </div>

                                <button type="submit" class="btn btn-primary">Lưu phiếu nhập</button>
                            </form>
                        </div>

                        <!-- Xuất nguyên liệu -->
                        <div class="tab-pane fade" id="xuat">
                            <form id="formXuat" action="handle_xuat.php" method="post">
                                <div class="mb-3">
                                    <label for="ngayXuat" class="form-label">Ngày xuất</label>
                                    <input type="date" class="form-control" id="ngayXuat" name="ngayXuat" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nguyên liệu</label>
                                    <table class="table table-bordered" id="xuatTable">
                                        <thead>
                                            <tr>
                                                <th>Tên nguyên liệu</th>
                                                <th>Số lượng</th>
                                                <th>Ghi chú</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <button type="button" class="btn btn-secondary" onclick="themDongXuat()">+ Thêm nguyên liệu</button>
                                </div>

                                <button type="submit" class="btn btn-danger">Lưu phiếu xuất</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
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
            function themDongNhap() {
                const tbody = document.querySelector('#nhapTable tbody');
                const row = document.createElement('tr');
                row.innerHTML = `
        <td><input type="text" class="form-control" name="ten[]" required></td>
        <td><input type="number" class="form-control" name="soluong[]" required></td>
        <td><input type="number" class="form-control" name="dongia[]" required></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">X</button></td>
      `;
                tbody.appendChild(row);
            }

            function themDongXuat() {
                const tbody = document.querySelector('#xuatTable tbody');
                const row = document.createElement('tr');
                row.innerHTML = `
        <td><input type="text" class="form-control" name="ten[]" required></td>
        <td><input type="number" class="form-control" name="soluong[]" required></td>
        <td><input type="text" class="form-control" name="ghichu[]"></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">X</button></td>
      `;
                tbody.appendChild(row);
            }
        </script>

</body>

</html>
<?php
if (ob_get_length()) {
    ob_end_flush();
}
?>