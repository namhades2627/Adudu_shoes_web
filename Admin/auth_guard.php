<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../Includes/connect_db.php';

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(404);
    exit;
}

if (empty($_SESSION['id_nguoidung'])) {
    header('Location: ../Trangtin/dangnhap.php');
    exit;
}

$id_nguoidung = (int) $_SESSION['id_nguoidung'];
$stmt = mysqli_prepare($conn, 'SELECT ho_ten, quyen, trang_thai FROM tbl_nguoidung WHERE id_nguoidung = ? LIMIT 1');

if (!$stmt) {
    http_response_code(503);
    exit('Không thể xác thực quyền quản trị.');
}

mysqli_stmt_bind_param($stmt, 'i', $id_nguoidung);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ho_ten, $quyen, $trang_thai);
$da_xac_thuc = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$da_xac_thuc || (int) $trang_thai !== 1) {
    $_SESSION = [];
    session_destroy();
    header('Location: ../Trangtin/dangnhap.php');
    exit;
}

if ((int) $quyen !== 1) {
    header('Location: ../Trangtin/index.php');
    exit;
}

$_SESSION['ho_ten'] = $ho_ten;
$_SESSION['quyen'] = 1;