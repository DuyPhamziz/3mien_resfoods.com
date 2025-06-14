<?php
session_start();
if (!isset($_SESSION['staff'])) {
    header('Location: /3mien_resfoods.com/login.php');
    exit();
}
include_once __DIR__ . '/../../../dbconnect.php';
$id = $_GET['id'];

$sql = "DELETE FROM customers WHERE id = $id";
mysqli_query($conn, $sql);

header("Location: index.php");
exit();
