<?php
session_start();
include_once __DIR__ . '/../../../dbconnect.php';
$lsp_ma = $_GET['lsp_ma'];
$sqlDeleteLSP = "DELETE FROM categories WHERE id=$lsp_ma";
mysqli_query($conn, $sqlDeleteLSP);

$_SESSION['flash_msg'] = "Đã xóa loại món ăn có mã <b>$lsp_ma</b> ra khỏi thực đơn!";
$_SESSION['flash_context'] = 'danger';
echo '<script>location.href="index.php"</script>';
?>
