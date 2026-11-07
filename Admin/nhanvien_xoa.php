<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
session_start();
include_once '../Includes/connect_db.php';

if (isset($_GET['id'])) {
    $id_nv = (int)$_GET['id']; 
    
    $sql_xoa = "DELETE FROM tbl_nhanvien WHERE id_nhanvien = $id_nv";
    
    if (mysqli_query($conn, $sql_xoa)) {
        echo "<script>alert('Đã xóa nhân viên thành công!'); window.location.href='index.php?view=nhanvien_danhsach';</script>";
    } else {
        echo "<script>alert('Lỗi: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
} else {
    header("Location: index.php?view=nhanvien_danhsach");
}
?>