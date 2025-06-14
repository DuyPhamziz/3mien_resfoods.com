<?php
session_start();

// Xoá toàn bộ session
session_unset();
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: /3mien_resfoods.com/index.php"); // hoặc đường dẫn bạn dùng cho trang đăng nhập
exit();
