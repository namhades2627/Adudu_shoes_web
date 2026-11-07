<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
$sql_loai = "SELECT * FROM tbl_loaigiay ORDER BY ten_loaigiay ASC";
$res_loai = mysqli_query($conn, $sql_loai);
?>

<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="?view=sanpham" class="text-warning text-decoration-none">Sản phẩm</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">Thêm mới</li>
        </ol>
    </nav>
    <h3 class="text-white fw-bold">THÊM GIÀY MỚI</h3>
</div>

<div class="card bg-dark border-secondary shadow">
    <div class="card-body p-4">
        <form action="sanpham_them_xuly.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">MÃ SẢN PHẨM</label>
                        <input type="text" name="ma_sp" class="form-control bg-dark text-white border-secondary" placeholder="VD: AD-01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">TÊN GIÀY</label>
                        <input type="text" name="ten_sp" class="form-control bg-dark text-white border-secondary" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">LOẠI GIÀY</label>
                        <select name="id_loaigiay" class="form-select bg-dark text-white border-secondary">
                            <?php while($row_loai = mysqli_fetch_assoc($res_loai)): ?>
                                <option value="<?php echo $row_loai['id_loaigiay']; ?>"><?php echo $row_loai['ten_loaigiay']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">GIÁ BÁN (VNĐ)</label>
                            <input type="text" name="gia_ban" 
                                class="form-control bg-dark text-white border-secondary" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                                placeholder="Nhập giá bán..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">SỐ LƯỢNG TỒN</label>
                            <input type="text" name="so_luong_ton" 
                                class="form-control bg-dark text-white border-secondary" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                                value="0">
                        </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">ẢNH SẢN PHẨM</label>
                        <input type="file" name="hinh_anh" class="form-control bg-dark text-white border-secondary">
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label text-secondary small fw-bold">MÔ TẢ CHI TIẾT</label>
                    <textarea name="mo_ta" class="form-control bg-dark text-white border-secondary" rows="4"></textarea>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" name="btnThemSP" class="btn btn-warning fw-bold px-4">LƯU SẢN PHẨM</button>
                <a href="?view=sanpham" class="btn btn-outline-secondary px-4">HỦY</a>
            </div>
        </form>
    </div>
</div>