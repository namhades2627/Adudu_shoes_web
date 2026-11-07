<?php
include '../Includes/connect_db.php';
/** @var mysqli $conn */

$sql = "SELECT * FROM tbl_sanpham ORDER BY id_sanpham DESC LIMIT 8";
$result = mysqli_query($conn, $sql);
include '../Includes/header.php';
?>

<div class="container mt-3 mb-4">
    <div id="mainBannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainBannerCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#mainBannerCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#mainBannerCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner" style="border-radius: 5px;">
            <div class="carousel-item active" data-bs-interval="5000">
                <img src="../Images/Banner1.jpg" class="d-block w-100" alt="Banner 1">
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="../Images/Banner2.jpg" class="d-block w-100" alt="Banner 2">
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="../Images/Banner3.jpg" class="d-block w-100" alt="Banner 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mainBannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainBannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>

<div class="container">
    <div class="section-header">
        <div class="section-title">TOP SẢN PHẨM MỚI NHẤT</div>
        <a href="sanpham.php" class="view-all">Xem thêm <i class="fas fa-chevron-right ms-1"></i></a>
    </div>
    
    <div class="row">
        <?php 
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="col-md-3 mb-4">
            <a href="sanpham_xem.php?id=<?php echo $row['id_sanpham']; ?>" class="text-decoration-none">
                <div class="product-card"> 
                    <div class="product-img-container">
                        <img src="../Images/<?php echo $row['hinh_anh']; ?>" alt="Giày">
                    </div>
                    <div class="product-info">
                        <div class="product-title text-white"><?php echo $row['ten_sp']; ?></div>
                        <div class="price-new text-danger fw-bold">
                            <?php echo number_format($row['gia_ban'], 0, ',', '.'); ?>₫
                        </div>
                        <div class="btn btn-order w-100 mt-2">ĐẶT HÀNG</div>
                    </div>
                </div>
            </a>
        </div>
        <?php 
            } 
        }
        ?>
    </div>

    <div class="section-header mt-4">
        <div class="section-title">TOP SẢN PHẨM BÁN CHẠY</div>
        <a href="sanpham.php" class="view-all">Xem thêm <i class="fas fa-chevron-right ms-1"></i></a>
    </div>
    
    <div class="row d-flex align-items-stretch">
        <div class="col-md-9">
            <div class="row">
                <?php 
                $sql_sale = "SELECT * FROM tbl_sanpham WHERE giam_gia > 0 LIMIT 6";
                $res_sale = mysqli_query($conn, $sql_sale);
                while($row_sale = mysqli_fetch_assoc($res_sale)) {
                ?>
                <div class="col-md-4 mb-3">
                    <a href="sanpham_xem.php?id=<?php echo $row_sale['id_sanpham']; ?>" class="text-decoration-none">
                        <div class="product-card h-100">
                            <div class="discount-badge">Giảm: -<?php echo $row_sale['giam_gia']; ?>%</div>
                            <img src="../Images/<?php echo $row_sale['hinh_anh']; ?>" alt="Giày Sale">
                            <div class="product-info">
                                <div class="product-title text-white"><?php echo $row_sale['ten_sp']; ?></div>
                                <div class="price-box">
                                    <span class="price-old text-secondary small text-decoration-line-through"><?php echo number_format($row_sale['gia_ban'], 0, ',', '.'); ?>đ</span><br>
                                    <span class="price-new text-danger fw-bold"><?php echo number_format($row_sale['gia_ban'] * (1 - $row_sale['giam_gia']/100), 0, ',', '.'); ?>đ</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="h-100">
                <img src="../Images/SaleBanner.jpg" class="img-fluid rounded w-100" alt="Sale Banner" style="object-fit: cover; height: 100%;">
            </div>
        </div>
    </div> 

    <div class="section-header mt-5">
        <div class="section-title">
             <i class="fas fa-newspaper me-2 text-white"></i> TIN TỨC MỚI NHẤT
        </div>
        <a href="tintuc.php" class="view-all">Xem thêm <i class="fas fa-chevron-right ms-1"></i></a>
    </div>
    
    <div class="row">
        <?php 
        $sql_news = "SELECT * FROM tbl_tintuc ORDER BY ngay_dang DESC LIMIT 4";
        $result_news = mysqli_query($conn, $sql_news);
        while($row_n = mysqli_fetch_assoc($result_news)) {
        ?>
        <div class="col-md-3">
            <a href="tintuc_chitiet.php?id=<?php echo $row_n['id_tintuc']; ?>" class="text-decoration-none">
                <div class="news-card">
                    <div class="date-badge">
                        <span><?php echo date('d', strtotime($row_n['ngay_dang'])); ?></span>
                        Th<?php echo date('m', strtotime($row_n['ngay_dang'])); ?>
                    </div>
                    <img src="../Images/<?php echo trim($row_n['hinh_anh']); ?>" alt="News">
                    <div class="news-info">
                        <div class="news-tag">TIN TỨC</div>
                        <div class="news-title text-white"><?php echo $row_n['tieu_de']; ?></div>
                        <div class="news-desc text-secondary"><?php echo $row_n['tom_tat']; ?></div>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
</div>

<?php include '../Includes/footer.php'; ?>