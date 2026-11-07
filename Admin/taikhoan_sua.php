<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
$id = $_GET['id'];
$sql = "SELECT * FROM tbl_nguoidung WHERE id_nguoidung = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<div class="mb-4">
    <h3 class="text-white fw-bold">SỬA TÀI KHOẢN</h3>
</div>

<div class="card bg-dark border-secondary shadow" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="taikhoan_sua_xuly.php" method="POST">
            <input type="hidden" name="id_nguoidung" value="<?php echo $row['id_nguoidung']; ?>">
            
            <div class="mb-3 text-white">
                <label class="form-label small fw-bold">HỌ TÊN</label>
                <input type="text" name="ho_ten" class="form-control bg-dark text-white border-secondary" value="<?php echo $row['ho_ten']; ?>" required>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label small fw-bold">EMAIL</label>
                <input type="email" name="email" class="form-control bg-dark text-white border-secondary" value="<?php echo $row['email']; ?>">
            </div>

            <div class="mb-3 text-white">
                <label class="form-label small fw-bold">MẬT KHẨU MỚI (Để trống nếu không đổi)</label>
                <input type="password" name="mat_khau_moi" class="form-control bg-dark text-white border-secondary">
            </div>

            <div class="mb-4 text-white">
                <label class="form-label small fw-bold">PHÂN QUYỀN</label>
                <select name="quyen" class="form-select bg-dark text-white border-secondary">
                    <option value="0" <?php if($row['quyen'] == 0) echo 'selected'; ?>>Khách hàng</option>
                    <option value="1" <?php if($row['quyen'] == 1) echo 'selected'; ?>>Quản trị viên</option>
                </select>
            </div>

            <button type="submit" name="btnSua" class="btn btn-warning fw-bold px-4">CẬP NHẬT</button>
            <a href="?view=taikhoan" class="btn btn-outline-secondary px-4 ms-2">HỦY</a>
        </form>
    </div>
</div>