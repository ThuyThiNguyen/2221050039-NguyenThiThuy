<?php
include "connect.php";

$loi = "";
if (isset($_POST['sbm'])) {
    $tieu_de = mysqli_real_escape_string($conn, $_POST['tieu_de']);
    $mo_ta_ngan = mysqli_real_escape_string($conn, $_POST['mo_ta_ngan']);
    $noi_dung = mysqli_real_escape_string($conn, $_POST['noi_dung']);
    
    // Xử lý ảnh
    $anh_bia = "";
    if (!empty($_FILES['anh_bia']['name'])) {
        // Đã sửa lại đường dẫn upload
        $target_dir = "../../image/"; 
        
        $anh_bia = time() . "_" . basename($_FILES['anh_bia']['name']);
        
        // Kiểm tra xem thư mục có tồn tại không, nếu không thì tạo (để tránh lỗi)
        if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
        
        move_uploaded_file($_FILES['anh_bia']['tmp_name'], $target_dir . $anh_bia);
    }

    if ($tieu_de) {
        $sql = "INSERT INTO tintuc (tieu_de, anh_bia, mo_ta_ngan, noi_dung) 
                VALUES ('$tieu_de', '$anh_bia', '$mo_ta_ngan', '$noi_dung')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>window.location.href='index.php?page_layout=qltintuc';</script>";
            exit();
        } else {
            $loi = "Lỗi SQL: " . mysqli_error($conn);
        }
    } else {
        $loi = "Vui lòng nhập tiêu đề!";
    }
}
?>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<style>
    .form-box { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); max-width: 900px; margin: 0 auto; }
    .form-title { font-size: 20px; font-weight: bold; margin-bottom: 20px; color: #333; text-align: center; border-bottom: 1px solid #eee; padding-bottom: 10px; }
    .form-group { margin-bottom: 15px; }
    label { display: block; margin-bottom: 5px; font-weight: 600; color: #555; font-size: 14px; }
    input[type="text"], input[type="file"], textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; box-sizing: border-box; }
    .btn-submit { width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; margin-top: 10px; }
    .btn-submit:hover { background: #2563eb; }
    .error-msg { color: red; text-align: center; margin-bottom: 15px; }
</style>

<div class="form-box">
    <div class="form-title">Thêm Bài Viết / Khuyến Mãi</div>
    <?php if($loi) echo "<p class='error-msg'>$loi</p>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Tiêu đề bài viết</label>
            <input type="text" name="tieu_de" placeholder="Nhập tiêu đề..." required>
        </div>
        
        <div class="form-group">
            <label>Ảnh bìa</label>
            <input type="file" name="anh_bia" required>
        </div>

        <div class="form-group">
            <label>Mô tả ngắn</label>
            <textarea name="mo_ta_ngan" rows="3" placeholder="Tóm tắt nội dung..."></textarea>
        </div>

        <div class="form-group">
            <label>Nội dung chi tiết</label>
            <textarea name="noi_dung" id="editor1"></textarea>
            <script>CKEDITOR.replace( 'editor1' );</script>
        </div>
        
        <button name="sbm" type="submit" class="btn-submit">Đăng bài</button>
    </form>
</div>