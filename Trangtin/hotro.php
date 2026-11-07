<?php
session_start();
include '../Includes/connect_db.php';
/** @var mysqli $conn */

if(!isset($_SESSION['id_nguoidung'])) {
    echo "<script>alert('Vui lòng đăng nhập để chat với Admin!'); window.location.href='dangnhap.php';</script>";
    exit();
}

$id_nd = $_SESSION['id_nguoidung'];

if(isset($_POST['btnGui'])) {
    $noidung = mysqli_real_escape_string($conn, $_POST['noidung']);
    if(trim($noidung) != "") {
        mysqli_query($conn, "INSERT INTO tbl_hotro (id_nguoidung, nguoi_gui, noi_dung) VALUES ($id_nd, 0, '$noidung')");
        header("Location: hotro.php"); 
        exit();
    }
}

include '../Includes/header.php'; 
?>

<div class="container mt-5 mb-5" style="max-width: 800px;">
    <div class="card bg-dark border-secondary shadow-lg">
        <div class="card-header border-secondary bg-black bg-opacity-50 text-warning fw-bold py-3">
            <i class="fas fa-headset me-2"></i> TRUNG TÂM CHĂM SÓC KHÁCH HÀNG ADUDU
        </div>
        
        <div class="card-body p-4" id="chatBox" style="height: 450px; overflow-y: auto; background: #121212;">
            <div class="text-center mb-4">
                <span class="badge bg-secondary text-light">Nhân viên hỗ trợ sẽ phản hồi bạn trong giây lát</span>
            </div>

            <?php
            $sql_chat = "SELECT * FROM tbl_hotro WHERE id_nguoidung = $id_nd ORDER BY ngay_gui ASC";
            $res_chat = mysqli_query($conn, $sql_chat);
            
            while($chat = mysqli_fetch_assoc($res_chat)):
                if($chat['nguoi_gui'] == 0): 
            ?>
                <div class="d-flex justify-content-end mb-3">
                    <div class="p-3 rounded-3 text-dark shadow-sm" style="background: #ff6600; max-width: 75%;">
                        <?php echo nl2br($chat['noi_dung']); ?>
                        <div class="text-end mt-1" style="font-size: 10px; color: #ffe6d5;"><?php echo date('H:i d/m', strtotime($chat['ngay_gui'])); ?></div>
                    </div>
                </div>
            <?php else: ?>
                <div class="d-flex justify-content-start mb-3">
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 35px; height: 35px;">
                        <i class="fas fa-user-tie text-light"></i>
                    </div>
                    <div class="p-3 rounded-3 text-white shadow-sm" style="background: #2a2a2e; max-width: 75%;">
                        <?php echo nl2br($chat['noi_dung']); ?>
                        <div class="mt-1" style="font-size: 10px; color: #999;"><?php echo date('H:i d/m', strtotime($chat['ngay_gui'])); ?></div>
                    </div>
                </div>
            <?php 
                endif;
            endwhile; 
            ?>
        </div>

        <div class="card-footer border-secondary p-3 bg-black bg-opacity-50">
            <form action="" method="POST" class="d-flex gap-2">
                <input type="text" name="noidung" class="form-control bg-transparent text-white border-secondary" placeholder="Nhập tin nhắn..." autocomplete="off" required>
                <button type="submit" name="btnGui" class="btn btn-warning px-4 fw-bold"><i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</div>

<script>
    var chatBox = document.getElementById("chatBox");
    chatBox.scrollTop = chatBox.scrollHeight;
</script>

<?php include '../Includes/footer.php'; ?>