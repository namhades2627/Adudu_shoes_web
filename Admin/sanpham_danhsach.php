<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
$sql = "SELECT sp.*, loai.ten_loaigiay AS ten_loai 
        FROM tbl_sanpham sp 
        LEFT JOIN tbl_loaigiay loai ON sp.id_loaigiay = loai.id_loaigiay
        ORDER BY sp.id_sanpham DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Lỗi SQL: " . mysqli_error($conn));
}

$total_sp = mysqli_num_rows($result);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white fw-bold text-uppercase">Danh sách sản phẩm (<?php echo $total_sp; ?>)</h3>
    <a href="?view=sanpham&action=them" class="btn btn-warning fw-bold px-4">
        <i class="fas fa-plus me-2"></i> Thêm 
    </a>
</div>

<div class="card bg-dark border-secondary shadow">
    <div class="card-body p-0">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead class="table-secondary text-dark">
                <tr>
                    <th class="ps-4">ID</th>
                    <th>Sản phẩm / Mã SP</th>
                    <th>Loại giày</th>
                    <th>Giá bán</th>
                    <th>Số lượng</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if($total_sp > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="ps-4 text-secondary">#<?php echo $row['id_sanpham']; ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="../Images/<?php echo $row['hinh_anh']; ?>" 
                                     class="rounded border border-secondary me-3" 
                                     style="width: 50px; height: 50px; object-fit: cover;">
                                <div>
                                    <div class="fw-bold text-white"><?php echo $row['ten_sp']; ?></div>
                                    <small class="text-secondary">Mã: <?php echo $row['ma_sp']; ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge border border-info text-info">
                                <?php echo !empty($row['ten_loai']) ? $row['ten_loai'] : 'N/A'; ?>
                            </span>
                        </td>
                        <td class="text-warning fw-bold">
                            <?php echo number_format($row['gia_ban'], 0, ',', '.'); ?>₫
                        </td>
                        <td>
                            <?php echo $row['so_luong_ton']; ?>
                        </td>
                        <td class="text-center">
                            <a href="?view=sanpham&action=chitiet&id=<?php echo $row['id_sanpham']; ?>" class="text-info mx-1"><i class="fas fa-eye"></i></a>
                            <a href="?view=sanpham&action=sua&id=<?php echo $row['id_sanpham']; ?>" class="text-warning mx-2"><i class="fas fa-edit"></i></a>
                            <a href="?view=sanpham&action=xoa&id=<?php echo $row['id_sanpham']; ?>" class="text-danger mx-1" onclick="return confirm('Xóa giày này?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Chưa có sản phẩm nào trong hệ thống.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>