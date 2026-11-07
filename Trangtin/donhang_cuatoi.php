<?php
session_start();
include '../Includes/connect_db.php';
/** @var mysqli $conn */

if (empty($_SESSION['id_nguoidung'])) {
    header('Location: dangnhap.php');
    exit;
}

$id_nguoidung = (int)$_SESSION['id_nguoidung'];
if (empty($_SESSION['orders_csrf'])) {
    $_SESSION['orders_csrf'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'cancel') {
    $id_donhang = filter_var($_POST['id_donhang'] ?? null, FILTER_VALIDATE_INT);
    $csrf = (string)($_POST['csrf_token'] ?? '');

    if ($id_donhang === false || $id_donhang < 1 || !hash_equals($_SESSION['orders_csrf'], $csrf)) {
        $_SESSION['orders_notice'] = ['type' => 'danger', 'text' => 'Yêu cầu hủy đơn không hợp lệ.'];
        header('Location: donhang_cuatoi.php');
        exit;
    }

    if (!mysqli_begin_transaction($conn)) {
        $_SESSION['orders_notice'] = ['type' => 'danger', 'text' => 'Chưa thể hủy đơn hàng. Vui lòng thử lại.'];
        header('Location: donhang_cuatoi.php');
        exit;
    }

    try {
        $order_stmt = mysqli_prepare($conn, 'SELECT trang_thai FROM tbl_donhang WHERE id_donhang = ? AND id_nguoidung = ? LIMIT 1 FOR UPDATE');
        if (!$order_stmt) {
            throw new RuntimeException('Không thể kiểm tra đơn hàng.');
        }
        mysqli_stmt_bind_param($order_stmt, 'ii', $id_donhang, $id_nguoidung);
        if (!mysqli_stmt_execute($order_stmt)) {
            throw new RuntimeException('Không thể kiểm tra đơn hàng.');
        }
        $order_result = mysqli_stmt_get_result($order_stmt);
        $order = $order_result ? mysqli_fetch_assoc($order_result) : null;
        if ($order_result) {
            mysqli_free_result($order_result);
        }
        mysqli_stmt_close($order_stmt);

        if (!$order) {
            throw new DomainException('Không tìm thấy đơn hàng của bạn.');
        }
        if ((int)$order['trang_thai'] !== 0) {
            throw new DomainException('Chỉ có thể hủy đơn khi đơn hàng đang chờ duyệt.');
        }

        $detail_stmt = mysqli_prepare($conn, 'SELECT id_sanpham, SUM(so_luong) AS so_luong FROM tbl_chitietdonhang WHERE id_donhang = ? GROUP BY id_sanpham');
        if (!$detail_stmt) {
            throw new RuntimeException('Không thể đọc chi tiết đơn hàng.');
        }
        mysqli_stmt_bind_param($detail_stmt, 'i', $id_donhang);
        if (!mysqli_stmt_execute($detail_stmt)) {
            throw new RuntimeException('Không thể đọc chi tiết đơn hàng.');
        }
        $detail_result = mysqli_stmt_get_result($detail_stmt);
        $items = $detail_result ? mysqli_fetch_all($detail_result, MYSQLI_ASSOC) : [];
        if ($detail_result) {
            mysqli_free_result($detail_result);
        }
        mysqli_stmt_close($detail_stmt);
        if (empty($items)) {
            throw new DomainException('Đơn hàng không có sản phẩm để hủy.');
        }

        $stock_stmt = mysqli_prepare($conn, 'UPDATE tbl_sanpham SET so_luong_ton = so_luong_ton + ? WHERE id_sanpham = ?');
        if (!$stock_stmt) {
            throw new RuntimeException('Không thể hoàn tồn kho.');
        }
        foreach ($items as $item) {
            $so_luong = (int)$item['so_luong'];
            $id_sanpham = (int)$item['id_sanpham'];
            mysqli_stmt_bind_param($stock_stmt, 'ii', $so_luong, $id_sanpham);
            if (!mysqli_stmt_execute($stock_stmt) || mysqli_stmt_affected_rows($stock_stmt) !== 1) {
                throw new RuntimeException('Không thể hoàn tồn kho.');
            }
        }
        mysqli_stmt_close($stock_stmt);

        $cancel_stmt = mysqli_prepare($conn, 'UPDATE tbl_donhang SET trang_thai = 3 WHERE id_donhang = ? AND id_nguoidung = ? AND trang_thai = 0');
        if (!$cancel_stmt) {
            throw new RuntimeException('Không thể cập nhật trạng thái đơn hàng.');
        }
        mysqli_stmt_bind_param($cancel_stmt, 'ii', $id_donhang, $id_nguoidung);
        if (!mysqli_stmt_execute($cancel_stmt) || mysqli_stmt_affected_rows($cancel_stmt) !== 1) {
            throw new RuntimeException('Trạng thái đơn hàng vừa thay đổi. Vui lòng tải lại trang.');
        }
        mysqli_stmt_close($cancel_stmt);

        if (!mysqli_commit($conn)) {
            throw new RuntimeException('Không thể hoàn tất yêu cầu hủy.');
        }
        $_SESSION['orders_notice'] = ['type' => 'success', 'text' => 'Đơn hàng đã được hủy. Số lượng đã được hoàn lại vào kho.'];
    } catch (DomainException $error) {
        mysqli_rollback($conn);
        $_SESSION['orders_notice'] = ['type' => 'danger', 'text' => $error->getMessage()];
    } catch (Throwable $error) {
        mysqli_rollback($conn);
        error_log('Order cancellation failed: ' . $error->getMessage());
        $_SESSION['orders_notice'] = ['type' => 'danger', 'text' => 'Không thể hủy đơn lúc này. Vui lòng tải lại và thử lại.'];
    }

    header('Location: donhang_cuatoi.php');
    exit;
}

$notice = $_SESSION['orders_notice'] ?? null;
unset($_SESSION['orders_notice']);

$orders_stmt = mysqli_prepare($conn, 'SELECT dh.id_donhang, dh.ten_nguoi_nhan, dh.so_dien_thoai, dh.dia_chi_giao, dh.tong_tien, dh.trang_thai, dh.ngay_dat, ct.id_chitiet, ct.size_mua, ct.so_luong, ct.gia_mua, sp.ten_sp FROM tbl_donhang dh LEFT JOIN tbl_chitietdonhang ct ON ct.id_donhang = dh.id_donhang LEFT JOIN tbl_sanpham sp ON sp.id_sanpham = ct.id_sanpham WHERE dh.id_nguoidung = ? ORDER BY dh.ngay_dat DESC, dh.id_donhang DESC, ct.id_chitiet ASC');
$orders = [];
if ($orders_stmt) {
    mysqli_stmt_bind_param($orders_stmt, 'i', $id_nguoidung);
    if (mysqli_stmt_execute($orders_stmt)) {
        $orders_result = mysqli_stmt_get_result($orders_stmt);
        while ($row = $orders_result ? mysqli_fetch_assoc($orders_result) : null) {
            $id = (int)$row['id_donhang'];
            if (!isset($orders[$id])) {
                $orders[$id] = [
                    'id' => $id,
                    'ten_nguoi_nhan' => $row['ten_nguoi_nhan'],
                    'so_dien_thoai' => $row['so_dien_thoai'],
                    'dia_chi_giao' => $row['dia_chi_giao'],
                    'tong_tien' => $row['tong_tien'],
                    'trang_thai' => (int)$row['trang_thai'],
                    'ngay_dat' => $row['ngay_dat'],
                    'items' => []
                ];
            }
            if ($row['id_chitiet'] !== null) {
                $orders[$id]['items'][] = [
                    'ten_sp' => $row['ten_sp'] ?? 'Sản phẩm không còn tồn tại',
                    'size' => $row['size_mua'],
                    'so_luong' => $row['so_luong'],
                    'gia' => $row['gia_mua']
                ];
            }
        }
        if ($orders_result) {
            mysqli_free_result($orders_result);
        }
    }
    mysqli_stmt_close($orders_stmt);
}

function escape_order_text($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

include '../Includes/header.php';
?>

<div class="container my-5 text-white" style="min-height: 60vh;">
    <div class="d-flex justify-content-between align-items-center border-bottom border-secondary pb-3 mb-4">
        <h2 class="h4 fw-bold text-warning mb-0">ĐƠN HÀNG CỦA TÔI</h2>
        <a href="sanpham.php" class="btn btn-outline-warning btn-sm">Tiếp tục mua sắm</a>
    </div>

    <?php if ($notice): ?>
        <div class="alert alert-<?php echo escape_order_text($notice['type']); ?>" role="alert">
            <?php echo escape_order_text($notice['text']); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($orders)): ?>
        <div class="text-center py-5">
            <p class="text-secondary">Bạn chưa có đơn hàng nào.</p>
            <a href="sanpham.php" class="btn btn-warning">Xem sản phẩm</a>
        </div>
    <?php else: ?>
        <?php foreach ($orders as $order):
            $status = [
                0 => ['label' => 'Chờ duyệt', 'class' => 'warning text-dark'],
                1 => ['label' => 'Đang giao', 'class' => 'info text-dark'],
                2 => ['label' => 'Hoàn thành', 'class' => 'success'],
                3 => ['label' => 'Đã hủy', 'class' => 'secondary']
            ][$order['trang_thai']] ?? ['label' => 'Không xác định', 'class' => 'secondary'];
        ?>
            <section class="border border-secondary rounded mb-4 overflow-hidden">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 bg-dark px-3 py-3 border-bottom border-secondary">
                    <div>
                        <strong>Đơn #<?php echo $order['id']; ?></strong>
                        <span class="text-secondary ms-2 small"><?php echo date('d/m/Y H:i', strtotime($order['ngay_dat'])); ?></span>
                    </div>
                    <span class="badge bg-<?php echo $status['class']; ?>"><?php echo $status['label']; ?></span>
                </div>

                <div class="p-3">
                    <div class="table-responsive">
                        <table class="table table-dark table-sm align-middle mb-3">
                            <thead>
                                <tr><th>Sản phẩm</th><th>Size</th><th>Số lượng</th><th class="text-end">Đơn giá</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order['items'] as $item): ?>
                                    <tr>
                                        <td><?php echo escape_order_text($item['ten_sp']); ?></td>
                                        <td><?php echo escape_order_text($item['size']); ?></td>
                                        <td><?php echo (int)$item['so_luong']; ?></td>
                                        <td class="text-end"><?php echo number_format((int)$item['gia'], 0, ',', '.'); ?>₫</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex flex-wrap justify-content-between gap-3">
                        <div class="small text-secondary">
                            Người nhận: <?php echo escape_order_text($order['ten_nguoi_nhan']); ?> · <?php echo escape_order_text($order['so_dien_thoai']); ?><br>
                            Địa chỉ: <?php echo escape_order_text($order['dia_chi_giao']); ?>
                        </div>
                        <div class="text-end">
                            <div class="text-secondary small">Tổng đơn</div>
                            <strong class="text-warning fs-5"><?php echo number_format((int)$order['tong_tien'], 0, ',', '.'); ?>₫</strong>
                        </div>
                    </div>

                    <?php if ($order['trang_thai'] === 0): ?>
                        <form method="POST" class="mt-3 text-end" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?');">
                            <input type="hidden" name="action" value="cancel">
                            <input type="hidden" name="id_donhang" value="<?php echo $order['id']; ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo escape_order_text($_SESSION['orders_csrf']); ?>">
                            <button type="submit" class="btn btn-outline-danger btn-sm">Hủy đơn hàng</button>
                        </form>
                    <?php endif; ?>
                </div>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include '../Includes/footer.php'; ?>