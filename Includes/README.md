# Khởi tạo database

## Cài mới

1. Bật MySQL trong XAMPP.
2. Trong phpMyAdmin, import `WebKinhDoanhGiay.sql` trước. File này tạo database và các bảng lõi.
3. Import `update_db.sql` sau. File này tạo các bảng thông báo, đánh giá, bình luận, báo cáo, hỗ trợ và nhân viên mà website sử dụng.
4. Kiểm tra thông tin database trong `connect_db.php` nếu cấu hình MySQL của máy khác mặc định.

## Cảnh báo dữ liệu

- `WebKinhDoanhGiay.sql` có lệnh `DROP TABLE` cho các bảng lõi. Import lại sẽ xóa dữ liệu hiện có trong các bảng đó.
- `update_db.sql` đặt lại tồn kho sản phẩm bằng số ngẫu nhiên và xóa/tạo lại bảng `tbl_nhanvien`, bao gồm dữ liệu nhân viên.
- Chỉ import hai file theo thứ tự trên khi cài mới hoặc khi có bản sao lưu có thể khôi phục. Không chạy lại các file này trên database đang cần giữ.
- Với database đang có dữ liệu, sao lưu trước và chỉ áp dụng các lệnh tạo bảng còn thiếu; bỏ qua lệnh cập nhật tồn kho, `DROP TABLE` và dữ liệu mẫu không cần thiết.