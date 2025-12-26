<?php
include "connect.php";
if (!isset($_GET['id'])) {
    header("Location: index.php?page_layout=qlspham");
    exit();
}

$id = $_GET['id'];

/* Lấy sản phẩm */
$sql = "SELECT * FROM san_pham WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$sp = mysqli_fetch_assoc($result);

if (!$sp) {
    echo "Sản phẩm không tồn tại";
    exit();
}

/* Lấy danh mục */
$danh_muc = mysqli_query($conn, "SELECT * FROM danh_muc");

/* Cập nhật */
if (isset($_POST['submit'])) {
    $ten = $_POST['ten_san_pham'];
    $gia = $_POST['gia'];
    $so_luong = $_POST['so_luong'];
    $id_danh_muc = $_POST['id_danh_muc'];
    $mo_ta = $_POST['mo_ta'];
    
    // MỚI: Lấy nội dung cho tickbox
    $lua_chon_them = $_POST['lua_chon_them']; 

    /* Ảnh */
    $hinh_anh = $sp['hinh_anh'];

    if (!empty($_FILES['hinh_anh']['name'])) {
        $target_dir = "../../image/";
        $hinh_anh_moi = time() . "_" . $_FILES['hinh_anh']['name'];
        $target_file = $target_dir . $hinh_anh_moi;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!in_array($imageFileType, ['jpg','jpeg','png','gif'])) {
            $loi = "Chỉ cho phép JPG, JPEG, PNG, GIF";
        } elseif ($_FILES['hinh_anh']['size'] > 500000) {
            $loi = "Ảnh quá lớn";
        } else {
            move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file);
            if ($hinh_anh && file_exists($target_dir . $hinh_anh)) {
                unlink($target_dir . $hinh_anh);
            }
            $hinh_anh = $hinh_anh_moi;
        }
    }

    if ($ten && $gia && $id_danh_muc && !isset($loi)) {
        // MỚI: Cập nhật thêm cột lua_chon_them vào SQL
        $sql = "UPDATE san_pham SET
                ten_san_pham='$ten',
                gia='$gia',
                so_luong='$so_luong',
                id_danh_muc='$id_danh_muc',
                mo_ta='$mo_ta',
                hinh_anh='$hinh_anh',
                lua_chon_them='$lua_chon_them' 
                WHERE id='$id'";
        mysqli_query($conn, $sql);

        header("Location: index.php?page_layout=qlspham");
        exit();
    } else {
        if (!isset($loi)) $loi = "Vui lòng nhập đầy đủ thông tin";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sửa sản phẩm</title>
<style>
.container{ width:40%; margin:40px auto; border:1px solid #000; border-radius:10px; padding:20px; font-family: Arial;}
input, select, textarea{ width:100%; padding:8px; margin-bottom:10px; box-sizing: border-box;}
.warning{color:red;font-weight:bold;}
img{margin-bottom:10px; display: block;}
.note{font-size: 12px; color: #666; margin-top: -8px; margin-bottom: 10px;}
</style>
</head>
<body>

<div class="container">
<form method="post" enctype="multipart/form-data">
    <h2>Sửa sản phẩm</h2>

    <p>Tên sản phẩm</p>
    <input type="text" name="ten_san_pham" value="<?= $sp['ten_san_pham'] ?>">

    <p><b>Nội dung các Tickbox (Lựa chọn thêm)</b></p>
    <input type="text" name="lua_chon_them" value="<?= isset($sp['lua_chon_them']) ? $sp['lua_chon_them'] : '' ?>" placeholder="Ví dụ: Phô mai, Cay nồng, Rong biển">
    <p class="note">Nhập các lựa chọn cách nhau bởi dấu phẩy (,)</p>

    <p>Danh mục</p>
    <select name="id_danh_muc">
        <?php while ($dm = mysqli_fetch_assoc($danh_muc)) { ?>
            <option value="<?= $dm['id'] ?>"
                <?= ($dm['id'] == $sp['id_danh_muc']) ? 'selected' : '' ?>>
                <?= $dm['ten_danh_muc'] ?>
            </option>
        <?php } ?>
    </select>

    <p>Giá</p>
    <input type="number" name="gia" value="<?= $sp['gia'] ?>">

    <p>Số lượng</p>
    <input type="number" name="so_luong" value="<?= $sp['so_luong'] ?>">

    <p>Ảnh hiện tại</p>
    <?php if ($sp['hinh_anh']) { ?>
        <img src="../../image/<?= $sp['hinh_anh'] ?>" width="120">
    <?php } else { ?>
        <p>Không có ảnh</p>
    <?php } ?>

    <p>Đổi ảnh mới (nếu có)</p>
    <input type="file" name="hinh_anh">

    <p>Mô tả</p>
    <textarea name="mo_ta"><?= $sp['mo_ta'] ?></textarea>

    <input type="submit" name="submit" value="Cập nhật" style="background: #e53935; color: #fff; cursor: pointer; border: none; font-weight: bold; padding: 12px;">

    <?php if (isset($loi)) echo "<p class='warning'>$loi</p>"; ?>
</form>
</div>

</body>
</html>