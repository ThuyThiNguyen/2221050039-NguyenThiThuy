<?php
include "connect.php";
$id = $_GET['id'];
$sp = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM san_pham WHERE id = '$id'"));
$danh_muc = mysqli_query($conn, "SELECT * FROM danh_muc");
$loi = "";

if (isset($_POST['submit'])) {
    $ten = mysqli_real_escape_string($conn, $_POST['ten_san_pham']);
    $gia = $_POST['gia'];
    $so_luong = $_POST['so_luong'];
    $id_danh_muc = $_POST['id_danh_muc'];
    $mo_ta = mysqli_real_escape_string($conn, $_POST['mo_ta']);
    
    // Xử lý cột tickbox (Nếu bảng DB của bạn chưa có cột 'lua_chon_them' thì nhớ vào phpMyAdmin thêm nhé)
    $lua_chon_them = isset($_POST['lua_chon_them']) ? mysqli_real_escape_string($conn, $_POST['lua_chon_them']) : '';

    // Xử lý ảnh
    $hinh_anh = $sp['hinh_anh']; // Mặc định lấy ảnh cũ
    if (!empty($_FILES['hinh_anh']['name'])) {
        $target_dir = "../../image/";
        $file_name = time() . "_" . basename($_FILES['hinh_anh']['name']);
        
        // Upload
        if(move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_dir . $file_name)){
            $hinh_anh = $file_name; // Gán ảnh mới
        }
    }

    if ($ten && $gia) {
        $sql = "UPDATE san_pham SET 
                ten_san_pham='$ten', gia='$gia', so_luong='$so_luong', 
                id_danh_muc='$id_danh_muc', mo_ta='$mo_ta', 
                hinh_anh='$hinh_anh', lua_chon_them='$lua_chon_them' 
                WHERE id='$id'";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Cập nhật thành công!'); window.location.href='index.php?page_layout=qlspham';</script>";
            exit();
        } else {
            $loi = "Lỗi SQL: " . mysqli_error($conn);
        }
    } else {
        $loi = "Tên và giá không được để trống";
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
    .btn-submit { width: 100%; padding: 12px; background: #eab308; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; margin-top: 10px; }
    .btn-submit:hover { background: #ca8a04; }
    .img-preview { width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd; border-radius: 5px; margin-top: 5px; }
</style>

<div class="form-box">
    <div class="form-title">Chỉnh Sửa Sản Phẩm</div>
    
    <?php if($loi != "") echo "<div style='color:red; text-align:center; margin-bottom:10px;'>$loi</div>"; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-grid">
            <div class="form-group full">
                <label>Tên sản phẩm</label>
                <input type="text" name="ten_san_pham" value="<?= $sp['ten_san_pham'] ?>">
            </div>

            <div class="form-group">
                <label>Danh mục</label>
                <select name="id_danh_muc">
                    <?php while ($dm = mysqli_fetch_assoc($danh_muc)) { ?>
                        <option value="<?= $dm['id'] ?>" <?= ($dm['id'] == $sp['id_danh_muc']) ? 'selected' : '' ?>>
                            <?= $dm['ten_danh_muc'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label>Giá bán</label>
                <input type="number" name="gia" value="<?= $sp['gia'] ?>">
            </div>

            <div class="form-group">
                <label>Số lượng</label>
                <input type="number" name="so_luong" value="<?= $sp['so_luong'] ?>">
            </div>

            <div class="form-group">
                <label>Tùy chọn thêm (ngăn cách dấu phẩy)</label>
                <input type="text" name="lua_chon_them" value="<?= isset($sp['lua_chon_them']) ? $sp['lua_chon_them'] : '' ?>" placeholder="VD: Cay, Không cay...">
            </div>

            <div class="form-group full">
                <label>Hình ảnh</label>
                <input type="file" name="hinh_anh">
                <?php if($sp['hinh_anh']) echo "<img src='../../image/{$sp['hinh_anh']}' class='img-preview'>"; ?>
            </div>

            <div class="form-group full">
                <label>Mô tả</label>
                <textarea name="mo_ta" rows="4"><?= $sp['mo_ta'] ?></textarea>
            </div>
        </div>

        <button type="submit" name="submit" class="btn-submit">Cập Nhật Sản Phẩm</button>
    </form>
</div>