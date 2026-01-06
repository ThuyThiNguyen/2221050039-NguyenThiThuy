<?php
include "connect.php";
// Lấy ID từ URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Lấy thông tin cũ
$sql_get = "SELECT * FROM danh_muc WHERE id = '$id'";
$result_get = mysqli_query($conn, $sql_get);
$danhMuc = mysqli_fetch_assoc($result_get);

// Xử lý cập nhật
$error_message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenDanhMuc = trim($_POST["ten-danh-muc"]);

    if (!empty($tenDanhMuc)) {
        $sql_update = "UPDATE `danh_muc` SET `ten_danh_muc`='$tenDanhMuc' WHERE id = '$id'";
        if (mysqli_query($conn, $sql_update)) {
            echo "<script>window.location.href='index.php?page_layout=qldanhmuc';</script>";
            exit();
        } else {
            $error_message = "Lỗi cập nhật: " . mysqli_error($conn);
        }
    } else {
        $error_message = "Tên danh mục không được để trống!";
    }
}
?>

<style>
    .form-container { max-width: 500px; margin: 30px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .form-title { text-align: center; margin-bottom: 25px; color: #333; font-size: 22px; font-weight: bold; }
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
    .form-control { width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; box-sizing: border-box; }
    .form-control:focus { border-color: #3b82f6; outline: none; }
    .btn-group { display: flex; gap: 10px; margin-top: 10px; }
    .btn { flex: 1; padding: 10px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; text-align: center; text-decoration: none; color: white; transition: 0.2s;}
    .btn-update { background-color: #d69e2e; } /* Màu vàng đậm */
    .btn-update:hover { background-color: #b7791f; }
    .btn-back { background-color: #718096; }
    .btn-back:hover { background-color: #4a5568; }
    .alert-error { color: #e53e3e; background: #fff5f5; padding: 10px; border: 1px solid #fed7d7; border-radius: 5px; margin-bottom: 15px; text-align: center;}
</style>

<div class="form-container">
    <h2 class="form-title">Cập Nhật Danh Mục</h2>

    <?php if (!empty($error_message)): ?>
        <div class="alert-error"><?= $error_message ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form-group">
            <label class="form-label">Tên danh mục</label>
            <input type="text" name="ten-danh-muc" class="form-control" 
                   value="<?= isset($danhMuc['ten_danh_muc']) ? $danhMuc['ten_danh_muc'] : '' ?>" 
                   placeholder="Nhập tên danh mục">
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-update">Cập nhật</button>
            <a href="index.php?page_layout=qldanhmuc" class="btn btn-back">Hủy bỏ</a>
        </div>
    </form>
</div>