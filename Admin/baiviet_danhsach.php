<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
// Truy vấn 16 bài viết tin tức
$sql = "SELECT * FROM tbl_tintuc ORDER BY id_tintuc DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white fw-bold text-uppercase">Quản lý bài viết</h3>
    <a href="?view=baiviet&action=them" class="btn btn-success fw-bold px-4">
        <i class="fas fa-edit me-2"></i> Thêm
    </a>
</div>

<div class="card bg-dark border-secondary shadow">
    <div class="card-body p-0">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead class="table-secondary text-dark">
                <tr>
                    <th class="ps-4">ID</th>
                    <th>Hình ảnh</th>
                    <th style="width: 40%;">Tiêu đề</th>
                    <th>Ngày đăng</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td class="ps-4 text-secondary">#<?php echo $row['id_tintuc']; ?></td>
                    <td>
                        <img src="../Images/<?php echo $row['hinh_anh']; ?>" width="80" class="rounded border border-secondary">
                    </td>
                    <td>
                        <div class="fw-bold text-white"><?php echo $row['tieu_de']; ?></div>
                        <small class="text-secondary"><?php echo substr($row['tom_tat'], 0, 80); ?>...</small>
                    </td>
                    <td class="small"><?php echo date('d/m/Y', strtotime($row['ngay_dang'])); ?></td>
                    <td class="text-center">
                        <a href="?view=baiviet&action=sua&id=<?php echo $row['id_tintuc']; ?>" class="text-warning mx-2"><i class="fas fa-edit"></i></a>
                        <a href="?view=baiviet&action=xoa&id=<?php echo $row['id_tintuc']; ?>" class="text-danger" onclick="return confirm('Xóa bài viết này?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>