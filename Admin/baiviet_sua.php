<?php
require_once __DIR__ . '/auth_guard.php';
/** @var mysqli $conn */
$id = $_GET['id'];
$sql = "SELECT * FROM tbl_tintuc WHERE id_tintuc = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<div class="mb-4">
    <h3 class="text-white fw-bold text-uppercase">CHỈNH SỬA BÀI VIẾT</h3>
</div>

<div class="card bg-dark border-secondary shadow">
    <div class="card-body p-4">
        <form action="baiviet_sua_xuly.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_tintuc" value="<?php echo $row['id_tintuc']; ?>">
            
            <div class="mb-3">
                <label class="form-label text-secondary small fw-bold">TIÊU ĐỀ BÀI VIẾT</label>
                <input type="text" name="tieu_de" class="form-control bg-dark text-white border-secondary" value="<?php echo $row['tieu_de']; ?>" required>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label text-secondary small fw-bold d-block">ẢNH HIỆN TẠI</label>
                <img src="../Images/news/<?php echo $row['hinh_anh']; ?>" width="150" class="mb-2 rounded border border-secondary">
                <input type="file" name="hinh_anh" class="form-control bg-dark text-white border-secondary">
                <input type="hidden" name="hinh_anh_old" value="<?php echo $row['hinh_anh']; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary small fw-bold">TÓM TẮT NGẮN</label>
                <textarea name="tom_tat" class="form-control bg-dark text-white border-secondary" rows="2"><?php echo $row['tom_tat']; ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label text-secondary small fw-bold">NỘI DUNG CHI TIẾT</label>
                <textarea name="noi_dung" id="editor_sua_baiviet" class="form-control"><?php echo $row['noi_dung']; ?></textarea>
            </div>

            <button type="submit" name="btnSuaBV" class="btn btn-warning fw-bold px-4">LƯU THAY ĐỔI</button>
            <a href="?view=baiviet" class="btn btn-outline-secondary px-4 ms-2">HỦY</a>
        </form>
    </div>
</div>

<script>
    CKEDITOR.replace('editor_sua_baiviet');
</script>