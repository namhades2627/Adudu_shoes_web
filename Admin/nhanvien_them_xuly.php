<?php 
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
include_once '../Includes/connect_db.php';

if(isset($_POST['btnThemNV'])) {
    $ma_nv = mysqli_real_escape_string($conn, $_POST['ma_nv']);
    $ho_ten = mysqli_real_escape_string($conn, $_POST['ho_ten']);
    $so_dien_thoai = mysqli_real_escape_string($conn, $_POST['so_dien_thoai']);
    $email = mysqli_real_escape_string($conn, $_POST['email']); 
    $chuc_vu = mysqli_real_escape_string($conn, $_POST['chuc_vu']);
    $luong_co_ban = (int)$_POST['luong_co_ban'];
    $ngay_vao_lam = mysqli_real_escape_string($conn, $_POST['ngay_vao_lam']);

    $sql = "INSERT INTO tbl_nhanvien (ma_nv, ho_ten, so_dien_thoai, email, chuc_vu, luong_co_ban, ngay_vao_lam) 
            VALUES ('$ma_nv', '$ho_ten', '$so_dien_thoai', '$email', '$chuc_vu', $luong_co_ban, '$ngay_vao_lam')";
    
    if(mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Thêm nhân viên thành công!'); 
                window.location.href='index.php?view=nhanvien';
              </script>";
    } else {
        echo "<script>
                alert('Lỗi Database: " . mysqli_error($conn) . "'); 
                window.history.back();
              </script>";
    }
} else {
    header("Location: index.php?view=nhanvien");
}
?>