<?php
require_once __DIR__ . '/auth_guard.php';
?>
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?view=nhanvien" class="text-warning text-decoration-none">Nhân viên</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">Thêm mới</li>
        </ol>
    </nav>
    <h3 class="text-white fw-bold text-uppercase">Thêm Nhân Viên Mới</h3>
</div>

<div class="card bg-dark border-secondary shadow mx-auto" style="max-width: 900px;">
    <div class="card-body p-4">
        <form action="nhanvien_them_xuly.php" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-secondary small fw-bold text-uppercase">Mã nhân viên</label>
                    <input type="text" name="ma_nv" class="form-control bg-dark text-white border-secondary" placeholder="VD: NV005" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label text-secondary small fw-bold text-uppercase">Họ tên</label>
                    <input type="text" name="ho_ten" class="form-control bg-dark text-white border-secondary" placeholder="Nhập họ và tên..." required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-secondary small fw-bold text-uppercase">Số điện thoại</label>
                    <input type="text" name="so_dien_thoai" class="form-control bg-dark text-white border-secondary" placeholder="Nhập số điện thoại..." required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-secondary small fw-bold text-uppercase">Email</label>
                    <input type="email" name="email" class="form-control bg-dark text-white border-secondary" placeholder="example@gmail.com" required>
                </div>
                
                <div class="col-12 border-top border-secondary my-3 pt-3"></div>

                <div class="col-md-4 mb-3">
                    <label class="form-label text-secondary small fw-bold text-uppercase">Ngày vào làm</label>
                    <input type="date" name="ngay_vao_lam" class="form-control bg-dark text-white border-secondary" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label text-warning small fw-bold text-uppercase">Chọn Chức vụ</label>
                    <select name="chuc_vu" id="cv_sel" class="form-select bg-dark text-white border-warning" onchange="upLuong()" required>
                        <option value="" selected disabled>-- Vui lòng chọn --</option>
                        <option value="Quản lý cửa hàng" data-l="18000000">Quản lý cửa hàng</option>
                        <option value="Nhân viên Bán hàng" data-l="10000000">Nhân viên Bán hàng</option>
                        <option value="Thu ngân" data-l="10500000">Thu ngân</option>
                        <option value="Nhân viên Kho" data-l="11000000">Nhân viên Kho</option>
                    </select>
                </div>

                <div class="col-md-4 mb-4">
                    <label class="form-label text-success small fw-bold text-uppercase">Lương cơ bản (VNĐ)</label>
                    <input type="text" id="l_view" class="form-control bg-secondary text-white border-secondary fw-bold" placeholder="Tự động cập nhật..." readonly>
                    <input type="hidden" name="luong_co_ban" id="l_real" value="0">
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end mt-2">
                <button type="submit" name="btnThemNV" class="btn btn-warning fw-bold px-4">LƯU NHÂN VIÊN</button>
                <a href="?view=nhanvien" class="btn btn-outline-secondary px-4">HỦY</a>
            </div>
        </form>
    </div>
</div>

<script>
function upLuong() {
    let s = document.getElementById("cv_sel");
    let l = s.options[s.selectedIndex].getAttribute("data-l");
    if (l) {
        document.getElementById("l_real").value = l;
        document.getElementById("l_view").value = new Intl.NumberFormat('vi-VN').format(l) + ' ₫';
    }
}
</script>