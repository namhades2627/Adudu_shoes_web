<?php
session_start();
include '../Includes/connect_db.php';
/** @var mysqli $conn */

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM tbl_sanpham WHERE id_sanpham = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if(!$row) {
    header("Location: sanpham.php");
    exit();
}
$gia_goc = $row['gia_ban'];
$giam_gia = (isset($row['giam_gia'])) ? (int)$row['giam_gia'] : 0; 
$gia_hien_tai = ($giam_gia > 0) ? $gia_goc * (1 - $giam_gia / 100) : $gia_goc;
$available_sizes = array_values(array_unique(array_filter(array_map('trim', explode(',', (string)$row['size_giay'])), function ($size) {
    return $size !== '' && ctype_digit($size);
})));
$so_luong_ton = max(0, (int)$row['so_luong_ton']);
$so_luong_trong_gio = 0;
foreach (($_SESSION['cart'] ?? []) as $cart_item) {
    if (is_array($cart_item) && (int)($cart_item['id'] ?? 0) === (int)$row['id_sanpham']) {
        $so_luong_trong_gio += max(0, (int)($cart_item['sl'] ?? 0));
    }
}
$so_luong_co_the_them = max(0, $so_luong_ton - $so_luong_trong_gio);
$co_the_them_gio = $so_luong_co_the_them > 0 && !empty($available_sizes);
include '../Includes/header.php'; 
?>

