<?php
session_start();

if (isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];

    if (isset($_SESSION['cart'][$cart_id])) {
        unset($_SESSION['cart'][$cart_id]);
        
        $new_count = count($_SESSION['cart']);
        
        echo json_encode([
            'status' => 'success',
            'cart_count' => $new_count
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại']);
    }
}
?>