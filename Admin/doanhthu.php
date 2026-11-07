<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo '<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">';
echo '<meta http-equiv="Pragma" content="no-cache">';
echo '<meta http-equiv="Expires" content="0">';

include_once '../Includes/connect_db.php';

$sql_tong = "SELECT SUM(tong_tien) as total_revenue FROM tbl_donhang WHERE trang_thai = 2";
$res_tong = mysqli_query($conn, $sql_tong);
$row_tong = mysqli_fetch_assoc($res_tong);
$doanh_thu = $row_tong['total_revenue'] ?? 0;

$sql_count = "SELECT COUNT(*) as total_orders FROM tbl_donhang WHERE trang_thai = 2";
$res_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_assoc($res_count);
$so_don_hang = $row_count['total_orders'] ?? 0;

$sql_top = "SELECT * FROM tbl_donhang WHERE trang_thai = 2 ORDER BY tong_tien DESC LIMIT 5";
$res_top = mysqli_query($conn, $sql_top);
?>

<div class="mb-4">
    <h3 class="text-white fw-bold text-uppercase">Báo cáo doanh thu Adudu Shop</h3>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card bg-dark border-success shadow-sm text-center py-4">
             <i class="fas fa-money-bill-wave text-success mb-2" style="font-size: 2rem;"></i>
             <h6 class="text-secondary text-uppercase small">Tổng doanh thu thực nhận</h6>
             <h2 class="text-white fw-bold mb-0"><?php echo number_format($doanh_thu, 0, ',', '.'); ?>₫</h2>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-dark border-info shadow-sm text-center py-4">
             <i class="fas fa-box-open text-info mb-2" style="font-size: 2rem;"></i>
             <h6 class="text-secondary text-uppercase small">Đơn hàng hoàn tất</h6>
             <h2 class="text-white fw-bold mb-0"><?php echo $so_don_hang; ?> đơn</h2>
        </div>
    </div>
</div>