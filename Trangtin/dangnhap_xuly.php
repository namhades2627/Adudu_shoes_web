<?php
session_start();
include '../Includes/connect_db.php';
/** @var mysqli $conn */

if(isset($_POST['btnDangNhap'])) {
    $user = mysqli_real_escape_string($conn, $_POST['txtUser']);
    $pass = md5($_POST['txtPass']); 

    $sql = "SELECT * FROM tbl_nguoidung WHERE ten_dang_nhap = '$user' AND mat_khau = '$pass' AND trang_thai = 1 LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    session_regenerate_id(true);
    $_SESSION['id_nguoidung'] = $row['id_nguoidung']; 
    $_SESSION['ho_ten'] = $row['ho_ten'];
    $_SESSION['quyen'] = $row['quyen']; 
    
    header("Location: index.php");
    } else {
        echo "<script>alert('Thông tin đăng nhập không đúng!'); window.history.back();</script>";
    }
}
?>