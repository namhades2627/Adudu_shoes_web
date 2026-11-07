<?php
session_start();
include '../Includes/connect_db.php';
/** @var mysqli $conn */
/** @var mysqli $conn */
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.']);
    exit;
}

$id = filter_var($_POST['id_sp'] ?? null, FILTER_VALIDATE_INT);
$size = trim((string)($_POST['size'] ?? ''));
$sl = filter_var($_POST['sl'] ?? null, FILTER_VALIDATE_INT);

if ($id === false || $id < 1 || $sl === false || $sl < 1 || $size === '' || !ctype_digit($size)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng chọn size và số lượng hợp lệ.']);
    exit;
}

$stmt = mysqli_prepare($conn, 'SELECT ten_sp, hinh_anh, gia_ban, giam_gia, size_giay, so_luong_ton FROM tbl_sanpham WHERE id_sanpham = ? LIMIT 1');
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Không thể kiểm tra sản phẩm.']);
    exit;
}

mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$sp = $result ? mysqli_fetch_assoc($result) : null;
mysqli_stmt_close($stmt);

if (!$sp) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy sản phẩm.']);
    exit;
}

$available_sizes = array_values(array_unique(array_filter(array_map('trim', explode(',', (string)$sp['size_giay'])), function ($available_size) {
    return $available_size !== '' && ctype_digit($available_size);
})));
if (!in_array($size, $available_sizes, true)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Size đã chọn không có cho sản phẩm này.']);
    exit;
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$sl_trong_gio = 0;
foreach ($_SESSION['cart'] as $cart_item) {
    if (is_array($cart_item) && (int)($cart_item['id'] ?? 0) === $id) {
        $sl_trong_gio += max(0, (int)($cart_item['sl'] ?? 0));
    }
}

$sl_con_lai = max(0, (int)$sp['so_luong_ton'] - $sl_trong_gio);
if ($sl > $sl_con_lai) {
    http_response_code(409);
    echo json_encode(['status' => 'error', 'message' => $sl_con_lai > 0
        ? 'Chỉ còn ' . $sl_con_lai . ' sản phẩm có thể thêm vào giỏ.'
        : 'Sản phẩm đã hết tồn kho.']);
    exit;
}

$gia_ap_dung = (int)round((float)$sp['gia_ban'] * (1 - (int)$sp['giam_gia'] / 100));
$cart_id = $id . '_' . $size;
if (isset($_SESSION['cart'][$cart_id])) {
    $_SESSION['cart'][$cart_id]['sl'] += $sl;
    $_SESSION['cart'][$cart_id]['gia'] = $gia_ap_dung;
} else {
    $_SESSION['cart'][$cart_id] = [
        'id' => $id,
        'ten' => $sp['ten_sp'],
        'hinh' => $sp['hinh_anh'],
        'gia' => $gia_ap_dung,
        'size' => $size,
        'sl' => $sl
    ];
}

echo json_encode(['status' => 'success', 'cart_count' => count($_SESSION['cart'])]);
?>