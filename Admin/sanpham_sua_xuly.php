<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
include_once '../Includes/connect_db.php';

if (isset($_POST['btnSuaSP'])) {
    $id = $_POST['id_sanpham'];
    $ma_sp = mysqli_real_escape_string($conn, $_POST['ma_sp']);
    $ten_sp = mysqli_real_escape_string($conn, $_POST['ten_sp']);
    $id_loaigiay = $_POST['id_loaigiay'];
    $gia_ban = $_POST['gia_ban'];
    $so_luong_ton = $_POST['so_luong_ton'];
    $mo_ta = mysqli_real_escape_string($conn, $_POST['mo_ta']);

    if ($_FILES['hinh_anh']['name'] != "") {
        $hinh_anh = $_FILES['hinh_anh']['name'];
        move_uploaded_file($_FILES['hinh_anh']['tmp_name'], "../Images/".$hinh_anh);
    } else {
        $hinh_anh = $_POST['hinh_anh_old'];
    }

    $sql = "UPDATE tbl_sanpham SET 
            ma_sp = '$ma_sp', 
            ten_sp = '$ten_sp', 
            id_loaigiay = '$id_loaigiay', 
            gia_ban = '$gia_ban', 
            hinh_anh = '$hinh_anh', 
            mo_ta = '$mo_ta', 
            so_luong_ton = '$so_luong_ton' 
            WHERE id_sanpham = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href = 'index.php?view=sanpham';</script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>