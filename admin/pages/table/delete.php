<?php 
    session_start();
if (!isset($_SESSION['staff'])) {
    header('Location: /3mien_resfoods.com/login.php');
    exit();
}
    include_once __DIR__ . '/../../../dbconnect.php';

    $t_ma = $_GET['t_ma'];

    $sqlDeleteTable = "DELETE FROM tables WHERE id=$t_ma";

    mysqli_query($conn, $sqlDeleteTable);

    $_SESSION['flash_msg'] = "Đã xóa bàn <b>$t_ma</b> ra khỏi nhà hàng";
    $_SESSION['flash_context'] = 'danger';
    echo '<script>location.href="index.php"</script>'
?>