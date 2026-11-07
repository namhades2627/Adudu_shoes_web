<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
include_once '../Includes/connect_db.php';

if (isset($_POST['btnSuaBV'])) {
    $id = $_POST['id_tintuc'];
    $tieu_de = mysqli_real_escape_string($conn, $_POST['tieu_de']);
    $tom_tat = mysqli_real_escape_string($conn, $_POST['tom_tat']);
    $noi_dung = mysqli_real_escape_string($conn, $_POST['noi_dung']);

    if (!empty($_FILES['hinh_anh']['name'])) {
        $hinh_anh = $_FILES['hinh_anh']['name'];
        move_uploaded_file($_FILES['hinh_anh']['tmp_name'], "../Images/news/".$hinh_anh);
    } else {
        $hinh_anh = $_POST['hinh_anh_old'];
    }

    $sql = "UPDATE tbl_tintuc SET 
            tieu_de = '$tieu_de', 
            hinh_anh = '$hinh_anh', 
            tom_tat = '$tom_tat', 
            noi_dung = '$noi_dung' 
            WHERE id_tintuc = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Cập nhật bài viết thành công!'); window.location.href = 'index.php?view=baiviet';</script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>