<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
include_once '../Includes/connect_db.php';

if (isset($_POST['btnCapNhat'])) {
    $id_dh = $_POST['id_donhang'];
    $trang_thai_moi = $_POST['trang_thai_moi'];

    $sql = "UPDATE tbl_donhang SET trang_thai = $trang_thai_moi WHERE id_donhang = $id_dh";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Đã cập nhật trạng thái đơn hàng #$id_dh!');
                window.location.href = 'index.php?view=donhang&action=chitiet&id=$id_dh';
              </script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>