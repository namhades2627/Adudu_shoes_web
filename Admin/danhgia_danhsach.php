<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
if(isset($_GET['action']) && $_GET['action'] == 'xoa' && isset($_GET['id'])) {
    $id_xoa = $_GET['id'];
    mysqli_query($conn, "DELETE FROM tbl_danhgia WHERE id_danhgia = $id_xoa");
    echo "<script>alert('Đã xóa đánh giá thành công!'); window.location.href='index.php?view=danhgia';</script>";
    exit();
}

$sql_dg = "SELECT dg.*, nd.ho_ten, sp.ten_sp 
           FROM tbl_danhgia dg 
           JOIN tbl_nguoidung nd ON dg.id_nguoidung = nd.id_nguoidung
           JOIN tbl_sanpham sp ON dg.id_sanpham = sp.id_sanpham
           ORDER BY dg.id_danhgia DESC";
$res_dg = mysqli_query($conn, $sql_dg);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white fw-bold text-uppercase">Quản lý Đánh giá của Khách</h3>
</div>

<div class="card bg-dark border-secondary shadow">
    <div class="card-body p-0">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead class="table-secondary text-dark">
                <tr>
                    <th class="ps-4">Sản phẩm</th>
                    <th>Người dùng</th>
                    <th>Đánh giá</th>
                    <th>Nội dung bình luận</th>
                    <th>Ngày đăng</th>
                    <th class="text-center">Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($res_dg) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($res_dg)): ?>
                    <tr>
                        <td class="ps-4 fw-bold text-info" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <?php echo $row['ten_sp']; ?>
                        </td>
                        <td><?php echo $row['ho_ten']; ?></td>
                        <td class="text-warning fw-bold">
                            <?php echo $row['so_sao']; ?> <i class="fas fa-star small"></i>
                        </td>
                        <td style="max-width: 300px;">
                            <span class="d-inline-block text-truncate" style="max-width: 100%;"><?php echo $row['noi_dung']; ?></span>
                        </td>
                        <td class="text-secondary small"><?php echo date('d/m/Y H:i', strtotime($row['ngay_danh_gia'])); ?></td>
                        <td class="text-center">
                            <a href="?view=danhgia&action=xoa&id=<?php echo $row['id_danhgia']; ?>" class="text-danger mx-1" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn đánh giá này?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center text-secondary py-4">Chưa có đánh giá nào trên hệ thống.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>