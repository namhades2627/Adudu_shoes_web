<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
include_once '../Includes/connect_db.php';

if (isset($_POST['btnThemSP'])) {
    $ma_sp = mysqli_real_escape_string($conn, $_POST['ma_sp']);
    $ten_sp = mysqli_real_escape_string($conn, $_POST['ten_sp']);
    $id_loaigiay = $_POST['id_loaigiay'];
    $gia_ban = $_POST['gia_ban'];
    $so_luong_ton = $_POST['so_luong_ton'];
    $mo_ta = mysqli_real_escape_string($conn, $_POST['mo_ta']);

    $hinh_anh = $_FILES['hinh_anh']['name'];
    $tmp_img = $_FILES['hinh_anh']['tmp_name'];
    
    if(!empty($hinh_anh)) {
        move_uploaded_file($tmp_img, "../Images/".$hinh_anh);
    } else {
        $hinh_anh = "no-image.jpg";
    }

    $sql = "INSERT INTO tbl_sanpham (ma_sp, ten_sp, id_loaigiay, gia_ban, hinh_anh, mo_ta, so_luong_ton, ngay_tao) 
            VALUES ('$ma_sp', '$ten_sp', '$id_loaigiay', '$gia_ban', '$hinh_anh', '$mo_ta', '$so_luong_ton', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Thêm sản phẩm thành công!');
                window.location.href = 'index.php?view=sanpham';
              </script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>