<?php
session_start();
include_once __DIR__ . '/../../../dbconnect.php';

$id = $_GET['id'];

// Lấy thông tin ảnh cũ (nếu có) để xóa file ảnh
$sqlSelect = "SELECT img, name FROM staff WHERE id = $id";
$result = mysqli_query($conn, $sqlSelect);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if ($row && $row['img']) {
    $imgPath = __DIR__ . '/../../../assets/uploads/staff/' . $row['img'];
    if (file_exists($imgPath)) {
        unlink($imgPath); // Xóa file ảnh
    }
}

$sqlDelete = "DELETE FROM staff WHERE id = $id";
mysqli_query($conn, $sqlDelete);

$_SESSION['flash_msg'] = "Đã xóa nhân viên <b>{$row['name']}</b>!";
$_SESSION['flash_context'] = 'danger';
echo '<script>location.href="index.php"</script>';