<div class="container mt-5 mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="sanpham.php" class="text-secondary text-decoration-none">Sản phẩm</a></li>
            <li class="breadcrumb-item active text-warning" aria-current="page"><?php echo $row['ten_sp']; ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-md-5">
            <div class="product-detail-img shadow-lg" style="border: 1px solid #333; border-radius: 15px; overflow: hidden; background: #fff;">
                <img src="../Images/<?php echo trim($row['hinh_anh']); ?>" 
                     class="img-fluid w-100" 
                     alt="<?php echo $row['ten_sp']; ?>"
                     style="transition: transform 0.5s ease;">
            </div>
        </div>

        <div class="col-md-7 text-white">
            <h1 class="fw-bold mb-2" style="color: #ff6600; font-size: 2.5rem;"><?php echo $row['ten_sp']; ?></h1>
            <div class="mb-3">
                <span class="badge bg-secondary me-2">Mã SP: #ADU<?php echo $row['id_sanpham']; ?></span>
                <?php if ($so_luong_ton > 0): ?>
                    <span class="text-success"><i class="fas fa-check-circle me-1"></i> Còn <?php echo $so_luong_ton; ?> sản phẩm</span>
                <?php else: ?>
                    <span class="text-danger"><i class="fas fa-times-circle me-1"></i> Hết hàng</span>
                <?php endif; ?>
            </div>

            <div class="price-section p-3 mb-4" style="background: #1f1f23; border-radius: 10px;">
                <span class="display-6 fw-bold text-danger me-3">
                    <?php echo number_format($gia_hien_tai, 0, ',', '.'); ?>₫
                </span>

                <?php if($giam_gia > 0): ?>
                    <span class="text-secondary text-decoration-line-through fs-5">
                        <?php echo number_format($gia_goc, 0, ',', '.'); ?>₫
                    </span>
                    <span class="badge bg-orange ms-2" style="background: #ff6600;">
                        -<?php echo $giam_gia; ?>%
                    </span>
                <?php endif; ?>
            </div>

            <div class="size-selection mb-4">
                <h6 class="text-uppercase fw-bold mb-3">CHỌN SIZE:</h6>
                <div class="d-flex flex-wrap gap-2" id="sizeContainer">
                    <?php foreach ($available_sizes as $shoe_size): ?>
                        <input type="radio" class="btn-check" name="size" id="size<?php echo $shoe_size; ?>" value="<?php echo $shoe_size; ?>" <?php echo $co_the_them_gio ? '' : 'disabled'; ?>>
                        <label class="btn btn-outline-warning" for="size<?php echo $shoe_size; ?>" style="width: 45px;"><?php echo $shoe_size; ?></label>
                    <?php endforeach; ?>
                    <?php if (empty($available_sizes)): ?>
                        <span class="text-secondary small">Sản phẩm chưa có size khả dụng.</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="quantity-selection mb-4">
                <h6 class="text-uppercase fw-bold mb-2">SỐ LƯỢNG:</h6>
                <div class="input-group" style="width: 130px;">
                    <button class="btn btn-outline-secondary" type="button" onclick="changeQty(-1)" <?php echo $co_the_them_gio ? '' : 'disabled'; ?>>-</button>
                    <input type="text" id="cart_qty" class="form-control text-center bg-dark text-white border-secondary" value="1" data-max="<?php echo $so_luong_co_the_them; ?>" readonly <?php echo $co_the_them_gio ? '' : 'disabled'; ?>>
                    <button class="btn btn-outline-secondary" type="button" onclick="changeQty(1)" <?php echo $co_the_them_gio ? '' : 'disabled'; ?>>+</button>
                </div>
            </div>

            <div class="row g-3 mb-5">
                <div class="col-6">
                    <?php if(isset($_SESSION['id_nguoidung'])): ?>
                        <button class="btn btn-outline-warning btn-lg w-100 py-3 fw-bold" onclick="addToCart(<?php echo $row['id_sanpham']; ?>)" <?php echo $co_the_them_gio ? '' : 'disabled'; ?>>
                            <i class="fas fa-cart-plus me-2"></i> THÊM GIỎ HÀNG
                        </button>
                    <?php else: ?>
                        <button class="btn btn-outline-warning btn-lg w-100 py-3 fw-bold" onclick="alert('Vui lòng đăng nhập tài khoản để thêm sản phẩm vào giỏ hàng!'); window.location.href='dangnhap.php';">
                            <i class="fas fa-cart-plus me-2"></i> THÊM GIỎ HÀNG
                        </button>
                    <?php endif; ?>
                </div>
                <div class="col-6">
                    <?php if(isset($_SESSION['id_nguoidung'])): ?>
                        <button class="btn btn-warning btn-lg w-100 py-3 fw-bold text-dark" style="background: #ff6600; border:none;" onclick="buyNow(<?php echo $row['id_sanpham']; ?>)" <?php echo $co_the_them_gio ? '' : 'disabled'; ?>>
                            MUA NGAY
                        </button>
                    <?php else: ?>
                        <button class="btn btn-warning btn-lg w-100 py-3 fw-bold text-dark" style="background: #ff6600; border:none;" onclick="alert('Vui lòng đăng nhập tài khoản trước khi đặt hàng!'); window.location.href='dangnhap.php';">
                            MUA NGAY
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="product-policy border-top border-secondary pt-4">
                <div class="row text-center g-3">
                    <div class="col-4">
                        <i class="fas fa-truck mb-2 fs-4 text-warning"></i>
                        <p class="small mb-0">Giao hàng 24h</p>
                    </div>
                    <div class="col-4">
                        <i class="fas fa-sync mb-2 fs-4 text-warning"></i>
                        <p class="small mb-0">Đổi trả 7 ngày</p>
                    </div>
                    <div class="col-4">
                        <i class="fas fa-shield-alt mb-2 fs-4 text-warning"></i>
                        <p class="small mb-0">Bảo hành 6 tháng</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 text-white">
            <ul class="nav nav-tabs border-secondary mb-4" id="myTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active bg-transparent text-warning border-0 border-bottom border-warning border-3 fw-bold text-uppercase pb-2" type="button">Mô tả sản phẩm</button>
                </li>
            </ul>
            
            <div class="p-4" style="background: #1f1f23; border-radius: 10px; line-height: 1.8; color: #ccc;">
                <?php echo nl2br($row['mo_ta']); ?>
            </div>

            <div class="mt-5 pt-4 border-top border-secondary">
                <h5 class="text-warning fw-bold pb-3 mb-4"><i class="fas fa-comments me-2"></i> ĐÁNH GIÁ TỪ KHÁCH HÀNG</h5>
                
                <?php
                $sql_list_dg = "SELECT dg.*, nd.ho_ten FROM tbl_danhgia dg 
                                JOIN tbl_nguoidung nd ON dg.id_nguoidung = nd.id_nguoidung 
                                WHERE dg.id_sanpham = $id ORDER BY dg.id_danhgia DESC";
                $res_list_dg = mysqli_query($conn, $sql_list_dg);

                if($res_list_dg && mysqli_num_rows($res_list_dg) > 0):
                    while($row_dg = mysqli_fetch_assoc($res_list_dg)):
                ?>
                    <div class="card bg-dark border-secondary mb-3 text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold text-info mb-0"><i class="fas fa-user-circle me-2"></i><?php echo $row_dg['ho_ten']; ?></h6>
                                <small class="text-secondary"><i class="far fa-clock me-1"></i><?php echo date('d/m/Y H:i', strtotime($row_dg['ngay_danh_gia'])); ?></small>
                            </div>
                            <div class="text-warning mb-3" style="font-size: 13px;">
                                <?php 
                                for($i=1; $i<=5; $i++) {
                                    if($i <= $row_dg['so_sao']) echo '<i class="fas fa-star"></i>';
                                    else echo '<i class="far fa-star text-secondary"></i>';
                                }
                                ?>
                            </div>
                            <p class="mb-0 text-light" style="font-size: 14.5px;"><?php echo nl2br($row_dg['noi_dung']); ?></p>
                        </div>
                    </div>
                <?php 
                    endwhile;
                else: 
                ?>
                    <div class="p-4 bg-dark border border-secondary rounded text-center">
                        <p class="text-secondary fst-italic mb-0">Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên đánh giá sau khi mua hàng nhé!</p>
                    </div>
                <?php endif; ?>
            </div>
            </div>
    </div>
</div>

<?php include '../Includes/footer.php'; ?>