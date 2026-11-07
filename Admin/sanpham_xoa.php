<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM tbl_sanpham WHERE id_sanpham = $id";
    
    if(mysqli_query($conn, $sql)) {
       echo "<script>
                alert('Đã xóa sản phẩm thành công!');
                window.location.href = 'index.php?view=sanpham';
              </script>";
    } else {
        echo "Lỗi khi xóa sản phẩm: " . mysqli_error($conn);
    }
} else {
    echo "<script>window.location.href = 'index.php?view=sanpham';</script>";
}
?>