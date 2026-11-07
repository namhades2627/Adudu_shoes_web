<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
include_once '../Includes/connect_db.php';

if (isset($_POST['btnSua'])) {
    $id = $_POST['id_nguoidung'];
    $ho_ten = mysqli_real_escape_string($conn, $_POST['ho_ten']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $quyen = $_POST['quyen'];
    $mat_khau_moi = $_POST['mat_khau_moi'];

    if (!empty($mat_khau_moi)) {
        $mk_encoded = md5($mat_khau_moi);
        $sql = "UPDATE tbl_nguoidung SET 
                ho_ten = '$ho_ten', 
                email = '$email', 
                quyen = '$quyen', 
                mat_khau = '$mk_encoded' 
                WHERE id_nguoidung = $id";
    } else {
        $sql = "UPDATE tbl_nguoidung SET 
                ho_ten = '$ho_ten', 
                email = '$email', 
                quyen = '$quyen' 
                WHERE id_nguoidung = $id";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Cập nhật thông tin thành công!');
                window.location.href = 'index.php?view=taikhoan';
              </script>";
    } else {
        echo "Lỗi cập nhật: " . mysqli_error($conn);
    }
}
?>