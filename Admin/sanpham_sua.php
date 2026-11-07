<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
$id = $_GET['id'];
$sql = "SELECT * FROM tbl_sanpham WHERE id_sanpham = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$sql_loai = "SELECT * FROM tbl_loaigiay ORDER BY ten_loaigiay ASC";
$res_loai = mysqli_query($conn, $sql_loai);
?>

<div class="mb-4">
    <h3 class="text-white fw-bold">CHỈNH SỬA SẢN PHẨM</h3>
    <p class="text-secondary small">Mã hệ thống: #<?php echo $row['id_sanpham']; ?></p>
</div>

<div class="card bg-dark border-secondary shadow">
    <div class="card-body p-4">
        <form action="sanpham_sua_xuly.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_sanpham" value="<?php echo $row['id_sanpham']; ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">MÃ SẢN PHẨM</label>
                        <input type="text" name="ma_sp" class="form-control bg-dark text-white border-secondary" value="<?php echo $row['ma_sp']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">TÊN GIÀY</label>
                        <input type="text" name="ten_sp" class="form-control bg-dark text-white border-secondary" value="<?php echo $row['ten_sp']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">LOẠI GIÀY</label>
                        <select name="id_loaigiay" class="form-select bg-dark text-white border-secondary">
                            <?php while($row_loai = mysqli_fetch_assoc($res_loai)): ?>
                                <option value="<?php echo $row_loai['id_loaigiay']; ?>" <?php if($row['id_loaigiay'] == $row_loai['id_loaigiay']) echo 'selected'; ?>>
                                    <?php echo $row_loai['ten_loaigiay']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold text-uppercase">Giá bán (Nhập tay)</label>
                        <input type="text" name="gia_ban" class="form-control bg-dark text-white border-secondary" value="<?php echo $row['gia_ban']; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold text-uppercase">Số lượng tồn (Nhập tay)</label>
                        <input type="text" name="so_luong_ton" class="form-control bg-dark text-white border-secondary" value="<?php echo $row['so_luong_ton']; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">ẢNH HIỆN TẠI</label><br>
                        <img src="../Images/<?php echo $row['hinh_anh']; ?>" width="100" class="mb-2 rounded border border-secondary">
                        <input type="file" name="hinh_anh" class="form-control bg-dark text-white border-secondary">
                        <input type="hidden" name="hinh_anh_old" value="<?php echo $row['hinh_anh']; ?>">
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label text-secondary small fw-bold text-uppercase">Mô tả sản phẩm</label>
                    <textarea name="mo_ta" class="form-control bg-dark text-white border-secondary" rows="4"><?php echo $row['mo_ta']; ?></textarea>
                </div>
            </div>

            <button type="submit" name="btnSuaSP" class="btn btn-warning fw-bold px-4">CẬP NHẬT</button>
            <a href="?view=sanpham" class="btn btn-outline-secondary px-4 ms-2">HỦY</a>
        </form>
    </div>
</div>