<?php
session_start();
include '../Includes/connect_db.php';
include '../Includes/header.php';

$cart = $_SESSION['cart'] ?? [];
$tong_tien = 0;
foreach($cart as $item) { $tong_tien += $item['gia'] * $item['sl']; }
?>

<div class="container mt-5 mb-5 text-white">
    <div class="row">
        <div class="col-md-7">
            <h4 class="mb-4 text-warning fw-bold text-uppercase">Thông tin giao hàng</h4>
            <form action="thanhtoan_xuly.php" method="POST" class="p-4" style="background: #1f1f23; border-radius: 10px;">
                <div class="mb-3">
                    <label class="form-label">Họ tên người nhận</label>
                    <input type="text" name="ho_ten" class="form-control bg-dark text-white border-secondary"
                         placeholder="Nhập tên người nhận hàng..." required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="so_dien_thoai" class="form-control bg-dark text-white border-secondary" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Địa chỉ nhận hàng</label>
                    <textarea name="dia_chi" class="form-control bg-dark text-white border-secondary" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-warning w-100 fw-bold py-3 mt-3" style="background: #ff6600; border:none;">
                    XÁC NHẬN THANH TOÁN
                </button>
            </form>
        </div>

        <div class="col-md-5">
            <h4 class="mb-4 text-warning fw-bold text-uppercase">Đơn hàng của bạn</h4>
            <div class="p-3 border border-secondary" style="border-radius: 10px;">
                <?php foreach($cart as $item): ?>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span><?php echo $item['ten']; ?> (Size: <?php echo $item['size']; ?>) x <?php echo $item['sl']; ?></span>
                        <span><?php echo number_format($item['gia'] * $item['sl'], 0, ',', '.'); ?>₫</span>
                    </div>
                <?php endforeach; ?>
                <hr class="border-secondary">
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Tổng cộng:</span>
                    <span class="text-danger"><?php echo number_format($tong_tien, 0, ',', '.'); ?>₫</span>
                </div>
            </div>
        </div>
    </div>
</div>