<?php 
    require_once __DIR__ . '/auth_guard.php';
    include_once '../Includes/connect_db.php';
    include '../Includes/header.php'; 

    $count_sp = 48; 
    $count_tt = 16; 
    ?>
    <script src="../scripts/ckeditor/ckeditor.js"></script>

    <div class="container-fluid" style="background: #121212; min-height: 80vh;">
        <div class="row">
            <div class="col-md-2 p-0 border-end border-secondary" style="background: #1f1f23;">
                <div class="list-group list-group-flush admin-sidebar">
                    <a href="?view=taikhoan" class="list-group-item list-group-item-action bg-transparent text-white border-secondary py-3">
                        <i class="fas fa-users me-2"></i> Tài khoản
                    </a>
                    <a href="?view=sanpham" class="list-group-item list-group-item-action bg-transparent text-white border-secondary py-3">
                        <i class="fas fa-shoe-prints me-2"></i> Sản phẩm (48)
                    </a>
                    <a href="?view=donhang" class="list-group-item list-group-item-action bg-transparent text-white border-secondary py-3">
                        <i class="fas fa-shopping-cart me-2"></i> Đơn hàng
                    </a>
                    <a href="?view=baiviet" class="list-group-item list-group-item-action bg-transparent text-white border-secondary py-3">
                        <i class="fas fa-newspaper me-2"></i> Bài viết (8)
                    </a>
                    <a href="?view=doanhthu" class="list-group-item list-group-item-action bg-transparent text-white border-secondary py-3">
                        <i class="fas fa-chart-line me-2"></i> Doanh thu
                    </a>
                    
                    <a href="?view=nhanvien" class="list-group-item list-group-item-action bg-transparent text-white border-secondary py-3">
                        <i class="fas fa-user-tie me-2 text-success"></i> Quản lý Nhân viên
                    </a>

                    <a href="?view=danhgia" class="list-group-item list-group-item-action bg-transparent text-white border-secondary py-3">
                        <i class="fas fa-star me-2 text-warning"></i> Quản lý Đánh giá
                    </a>
                    <a href="?view=baocao" class="list-group-item list-group-item-action bg-transparent text-white border-secondary py-3">
                        <i class="fas fa-flag me-2 text-danger"></i> Quản lý Báo cáo
                    </a>
                    <a href="?view=hotro" class="list-group-item list-group-item-action bg-transparent text-white border-secondary py-3">
                        <i class="fas fa-headset me-2 text-info"></i> CSKH (Live Chat)
                    </a>
                </div>
            </div>

            <div class="col-md-10 p-4 text-white">
                <?php 
                $view = isset($_GET['view']) ? $_GET['view'] : 'dashboard';
                $action = isset($_GET['action']) ? $_GET['action'] : 'danhsach';
                switch($view) {
                    case 'taikhoan': 
                        if($action == 'them') {
                            include "taikhoan_them.php"; 
                        } elseif($action == 'sua') {
                            include "taikhoan_sua.php"; 
                        } elseif($action == 'xoa') {
                            include "taikhoan_xoa.php"; 
                        } elseif($action == 'chitiet') {
                            include "taikhoan_chitiet.php";
                        } else {
                            include "taikhoan_danhsach.php"; 
                        }
                        break;
                    case 'sanpham':
                            if($action == 'them') {
                                include "sanpham_them.php"; 
                            } elseif($action == 'sua') {
                                include "sanpham_sua.php"; 
                            } elseif($action == 'xoa') {
                                include "sanpham_xoa.php"; 
                            } elseif($action == 'chitiet') {
                                include "sanpham_chitiet.php";
                            } else {
                                include "sanpham_danhsach.php"; 
                            }
                            break;
                    case 'donhang':
                            if($action == 'them') {
                                include "donhang_them.php"; 
                            } elseif($action == 'sua') {
                                include "donhang_sua.php"; 
                            } elseif($action == 'xoa') {
                                include "donhang_xoa.php"; 
                            } elseif($action == 'chitiet') {
                                include "donhang_chitiet.php";
                            } else {
                                include "donhang_danhsach.php"; 
                            }
                            break;
                    case 'baiviet':
                            if($action == 'them') {
                                include "baiviet_them.php"; 
                            } elseif($action == 'sua') {
                                include "baiviet_sua.php"; 
                            } elseif($action == 'xoa') {
                                include "baiviet_xoa.php"; 
                            } elseif($action == 'chitiet') {
                                include "baiviet_chitiet.php";
                            } else {
                                include "baiviet_danhsach.php"; 
                            }
                            break;
                    case 'doanhthu':
                            include "doanhthu.php"; 
                            break;
                    
                   case 'nhanvien':
                            if($action == 'them') {
                                include "nhanvien_them.php"; 
                            } elseif($action == 'sua') {
                                include "nhanvien_sua.php"; 
                            } elseif($action == 'xoa') {
                                include "nhanvien_xoa.php"; 
                            } else {
                                include "nhanvien_danhsach.php"; 
                            }
                            break;

                    case 'danhgia':
                            include "danhgia_danhsach.php";
                            break;
                    case 'baocao':
                            include "baocao_danhsach.php";
                            break;
                    case 'hotro':
                            include "hotro_danhsach.php";
                            break;
                    default:
                        echo "<h3>Chào mừng Quản trị viên trở lại!</h3>";       
                        break;
                }
                ?>
            </div>
        </div>
    </div>

    <?php include '../Includes/footer.php';?>