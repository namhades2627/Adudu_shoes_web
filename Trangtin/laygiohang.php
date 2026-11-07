<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$total_money = 0;
$html = '';

if (!empty($cart)) {
    foreach ($cart as $id_key => $item) {
        $thanh_tien = $item['gia'] * $item['sl'];
        $total_money += $thanh_tien;
        
        $html .= '
        <div class="cart-item-row d-flex gap-3 mb-3 border-bottom pb-2">
            <img src="../Images/'.trim($item['hinh']).'" style="width: 70px; height: 70px; object-fit: cover;">
            <div class="flex-grow-1">
                <div class="small fw-bold">'.$item['ten'].'</div>
                <div class="small text-secondary">Size: '.$item['size'].'</div>
                <div class="text-danger fw-bold">'.number_format($item['gia'], 0, ',', '.').'₫</div>
                <div class="d-flex align-items-center justify-content-between mt-1">
                    <span class="small">Số lượng: '.$item['sl'].'</span>
                    <a href="javascript:void(0)" onclick="removeFromCart(\''.$id_key.'\')" class="small text-muted text-decoration-underline">Xóa</a>
                </div>
            </div>
        </div>';
    }
} else {
    $html = '<p class="text-center text-muted my-4 small">Chưa có sản phẩm nào</p>';
}

echo json_encode([
    'html' => $html,
    'total' => number_format($total_money, 0, ',', '.') . '₫',
    'count' => count($cart)
]);
?>