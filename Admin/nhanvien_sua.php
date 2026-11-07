<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
include_once '../Includes/connect_db.php';

$row = null;
if (isset($_GET['id'])) {
    $id_nv = (int)$_GET['id'];
    $res = mysqli_query($conn, "SELECT * FROM tbl_nhanvien WHERE id_nhanvien = $id_nv");
    $row = $res ? mysqli_fetch_assoc($res) : null;
}
if (empty($row)) {
    echo '<div class="alert alert-warning">Không tìm thấy nhân viên.</div>';
    return;
}
?>

<div class="card bg-dark border-secondary text-white p-4 shadow">
    <h4 class="text-warning fw-bold mb-4">SỬA THÔNG TIN NHÂN VIÊN</h4>
    <form action="nhanvien_sua_xuly.php" method="POST">
        <input type="hidden" name="id_nv" value="<?php echo $row['id_nhanvien']; ?>">
        
        <div class="mb-3">
            <label class="form-label small fw-bold text-secondary">HỌ TÊN</label>
            <input type="text" name="txtHoTen" class="form-control bg-dark text-white border-secondary" value="<?php echo $row['ho_ten']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold text-secondary">CHỨC VỤ</label>
            <input type="text" name="txtChucVu" class="form-control bg-dark text-white border-secondary" value="<?php echo $row['chuc_vu']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold text-secondary">LƯƠNG CƠ BẢN (VNĐ)</label>
            <input type="number" name="txtLuong" class="form-control bg-dark text-white border-secondary" value="<?php echo $row['luong_co_ban']; ?>" required>
        </div>

        <div class="mt-4">
            <button type="submit" name="btnLuuSua" class="btn btn-warning fw-bold px-4">LƯU THAY ĐỔI</button>
            <a href="?view=nhanvien" class="btn btn-outline-secondary px-4 ms-2">HỦY</a>
        </div>
    </form>
</div>