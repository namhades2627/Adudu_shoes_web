<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
$id = $_GET['id'];
$sql = "SELECT sp.*, loai.ten_loaigiay AS ten_loai FROM tbl_sanpham sp 
        LEFT JOIN tbl_loaigiay loai ON sp.id_loaigiay = loai.id_loaigiay 
        WHERE id_sanpham = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<div class="mb-4">
    <h3 class="text-white fw-bold">THÔNG TIN CHI TIẾT SẢN PHẨM</h3>
    <a href="?view=sanpham" class="btn btn-outline-secondary btn-sm mt-2"><i class="fas fa-arrow-left me-1"></i> Quay lại</a>
</div>

<div class="card bg-dark border-secondary shadow p-4 text-white">
    <div class="row">
        <div class="col-md-4 text-center">
            <img src="../Images/<?php echo $row['hinh_anh']; ?>" class="img-fluid rounded border border-secondary shadow-lg">
        </div>
        <div class="col-md-8">
            <h2 class="text-warning fw-bold mb-3"><?php echo $row['ten_sp']; ?></h2>
            <div class="mb-2"><span class="text-secondary fw-bold">MÃ SẢN PHẨM:</span> <?php echo $row['ma_sp']; ?></div>
            <div class="mb-2"><span class="text-secondary fw-bold">LOẠI GIÀY:</span> <?php echo $row['ten_loai']; ?></div>
            <div class="mb-2"><span class="text-secondary fw-bold">GIÁ BÁN:</span> <span class="text-warning h4 fw-bold"><?php echo number_format($row['gia_ban'], 0, ',', '.'); ?>₫</span></div>
            <div class="mb-2"><span class="text-secondary fw-bold">SỐ LƯỢNG TRONG KHO:</span> <?php echo $row['so_luong_ton']; ?></div>
            <hr class="border-secondary">
            <div class="mt-3">
                <p class="text-secondary fw-bold">MÔ TẢ SẢN PHẨM:</p>
                <div class="text-light"><?php echo nl2br($row['mo_ta']); ?></div>
            </div>
        </div>
    </div>
</div>