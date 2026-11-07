<?php
session_start();
include '../Includes/header.php';
?>

<div class="container-fluid login-section" style="background: #121212; min-height: 85vh; padding-top: 50px; padding-bottom: 50px;">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card bg-dark border-secondary text-white shadow-lg p-4" style="width: 500px; border-radius: 15px;">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2 class="fw-bold" style="color:#ff6600; font-style:italic;">ADU<span style="color:white; font-weight:normal;">DU</span></h2>
                    <p class="text-secondary small">Tạo tài khoản mới để trải nghiệm mua sắm tốt hơn!</p>
                </div>

                <form action="dangky_xuly.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Họ và tên</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-secondary text-secondary"><i class="fas fa-id-badge"></i></span>
                            <input type="text" name="txtHoTen" class="form-control bg-dark text-white border-secondary" placeholder="Nhập họ và tên..." required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Tên đăng nhập</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-secondary text-secondary"><i class="fas fa-user"></i></span>
                            <input type="text" name="txtUser" class="form-control bg-dark text-white border-secondary" placeholder="Nhập tên đăng nhập..." required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-secondary text-secondary"><i class="fas fa-lock"></i></span>
                            <input type="password" name="txtPass" class="form-control bg-dark text-white border-secondary" placeholder="Nhập mật khẩu..." required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-secondary text-secondary"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="txtEmail" class="form-control bg-dark text-white border-secondary" placeholder="Nhập email..." required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Số điện thoại</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-secondary text-secondary"><i class="fas fa-phone"></i></span>
                            <input type="text" name="txtSDT" class="form-control bg-dark text-white border-secondary" placeholder="Nhập số điện thoại..." required>
                        </div>
                    </div>

                    <button type="submit" name="btnDangKy" class="btn btn-warning w-100 fw-bold py-2 mb-3 text-uppercase">
                        Đăng ký tài khoản
                    </button>

                    <div class="text-center">
                        <p class="mb-0 small text-secondary">
                            Đã có tài khoản? <a href="dangnhap.php" class="text-info text-decoration-none fw-bold">Đăng nhập tại đây</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../Includes/footer.php'; ?>