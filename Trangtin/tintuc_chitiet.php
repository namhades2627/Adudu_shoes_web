<?php 
include '../Includes/connect_db.php';
/** @var mysqli $conn */

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM tbl_tintuc WHERE id_tintuc = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: tintuc.php");
    exit();
}

include '../Includes/header.php'; 
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="tintuc.php" class="text-secondary text-decoration-none">Tin tức</a></li>
                    <li class="breadcrumb-item active text-warning" aria-current="page">Chi tiết bài viết</li>
                </ol>
            </nav>

            <h1 class="display-5 fw-bold mb-3" style="color: #ff6600; line-height: 1.2;">
                <?php echo $row['tieu_de']; ?>
            </h1>

            <div class="d-flex align-items-center text-secondary mb-4 pb-3 border-bottom border-secondary">
                <span class="me-4"><i class="fas fa-calendar-alt me-2"></i> Đăng ngày: <?php echo date('d/m/Y', strtotime($row['ngay_dang'])); ?></span>
                <span><i class="fas fa-user me-2"></i> Bởi: Admin ADUDU</span>
            </div>

            <div class="mb-5 shadow-lg" style="border-radius: 15px; overflow: hidden;">
                <img src="../Images/<?php echo $row['hinh_anh']; ?>" class="img-fluid w-100" alt="News Image" style="max-height: 500px; object-fit: cover;">
            </div>

            <div class="p-4 mb-5" style="background: #25252b; border-left: 5px solid #ff6600; border-radius: 0 10px 10px 0;">
                <p class="fst-italic mb-0" style="color: #eee; font-size: 1.2rem; line-height: 1.6;">
                    <?php echo $row['tom_tat']; ?>
                </p>
            </div>

            <article class="news-content-detail" style="color: #ccc; font-size: 1.1rem; line-height: 1.9; text-align: justify;">
                <?php echo $row['noi_dung']; ?>
            </article>

            <div class="mt-5 pt-5 border-top border-secondary d-flex justify-content-between align-items-center">
                <a href="tintuc.php" class="btn btn-outline-warning">
                    <i class="fas fa-chevron-left me-2"></i> Quay lại danh sách tin
                </a>
                <div class="social-share">
                    <span class="me-3 text-secondary">Chia sẻ:</span>
                    <a href="https://www.facebook.com/quan.ton.7549" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fas fa-link fa-lg"></i></a>
                </div>
            </div>

            <div class="mt-5 pt-4 border-top border-secondary">
                <h5 class="text-warning fw-bold pb-3"><i class="fas fa-comments me-2"></i> BÌNH LUẬN BÀI VIẾT</h5>
                
                <div class="card bg-dark border-secondary mb-4 shadow-sm">
                    <div class="card-body">
                        <?php if(isset($_SESSION['id_nguoidung'])): ?>
                            <form action="tintuc_binhluan_xuly.php" method="POST">
                                <input type="hidden" name="id_tintuc" value="<?php echo $id; ?>">
                                <div class="d-flex gap-3">
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                                        <i class="fas fa-user text-light fs-5"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <textarea name="noi_dung" class="form-control bg-transparent text-white border-secondary mb-2" rows="2" placeholder="Để lại bình luận của bạn về bài viết này..." required></textarea>
                                        <div class="text-end">
                                            <button type="submit" name="btnGuiBinhLuan" class="btn btn-warning btn-sm fw-bold px-4">GỬI BÌNH LUẬN</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="text-center py-3">
                                <p class="text-secondary mb-2">Vui lòng đăng nhập để tham gia bình luận.</p>
                                <a href="dangnhap.php" class="btn btn-outline-warning btn-sm px-4">ĐĂNG NHẬP</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php
                $id_tt_bl = $id; 
                $sql_bl = "SELECT bl.*, nd.ho_ten 
                           FROM tbl_binhluan_tintuc bl 
                           JOIN tbl_nguoidung nd ON bl.id_nguoidung = nd.id_nguoidung 
                           WHERE bl.id_tintuc = $id_tt_bl 
                           ORDER BY bl.id_binhluan DESC";
                $res_bl = mysqli_query($conn, $sql_bl);

                if($res_bl && mysqli_num_rows($res_bl) > 0):
                    while($row_bl = mysqli_fetch_assoc($res_bl)):
                ?>
                    <div class="d-flex gap-3 mb-3 pb-3 border-bottom border-dark position-relative">
                        <div id="noidung_bl_<?php echo $row_bl['id_binhluan']; ?>" class="d-none"><?php echo htmlspecialchars($row_bl['noi_dung']); ?></div>

                        <div class="rounded-circle bg-black d-flex align-items-center justify-content-center flex-shrink-0 border border-secondary" style="width: 40px; height: 40px;">
                            <i class="fas fa-user text-secondary"></i>
                        </div>
                        <div class="w-100">
                            <div class="mb-1">
                                <span class="fw-bold text-info me-2"><?php echo $row_bl['ho_ten']; ?></span>
                                <span class="text-secondary small" style="font-size: 12px;"><i class="far fa-clock me-1"></i><?php echo date('d/m/Y H:i', strtotime($row_bl['ngay_binhluan'])); ?></span>
                            </div>
                            <p class="mb-0 text-light pe-4" style="font-size: 14.5px;"><?php echo nl2br($row_bl['noi_dung']); ?></p>
                        </div>

                        <div class="dropdown position-absolute top-0 end-0">
                            <button class="btn btn-link text-secondary text-decoration-none p-0" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark shadow">
                                <?php if(isset($_SESSION['id_nguoidung'])): ?>
                                    <?php if($_SESSION['id_nguoidung'] == $row_bl['id_nguoidung']): ?>
                                        <li><a class="dropdown-item small" href="javascript:void(0)" onclick="openEditModal(<?php echo $row_bl['id_binhluan']; ?>)"><i class="fas fa-edit me-2"></i>Sửa bình luận</a></li>
                                        <li><a class="dropdown-item text-danger small" href="tintuc_binhluan_xuly.php?action=xoa&id_bl=<?php echo $row_bl['id_binhluan']; ?>&id_tt=<?php echo $id; ?>" onclick="return confirm('Bạn có chắc muốn xóa bình luận này?');"><i class="fas fa-trash-alt me-2"></i>Xóa</a></li>
                                    <?php else: ?>
                                        <li><a class="dropdown-item text-warning small" href="javascript:void(0)" onclick="openReportModal(<?php echo $row_bl['id_binhluan']; ?>)"><i class="fas fa-flag me-2"></i>Báo cáo</a></li>
                                    <?php endif; ?>
                                    
                                    <?php if(isset($_SESSION['quyen']) && $_SESSION['quyen'] == 1 && $_SESSION['id_nguoidung'] != $row_bl['id_nguoidung']): ?>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger small" href="tintuc_binhluan_xuly.php?action=xoa&id_bl=<?php echo $row_bl['id_binhluan']; ?>&id_tt=<?php echo $id; ?>" onclick="return confirm('ADMIN: Xác nhận xóa bình luận vi phạm này?');"><i class="fas fa-shield-alt me-2"></i>Xóa (Quyền Admin)</a></li>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <li><a class="dropdown-item small text-muted" href="dangnhap.php">Đăng nhập để thao tác</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                <?php 
                    endwhile;
                else: 
                ?>
                    <div class="text-center py-4">
                        <p class="text-secondary fst-italic mb-0">Chưa có bình luận nào. Hãy là người đầu tiên chia sẻ ý kiến nhé!</p>
                    </div>
                <?php endif; ?>

                <div class="modal fade" id="reportModal" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-white border-secondary">
                      <div class="modal-header border-secondary">
                        <h5 class="modal-title text-warning fw-bold"><i class="fas fa-flag me-2"></i>Báo cáo bình luận</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="tintuc_binhluan_xuly.php" method="GET">
                        <div class="modal-body">
                          <input type="hidden" name="action" value="baocao">
                          <input type="hidden" name="id_tt" value="<?php echo $id; ?>">
                          <input type="hidden" name="id_bl" id="report_id_bl" value="">
                          <div class="mb-3">
                            <label class="form-label small text-secondary">Vui lòng cho biết lý do bạn báo cáo bình luận này:</label>
                            <textarea name="lydo" class="form-control bg-transparent text-white border-secondary" rows="3" placeholder="Ví dụ: Nội dung spam, chửi thề, lừa đảo..." required></textarea>
                          </div>
                        </div>
                        <div class="modal-footer border-secondary">
                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                          <button type="submit" class="btn btn-warning fw-bold">Gửi Báo Cáo</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-white border-secondary">
                      <div class="modal-header border-secondary">
                        <h5 class="modal-title text-info fw-bold"><i class="fas fa-edit me-2"></i>Chỉnh sửa bình luận</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="tintuc_binhluan_xuly.php" method="GET">
                        <div class="modal-body">
                          <input type="hidden" name="action" value="sua">
                          <input type="hidden" name="id_tt" value="<?php echo $id; ?>">
                          <input type="hidden" name="id_bl" id="edit_id_bl" value="">
                          <div class="mb-3">
                            <textarea name="noidung" id="edit_noidung" class="form-control bg-transparent text-white border-secondary" rows="4" required></textarea>
                          </div>
                        </div>
                        <div class="modal-footer border-secondary">
                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                          <button type="submit" class="btn btn-info fw-bold text-dark">Lưu Thay Đổi</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <script>
                function openReportModal(id_bl) {
                    document.getElementById('report_id_bl').value = id_bl;
                    var reportModal = new bootstrap.Modal(document.getElementById('reportModal'));
                    reportModal.show();
                }

                function openEditModal(id_bl) {
                    let noidungCu = document.getElementById('noidung_bl_' + id_bl).innerText;
                    document.getElementById('edit_id_bl').value = id_bl;
                    document.getElementById('edit_noidung').value = noidungCu;
                    var editModal = new bootstrap.Modal(document.getElementById('editModal'));
                    editModal.show();
                }
                </script>

            </div>
            </div>
    </div>
</div>

<?php include '../Includes/footer.php'; ?>