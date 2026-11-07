<?php
session_start();
include '../Includes/connect_db.php';
/** @var mysqli $conn */

if(isset($_GET['id']) && isset($_GET['link'])) {
    $id_tb = $_GET['id'];
    $link = $_GET['link'];
    
    $sql_update_tb = "UPDATE tbl_thongbao SET trang_thai = 1 WHERE id_thongbao = $id_tb";
    mysqli_query($conn, $sql_update_tb);

    header("Location: " . $link);
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>