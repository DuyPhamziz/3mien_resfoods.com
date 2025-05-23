<?php 
    session_start();

    include_once __DIR__ . '/../../../dbconnect.php';
    $menu_ma = isset($_GET['menu_ma']) ? intval($_GET['menu_ma']) : 0;

    $sqlSelectMenuOld = "SELECT * FROM menu_items WHERE id=$menu_ma;";
    $resultMenuOld = mysqli_query($conn, $sqlSelectMenuOld);
    $rowMenuOld = mysqli_fetch_array($resultMenuOld, MYSQLI_ASSOC);

    if(!empty($rowMenuOld['img'])) {
    $uploadFolder = realpath(__DIR__ . "/../../upload/img/") . DIRECTORY_SEPARATOR;
    $delete_path = $uploadFolder . basename($rowMenuOld['img']);
    if (file_exists($delete_path)) {
        unlink($delete_path);
    }
    }
    $sqlDeleteMenu = "DELETE FROM menu_items WHERE id=$menu_ma;";

    mysqli_query($conn, $sqlDeleteMenu);

    $_SESSION['flash_msg'] = "Đã xóa món <b>{$rowMenuOld['name']}</b> ra khỏi thực đơn!!!";
    $_SESSION['flash_context'] = 'danger';
    echo '<script>location.href = "index.php"</script>';
?>