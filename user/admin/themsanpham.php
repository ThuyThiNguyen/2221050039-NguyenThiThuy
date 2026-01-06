<?php
include "connect.php";
$danh_muc = mysqli_query($conn, "SELECT * FROM danh_muc");
$loi = "";

if (isset($_POST['submit'])) {
    $ten = mysqli_real_escape_string($conn, $_POST['ten_san_pham']);
    $gia = $_POST['gia'];
    $so_luong = $_POST['so_luong'];
    $id_danh_muc = $_POST['id_danh_muc'];
    $mo_ta = mysqli_real_escape_string($conn, $_POST['mo_ta']);

    // Xử lý ảnh
    $hinh_anh = "";
    if (!empty($_FILES['hinh_anh']['name'])) {
        // Đường dẫn tính từ file index.php (Admin) ra thư mục image gốc
        $target_dir = "../../image/"; 
        $file_name = time() . "_" . basename($_FILES['hinh_anh']['name']);
        $target_file = $target_dir . $file_name;
        
        // Kiểm tra đuôi file
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if(in_array($fileType, ['jpg','jpeg','png','gif'])) {
            if(move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file)){
                $hinh_anh = $file_name;
            } else {
                $loi = "Lỗi upload ảnh (Check quyền thư mục).";
            }
        } else {
            $loi = "Chỉ chấp nhận file ảnh (jpg, png, gif).";
        }
    }

    if ($ten && $gia && $id_danh_muc && $loi == "") {
        $sql = "INSERT INTO san_pham (ten_san_pham, gia, so_luong, id_danh_muc, mo_ta, hinh_anh)
                VALUES ('$ten', '$gia', '$so_luong', '$id_danh_muc', '$mo_ta', '$hinh_anh')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>window.location.href='index.php?page_layout=qlspham';</script>";
            exit();
        } else {
            $loi = "Lỗi SQL: " . mysqli_error($conn);
        }
    } else {
        if($loi == "") $loi = "Vui lòng nhập đầy đủ thông tin!";
    }
}
?>

<style>
    .form-box { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto; }
    .form-title { font-size: 20px; font-weight: bold; margin-bottom: 20px; color: #333; text-align: center; border-bottom: 1px solid #eee; padding-bottom: 10px; }
    
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { margin-bottom: 15px; }
    .form-group.full { grid-column: span 2; }
    
    label { display: block; margin-bottom: 5px; font-weight: 600; color: #555; font-size: 14px; }
    input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; box-sizing: border-box; }
    input:focus, select:focus, textarea:focus { border-color: #3b82f6; outline: none; }
    
    .btn-submit { width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; margin-top: 10px; }
    .btn-submit:hover { background: #2563eb; }
    
    .error-msg { background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; border: 1px solid #fecaca; }
</style>

<div class="form-box">
    <div class="form-title">Thêm Sản Phẩm Mới</div>
    
    <?php if($loi != ""): ?>
        <div class="error-msg"><?= $loi ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-grid">
            <div class="form-group full">
                <label>Tên sản phẩm</label>
                <input type="text" name="ten_san_pham" placeholder="Nhập tên sản phẩm...">
            </div>

            <div class="form-group">
                <label>Danh mục</label>
                <select name="id_danh_muc">
                    <option value="">-- Chọn danh mục --</option>
                    <?php while ($dm = mysqli_fetch_assoc($danh_muc)) { ?>
                        <option value="<?= $dm['id'] ?>"><?= $dm['ten_danh_muc'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label>Hình ảnh</label>
                <input type="file" name="hinh_anh" style="padding: 7px;">
            </div>

            <div class="form-group">
                <label>Giá bán (VNĐ)</label>
                <input type="number" name="gia" placeholder="0">
            </div>

            <div class="form-group">
                <label>Số lượng kho</label>
                <input type="number" name="so_luong" value="1">
            </div>

            <div class="form-group full">
                <label>Mô tả chi tiết</label>
                <textarea name="mo_ta" rows="4" placeholder="Mô tả về sản phẩm..."></textarea>
            </div>
        </div>

        <button type="submit" name="submit" class="btn-submit">Lưu Sản Phẩm</button>
    </form>
</div>