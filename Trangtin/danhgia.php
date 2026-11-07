<?php
session_start();
include '../Includes/header.php';
/** @var mysqli $conn */

if(!isset($_SESSION['id_nguoidung'])) {
    echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='dangnhap.php';</script>";
    exit();
}

$id_nd = $_SESSION['id_nguoidung'];
$id_dh = isset($_GET['id_dh']) ? $_GET['id_dh'] : 0;

$sql_check_dh = "SELECT * FROM tbl_donhang WHERE id_donhang = $id_dh AND id_nguoidung = $id_nd AND trang_thai = 2";
$res_dh = mysqli_query($conn, $sql_check_dh);

if(mysqli_num_rows($res_dh) == 0) {
    echo "<div class='container my-5 text-center text-white'><h4>Không tìm thấy đơn hàng hoặc đơn hàng chưa hoàn thành!</h4></div>";
    include '../Includes/footer.php';
    exit();
}

$sql_ct = "SELECT ct.*, sp.ten_sp, sp.hinh_anh 
           FROM tbl_chitietdonhang ct 
           JOIN tbl_sanpham sp ON ct.id_sanpham = sp.id_sanpham 
           WHERE ct.id_donhang = $id_dh";
$res_ct = mysqli_query($conn, $sql_ct);
?>

<div class="container my-5" style="min-height: 60vh;">
    <h3 class="text-white fw-bold mb-4 border-bottom border-secondary pb-2">
        <i class="fas fa-star text-warning me-2"></i> ĐÁNH GIÁ SẢN PHẨM (ĐƠN #<?php echo $id_dh; ?>)
    </h3>

    <div class="row">
        <?php while($item = mysqli_fetch_assoc($res_ct)): 
            $id_sp = $item['id_sanpham'];
            
            $sql_dg = "SELECT * FROM tbl_danhgia WHERE id_sanpham = $id_sp AND id_nguoidung = $id_nd";
            $res_dg = mysqli_query($conn, $sql_dg);
            $da_danh_gia = mysqli_num_rows($res_dg) > 0;
        ?>
        <div class="col-md-6 mb-4">
            <div class="card bg-dark border-secondary text-white shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3 border-bottom border-secondary pb-3">
                        <img src="../Images/<?php echo $item['hinh_anh']; ?>" class="rounded border border-secondary me-3" style="width: 80px; height: 80px; object-fit: cover;">
                        <div>
                            <h6 class="fw-bold mb-1"><?php echo $item['ten_sp']; ?></h6>
                            <span class="badge border border-secondary text-secondary">Size: <?php echo $item['size_mua']; ?></span>
                        </div>
                    </div>

                    <?php if($da_danh_gia): ?>
                        <div class="alert alert-success bg-transparent border-success text-success text-center py-2 m-0 small fw-bold">
                            <i class="fas fa-check-circle me-1"></i> Bạn đã đánh giá sản phẩm này!
                        </div>
                    <?php else: ?>
                        <form action="danhgia_xuly.php" method="POST">
                            <input type="hidden" name="id_dh" value="<?php echo $id_dh; ?>">
                            <input type="hidden" name="id_sp" value="<?php echo $id_sp; ?>">
                            
                            <div class="mb-3">
                                <label class="small text-secondary fw-bold mb-2">Chất lượng sản phẩm:</label>
                                <select name="so_sao" class="form-select bg-dark text-warning border-secondary fw-bold">
                                    <option value="5">⭐⭐⭐⭐⭐ Tuyệt vời</option>
                                    <option value="4">⭐⭐⭐⭐ Tốt</option>
                                    <option value="3">⭐⭐⭐ Bình thường</option>
                                    <option value="2">⭐⭐ Tệ</option>
                                    <option value="1">⭐ Rất tệ</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <textarea name="noi_dung" class="form-control bg-dark text-white border-secondary" rows="3" placeholder="Hãy chia sẻ cảm nhận của bạn về đôi giày này nhé..." required></textarea>
                            </div>
                            
                            <button type="submit" name="btnGuiDanhGia" class="btn btn-warning w-100 fw-bold">
                                GỬI ĐÁNH GIÁ
                            </button>
                        </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include '../Includes/footer.php'; ?>