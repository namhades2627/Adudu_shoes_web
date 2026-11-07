<?php
require_once __DIR__ . '/auth_guard.php';
?>
<div class="mx-auto" style="max-width: 600px; padding-top: 20px;">
    
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?view=taikhoan" class="text-warning text-decoration-none">Tài khoản</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Thêm mới</li>
            </ol>
        </nav>
        <h3 class="text-white fw-bold text-uppercase">Thêm Tài Khoản Mới</h3>
    </div>

    <div class="card bg-dark border-secondary shadow">
        <div class="card-body p-4">
            <form action="taikhoan_them_xuly.php" method="POST">
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold text-uppercase">Họ tên</label>
                    <input type="text" name="ho_ten" class="form-control bg-dark text-white border-secondary" placeholder="Nhập họ và tên..." required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold text-uppercase">Tên đăng nhập</label>
                    <input type="text" name="ten_dang_nhap" class="form-control bg-dark text-white border-secondary" placeholder="Username..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold text-uppercase">Mật khẩu</label>
                    <input type="password" name="mat_khau" class="form-control bg-dark text-white border-secondary" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold text-uppercase">Email</label>
                    <input type="email" name="email" class="form-control bg-dark text-white border-secondary" placeholder="example@gmail.com">
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold text-uppercase">Số điện thoại</label>
                    <input type="text" name="so_dien_thoai" class="form-control bg-dark text-white border-secondary" placeholder="Nhập số điện thoại..." required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small fw-bold text-uppercase">Phân quyền</label>
                    <select name="quyen" class="form-select bg-dark text-white border-secondary">
                        <option value="0">Khách hàng (Client)</option>
                        <option value="1">Quản trị viên (Admin)</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" name="btnThem" class="btn btn-warning fw-bold px-4">LƯU THÔNG TIN</button>
                    <a href="?view=taikhoan" class="btn btn-outline-secondary px-4">HỦY</a>
                </div>
            </form>
        </div>
    </div>
    
</div>