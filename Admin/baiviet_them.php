<?php
require_once __DIR__ . '/auth_guard.php';
?>
<div class="mb-4">
    <h3 class="text-white fw-bold text-uppercase">THÊM BÀI VIẾT MỚI</h3>
</div>

<div class="card bg-dark border-secondary shadow">
    <div class="card-body p-4">
        <form action="baiviet_them_xuly.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label text-secondary small fw-bold">TIÊU ĐỀ BÀI VIẾT</label>
                <input type="text" name="tieu_de" class="form-control bg-dark text-white border-secondary" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary small fw-bold">ẢNH ĐẠI DIỆN</label>
                <input type="file" name="hinh_anh" class="form-control bg-dark text-white border-secondary">
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary small fw-bold">TÓM TẮT NGẮN</label>
                <textarea name="tom_tat" class="form-control bg-dark text-white border-secondary" rows="2"></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label text-secondary small fw-bold">NỘI DUNG CHI TIẾT</label>
                <textarea name="noi_dung" id="noidung" class="form-control"></textarea>
            </div>

            <button type="submit" name="btnThemBV" class="btn btn-success fw-bold px-4">ĐĂNG BÀI VIẾT</button>
            <a href="?view=baiviet" class="btn btn-outline-secondary px-4 ms-2">HỦY</a>
        </form>
    </div>
</div>

<script>
    CKEDITOR.replace('noidung');
</script>