<?php
session_start();
include '../Includes/connect_db.php';
/** @var mysqli $conn */

if(isset($_POST['btnGuiDanhGia'])) {
    if(!isset($_SESSION['id_nguoidung'])) {
        die("Lỗi: Bạn chưa đăng nhập!");
    }

    $id_nd = $_SESSION['id_nguoidung'];
    $id_dh = $_POST['id_dh'];
    $id_sp = $_POST['id_sp'];
    $so_sao = $_POST['so_sao'];
    $noi_dung = mysqli_real_escape_string($conn, $_POST['noi_dung']);

    $sql_check = "SELECT * FROM tbl_danhgia WHERE id_sanpham = $id_sp AND id_nguoidung = $id_nd";
    $res_check = mysqli_query($conn, $sql_check);

    if(mysqli_num_rows($res_check) == 0) {
        $sql_insert = "INSERT INTO tbl_danhgia (id_sanpham, id_nguoidung, so_sao, noi_dung) 
                       VALUES ($id_sp, $id_nd, $so_sao, '$noi_dung')";
        
        if(mysqli_query($conn, $sql_insert)) {
            echo "<script>alert('Cảm ơn bạn đã đánh giá sản phẩm!'); window.location.href='danhgia.php?id_dh=$id_dh';</script>";
        } else {
            echo "<script>alert('Lỗi: " . mysqli_error($conn) . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Bạn đã đánh giá sản phẩm này rồi!'); window.history.back();</script>";
    }
} else {
    header("Location: index.php");
}
?>