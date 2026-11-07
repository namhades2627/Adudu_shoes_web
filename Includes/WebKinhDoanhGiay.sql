
SET FOREIGN_KEY_CHECKS = 0;

-- 1. TẠO DATABASE
CREATE DATABASE IF NOT EXISTS `WebKinhDoanhGiay` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `WebKinhDoanhGiay`;

-- --------------------------------------------------------
-- 2. BẢNG LOẠI GIÀY 
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tbl_loaigiay`;
CREATE TABLE `tbl_loaigiay` (
  `id_loaigiay` int(11) NOT NULL AUTO_INCREMENT,
  `ten_loaigiay` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_loaigiay`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tbl_loaigiay` (`id_loaigiay`, `ten_loaigiay`) VALUES
('Giày Sneaker'),
('Giày Thể Thao'),
('Giày Sandal'),
('Giày Tây'),
('Giày Da'),
('Giày Cổ Cao');

-- --------------------------------------------------------
-- 3. BẢNG SẢN PHẨM 
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tbl_sanpham`;
CREATE TABLE `tbl_sanpham` (
  `id_sanpham` int(11) NOT NULL AUTO_INCREMENT,
  `ma_sp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_sp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_loaigiay` int(11) NOT NULL,
  `gia_ban` int(11) NOT NULL,
  `giam_gia` int(3) NOT NULL DEFAULT '0' COMMENT 'Phần trăm giảm giá (VD: 10)',
  `hinh_anh` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no-image.jpg',
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `size_giay` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '38,39,40,41,42',
  `so_luong_ton` int(11) NOT NULL DEFAULT '0',
  `luot_xem` int(11) NOT NULL DEFAULT '0',
  `ngay_tao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sanpham`),
  KEY `fk_sanpham_loaigiay` (`id_loaigiay`),
  CONSTRAINT `fk_sanpham_loaigiay` FOREIGN KEY (`id_loaigiay`) REFERENCES `tbl_loaigiay` (`id_loaigiay`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ========================================================
-- 1. NHÓM GIÀY SNEAKER (id_loaigiay = 1)
-- ========================================================
INSERT INTO `tbl_sanpham` (`ma_sp`, `ten_sp`, `id_loaigiay`, `gia_ban`, `giam_gia`, `hinh_anh`) VALUES
('SN01', 'Giày Balenciaga Triple S đen cam', 1, 1695000, 35, 'SN01.jpg'),
('SN02', 'Giày Balenciaga x adidas Triple S trắng', 1, 1795000, 50, 'SN02.jpg'),
('SN03', 'Giày thể thao Balenciaga Track trắng cam', 1, 1795000, 50, 'SN03.jpg'),
('SN04', 'MLB Big Ball Chunky A NY Yankees', 1, 1195000, 0, 'SN04.jpg'),
('SN05', 'Air Max 97 Ultra 17 Triple Black', 1, 1195000, 0, 'SN05.jpg'),
('SN06', 'MLB BIGBALL CHUNKY Planet NEW YORK YANKEES', 1, 1195000, 0, 'SN06.jpg'),
('SN07', 'Balenciaga Triple S Trainer Grey', 1, 1695000, 59, 'SN07.jpg'),
('SN08', 'Giày Bitis Hunter Running Màu Xanh Dương HSM011000XDG', 1, 1295000 , 0, 'SN08.jpg');

-- ========================================================
-- 2. NHÓM GIÀY THỂ THAO (id_loaigiay = 2)
-- ========================================================
INSERT INTO `tbl_sanpham` (`ma_sp`, `ten_sp`, `id_loaigiay`, `gia_ban`, `giam_gia`, `hinh_anh`) VALUES
('TT01', 'Giày Thể Thao Bitis Hunter Running Nam Màu Trắng HSM011000TRG', 2, 1295000, 0, 'TT01.jpg'),
('TT02', 'Giày Thể Thao Bitis Hunter EZ Lift Nam Màu Xanh Dương HSM012001XDG', 2, 1295000, 35, 'TT02.jpg'),
('TT03', 'Giày Thể Thao Bitis Hunter Litedash Nam Màu Đen HSM009702DEN', 2, 1295000, 0, 'TT03.jpg'),
('TT04', 'Giày Thể Thao Bitis Hunter Running Nam Màu Trắng HSM011000TRG', 2, 1175000, 0, 'TT04.jpg'),
('TT05', 'Giày Thể Thao Bitis Nam Soulmate Màu Trắng BSM004400TRG', 2, 545000, 0, 'TT05.jpg'),
('TT06', 'Giày Thể Thao Bitis Nam BSM000900', 2, 766000, 0, 'TT06.jpg'),
('TT07', 'JORDAN LUKA 4 "WHITE CEMENT"', 2, 2790000, 10, 'TT07.jpg'),
('TT08', 'Giày Thể Thao Bitis Embrace Màu Đen BSW005300DEN', 2, 475000 , 0, 'TT08.jpg');

-- ========================================================
-- 3. NHÓM GIÀY SANDAL (id_loaigiay = 3)
-- ========================================================
INSERT INTO `tbl_sanpham` (`ma_sp`, `ten_sp`, `id_loaigiay`, `gia_ban`, `giam_gia`, `hinh_anh`) VALUES
('SD01', 'Giày Sandals Nam Teva Forebay - Nâu', 3, 1799000, 0, 'SD01.jpg'),
('SD02', 'Giày Sandal Nam Teva Hudson - Xám', 3, 1699000, 0, 'SD02.jpg'),
('SD03', 'Giày Sandal Nam Teva Langdon - Nâu', 3, 1899000, 50, 'SD03.jpg'),
('SD04', 'Giày Sandal Unisex Crocs Classic Mega Crush - Be', 3, 2295000, 50, 'SD04.jpg'),
('SD05', 'Giày Xăng Đan Nam Teva Original Universal - Urban - Đen', 3, 1299000, 60, 'SD05.jpg'),
('SD06', 'Giày Sandal Nam Teva Original Alp Revive - Đen', 3, 1295000, 35, 'SD06.jpg'),
('SD07', 'Giày Sandals Nam Teva Hurricane Xlt3 Closed-Toe - Xanh Quân Đội', 3, 2799000, 0, 'SD07.jpg'),
('SD08', 'Giày Sandals Nam Teva Hurricane Xlt3 - Xanh Navy', 3, 239900, 50, 'SD08.jpg');

-- ========================================================
-- 4. NHÓM GIÀY TÂY (id_loaigiay = 4)
-- ========================================================
INSERT INTO `tbl_sanpham` (`ma_sp`, `ten_sp`, `id_loaigiay`, `gia_ban`, `giam_gia`, `hinh_anh`) VALUES
('GT01', 'Giày Tây Oxford - Classic', 4, 1550000, 35, 'GT01.jpg'),
('GT02', 'Giày Tây Derby - Elegant', 4, 1450000, 31, 'GT02.jpg'),
('GT03', 'Giày Tây Loafer - Modern', 4, 1250000, 0, 'GT03.jpg'),
('GT04', 'Giày Tây Monk Strap', 4, 1650000, 0, 'GT04.jpg'),
('GT05', 'Giày Tây Brogue', 4, 1500000, 33, 'GT05.jpg'),
('GT06', 'Giày Tây Chelsea Boots', 4, 1850000, 19, 'GT06.jpg'),
('GT07', 'Giày Tây Penny Loafer', 4, 1350000, 0, 'GT07.jpg'),
('GT08', 'Giày Tây Boot Nam Bitis BVM001788', 4, 1750000, 14, 'GT08.jpg');

-- ========================================================
-- 5. NHÓM GIÀY DA (id_loaigiay = 5)
-- ========================================================
INSERT INTO `tbl_sanpham` (`ma_sp`, `ten_sp`, `id_loaigiay`, `gia_ban`, `giam_gia`, `hinh_anh`) VALUES
('GD01', 'Giày Da Bò Sáp Tebe Đen', 5, 1250000, 15, 'GD01.jpg'),
('GD02', 'Giày Moca Da Bò Hạt Màu Nâu', 5, 950000, 0, 'GD02.jpg'),
('GD03', 'Giày Da Nam Sapo Sabo Cao Cấp', 5, 850000, 10, 'GD03.jpg'),
('GD04', 'Giày Chelsea Boot Da Lộn Camel', 5, 1450000, 20, 'GD04.jpg'),
('GD05', 'Giày Lười Da Nam Công Sở Dr.M', 5, 1100000, 0, 'GD05.jpg'),
('GD06', 'Giày Da Nam Derby Đế Phíp Gỗ', 5, 1350000, 5, 'GD06.jpg'),
('GD07', 'Giày Da Lộn Nam Chukka Boot', 5, 1200000, 0, 'GD07.jpg'),
('GD08', 'Giày Da Nam Oxford Captoe Brown', 5, 1550000, 10, 'GD08.jpg');

-- ========================================================
-- 6. NHÓM GIÀY CỔ CAO (id_loaigiay = 6)
-- ========================================================
INSERT INTO `tbl_sanpham` (`ma_sp`, `ten_sp`, `id_loaigiay`, `gia_ban`, `giam_gia`, `hinh_anh`) VALUES
('CC01', 'Giày Cổ Cao Converse Chuck 70 Classic', 6, 1950000, 0, 'CC01.jpg'),
('CC02', 'Giày Cổ Cao Palladium Pampa Hi Canvas', 6, 2100000, 15, 'CC02.jpg'),
('CC03', 'Giày Boot Nam Timberland 6-Inch Yellow', 6, 4500000, 10, 'CC03.jpg'),
('CC04', 'Giày unisex cổ cao Pampa Petit Prince', 6, 5200000, 0, 'CC04.jpg'),
('CC05', 'Giày Boot Cổ Cao Dr. Martens 1460 8-Eye', 6, 3800000, 5, 'CC05.jpg'),
('CC06', 'Giày unisex cổ cao Pampa Hi Dare II', 6, 1850000, 0, 'CC06.jpg'),
('CC07', 'Giày unisex cổ cao Ace Chukka Organic', 6, 2500000, 25, 'CC07.jpg'),
('CC08', 'Giày unisex cổ cao Run Star Motion', 6, 3200000, 0, 'CC08.jpg');

UPDATE `tbl_sanpham` SET `mo_ta` = 'Mẫu giày Balenciaga Triple S Đen Cam sở hữu thiết kế Chunky đồ sộ, phong cách Streetwear cực chất. Chất liệu da cao cấp kết hợp vải lưới thoáng khí, đế cao su 3 lớp giúp tăng chiều cao tối ưu.' WHERE `ma_sp` = 'SN01';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Sự kết hợp hoàn hảo giữa Balenciaga và adidas. Mẫu Triple S Trắng mang biểu tượng 3 sọc đặc trưng, thiết kế phá cách, vừa mang nét thể thao vừa đậm chất thời trang xa xỉ.' WHERE `ma_sp` = 'SN02';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Balenciaga Track Trắng Cam với hệ thống dây giày đan xen phức tạp, đế giày bám dính cực tốt. Đây là lựa chọn hàng đầu cho những bạn yêu thích sự năng động và nổi bật.' WHERE `ma_sp` = 'SN03';
UPDATE `tbl_sanpham` SET `mo_ta` = 'MLB Big Ball Chunky A với logo NY Yankees in nổi bật. Giày có form dáng chắc chắn, lót đệm êm ái, phù hợp cho cả nam và nữ đi học hoặc đi chơi hàng ngày.' WHERE `ma_sp` = 'SN04';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Air Max 97 Ultra 17 phiên bản Triple Black đầy quyền lực. Thiết kế lấy cảm hứng từ tàu cao tốc Nhật Bản với các đường vân lượn sóng phản quang, đế Air toàn phần êm ái.' WHERE `ma_sp` = 'SN05';
UPDATE `tbl_sanpham` SET `mo_ta` = 'MLB BIGBALL CHUNKY Planet là sự nâng cấp với họa tiết vũ trụ độc đáo. Form giày hack chiều cao cực tốt, chất liệu da tổng hợp bền bỉ, dễ dàng vệ sinh.' WHERE `ma_sp` = 'SN06';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Balenciaga Triple S Trainer Grey mang phối màu xám trung tính, dễ phối đồ. Thiết kế bụi bặm với hiệu ứng làm cũ đặc trưng, khẳng định đẳng cấp người mang.' WHERE `ma_sp` = 'SN07';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Biti\'s Hunter Running Xanh Dương sở hữu công nghệ đế LiteFlex siêu nhẹ. Thân giày dệt Mesh co giãn, ôm sát chuyển động, hỗ trợ chạy bộ chuyên nghiệp.' WHERE `ma_sp` = 'SN08';

UPDATE `tbl_sanpham` SET `mo_ta` = 'Biti\'s Hunter Running Trắng tinh khôi, thiết kế tối giản nhưng hiện đại. Công nghệ đế giảm chấn giúp bảo vệ khớp gối khi vận động mạnh.' WHERE `ma_sp` = 'TT01';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Biti\'s Hunter EZ Lift Xanh Dương chuyên dụng cho tập Gym và tập tạ. Đế bằng vững chãi, quai dán hỗ trợ cố định bàn chân trong các bài tập nặng.' WHERE `ma_sp` = 'TT02';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Biti\'s Hunter Litedash Đen với thiết kế slip-on tiện lợi. Trọng lượng siêu nhẹ, phù hợp cho những người bận rộn cần một đôi giày đa năng từ phòng tập ra phố.' WHERE `ma_sp` = 'TT03';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Phiên bản Running Trắng cải tiến với lót giày kháng khuẩn O2. Độ đàn hồi cao hơn 20% so với thế hệ cũ, mang lại cảm giác nhẹ nhàng trong từng bước chạy.' WHERE `ma_sp` = 'TT04';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Biti\'s Soulmate Trắng là người bạn đồng hành lý tưởng cho giới trẻ. Thiết kế thanh thoát, trọng lượng cực nhẹ, phù hợp cho mọi outfit hàng ngày.' WHERE `ma_sp` = 'TT05';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Mẫu Bitis BSM000900 bền bỉ với đế cao su tổng hợp. Thân giày chắc chắn, chịu được va đập tốt, chuyên dùng cho các môn thể thao vận động ngoài trời.' WHERE `ma_sp` = 'TT06';
UPDATE `tbl_sanpham` SET `mo_ta` = 'JORDAN LUKA 4 White Cement sở hữu công nghệ đệm khí vượt trội. Phối màu xi măng kinh điển, hỗ trợ cực tốt cho những cú step-back và đổi hướng đột ngột trên sân bóng rổ.' WHERE `ma_sp` = 'TT07';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Bitis Embrace Đen mang thiết kế ôm trọn bàn chân như một chiếc tất. Đế ngoài rãnh sâu tăng cường độ bám, lý tưởng cho việc đi bộ đường dài.' WHERE `ma_sp` = 'TT08';

UPDATE `tbl_sanpham` SET `mo_ta` = 'Sandal Teva Forebay Nâu mang phong cách dã ngoại mạnh mẽ. Hệ thống quai dán chắc chắn, mũi giày bọc cao su bảo vệ ngón chân khỏi va chạm đá sỏi.' WHERE `ma_sp` = 'SD01';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Teva Hudson Xám với lòng bàn chân bằng đệm EVA cực êm. Chất liệu quai chống thấm nước, khô nhanh, phù hợp cho các hoạt động lội suối, đi biển.' WHERE `ma_sp` = 'SD02';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Teva Langdon Nâu làm từ da thật lót vải lưới. Thiết kế lịch sự nhưng vẫn giữ được độ linh hoạt đặc trưng của dòng sandal outdoor.' WHERE `ma_sp` = 'SD03';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Crocs Classic Mega Crush Be với phần đế cao đột phá. Chất liệu nhựa Croslite đặc trưng giúp giày siêu nhẹ, kháng khuẩn và cực kỳ thời trang.' WHERE `ma_sp` = 'SD04';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Teva Original Universal Đen là biểu tượng của sự đơn giản. Thiết kế quai bền bỉ từ nhựa tái chế, phù hợp cho mọi hoạt động từ dạo phố đến du lịch.' WHERE `ma_sp` = 'SD05';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Teva Original Alp Revive lấy cảm hứng từ thập niên 90 với hệ thống quai đan chéo độc đáo, giữ chân cực kỳ vững chãi khi di chuyển trên địa hình gồ ghề.' WHERE `ma_sp` = 'SD06';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Teva Hurricane XLT3 Xanh Quân Đội với mũi giày kín, bảo vệ tối đa chân bạn. Đế ngoài bám dính vượt trội trên bề mặt ướt.' WHERE `ma_sp` = 'SD07';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Hurricane XLT3 Xanh Navy là sự kết hợp giữa hiệu năng và thời trang. Đệm gót chân giúp giảm chấn khi đi bộ đường dài.' WHERE `ma_sp` = 'SD08';

UPDATE `tbl_sanpham` SET `mo_ta` = 'Giày Tây Oxford Classic với thiết kế mũi Cap-toe thanh lịch. Da bò thật mềm mại, bóng mịn, hoàn hảo khi kết hợp cùng các bộ Suit trang trọng.' WHERE `ma_sp` = 'GT01';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Derby Elegant mang phong cách hiện đại với hệ thống mui mở, giúp người mang dễ dàng điều chỉnh độ ôm chân. Phù hợp cho môi trường công sở.' WHERE `ma_sp` = 'GT02';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Loafer Modern không dây tiện lợi. Chất liệu da trơn, đế cao su chống trượt giúp bạn di chuyển linh hoạt và thoải mái suốt cả ngày dài.' WHERE `ma_sp` = 'GT03';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Giày Monk Strap độc đáo với khóa cài kim loại thay cho dây buộc. Thể hiện gu thời trang khác biệt và lịch lãm cho quý ông.' WHERE `ma_sp` = 'GT04';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Giày Brogue với họa tiết đục lỗ nghệ thuật trên thân giày. Sự kết hợp giữa cổ điển và thời thượng, phù hợp cho những buổi tiệc quan trọng.' WHERE `ma_sp` = 'GT05';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Chelsea Boots thiết kế mượt mà, thun co giãn hai bên hông giúp mang vào dễ dàng. Form giày ôm sát chân, tạo diện mạo cực kỳ cuốn hút.' WHERE `ma_sp` = 'GT06';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Penny Loafer tinh tế với đai da vắt ngang thân giày. Đây là mẫu giày không thể thiếu cho phong cách Smart Casual thanh lịch.' WHERE `ma_sp` = 'GT07';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Bitis BVM001788 là sự giao thoa giữa giày Tây và Boot. Chất liệu da cao cấp, đế đúc chắc chắn, mang lại vẻ ngoài mạnh mẽ và nam tính.' WHERE `ma_sp` = 'GT08';

UPDATE `tbl_sanpham` SET `mo_ta` = 'Giày Da Bò Sáp Tebe Đen với bề mặt da cá tính, càng đi càng đẹp theo thời gian. Đế đúc nguyên khối, chống mài mòn cực tốt.' WHERE `ma_sp` = 'GD01';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Moca Da Bò Hạt Nâu mang lại sự thoải mái tuyệt đối nhờ lót đệm dày. Họa tiết da hạt sang trọng, phù hợp cho cả đi làm và đi chơi.' WHERE `ma_sp` = 'GD02';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Giày Sabo Da Cao Cấp không gót tiện lợi. Giải pháp hoàn hảo cho những ngày cần sự nhanh chóng nhưng vẫn giữ được nét lịch sự.' WHERE `ma_sp` = 'GD03';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Chelsea Boot Da Lộn Camel với tone màu vàng bò ấm áp. Chất liệu da lộn mềm mịn, phù hợp cho phong cách lãng tử, bụi bặm.' WHERE `ma_sp` = 'GD04';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Giày Lười Dr.M thiết kế đế kếp đặc trưng. Da bò bóng nhẹ, phong cách khỏe khoắn, độ bền cao thách thức thời gian.' WHERE `ma_sp` = 'GD05';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Derby Đế Phíp Gỗ tạo tiếng vang giòn tan trong từng bước đi. Sự tỉ mỉ trong từng đường kim mũi chỉ khẳng định giá trị thủ công cao cấp.' WHERE `ma_sp` = 'GD06';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Chukka Boot Da Lộn với thiết kế cổ lửng ngang mắt cá. Hai lỗ xỏ dây đơn giản, mang lại vẻ đẹp cổ điển và phóng khoáng.' WHERE `ma_sp` = 'GD07';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Oxford Captoe Brown với phối màu nâu cánh gián sang trọng. Đây là mẫu giày "phải có" để tôn lên vẻ đẹp của những chiếc quần Tây xanh Navy hoặc xám.' WHERE `ma_sp` = 'GD08';

UPDATE `tbl_sanpham` SET `mo_ta` = 'Converse Chuck 70 Classic cổ cao với vải Canvas dày dặn, đế màu ngà vintage. Tem gót đen và đường chỉ may tỉ mỉ tạo nên đẳng cấp của dòng 70s.' WHERE `ma_sp` = 'CC01';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Palladium Pampa Hi Canvas mang phong cách quân đội Pháp. Đế cao su bánh mì hầm hố, bảo vệ chân tuyệt đối trong các chuyến phượt bụi.' WHERE `ma_sp` = 'CC02';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Timberland 6-Inch Yellow mang tính biểu tượng với khả năng chống thấm nước tuyệt đối. Chất liệu da Nubuck vàng nổi bật, cổ giày bọc đệm êm ái.' WHERE `ma_sp` = 'CC03';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Pampa Petit Prince - Phiên bản Hoàng Tử Bé đầy lãng mạn. Họa tiết in đặc biệt kết hợp cùng form dáng Pampa kinh điển, mang giá trị sưu tầm cao.' WHERE `ma_sp` = 'CC04';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Dr. Martens 1460 với 8 lỗ xỏ dây, đế đệm khí AirWair huyền thoại. Đường chỉ vàng nổi bật, da trơn chắc chắn, biểu tượng của văn hóa Rock & Roll.' WHERE `ma_sp` = 'CC05';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Pampa Hi Dare II với thông điệp mạnh mẽ in trên gót giày. Chất liệu vải bền bỉ, màu sắc trung tính, phù hợp cho những cá tính không ngại thử thách.' WHERE `ma_sp` = 'CC06';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Ace Chukka Organic làm từ vải thân thiện môi trường. Kiểu dáng Chukka thanh lịch trên nền đế sneaker linh hoạt, lựa chọn xanh cho người yêu thiên nhiên.' WHERE `ma_sp` = 'CC07';
UPDATE `tbl_sanpham` SET `mo_ta` = 'Run Star Motion với phần đế ziczac cực đại. Thiết kế tương lai giúp bạn trở thành tâm điểm của mọi ánh nhìn, tăng chiều cao vượt trội.' WHERE `ma_sp` = 'CC08';

-- --------------------------------------------------------
-- 4. BẢNG NGƯỜI DÙNG (Users & Admin)

DROP TABLE IF EXISTS `tbl_nguoidung`;
CREATE TABLE `tbl_nguoidung` (
  `id_nguoidung` int(11) NOT NULL AUTO_INCREMENT,
  `ho_ten` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_dang_nhap` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mat_khau` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dien_thoai` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quyen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Khách hàng, 1: Admin',
  `trang_thai` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: Bị khóa, 1: Đang hoạt động',
  PRIMARY KEY (`id_nguoidung`),
  UNIQUE KEY `uk_ten_dang_nhap` (`ten_dang_nhap`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tbl_nguoidung` (`ho_ten`, `ten_dang_nhap`, `mat_khau`, `email`, `so_dien_thoai`, `quyen`, `trang_thai`) 
VALUES ('Quản Trị Viên', 'admin', MD5('123'), 'admin@gmail.com', '0905009009', 1, 1);

INSERT INTO `tbl_nguoidung` (`ho_ten`, `ten_dang_nhap`, `mat_khau`, `email`, `so_dien_thoai`, `quyen`, `trang_thai`) 
VALUES 
('Nguyễn Văn A', 'user', MD5('123'), 'user@gmail.com', '0123456781', 0, 1);


-- 5. BẢNG TIN TỨC 
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tbl_tintuc`;
CREATE TABLE `tbl_tintuc` (
  `id_tintuc` int(11) NOT NULL AUTO_INCREMENT,
  `tieu_de` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hinh_anh` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no-news.jpg',
  `tom_tat` text COLLATE utf8mb4_unicode_ci,
  `noi_dung` longtext COLLATE utf8mb4_unicode_ci,
  `ngay_dang` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tintuc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================
-- NHẬP DỮ LIỆU CHO 8 BÀI VIẾT (tbl_tintuc)
-- ========================================================

INSERT INTO `tbl_tintuc` (`tieu_de`, `hinh_anh`, `tom_tat`, `noi_dung`, `ngay_dang`) VALUES
('Mason Mount chính thức làm đại sứ thương hiệu Mizuno', 'news01.jpg', 'Mizuno vừa tạo nên một cú hích lớn khi công bố bản hợp đồng đại sứ thương hiệu cùng ngôi sao Mason Mount...', 
'<p>Sự kết hợp giữa tiền vệ tài hoa người Anh và thương hiệu thể thao danh tiếng Nhật Bản đánh dấu một chương mới trong chiến lược bành trướng của Mizuno tại châu Âu.</p>
<p>Theo thỏa thuận, <b>Mason Mount</b> sẽ trực tiếp trên chân dòng giày bóng đá <b>Mizuno α III Japan</b>. Nam tiền vệ sẽ làm việc chặt chẽ với đội ngũ chuyên gia Nhật Bản để cung cấp những phản hồi kỹ thuật thực tế, hỗ trợ phát triển các dòng sản phẩm đột phá trong tương lai.</p>
<p>Trải nghiệm đầu tiên của Mount với Mizuno đã để lại ấn tượng tức thì nhờ nghệ thuật thủ công thượng thặng. Việc ký hợp đồng này khẳng định vị thế của một "ông lớn" về công nghệ hiệu năng trong bóng đá hiện đại.</p>', NOW()),

('adidas Predator 94 Reverse: Bản giao thoa ngược thời gian', 'news02.jpg', 'adidas vừa ra mắt mẫu Predator 94 "Reverse", đảo ngược hoàn toàn bảng màu huyền thoại của phiên bản OG 1994...', 
'<p>Mẫu giày đá bóng Predator 94 "Reverse" xuất hiện với phối màu chính thức "Ftwr White/Core Black", mang đến một hình ảnh phản chiếu đầy thuần khiết của dòng giày quái thú.</p>
<p>Nếu đôi OG 1994 kinh điển là phần "Dương" với sắc đen mạnh mẽ, thì phiên bản Reverse chính là phần "Âm" với nền trắng tinh khôi. Điểm nhấn là biểu tượng <b>"đôi mắt quái thú"</b> rực rỡ trên lưỡi gà.</p>
<p>Predator 94 "Reverse" là lựa chọn hàng đầu cho những cầu thủ trân trọng giá trị di sản nhưng luôn khao khát sự khác biệt bùng nổ.</p>', NOW()),

('Có nên giặt giày bằng máy giặt?', 'news03.jpg', 'Nhiều người lo ngại giặt máy sẽ làm hỏng giày. Hãy cùng tìm hiểu chế độ giặt an toàn nhất.', 
'<p>Giặt giày bằng máy giặt thực sự hiệu quả nhưng cần lưu ý một số quy tắc vàng:</p>
<p><b>1. Chế độ giặt:</b> Tuyệt đối dùng nước lạnh và tắt chế độ sấy vì nhiệt độ cao sẽ làm bong keo giày.</p>
<p><b>2. Chất liệu:</b> Chỉ giặt các loại vải canvas, nylon, polyester. Tránh xa da lộn và các loại đính cườm.</p>
<p><b>3. Chuẩn bị:</b> Tháo dây và lót giày giặt riêng. Nên để giày trong túi giặt và bỏ thêm thảm vải cũ vào lồng giặt để giảm va đập.</p>', NOW()),

('Đôi giày bạn chọn tiết lộ con đường dẫn đến thành công', 'news04.jpg', 'Mỗi đôi giày tượng trưng cho một cá tính và con đường riêng để dẫn bạn đến ước mơ.', 
'<p>Lựa chọn của bạn nói lên điều gì về tương lai?</p>
<p><b>Giày A:</b> Bạn coi trọng truyền thống và sự ổn định. Thành công của bạn dựa trên kỷ luật và kiên nhẫn. Bạn tin rằng chậm mà chắc sẽ đưa bạn đi xa.</p>
<p><b>Giày B:</b> Bạn là người năng động và hành động. Thành công đến từ việc chấp nhận rủi ro và luôn đi trước một bước. Tốc độ là đồng minh của bạn.</p>
<p><b>Giày C:</b> Bạn mang trong mình tham vọng lớn lao. Bạn tự tin và biết rằng hình ảnh cá nhân là chìa khóa mở ra cánh cửa sự nghiệp đỉnh cao.</p>', NOW()),

('Trung Quốc phát triển giày phân hủy sinh học', 'news05.jpg', 'Đại học Công nghệ Hóa học Bắc Kinh ra mắt lô giày sinh học đầu tiên có thể phân hủy hoàn toàn...', 
'<p>Hơn 500 đôi giày sinh học đầu tiên đã được trao tặng cho giảng viên và sinh viên tại BUCT.</p>
<p>Phần đế sử dụng chất liệu <b>cao su polyester</b> nguồn gốc sinh học, trong khi các bộ phận khác làm từ sợi gai dầu và tre. Chúng đủ bền để dùng hàng ngày nhưng phân hủy rất nhanh trong điều kiện ủ phân.</p>
<p>Đây là giải pháp cho vấn đề môi trường khi mỗi năm có gần một tỷ đôi giày bị vứt bỏ tại Trung Quốc.</p>', NOW()),

('Giày hiệu dán nhãn chỉ số khí thải carbon', 'news06.jpg', 'Allbirds trở thành thương hiệu đầu tiên dán nhãn chỉ số CO2 sản sinh trong quá trình sản xuất...', 
'<p>Mọi sản phẩm của Allbirds từ nay sẽ đính kèm chỉ số khí thải carbon. Trung bình một đôi giày của hãng thải ra 7,6 kg CO2.</p>
<p>Hãng tập trung đo lường từ khâu chất liệu đến vận chuyển. Allbirds cũng cam kết đóng góp vào quỹ giảm phát thải để duy trì mức 100% trung tính carbon.</p>
<p>Sáng kiến này hy vọng sẽ truyền cảm hứng về sự minh bạch môi trường trong ngành thời trang thế giới.</p>', NOW()),

('giayBOM - Thương hiệu giày dành cho người Việt', 'news07.jpg', 'giayBOM (Buy One More) mang tới những sản phẩm thiết kế phù hợp, mẫu mã đa dạng cho giới trẻ.', 
'<p>Thành lập từ 2016, <b>giayBOM</b> đặt tiêu chí chất lượng và trải nghiệm mua hàng lên hàng đầu.</p>
<p>Thương hiệu mang đến những mẫu giày thể thao, sandals trẻ trung với giá thành hợp lý. Đặc biệt, các bộ sưu tập được cập nhật liên tục theo xu hướng thời trang năng động của người Việt.</p>', NOW()),

('Cách chọn giày chạy bộ phù hợp với địa hình', 'news08.jpg', 'Bên cạnh vẻ ngoài, tính năng và địa hình chạy là yếu tố quan trọng nhất khi chọn giày...', 
'<p>Để chọn được đôi giày ưng ý, bạn cần lưu ý:</p>
<p><b>1. Địa hình:</b> Giày <i>Road-running</i> cho đường bằng nhựa và <i>Trail-running</i> có độ bám cao cho đường núi dốc.</p>
<p><b>2. Kiểu chân:</b> Xác định độ lệch cổ chân (lệch trong, lệch ngoài hay bình thường) để chọn miếng đệm hỗ trợ phù hợp.</p>
<p><b>3. Bộ phận giày:</b> Chú ý đến đệm đế và cao su đế để đảm bảo độ êm và giảm chấn thương khi luyện tập lâu dài.</p>', NOW());

-- --------------------------------------------------------
-- 6. BẢNG ĐƠN HÀNG (Orders)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tbl_donhang`;
CREATE TABLE `tbl_donhang` (
  `id_donhang` int(11) NOT NULL AUTO_INCREMENT,
  `id_nguoidung` int(11) DEFAULT NULL,
  `ten_nguoi_nhan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_dien_thoai` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dia_chi_giao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci,
  `tong_tien` int(11) NOT NULL,
  `trang_thai` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Chờ duyệt, 1: Đang giao, 2: Hoàn thành, 3: Đã hủy',
  `ngay_dat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_donhang`),
  KEY `fk_donhang_nguoidung` (`id_nguoidung`),
  CONSTRAINT `fk_donhang_nguoidung` FOREIGN KEY (`id_nguoidung`) REFERENCES `tbl_nguoidung` (`id_nguoidung`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 7. BẢNG CHI TIẾT ĐƠN HÀNG (Order Details)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tbl_chitietdonhang`;
CREATE TABLE `tbl_chitietdonhang` (
  `id_chitiet` int(11) NOT NULL AUTO_INCREMENT,
  `id_donhang` int(11) NOT NULL,
  `id_sanpham` int(11) NOT NULL,
  `size_mua` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_luong` int(11) NOT NULL,
  `gia_mua` int(11) NOT NULL COMMENT 'Giá chốt tại thời điểm khách mua',
  PRIMARY KEY (`id_chitiet`),
  KEY `fk_chitiet_donhang` (`id_donhang`),
  KEY `fk_chitiet_sanpham` (`id_sanpham`),
  CONSTRAINT `fk_chitiet_donhang` FOREIGN KEY (`id_donhang`) REFERENCES `tbl_donhang` (`id_donhang`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_chitiet_sanpham` FOREIGN KEY (`id_sanpham`) REFERENCES `tbl_sanpham` (`id_sanpham`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bật lại kiểm tra khóa ngoại
SET FOREIGN_KEY_CHECKS = 1;