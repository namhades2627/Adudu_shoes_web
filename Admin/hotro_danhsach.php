<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
if(isset($_POST['btnGuiAdmin'])) {
    $id_kh = (int)$_POST['id_kh'];
    $noidung = mysqli_real_escape_string($conn, $_POST['noidung']);
    if(trim($noidung) != "") {
        mysqli_query($conn, "INSERT INTO tbl_hotro (id_nguoidung, nguoi_gui, noi_dung) VALUES ($id_kh, 1, '$noidung')");
        echo "<script>window.location.href='index.php?view=hotro&id_kh=$id_kh';</script>";
        exit();
    }
}

$id_kh_active = isset($_GET['id_kh']) ? (int)$_GET['id_kh'] : 0;
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white fw-bold text-uppercase">Hỗ trợ Khách hàng</h3>
</div>

<div class="row g-0 rounded shadow overflow-hidden border border-secondary" style="height: 600px; background: #1a1a1d;">
    <div class="col-md-4 border-end border-secondary d-flex flex-column" style="height: 100%;">
        <div class="p-3 bg-dark text-warning fw-bold border-bottom border-secondary">
            <i class="fas fa-users me-2"></i> Danh sách cần hỗ trợ
        </div>
        <div class="overflow-auto flex-grow-1 p-2">
            <?php
            $sql_users = "SELECT nd.id_nguoidung, nd.ho_ten, MAX(ht.ngay_gui) as last_msg 
                          FROM tbl_hotro ht JOIN tbl_nguoidung nd ON ht.id_nguoidung = nd.id_nguoidung 
                          GROUP BY nd.id_nguoidung ORDER BY last_msg DESC";
            $res_users = mysqli_query($conn, $sql_users);

            if(mysqli_num_rows($res_users) > 0):
                while($user = mysqli_fetch_assoc($res_users)):
                    $active_class = ($user['id_nguoidung'] == $id_kh_active) ? 'bg-secondary bg-opacity-25 border-warning' : 'border-dark';
            ?>
                <a href="?view=hotro&id_kh=<?php echo $user['id_nguoidung']; ?>" class="d-block text-decoration-none text-white p-3 mb-2 rounded border <?php echo $active_class; ?> hover-bg-dark">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px;">
                            <?php echo substr($user['ho_ten'], 0, 1); ?>
                        </div>
                        <div>
                            <div class="fw-bold"><?php echo $user['ho_ten']; ?></div>
                            <div class="small text-secondary"><i class="far fa-clock me-1"></i><?php echo date('H:i d/m', strtotime($user['last_msg'])); ?></div>
                        </div>
                    </div>
                </a>
            <?php 
                endwhile;
            else:
            ?>
                <div class="text-center text-secondary mt-5 p-3">Chưa có tin nhắn nào.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-8 d-flex flex-column bg-dark" style="height: 100%;">
        <?php if($id_kh_active > 0): 
            $kh_info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ho_ten FROM tbl_nguoidung WHERE id_nguoidung = $id_kh_active"));
        ?>
            <div class="p-3 bg-black bg-opacity-50 text-white fw-bold border-bottom border-secondary d-flex align-items-center">
                <i class="fas fa-comments text-warning me-2 fs-5"></i> Đang hỗ trợ: <span class="text-warning ms-2"><?php echo $kh_info['ho_ten']; ?></span>
            </div>

            <div class="flex-grow-1 p-4 overflow-auto" id="adminChatBox" style="background: #121212;">
                <?php
                $sql_chat = "SELECT * FROM tbl_hotro WHERE id_nguoidung = $id_kh_active ORDER BY ngay_gui ASC";
                $res_chat = mysqli_query($conn, $sql_chat);
                while($chat = mysqli_fetch_assoc($res_chat)):
                    if($chat['nguoi_gui'] == 1): 
                ?>
                    <div class="d-flex justify-content-end mb-3">
                        <div class="p-3 rounded-3 text-white shadow-sm" style="background: #3a3a3e; max-width: 75%;">
                            <?php echo nl2br($chat['noi_dung']); ?>
                            <div class="text-end mt-1" style="font-size: 10px; color: #aaa;"><?php echo date('H:i d/m', strtotime($chat['ngay_gui'])); ?></div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="d-flex justify-content-start mb-3">
                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-2 flex-shrink-0 text-dark fw-bold" style="width: 35px; height: 35px;">KH</div>
                        <div class="p-3 rounded-3 text-dark shadow-sm" style="background: #ff6600; max-width: 75%;">
                            <?php echo nl2br($chat['noi_dung']); ?>
                            <div class="mt-1" style="font-size: 10px; color: #ffe6d5;"><?php echo date('H:i d/m', strtotime($chat['ngay_gui'])); ?></div>
                        </div>
                    </div>
                <?php 
                    endif;
                endwhile; 
                ?>
            </div>

            <div class="p-3 bg-black bg-opacity-50 border-top border-secondary">
                <form action="" method="POST" class="d-flex gap-2">
                    <input type="hidden" name="id_kh" value="<?php echo $id_kh_active; ?>">
                    <input type="text" name="noidung" class="form-control bg-transparent text-white border-secondary" placeholder="Nhập câu trả lời..." autocomplete="off" required>
                    <button type="submit" name="btnGuiAdmin" class="btn btn-warning px-4 fw-bold"><i class="fas fa-paper-plane"></i> Gửi</button>
                </form>
            </div>
            
            <script>
                var adminChatBox = document.getElementById("adminChatBox");
                adminChatBox.scrollTop = adminChatBox.scrollHeight;
            </script>

        <?php else: ?>
            <div class="d-flex align-items-center justify-content-center h-100 flex-column text-secondary">
                <i class="far fa-comments mb-3" style="font-size: 5rem;"></i>
                <h5>Chọn một khách hàng bên trái để bắt đầu hỗ trợ</h5>
            </div>
        <?php endif; ?>
    </div>
</div>