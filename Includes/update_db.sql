
USE `WebKinhDoanhGiay`;

UPDATE tbl_sanpham SET so_luong_ton = FLOOR(7 + (RAND() * 9));

CREATE TABLE `tbl_thongbao` (
  `id_thongbao` int(11) NOT NULL AUTO_INCREMENT,
  `id_nguoidung` int(11) NOT NULL,
  `noi_dung` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `trang_thai` int(1) DEFAULT 0, -- 0: Chưa đọc, 1: Đã đọc
  `ngay_tao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_thongbao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng chứa đánh giá sản phẩm
CREATE TABLE `tbl_danhgia` (
  `id_danhgia` int(11) NOT NULL AUTO_INCREMENT,
  `id_sanpham` int(11) NOT NULL,
  `id_nguoidung` int(11) NOT NULL,
  `so_sao` int(1) NOT NULL DEFAULT 5,
  `noi_dung` text NOT NULL,
  `ngay_danh_gia` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_danhgia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_UNICODE_CI;

CREATE TABLE `tbl_binhluan_tintuc` (
  `id_binhluan` int(11) NOT NULL AUTO_INCREMENT,
  `id_tintuc` int(11) NOT NULL,
  `id_nguoidung` int(11) NOT NULL,
  `noi_dung` text NOT NULL,
  `ngay_binhluan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_binhluan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_UNICODE_CI;

CREATE TABLE `tbl_baocao_binhluan` (
  `id_baocao` int(11) NOT NULL AUTO_INCREMENT,
  `id_binhluan` int(11) NOT NULL,
  `id_nguoidung` int(11) NOT NULL, 
  `ly_do` varchar(255) NOT NULL,
  `ngay_baocao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trang_thai` int(1) DEFAULT 0, -- 0: Chờ xử lý, 1: Đã xử lý xong
  PRIMARY KEY (`id_baocao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_UNICODE_CI;

CREATE TABLE `tbl_hotro` (
  `id_tinnhan` int(11) NOT NULL AUTO_INCREMENT,
  `id_nguoidung` int(11) NOT NULL, 
  `nguoi_gui` int(1) NOT NULL DEFAULT 0, -- 0: Khách gửi, 1: Admin gửi
  `noi_dung` text NOT NULL,
  `ngay_gui` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tinnhan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_UNICODE_CI;

DROP TABLE IF EXISTS `tbl_nhanvien`;

CREATE TABLE `tbl_nhanvien` (
  `id_nhanvien` int(11) NOT NULL AUTO_INCREMENT,
  `ma_nv` varchar(20) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `so_dien_thoai` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `chuc_vu` varchar(50) NOT NULL,
  `ngay_vao_lam` date NOT NULL,
  PRIMARY KEY (`id_nhanvien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_UNICODE_CI;

ALTER TABLE `tbl_nhanvien` ADD COLUMN `luong_co_ban` INT(11) NOT NULL DEFAULT 0 AFTER `chuc_vu`;

-- Thêm dữ liệu mẫu
INSERT INTO `tbl_nhanvien` (`ma_nv`, `ho_ten`, `so_dien_thoai`, `email`, `chuc_vu`, `luong_co_ban`, `ngay_vao_lam`) VALUES
('NV001', 'Trần Văn Sếp', '0901234567', 'sep.tran@adudu.com', 'Quản lý cửa hàng', 18000000, '2025-01-15'),
('NV002', 'Nguyễn Thị Bán', '0902345678', 'ban.nguyen@adudu.com', 'Nhân viên Bán hàng', 10000000, '2025-02-10'),
('NV003', 'Lê Văn Tiền', '0903456789', 'tien.le@adudu.com', 'Thu ngân', 10500000, '2025-02-20'),
('NV004', 'Phạm Thị Kho', '0904567890', 'kho.pham@adudu.com', 'Nhân viên Kho', 11000000, '2025-03-01');