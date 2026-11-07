<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
if(isset($_GET['action'])) {
    $id_bc = (int)$_GET['id'];
    $id_bl = (int)$_GET['id_bl'];
    
    if($_GET['action'] == 'xoa_bl') {
        mysqli_query($conn, "DELETE FROM tbl_binhluan_tintuc WHERE id_binhluan = $id_bl");
        mysqli_query($conn, "DELETE FROM tbl_baocao_binhluan WHERE id_binhluan = $id_bl");
        echo "<script>alert('Đã xóa bình luận vi phạm!'); window.location.href='index.php?view=baocao';</script>";
    } elseif($_GET['action'] == 'bo_qua') {
        mysqli_query($conn, "UPDATE tbl_baocao_binhluan SET trang_thai = 1 WHERE id_baocao = $id_bc");
        echo "<script>window.location.href='index.php?view=baocao';</script>";
    }
    exit();
}

$sql_bc = "SELECT bc.*, nd.ho_ten as nguoi_bao_cao, bl.noi_dung, bl.id_tintuc, tt.tieu_de 
           FROM tbl_baocao_binhluan bc 
           JOIN tbl_nguoidung nd ON bc.id_nguoidung = nd.id_nguoidung 
           JOIN tbl_binhluan_tintuc bl ON bc.id_binhluan = bl.id_binhluan
           JOIN tbl_tintuc tt ON bl.id_tintuc = tt.id_tintuc
           WHERE bc.trang_thai = 0 
           ORDER BY bc.id_baocao DESC";
$res_bc = mysqli_query($conn, $sql_bc);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white fw-bold text-uppercase">Bình luận bị báo cáo</h3>
</div>

<div class="card bg-dark border-secondary shadow">
    <div class="card-body p-0">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead class="table-secondary text-dark">
                <tr>
                    <th class="ps-4">Bài viết</th>
                    <th>Người báo cáo</th>
                    <th>Nội dung bị Report</th>
                    <th>Lý do</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($res_bc) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($res_bc)): ?>
                    <tr>
                        <td class="ps-4 text-info small" style="max-width: 200px;">
                            <a href="../Trangtin/tintuc_chitiet.php?id=<?php echo $row['id_tintuc']; ?>" target="_blank" class="text-info text-decoration-none">
                                <?php echo $row['tieu_de']; ?>
                            </a>
                        </td>
                        <td class="fw-bold"><?php echo $row['nguoi_bao_cao']; ?></td>
                        <td style="max-width: 250px;" class="text-secondary fst-italic">"<?php echo $row['noi_dung']; ?>"</td>
                        <td class="text-warning"><?php echo $row['ly_do']; ?></td>
                        <td class="text-center">
                            <a href="?view=baocao&action=xoa_bl&id=<?php echo $row['id_baocao']; ?>&id_bl=<?php echo $row['id_binhluan']; ?>" class="btn btn-danger btn-sm mx-1" title="Xóa bình luận này" onclick="return confirm('Chắc chắn xóa bình luận này?')"><i class="fas fa-trash"></i> Xóa BL</a>
                            <a href="?view=baocao&action=bo_qua&id=<?php echo $row['id_baocao']; ?>&id_bl=0" class="btn btn-outline-secondary btn-sm" title="Bỏ qua báo cáo này"><i class="fas fa-check"></i> Bỏ qua</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center text-success py-4"><i class="fas fa-check-circle me-2"></i>Không có báo cáo nào cần xử lý. Môi trường mạng đang rất trong sạch!</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>