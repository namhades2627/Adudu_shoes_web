<?php
session_start();
include '../Includes/connect_db.php';
/** @var mysqli $conn */
global $conn;

function checkout_fail(string $message)
{
    http_response_code(400);
    echo '<script>alert(' . json_encode($message, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) . '); window.location.href="thanhtoan.php";</script>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    checkout_fail('Giỏ hàng trống hoặc yêu cầu đặt hàng không hợp lệ.');
}

$ho_ten = trim((string)($_POST['ho_ten'] ?? ''));
$sdt = trim((string)($_POST['so_dien_thoai'] ?? ''));
$dia_chi = trim((string)($_POST['dia_chi'] ?? ''));
if ($ho_ten === '' || $sdt === '' || $dia_chi === '') {
    checkout_fail('Vui lòng nhập đầy đủ thông tin giao hàng.');
}

$cart_items = [];
$tong_so_luong = [];
foreach ($_SESSION['cart'] as $cart_key => $item) {
    if (!is_array($item)) {
        checkout_fail('Giỏ hàng có dữ liệu không hợp lệ. Vui lòng tải lại giỏ hàng.');
    }

    $id_sp = filter_var($item['id'] ?? null, FILTER_VALIDATE_INT);
    $sl = filter_var($item['sl'] ?? null, FILTER_VALIDATE_INT);
    $size = trim((string)($item['size'] ?? ''));
    if ($id_sp === false || $id_sp < 1 || $sl === false || $sl < 1 || $size === '' || !ctype_digit($size) || $cart_key !== $id_sp . '_' . $size) {
        checkout_fail('Giỏ hàng có sản phẩm hoặc size không hợp lệ. Vui lòng thêm lại sản phẩm.');
    }

    $cart_items[] = ['id' => $id_sp, 'size' => $size, 'sl' => $sl];
    $tong_so_luong[$id_sp] = ($tong_so_luong[$id_sp] ?? 0) + $sl;
}

$id_sp_query = 0;
$transaction_started = mysqli_begin_transaction($conn);
if (!$transaction_started) {
    checkout_fail('Chưa thể bắt đầu đặt hàng. Vui lòng thử lại.');
}

try {
    $product_stmt = mysqli_prepare($conn, 'SELECT ten_sp, gia_ban, giam_gia, size_giay, so_luong_ton FROM tbl_sanpham WHERE id_sanpham = ? LIMIT 1 FOR UPDATE');
    if (!$product_stmt) {
        throw new RuntimeException('Không thể kiểm tra sản phẩm.');
    }

    $stock_by_product = [];
    $tong_bill = 0;
    mysqli_stmt_bind_param($product_stmt, 'i', $id_sp_query);
    foreach ($cart_items as &$item) {
        $id_sp_query = $item['id'];
        if (!mysqli_stmt_execute($product_stmt)) {
            throw new RuntimeException('Không thể kiểm tra tồn kho.');
        }

        $result = mysqli_stmt_get_result($product_stmt);
        $sp = $result ? mysqli_fetch_assoc($result) : null;
        if ($result) {
            mysqli_free_result($result);
        }
        if (!$sp) {
            throw new DomainException('Một sản phẩm trong giỏ hàng không còn tồn tại.');
        }

        $available_sizes = array_values(array_unique(array_filter(array_map('trim', explode(',', (string)$sp['size_giay'])), function ($available_size) {
            return $available_size !== '' && ctype_digit($available_size);
        })));
        if (!in_array($item['size'], $available_sizes, true)) {
            throw new DomainException('Size ' . $item['size'] . ' của sản phẩm ' . $sp['ten_sp'] . ' không còn khả dụng.');
        }

        $stock_by_product[$item['id']] = (int)$sp['so_luong_ton'];
        $item['gia'] = (int)round((float)$sp['gia_ban'] * (1 - (int)$sp['giam_gia'] / 100));
        $tong_bill += $item['gia'] * $item['sl'];
    }
    unset($item);
    mysqli_stmt_close($product_stmt);

    foreach ($tong_so_luong as $id_sp => $sl) {
        if (!isset($stock_by_product[$id_sp]) || $sl > $stock_by_product[$id_sp]) {
            throw new DomainException('Tồn kho không đủ cho một sản phẩm trong giỏ. Vui lòng giảm số lượng.');
        }
    }

    $id_nguoidung = isset($_SESSION['id_nguoidung']) ? (int)$_SESSION['id_nguoidung'] : null;
    $order_stmt = mysqli_prepare($conn, 'INSERT INTO tbl_donhang (id_nguoidung, ten_nguoi_nhan, so_dien_thoai, dia_chi_giao, tong_tien, trang_thai) VALUES (?, ?, ?, ?, ?, 0)');
    if (!$order_stmt) {
        throw new RuntimeException('Không thể tạo đơn hàng.');
    }
    mysqli_stmt_bind_param($order_stmt, 'isssi', $id_nguoidung, $ho_ten, $sdt, $dia_chi, $tong_bill);
    if (!mysqli_stmt_execute($order_stmt)) {
        throw new RuntimeException('Không thể tạo đơn hàng.');
    }
    $id_donhang = mysqli_insert_id($conn);
    mysqli_stmt_close($order_stmt);

    $detail_stmt = mysqli_prepare($conn, 'INSERT INTO tbl_chitietdonhang (id_donhang, id_sanpham, size_mua, so_luong, gia_mua) VALUES (?, ?, ?, ?, ?)');
    if (!$detail_stmt) {
        throw new RuntimeException('Không thể lưu chi tiết đơn hàng.');
    }
    foreach ($cart_items as $item) {
        $id_sp = $item['id'];
        $size = $item['size'];
        $sl = $item['sl'];
        $gia = $item['gia'];
        mysqli_stmt_bind_param($detail_stmt, 'iisii', $id_donhang, $id_sp, $size, $sl, $gia);
        if (!mysqli_stmt_execute($detail_stmt)) {
            throw new RuntimeException('Không thể lưu chi tiết đơn hàng.');
        }
    }
    mysqli_stmt_close($detail_stmt);

    $stock_stmt = mysqli_prepare($conn, 'UPDATE tbl_sanpham SET so_luong_ton = so_luong_ton - ? WHERE id_sanpham = ? AND so_luong_ton >= ?');
    if (!$stock_stmt) {
        throw new RuntimeException('Không thể cập nhật tồn kho.');
    }
    foreach ($tong_so_luong as $id_sp => $sl) {
        mysqli_stmt_bind_param($stock_stmt, 'iii', $sl, $id_sp, $sl);
        if (!mysqli_stmt_execute($stock_stmt) || mysqli_stmt_affected_rows($stock_stmt) !== 1) {
            throw new DomainException('Tồn kho vừa thay đổi. Vui lòng kiểm tra lại giỏ hàng.');
        }
    }
    mysqli_stmt_close($stock_stmt);

    if (!mysqli_commit($conn)) {
        throw new RuntimeException('Không thể hoàn tất đơn hàng.');
    }
} catch (DomainException $error) {
    mysqli_rollback($conn);
    checkout_fail($error->getMessage());
} catch (Throwable $error) {
    mysqli_rollback($conn);
    error_log('Checkout failed: ' . $error->getMessage());
    checkout_fail('Có lỗi khi tạo đơn hàng. Dữ liệu đơn và tồn kho đã được giữ nguyên, vui lòng thử lại.');
}

unset($_SESSION['cart']);
echo "<script>alert('Đặt hàng thành công! ADUDU sẽ sớm liên hệ với bạn.'); window.location.href='index.php';</script>";
exit;
?>