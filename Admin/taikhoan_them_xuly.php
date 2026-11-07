<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
include_once '../Includes/connect_db.php';

if (isset($_POST['btnThem'])) {
    $ho_ten = mysqli_real_escape_string($conn, $_POST['ho_ten']);
    $ten_dang_nhap = mysqli_real_escape_string($conn, $_POST['ten_dang_nhap']);
    $mat_khau = md5($_POST['mat_khau']); 
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    $so_dien_thoai = mysqli_real_escape_string($conn, $_POST['so_dien_thoai']); 
    
    $quyen = $_POST['quyen'];
    $trang_thai = 1;

    $sql = "INSERT INTO tbl_nguoidung (ho_ten, ten_dang_nhap, mat_khau, email, so_dien_thoai, quyen, trang_thai) 
            VALUES ('$ho_ten', '$ten_dang_nhap', '$mat_khau', '$email', '$so_dien_thoai', '$quyen', '$trang_thai')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Thêm tài khoản thành công!');
                window.location.href = 'index.php?view=taikhoan';
              </script>";
    } else {
        echo "<script>
                alert('Lỗi: Tên đăng nhập đã tồn tại hoặc thiếu thông tin!');
                window.history.back();
              </script>";
    }
}
?>