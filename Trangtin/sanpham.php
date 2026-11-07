<?php 
include '../Includes/connect_db.php';
/** @var mysqli $conn */

$trang = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($trang < 1) $trang = 1;

$id_loaigiay = isset($_GET['id_loaigiay']) ? (int)$_GET['id_loaigiay'] : 0;
$muc_gia = $_GET['gia'] ?? []; 
$khuyen_mai = $_GET['km'] ?? '';
$so_sp_tren_trang = 24;
$offset = ($trang - 1) * $so_sp_tren_trang;
$search = mysqli_real_escape_string($conn, $_GET['txtSearch'] ?? ''); 

$conditions = [];
if ($id_loaigiay > 0) $conditions[] = "id_loaigiay = $id_loaigiay";
if (!empty($search)) $conditions[] = "sp.ten_sp LIKE '%$search%'";
if (!empty($muc_gia)) {
    $price_queries = [];
    foreach ($muc_gia as $g) {
        if ($g == '1') $price_queries[] = "gia_ban < 500000";
        if ($g == '2') $price_queries[] = "(gia_ban >= 500000 AND gia_ban <= 1000000)";
        if ($g == '3') $price_queries[] = "(gia_ban > 1000000 AND gia_ban <= 2000000)";
        if ($g == '4') $price_queries[] = "gia_ban > 2000000";
    }
    $conditions[] = "(" . implode(" OR ", $price_queries) . ")";
}
if ($khuyen_mai == '1') $conditions[] = "giam_gia > 0";

$where = !empty($conditions) ? " WHERE " . implode(" AND ", $conditions) : "";

$sort = $_GET['sort'] ?? 'newest';


$order_by = "ORDER BY sp.id_sanpham DESC";
$join_clause = ""; 

if ($sort == 'price_asc') $order_by = "ORDER BY sp.gia_ban ASC";
if ($sort == 'price_desc') $order_by = "ORDER BY sp.gia_ban DESC";
if ($sort == 'name_az') $order_by = "ORDER BY sp.ten_sp ASC";
if ($sort == 'best_seller') {
    $join_clause = " LEFT JOIN (SELECT id_sanpham, SUM(so_luong) as tong_ban FROM tbl_chitietdonhang GROUP BY id_sanpham) as sales ON sp.id_sanpham = sales.id_sanpham ";
    $order_by = "ORDER BY sales.tong_ban DESC";
}

$total_sql = "SELECT COUNT(*) as total FROM tbl_sanpham sp $where";
$total_query = mysqli_query($conn, $total_sql);

if ($total_query) {
    $row_total = mysqli_fetch_assoc($total_query);
    $total_sp = $row_total['total'];
} else {
    $total_sp = 0;
}
$tong_so_trang = ceil($total_sp / $so_sp_tren_trang);
$sql = "SELECT sp.* FROM tbl_sanpham sp $join_clause $where $order_by LIMIT $offset, $so_sp_tren_trang";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}
include '../Includes/header.php'; 
?>

