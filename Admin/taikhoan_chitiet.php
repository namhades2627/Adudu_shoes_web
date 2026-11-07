<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
$id = $_GET['id'];
$sql = "SELECT * FROM tbl_nguoidung WHERE id_nguoidung = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<div class="mb-4">
    <h3 class="text-white fw-bold">Chi tiết tài khoản: <?php echo $row['ten_dang_nhap']; ?></h3>
    <a href="?view=taikhoan" class="btn btn-outline-secondary btn-sm mt-2">
        <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
    </a>
</div>

<div class="card bg-dark border-secondary shadow" style="max-width: 700px;">
    <div class="card-body p-4 text-white">
        <div class="row mb-3">
            <div class="col-sm-4 text-secondary fw-bold text-uppercase small">Họ và tên</div>
            <div class="col-sm-8"><?php echo $row['ho_ten']; ?></div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-4 text-secondary fw-bold text-uppercase small">Tên đăng nhập</div>
            <div class="col-sm-8 text-warning fw-bold"><?php echo $row['ten_dang_nhap']; ?></div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-4 text-secondary fw-bold text-uppercase small">Email</div>
            <div class="col-sm-8"><?php echo $row['email'] ? $row['email'] : 'Chưa cập nhật'; ?></div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-4 text-secondary fw-bold text-uppercase small">Số điện thoại</div>
            <div class="col-sm-8"><?php echo $row['so_dien_thoai'] ? $row['so_dien_thoai'] : 'Chưa cập nhật'; ?></div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-4 text-secondary fw-bold text-uppercase small">Quyền hạn</div>
            <div class="col-sm-8">
                <?php echo ($row['quyen'] == 1) ? '<span class="badge bg-info text-dark">Quản trị viên</span>' : '<span class="badge border border-secondary text-secondary">Khách hàng</span>'; ?>
            </div>
        </div>
    </div>
</div>