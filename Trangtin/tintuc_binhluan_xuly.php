<?php
session_start();
include '../Includes/connect_db.php';
/** @var mysqli $conn */

if(isset($_POST['btnGuiBinhLuan'])) {
    if(!isset($_SESSION['id_nguoidung'])) die("Lỗi: Bạn chưa đăng nhập!");
    $id_nd = $_SESSION['id_nguoidung'];
    $id_tintuc = (int)$_POST['id_tintuc'];
    $noi_dung = mysqli_real_escape_string($conn, $_POST['noi_dung']);

    $sql_insert = "INSERT INTO tbl_binhluan_tintuc (id_tintuc, id_nguoidung, noi_dung) VALUES ($id_tintuc, $id_nd, '$noi_dung')";
    mysqli_query($conn, $sql_insert);
    header("Location: tintuc_chitiet.php?id=$id_tintuc");
    exit();
}

if(isset($_GET['action'])) {
    if(!isset($_SESSION['id_nguoidung'])) {
        echo "<script>alert('Vui lòng đăng nhập!'); window.history.back();</script>"; exit();
    }
    
    $action = $_GET['action'];
    $id_bl = (int)$_GET['id_bl'];
    $id_tt = (int)$_GET['id_tt'];
    $id_nd = $_SESSION['id_nguoidung'];
    $quyen = $_SESSION['quyen'];

    if($action == 'xoa') {
        $sql_check = "SELECT id_nguoidung FROM tbl_binhluan_tintuc WHERE id_binhluan = $id_bl";
        $row = mysqli_fetch_assoc(mysqli_query($conn, $sql_check));
        
        if($row['id_nguoidung'] == $id_nd || $quyen == 1) {
            mysqli_query($conn, "DELETE FROM tbl_binhluan_tintuc WHERE id_binhluan = $id_bl");
            mysqli_query($conn, "DELETE FROM tbl_baocao_binhluan WHERE id_binhluan = $id_bl"); 
            echo "<script>window.location.href='tintuc_chitiet.php?id=$id_tt';</script>";
        } else {
            echo "<script>alert('Bạn không có quyền xóa bình luận này!'); window.history.back();</script>";
        }
    } 
    elseif ($action == 'sua') {
        $noidung_moi = mysqli_real_escape_string($conn, $_GET['noidung']);
        $sql_update = "UPDATE tbl_binhluan_tintuc SET noi_dung = '$noidung_moi' WHERE id_binhluan = $id_bl AND id_nguoidung = $id_nd";
        mysqli_query($conn, $sql_update);
        echo "<script>window.location.href='tintuc_chitiet.php?id=$id_tt';</script>";
    }
    elseif ($action == 'baocao') {
        $lydo = mysqli_real_escape_string($conn, $_GET['lydo']);
        $sql_bc = "INSERT INTO tbl_baocao_binhluan (id_binhluan, id_nguoidung, ly_do) VALUES ($id_bl, $id_nd, '$lydo')";
        mysqli_query($conn, $sql_bc);
        echo "<script>alert('Cảm ơn bạn đã báo cáo. Quản trị viên sẽ xem xét!'); window.location.href='tintuc_chitiet.php?id=$id_tt';</script>";
    }
} else {
    header("Location: index.php");
}
?>