<div class="container mt-4 mb-5">
    <div class="row">
        <div class="col-md-3">
            <div class="filter-sidebar">
                <div class="filter-title"><i class="fas fa-filter me-2"></i> BỘ LỌC TÌM KIẾM</div>
                <form action="sanpham.php" method="GET" id="filterForm">
                    <input type="hidden" name="id_loaigiay" value="<?php echo $id_loaigiay; ?>">
                    
                    <div class="filter-group">
                        <div class="filter-section-title">Loại sản phẩm</div>
                        <?php 
                        $ds_loai = [1 => "Giày Sneaker", 2 => "Giày Thể Thao", 3 => "Giày Sandal", 4 => "Giày Tây", 5 => "Giày Da", 6 => "Giày Cổ Cao"];
                        foreach ($ds_loai as $id => $ten): 
                            $active = ($id_loaigiay == $id) ? "text-warning fw-bold" : "text-secondary";
                        ?>
                            <a href="sanpham.php?id_loaigiay=<?php echo $id; ?>" class="d-block mb-1 text-decoration-none <?php echo $active; ?> small">
                                <?php echo $ten; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <div class="filter-group mt-3">
                        <div class="filter-section-title">Mức giá</div>
                        <label class="d-block small"><input type="checkbox" name="gia[]" value="1" onchange="this.form.submit()" <?php echo in_array('1', $muc_gia) ? 'checked' : ''; ?>> Dưới 500k</label>
                        <label class="d-block small"><input type="checkbox" name="gia[]" value="2" onchange="this.form.submit()" <?php echo in_array('2', $muc_gia) ? 'checked' : ''; ?>> 500k - 1 Triệu</label>
                        <label class="d-block small"><input type="checkbox" name="gia[]" value="3" onchange="this.form.submit()" <?php echo in_array('3', $muc_gia) ? 'checked' : ''; ?>> 1 Triệu - 2 Triệu</label>
                        <label class="d-block small"><input type="checkbox" name="gia[]" value="4" onchange="this.form.submit()" <?php echo in_array('4', $muc_gia) ? 'checked' : ''; ?>> Trên 2 Triệu</label>
                    </div>

                    <div class="filter-group mt-3">
                        <div class="filter-section-title">Ưu đãi</div>
                        <label class="d-block small"><input type="checkbox" name="km" value="1" onchange="this.form.submit()" <?php echo ($khuyen_mai == '1') ? 'checked' : ''; ?>> Đang giảm giá</label>
                    </div>

                    <a href="sanpham.php" class="btn btn-warning w-100 fw-bold mt-3 btn-sm">XÓA BỘ LỌC</a>
                </form>
            </div>
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-end align-items-center mb-4">
        <div class="d-flex align-items-center">
            <span class="text-secondary me-2 small">Sắp xếp theo:</span>
            <select class="form-select bg-dark text-white border-secondary btn-sm" 
                    style="width: auto; cursor: pointer;"
                    onchange="location.href='sanpham.php?<?php echo http_build_query(array_merge($_GET, ['sort' => ''])); ?>' + this.value">
                <option value="newest" <?php echo ($sort == 'newest') ? 'selected' : ''; ?>>Mới nhất</option>
                <option value="best_seller" <?php echo ($sort == 'best_seller') ? 'selected' : ''; ?>>Bán chạy nhất</option>
                <option value="price_asc" <?php echo ($sort == 'price_asc') ? 'selected' : ''; ?>>Giá tăng dần</option>
                <option value="price_desc" <?php echo ($sort == 'price_desc') ? 'selected' : ''; ?>>Giá giảm dần</option>
                <option value="name_az" <?php echo ($sort == 'name_az') ? 'selected' : ''; ?>>Tên A - Z</option>
            </select>
        </div>
    </div>
            <div class="row row-cols-1 row-cols-md-4 g-3">
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <div class="col">
                            <div class="product-card-custom position-relative h-100">
                            <?php if(($row['giam_gia'] ?? 0) > 0): ?>
                                <div class="position-absolute top-0 start-0 text-white px-2 py-1 small fw-bold" 
                                    style="z-index:5; background-color: #ff6600; border-bottom-right-radius: 5px;">
                                    Giảm: -<?php echo $row['giam_gia']; ?>%
                                </div>
                                <?php endif; ?>

                                <a href="sanpham_xem.php?id=<?php echo $row['id_sanpham']; ?>">
                                    <div class="product-img-container">
                                        <img src="../Images/<?php echo $row['hinh_anh']; ?>" class="img-fluid" alt="Giày">
                                    </div>
                                </a>

                                <div class="product-info-dark p-2 text-center">
                                    <h6 class="product-title small text-white"><?php echo $row['ten_sp']; ?></h6>
                                    <div class="price-container">
                                        <?php if(($row['giam_gia'] ?? 0) > 0): 
                                            $gia_moi = $row['gia_ban'] * (1 - $row['giam_gia'] / 100); ?>
                                            <div class="text-secondary small text-decoration-line-through"><?php echo number_format($row['gia_ban'], 0, ',', '.'); ?>₫</div>
                                            <div class="text-danger fw-bold"><?php echo number_format($gia_moi, 0, ',', '.'); ?>₫</div>
                                        <?php else: ?>
                                            <div class="text-white fw-bold"><?php echo number_format($row['gia_ban'], 0, ',', '.'); ?>₫</div>
                                        <?php endif; ?>
                                    </div>
                                    <a href="sanpham_xem.php?id=<?php echo $row['id_sanpham']; ?>" class="btn btn-outline-warning btn-sm w-100 mt-2">ĐẶT HÀNG</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-search-minus mb-3 text-secondary" style="font-size: 4rem;"></i>
                        <h4 class="text-white">Không tìm thấy sản phẩm!</h4>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($tong_so_trang > 1): ?>
            <div class="pagination-wrapper mt-5 d-flex justify-content-center">
                <ul class="pagination gap-2 list-unstyled">
                    <?php for($i = 1; $i <= $tong_so_trang; $i++): 
                        $params = $_GET; $params['page'] = $i;
                        $link = "sanpham.php?" . http_build_query($params);
                    ?>
                        <li>
                            <a class="page-link rounded px-3 py-2 text-decoration-none" 
                               href="<?php echo $link; ?>"
                               style="background:<?php echo ($trang == $i) ? '#ff6600' : '#1f1f23'; ?>; color:white;">
                               <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../Includes/footer.php'; ?>