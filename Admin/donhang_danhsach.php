<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
$sql = "SELECT * FROM tbl_donhang ORDER BY id_donhang DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="mb-4">
    <h3 class="text-white fw-bold text-uppercase">QUẢN LÝ ĐƠN HÀNG</h3>
</div>

<div class="card bg-dark border-secondary shadow">
    <div class="card-body p-0">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead class="table-secondary text-dark">
                <tr>
                    <th class="ps-4">ID</th>
                    <th>Người nhận / SĐT</th>
                    <th style="width: 30%;">Địa chỉ giao hàng</th>
                    <th>Tổng tiền</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td class="ps-4 text-secondary">#<?php echo $row['id_donhang']; ?></td>
                    <td>
                        <div class="fw-bold text-white"><?php echo $row['ten_nguoi_nhan']; ?></div>
                        <small class="text-secondary"><?php echo $row['so_dien_thoai']; ?></small>
                    </td>
                    <td>
                        <div class="small text-light" style="display: -webkit-box; line-clamp: 2; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?php echo $row['dia_chi_giao']; ?>
                        </div>
                    </td>
                    <td class="text-warning fw-bold">
                        <?php echo number_format($row['tong_tien'], 0, ',', '.'); ?>₫
                    </td>
                    <td class="small text-secondary">
                        <?php echo date('d/m/Y', strtotime($row['ngay_dat'])); ?><br>
                        <?php echo date('H:i', strtotime($row['ngay_dat'])); ?>
                    </td>
                    <td>
                        <?php 
                        switch($row['trang_thai']) {
                            case 0: 
                                echo '<span class="badge bg-danger">Chờ duyệt</span>';
                                break;
                            case 1: 
                                echo '<span class="badge bg-warning text-dark">Đang giao</span>';
                                break;
                            case 2: 
                                echo '<span class="badge bg-success">Hoàn thành</span>';
                                break;
                            case 3:
                                echo '<span class="badge bg-secondary">Đã hủy</span>';
                                break;
                            default:
                                echo '<span class="badge border border-secondary text-secondary">N/A</span>';
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <a href="?view=donhang&action=chitiet&id=<?php echo $row['id_donhang']; ?>" 
                           class="btn btn-sm btn-info fw-bold">
                           Chi tiết
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>