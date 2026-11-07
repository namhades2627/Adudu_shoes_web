<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
include_once '../Includes/connect_db.php';

if (isset($_POST['btnThemBV'])) {
    $tieu_de = mysqli_real_escape_string($conn, $_POST['tieu_de']);
    $tom_tat = mysqli_real_escape_string($conn, $_POST['tom_tat']);
    $noi_dung = mysqli_real_escape_string($conn, $_POST['noi_dung']); 

    $hinh_anh = $_FILES['hinh_anh']['name'];
    if(!empty($hinh_anh)) {
        move_uploaded_file($_FILES['hinh_anh']['tmp_name'], "../Images/news/".$hinh_anh);
    } else {
        $hinh_anh = "no-news.jpg"; 
    }

    $sql = "INSERT INTO tbl_tintuc (tieu_de, hinh_anh, tom_tat, noi_dung, ngay_dang) 
            VALUES ('$tieu_de', '$hinh_anh', '$tom_tat', '$noi_dung', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Đăng bài viết thành công!'); window.location.href = 'index.php?view=baiviet';</script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>