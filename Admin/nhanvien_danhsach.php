<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
$res_nv = mysqli_query($conn, "SELECT * FROM tbl_nhanvien ORDER BY id_nhanvien DESC");
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white fw-bold text-uppercase">Danh sách Nhân viên</h3>
    <a href="?view=nhanvien&action=them" class="btn btn-warning fw-bold px-4"><i class="fas fa-user-plus me-2"></i> Thêm mới</a>
</div>
<div class="card bg-dark border-secondary shadow"><div class="card-body p-0">
    <table class="table table-dark table-hover align-middle mb-0 text-center">
        <thead class="table-secondary text-dark"><tr><th class="ps-4 text-start">Mã NV</th><th class="text-start">Họ tên & Liên hệ</th><th>Chức vụ</th><th>Lương cơ bản</th><th>Thao tác</th></tr></thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($res_nv)): ?>
            <tr>
                <td class="ps-4 text-secondary text-start fw-bold"><?php echo $row['ma_nv']; ?></td>
                <td class="text-start"><div class="fw-bold text-info"><?php echo $row['ho_ten']; ?></div><div class="small text-secondary"><?php echo $row['so_dien_thoai']; ?></div></td>
                <td><span class="badge bg-primary"><?php echo $row['chuc_vu']; ?></span></td>
                <td class="text-warning fw-bold"><?php echo number_format($row['luong_co_ban'], 0, ',', '.'); ?>₫</td>
                <td class="text-center">
                    <a href="index.php?view=nhanvien&action=sua&id=<?php echo $row['id_nhanvien']; ?>" class="text-warning mx-2"><i class="fas fa-edit"></i></a>
                    <a href="nhanvien_xoa.php?id=<?php echo $row['id_nhanvien']; ?>" class="text-danger" onclick="return confirm('Bạn có chắc muốn xóa nhân viên <?php echo $row['ho_ten']; ?>?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div></div>