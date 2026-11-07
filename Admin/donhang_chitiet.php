<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
$id_dh = $_GET['id'];

if(isset($_GET['req']) && $_GET['req'] == 'delete') {
    mysqli_query($conn, "DELETE FROM tbl_chitietdonhang WHERE id_donhang = $id_dh");
    mysqli_query($conn, "DELETE FROM tbl_donhang WHERE id_donhang = $id_dh");
    
    echo "<script>alert('Đã xóa đơn hàng #$id_dh thành công!'); window.location.href='index.php?view=donhang';</script>";
    exit();
}

if(isset($_POST['btnCapNhat'])) {
    $trang_thai_moi = $_POST['trang_thai_moi'];
    $sql_update = "UPDATE tbl_donhang SET trang_thai = $trang_thai_moi WHERE id_donhang = $id_dh";
    if(mysqli_query($conn, $sql_update)) {
        if($trang_thai_moi == 2) { 
            $sql_get_user = "SELECT id_nguoidung FROM tbl_donhang WHERE id_donhang = $id_dh";
            $res_user = mysqli_query($conn, $sql_get_user);
            $row_user = mysqli_fetch_assoc($res_user);
            
            if($row_user && !empty($row_user['id_nguoidung'])) {
                $id_user = $row_user['id_nguoidung'];
                $noi_dung = "Đơn hàng #$id_dh của bạn đã giao thành công. Nhấn vào đây để đánh giá sản phẩm nhé!";
                $link = "danhgia.php?id_dh=" . $id_dh;
                
                $sql_tb = "INSERT INTO tbl_thongbao (id_nguoidung, noi_dung, link, trang_thai) 
                           VALUES ($id_user, '$noi_dung', '$link', 0)";
                mysqli_query($conn, $sql_tb);
            }
        }

        echo "<script>alert('Cập nhật trạng thái thành công!'); window.location.href='index.php?view=donhang';</script>";
        exit();
    }
}
$sql_dh = "SELECT * FROM tbl_donhang WHERE id_donhang = $id_dh";
$res_dh = mysqli_query($conn, $sql_dh);
$dh = mysqli_fetch_assoc($res_dh);

$sql_ct = "SELECT ct.*, sp.ten_sp, sp.hinh_anh 
           FROM tbl_chitietdonhang ct 
           JOIN tbl_sanpham sp ON ct.id_sanpham = sp.id_sanpham 
           WHERE ct.id_donhang = $id_dh";
$res_ct = mysqli_query($conn, $sql_ct);

if(mysqli_num_rows($res_ct) == 0) {
    echo "<p class='text-danger'>Lỗi: Không tìm thấy chi tiết cho đơn hàng #$id_dh trong database!</p>";
}
?>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h3 class="text-white fw-bold text-uppercase">Chi tiết đơn hàng #<?php echo $id_dh; ?></h3>
        <span class="text-secondary small">Ngày đặt: <?php echo date('d/m/Y H:i', strtotime($dh['ngay_dat'])); ?></span>
    </div>
    <a href="?view=donhang" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
    </a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card bg-dark border-secondary text-white shadow mb-4">
            <div class="card-header border-secondary fw-bold text-warning small text-uppercase">
                Thông tin giao hàng
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-secondary small d-block">NGƯỜI NHẬN</label>
                    <span class="fw-bold text-info"><?php echo $dh['ten_nguoi_nhan']; ?></span>
                </div>
                <div class="mb-3">
                    <label class="text-secondary small d-block">SỐ ĐIỆN THOẠI</label>
                    <span><?php echo $dh['so_dien_thoai']; ?></span>
                </div>
                <div class="mb-3">
                    <label class="text-secondary small d-block">ĐỊA CHỈ GIAO</label>
                    <p class="small mb-0 text-light"><?php echo $dh['dia_chi_giao']; ?></p>
                </div>
                <div class="mb-3">
                    <label class="text-secondary small d-block">GHI CHÚ</label>
                    <p class="small fst-italic text-secondary"><?php echo $dh['ghi_chu'] ? $dh['ghi_chu'] : 'Không có ghi chú'; ?></p>
                </div>

                <div class="mt-4 p-3 border border-secondary rounded bg-black bg-opacity-25">
                    <label class="text-warning small fw-bold mb-2 d-block">TRẠNG THÁI ĐƠN HÀNG</label>
                    
                    <form action="" method="POST" class="d-flex flex-column gap-2">
                        <input type="hidden" name="id_donhang" value="<?php echo $id_dh; ?>">
                        <select name="trang_thai_moi" class="form-select bg-dark text-white border-secondary fw-bold">
                            <option value="0" <?php if($dh['trang_thai'] == 0) echo 'selected'; ?>>Chờ duyệt</option>
                            <option value="1" <?php if($dh['trang_thai'] == 1) echo 'selected'; ?>>Đang giao</option>
                            <option value="2" <?php if($dh['trang_thai'] == 2) echo 'selected'; ?>>Hoàn thành</option>
                            <option value="3" <?php if($dh['trang_thai'] == 3) echo 'selected'; ?>>Đã hủy</option>
                        </select>
                        <button type="submit" name="btnCapNhat" class="btn btn-primary fw-bold w-100">XÁC NHẬN</button>
                    </form>

                    <a href="?view=donhang&action=chitiet&id=<?php echo $id_dh; ?>&req=delete" 
                       class="btn btn-danger fw-bold w-100 mt-2" 
                       onclick="return confirm('Bạn có chắc chắn muốn xóa toàn bộ dữ liệu của đơn hàng #<?php echo $id_dh; ?> này không?');">
                       <i class="fas fa-trash me-1"></i> XÓA ĐƠN HÀNG
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card bg-dark border-secondary shadow">
            <div class="card-header border-secondary fw-bold text-warning small text-uppercase">
                Sản phẩm trong đơn
            </div>
            <div class="card-body p-0">
                <table class="table table-dark mb-0">
                    <thead class="table-secondary text-dark">
                        <tr>
                            <th class="ps-3 small">SẢN PHẨM</th>
                            <th class="small">SIZE</th>
                            <th class="small">SỐ LƯỢNG</th>
                            <th class="text-end pe-3 small">THÀNH TIỀN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $tong_thuc_te = 0; 
                        while($item = mysqli_fetch_assoc($res_ct)):           
                            $thanh_tien = $item['gia_mua'] * $item['so_luong']; 
                            $tong_thuc_te += $thanh_tien;
                        ?>
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center py-2">
                                    <img src="../Images/<?php echo $item['hinh_anh']; ?>" width="55" class="rounded border border-secondary me-3">
                                    <span class="fw-bold"><?php echo $item['ten_sp']; ?></span>
                                </div>
                            </td>
                            <td><span class="badge border border-secondary"><?php echo $item['size_mua']; ?></span></td>
                            <td class="text-center">x<?php echo $item['so_luong']; ?></td>
                            <td class="text-end pe-3 fw-bold text-success">
                                <?php echo number_format($thanh_tien, 0, ',', '.'); ?>₫
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot class="border-top border-secondary bg-black bg-opacity-25">
                        <tr>
                            <td colspan="3" class="text-end py-3 fw-bold text-secondary">TỔNG CỘNG THANH TOÁN:</td>
                            <td class="text-end pe-3 py-3 h5 fw-bold text-warning">
                                <?php echo number_format($dh['tong_tien'], 0, ',', '.'); ?>₫
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>