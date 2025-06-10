<?php
session_start();
include_once __DIR__ . '/../../../dbconnect.php';

// Lấy mã món ăn từ URL
$menu_ma = $_GET['menu_ma'] ?? null;

if (!$menu_ma) {
    $_SESSION['flash_msg'] = 'Không xác định món ăn cần xoá.';
    $_SESSION['flash_context'] = 'danger';
    header('Location: index.php');
    exit;
}

// Lấy thông tin món ăn để biết đường dẫn ảnh và tên món
$sqlSelect = "SELECT * FROM menu_items WHERE id = $menu_ma";
$resultSelect = mysqli_query($conn, $sqlSelect);
$row = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC);

if (!$row) {
    $_SESSION['flash_msg'] = 'Món ăn không tồn tại.';
    $_SESSION['flash_context'] = 'danger';
    header('Location: index.php');
    exit;
}

// Xoá ảnh cũ nếu tồn tại
$imgPath = $_SERVER['DOCUMENT_ROOT'] . $row['img'];
if (file_exists($imgPath)) {
    unlink($imgPath);
}

// Xoá liên kết món ăn - loại (nếu dùng bảng trung gian)
$sqlDeleteRelation = "DELETE FROM menu_item_categories WHERE menu_item_id = $menu_ma";
mysqli_query($conn, $sqlDeleteRelation);

// Xoá món ăn
$sqlDelete = "DELETE FROM menu_items WHERE id = $menu_ma";
mysqli_query($conn, $sqlDelete);

// Thông báo
$_SESSION['flash_msg'] = "Đã xoá món <b>{$row['menu_name']}</b>!";
$_SESSION['flash_context'] = 'danger';
header('Location: index.php');
exit;
