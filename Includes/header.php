<?php
$current_page = basename($_SERVER['PHP_SELF']);
$is_admin_path = (strpos($_SERVER['PHP_SELF'], '/Admin/') !== false);

$base_url = '/Nhom10_TongNhutNam_TonAnhQuan_DH24TH2';

include_once __DIR__ . '/connect_db.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <script src="<?php echo $base_url; ?>/Scripts/main.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADUDU - <?php echo $is_admin_path ? 'Hệ thống Quản trị' : 'Cửa hàng về giày'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/CSS/style.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="top-bar">
        <div class="container d-flex justify-content-between align-items-center">
            <div>Chào mừng bạn đến với Adudu Shop!</div>
            <div>
                <span class="me-4"><i class="fas fa-envelope"></i> Nhom10@gmail.com</span>
                <span class="me-4"><i class="fas fa-clock"></i> Thứ 2 - Thứ 7 : 8h-21h30</span>
                <span><i class="fas fa-phone"></i> 0905 009 009</span>
            </div>
        </div>
    </div>

    <header class="main-header">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="logo">
                <a href="<?php echo $is_admin_path ? '../Trangtin/index.php' : 'index.php'; ?>">
                    <h2 style="color:#ff6600; margin:0; font-weight:900; font-style:italic;">ADU<span style="color:white; font-weight:normal;">DU</span></h2>
                </a>
            </div>
            <form action="<?php echo $base_url; ?>/Trangtin/sanpham.php" method="GET" class="search-bar input-group w-50">
                <input type="text" name="txtSearch" class="form-control" placeholder="Bạn đang tìm gì" 
                    value="<?php echo $_GET['txtSearch'] ?? ''; ?>">
                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            </form>
            <div class="icons text-white fs-5 d-flex align-items-center">
                
                <div class="user-dropdown me-4">
                    <a href="#" class="text-white"><i class="far fa-user"></i></a>
                    <ul class="user-menu-custom">
                        <?php $path_fix = $is_admin_path ? '../Trangtin/' : ''; ?>
                        <?php if(!isset($_SESSION['id_nguoidung'])): ?>
                            <li><a href="<?php echo $path_fix; ?>dangnhap.php">Đăng nhập</a></li>
                            <li><a href="<?php echo $path_fix; ?>dangky.php">Đăng ký</a></li>
                        <?php else: ?>
                            <li class="px-3 py-1 small text-warning fw-bold border-bottom border-secondary mb-1">
                                Chào, <?php echo $_SESSION['ho_ten']; ?>
                            </li>
                            <li><a href="<?php echo $path_fix; ?>donhang_cuatoi.php">Đơn hàng của tôi</a></li>
                            <li><a href="<?php echo $path_fix; ?>dangxuat.php" class="text-danger">Đăng xuất</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="user-dropdown me-4 position-relative">
                    <a href="#" class="text-white"><i class="fas fa-bell"></i>
                        <?php
                        $id_nd_tb = isset($_SESSION['id_nguoidung']) ? $_SESSION['id_nguoidung'] : 0;
                        if($id_nd_tb > 0 && isset($conn) && $conn) {
                            $sql_dem = "SELECT COUNT(*) as chua_doc FROM tbl_thongbao WHERE id_nguoidung = $id_nd_tb AND trang_thai = 0";
                            $res_dem = mysqli_query($conn, $sql_dem);
                            if($res_dem) {
                                $row_dem = mysqli_fetch_assoc($res_dem);
                                if($row_dem['chua_doc'] > 0) {
                                    echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.55rem; padding: 0.25em 0.5em;">'.$row_dem['chua_doc'].'</span>';
                                }
                            }
                        }
                        ?>
                    </a>
                    
                    <ul class="user-menu-custom shadow-lg" style="width: 320px; right: -50px; padding: 15px; max-height: 400px; overflow-y: auto;">
                        <li class="border-bottom pb-2 mb-2 fw-bold text-uppercase" style="font-size: 14px; color: #ff8c00;">Thông báo mới</li>
                        <?php
                        if($id_nd_tb == 0) {
                            echo '<li class="text-white small text-center py-3">Vui lòng đăng nhập để xem thông báo.</li>';
                        } elseif(isset($conn) && $conn) {
                            $sql_tb = "SELECT * FROM tbl_thongbao WHERE id_nguoidung = $id_nd_tb ORDER BY id_thongbao DESC LIMIT 5";
                            $res_tb = mysqli_query($conn, $sql_tb);
                            if($res_tb && mysqli_num_rows($res_tb) > 0) {
                                while($tb = mysqli_fetch_assoc($res_tb)) {
                                    $bg_color = ($tb['trang_thai'] == 0) ? 'background: #333;' : 'background: transparent;';
                                    $text_color = ($tb['trang_thai'] == 0) ? 'text-white' : 'text-secondary';
                                    
                                    echo '<li class="mb-2 p-2 rounded" style="'.$bg_color.'">';
                                    echo '<a href="'.$path_fix.'thongbao_xuly.php?id='.$tb['id_thongbao'].'&link='.$tb['link'].'" class="'.$text_color.' small" style="display: block; line-height: 1.5; white-space: normal;">'.$tb['noi_dung'].'</a>';
                                    echo '<div class="text-muted mt-1" style="font-size: 0.7rem;">'.date('d/m/Y H:i', strtotime($tb['ngay_tao'])).'</div>';
                                    echo '</li>';
                                }
                            } else {
                                echo '<li class="text-muted small text-center py-3">Bạn chưa có thông báo nào.</li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="cart-overlay" id="cartOverlay" onclick="toggleMiniCart()"></div>                     
                <div class="cart-dropdown-wrapper">
                    <a href="javascript:void(0)" class="cart-icon-link" onclick="toggleMiniCart()">
                        <i class="fas fa-shopping-bag"></i>
                        <span id="cart-count" class="badge rounded-pill bg-danger">
                            <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                        </span>
                    </a>

                    <div class="mini-cart-content" id="miniCart">
                        <div class="p-3 d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="m-0 fw-bold">Giỏ hàng</h5>
                            <a href="javascript:void(0)" class="text-dark fs-4" onclick="toggleMiniCart()">&times;</a>
                        </div>

                        <div class="p-3 flex-grow-1" id="cart-items-list" style="overflow-y: auto;">
                            <p class="text-center text-muted my-4 small">Chưa có sản phẩm nào</p>
                        </div>

                        <div class="p-3 border-top bg-light">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold">Tạm tính:</span>
                                <span class="fw-bold fs-5" id="cart-total">0₫</span>
                            </div>
                            <a href="thanhtoan.php" class="btn btn-dark w-100 py-3 fw-bold mb-2 text-uppercase text-decoration-none" 
                                style="background: #112d4e; color: white;">
                                Thanh toán
                            </a>
                            <div class="text-center mt-3 small fw-bold text-danger">HOTLINE: 0905 009 009</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <nav class="main-nav">
        <div class="container d-flex align-items-center">
            <div class="category-dropdown">
                <button class="btn-category"><i class="fas fa-bars me-2"></i> DANH MỤC SẢN PHẨM</button>
                <ul class="dropdown-menu-custom">
                    <?php $path_to_client = $is_admin_path ? '../Trangtin/' : ''; ?>
                    <li><a href="<?php echo $path_to_client; ?>sanpham.php?id_loaigiay=1">Giày Sneaker</a></li>
                    <li><a href="<?php echo $path_to_client; ?>sanpham.php?id_loaigiay=2">Giày Thể Thao</a></li>
                    <li><a href="<?php echo $path_to_client; ?>sanpham.php?id_loaigiay=3">Giày Sandal</a></li>
                    <li><a href="<?php echo $path_to_client; ?>sanpham.php?id_loaigiay=4">Giày Tây</a></li>
                    <li><a href="<?php echo $path_to_client; ?>sanpham.php?id_loaigiay=5">Giày Da</a></li>
                    <li><a href="<?php echo $path_to_client; ?>sanpham.php?id_loaigiay=6">Giày Cổ Cao</a></li>
                </ul>
            </div>                  
            <div class="nav-links ms-3 d-flex align-items-center">
                <a href="<?php echo $path_to_client; ?>index.php" class="<?php echo ($current_page == 'index.php' && !$is_admin_path) ? 'active' : ''; ?>">Trang chủ</a>
                <a href="<?php echo $path_to_client; ?>tintuc.php" class="<?php echo ($current_page == 'tintuc.php') ? 'active' : ''; ?>">Tin tức</a>
                <a href="<?php echo $path_to_client; ?>sanpham.php" class="<?php echo ($current_page == 'sanpham.php') ? 'active' : ''; ?>">Sản phẩm</a>
                <a href="<?php echo $path_to_client; ?>hotro.php" class="<?php echo ($current_page == 'hotro.php') ? 'active' : ''; ?>">Hỗ trợ</a>
                
                <?php if(isset($_SESSION['quyen']) && $_SESSION['quyen'] == 1): ?>
                    <a href="<?php echo $is_admin_path ? 'index.php' : '../Admin/index.php'; ?>" 
                    class="nav-link-admin <?php echo ($is_admin_path) ? 'active' : ''; ?>">
                        QUẢN LÝ
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>