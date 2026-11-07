<?php
session_start();
include '../Includes/connect_db.php';
/** @var mysqli $conn */

if(isset($_POST['btnDangKy'])) {
    $ho_ten = mysqli_real_escape_string($conn, $_POST['txtHoTen']);
    $user = mysqli_real_escape_string($conn, $_POST['txtUser']);
    $pass = md5($_POST['txtPass']); 
    $email = mysqli_real_escape_string($conn, $_POST['txtEmail']);
    $sdt = mysqli_real_escape_string($conn, $_POST['txtSDT']);

    $sql_check = "SELECT * FROM tbl_nguoidung WHERE ten_dang_nhap = '$user' LIMIT 1";
    $res_check = mysqli_query($conn, $sql_check);

    if(mysqli_num_rows($res_check) > 0) {
        echo "<script>alert('Tên đăng nhập này đã tồn tại, vui lòng chọn tên khác!'); window.history.back();</script>";
    } else {
        $sql_insert = "INSERT INTO tbl_nguoidung (ho_ten, ten_dang_nhap, mat_khau, email, so_dien_thoai, quyen, trang_thai) 
                       VALUES ('$ho_ten', '$user', '$pass', '$email', '$sdt', 0, 1)";
        
        if(mysqli_query($conn, $sql_insert)) {
            echo "<script>alert('Đăng ký tài khoản thành công! Mời bạn đăng nhập.'); window.location.href='dangnhap.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra: " . mysqli_error($conn) . "'); window.history.back();</script>";
        }
    }
}
?>