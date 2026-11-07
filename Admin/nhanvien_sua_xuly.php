<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
session_start();
include_once '../Includes/connect_db.php';

if (isset($_POST['btnLuuSua'])) {
    $id_nv = (int)$_POST['id_nv'];
    $ho_ten = mysqli_real_escape_string($conn, $_POST['txtHoTen']);
    $chuc_vu = mysqli_real_escape_string($conn, $_POST['txtChucVu']);
    $luong = (int)$_POST['txtLuong'];

    $sql_update = "UPDATE tbl_nhanvien SET 
                    ho_ten = '$ho_ten', 
                    chuc_vu = '$chuc_vu', 
                    luong_co_ban = $luong 
                   WHERE id_nhanvien = $id_nv";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Cập nhật nhân viên thành công!'); window.location.href='index.php?view=nhanvien';</script>";
    } else {
        echo "<script>alert('Lỗi cập nhật: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
?>