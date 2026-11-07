<?php 
include '../Includes/connect_db.php';
/** @var mysqli $conn */

$trang = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$so_tin_tren_trang = 8; 
$offset = ($trang - 1) * $so_tin_tren_trang;

$sql = "SELECT * FROM tbl_tintuc ORDER BY ngay_dang DESC LIMIT $so_tin_tren_trang OFFSET $offset";
$result = mysqli_query($conn, $sql);

$sql_count = "SELECT COUNT(*) as total FROM tbl_tintuc";
$count_result = mysqli_query($conn, $sql_count);
$total_row = mysqli_fetch_assoc($count_result);
$tong_so_trang = ceil($total_row['total'] / $so_tin_tren_trang);

include '../Includes/header.php'; 
?>

<div class="container mt-5 mb-5">
    <div class="section-header">
        <div class="section-title">Tin tức mới nhất</div>
        <div class="view-all text-secondary">Trang <?php echo $trang; ?> / <?php echo $tong_so_trang; ?></div>
    </div>

    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php 
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="col">
            <div class="news-card h-100">
                <div class="date-badge">
                    <span><?php echo date('d', strtotime($row['ngay_dang'])); ?></span>
                    Th<?php echo date('m', strtotime($row['ngay_dang'])); ?>
                </div>

                <div class="news-img-wrapper" style="height: 180px; overflow: hidden;">
                    <img src="../Images/<?php echo $row['hinh_anh']; ?>" alt="News" style="width: 100%; height: 100%; object-fit: cover;">
                </div>

                <div class="news-info p-3 d-flex flex-column">
                    <div class="news-tag mb-1">ADUDU BLOG</div>
                    
                    <h5 class="news-title" style="font-size: 15px; font-weight: bold; min-height: 45px;">
                        <a href="tintuc_chitiet.php?id=<?php echo $row['id_tintuc']; ?>" class="text-white text-decoration-none">
                            <?php echo $row['tieu_de']; ?>
                        </a>
                    </h5>

                    <p class="news-desc" style="font-size: 13px; color: #aaa; flex-grow: 1;">
                        <?php echo $row['tom_tat']; ?>
                    </p>

                    <div class="text-center mt-3 pt-3 border-top border-secondary">
                        <a href="tintuc_chitiet.php?id=<?php echo $row['id_tintuc']; ?>" class="btn-order">Đọc tiếp</a>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            }
        } else {
            echo "<div class='col-12 text-center py-5'>Chưa có tin tức nào được đăng.</div>";
        }
        ?>
    </div>

    <div class="pagination-wrapper mt-5">
        <nav>
            <ul class="pagination mb-0" style="display: flex; gap: 10px; list-style: none; padding: 0; justify-content: center;">
                <?php for($i = 1; $i <= $tong_so_trang; $i++): ?>
                    <li class="page-item">
                        <a class="page-link" href="tintuc.php?page=<?php echo $i; ?>" 
                           style="background:<?php echo ($trang == $i) ? '#ff6600' : '#222'; ?>; 
                                  color: white; 
                                  border: 1px solid <?php echo ($trang == $i) ? '#ff6600' : '#444'; ?>; 
                                  padding: 10px 18px; 
                                  border-radius: 4px; 
                                  font-weight: bold; 
                                  transition: 0.3s;
                                  text-decoration: none;">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>

<?php include '../Includes/footer.php'; ?>