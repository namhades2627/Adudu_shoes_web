<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM tbl_tintuc WHERE id_tintuc = $id";
    
    if(mysqli_query($conn, $sql)) {
       echo "<script>
                alert('Đã xóa bài viết thành công!');
                window.location.href = 'index.php?view=baiviet';
              </script>";
    } else {
        echo "Lỗi khi xóa bài viết: " . mysqli_error($conn);
    }
} else {
    echo "<script>window.location.href = 'index.php?view=baiviet';</script>";
}
?>