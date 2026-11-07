<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
$sql = "SELECT * FROM tbl_nguoidung ORDER BY id_nguoidung DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="mx-auto" style="max-width: 1100px; padding-top: 15px;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-white fw-bold text-uppercase">Quản lý Tài khoản</h3>
        
        <a href="?view=taikhoan&action=them" class="btn btn-warning fw-bold px-4">
            <i class="fas fa-plus me-1"></i> Thêm
        </a>
    </div>

    <div class="card bg-dark border-secondary shadow">
        <div class="card-body p-0">
            <table class="table table-dark table-hover align-middle mb-0 text-center">
                <thead class="table-secondary text-dark">
                    <tr>
                        <th class="ps-4 text-start">ID</th>
                        <th class="text-start">Họ tên</th>
                        <th>Email</th>
                        <th>Quyền hạn</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="ps-4 text-secondary text-start">#<?php echo $row['id_nguoidung']; ?></td>
                        <td class="text-start">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user text-light"></i>
                                </div>
                                <span class="fw-bold"><?php echo $row['ho_ten']; ?></span>
                            </div>
                        </td>
                        <td><?php echo $row['email'] ? $row['email'] : '<span class="text-secondary fst-italic">Trống</span>'; ?></td>
                        <td>
                            <?php if($row['quyen'] == 1): ?>
                                <span class="badge bg-info text-dark">Admin</span>
                            <?php else: ?>
                                <span class="badge border border-secondary text-secondary">Client</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="?view=taikhoan&action=chitiet&id=<?php echo $row['id_nguoidung']; ?>" class="text-info mx-1" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
                            
                            <a href="?view=taikhoan&action=sua&id=<?php echo $row['id_nguoidung']; ?>" class="text-warning mx-2" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <a href="?view=taikhoan&action=xoa&id=<?php echo $row['id_nguoidung']; ?>" class="text-danger mx-1" title="Xóa" onclick="return confirm('Bạn chắc chắn muốn xóa tài khoản này?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>