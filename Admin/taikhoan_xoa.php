<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM tbl_nguoidung WHERE id_nguoidung = $id";
    
    if(mysqli_query($conn, $sql)) {
       echo "<script>
                alert('Đã xóa tài khoản thành công!');
                window.location.href = 'index.php?view=taikhoan';
              </script>";
    } else {
        echo "Lỗi khi xóa tài khoản: " . mysqli_error($conn);
    }
} else {
    echo "<script>window.location.href = 'index.php?view=taikhoan';</script>";
}
?>