 <?php
include "connect.php";

/* Lấy danh mục */
$danh_muc = mysqli_query($conn, "SELECT * FROM danh_muc");

if (isset($_POST['submit'])) {
    $ten = trim($_POST['ten_san_pham']);
    $gia = trim($_POST['gia']);
    $so_luong = trim($_POST['so_luong']);
    $id_danh_muc = trim($_POST['id_danh_muc']);
    $mo_ta = trim($_POST['mo_ta']);

    /* Upload ảnh */
    $hinh_anh = "";

    if (!empty($_FILES['hinh_anh']['name'])) {

        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/2221050039/image/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $hinh_anh = time() . "_" . basename($_FILES['hinh_anh']['name']);
        $target_file = $target_dir . $hinh_anh;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!in_array($imageFileType, ['jpg','jpeg','png','gif'])) {
            $loi = "Chỉ cho phép JPG, JPEG, PNG, GIF";
        }elseif ($_FILES['hinh_anh']['size'] > 5000000) {
             $loi = "Ảnh quá lớn (tối đa 5MB)";
        } elseif (!move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file)) {
            $loi = "Upload ảnh thất bại";
        }
    }

  if ($ten && $gia && $id_danh_muc && !isset($loi)) {

    $sql = "INSERT INTO san_pham
            (ten_san_pham, gia, so_luong, id_danh_muc, mo_ta, hinh_anh)
            VALUES
            ('$ten', '$gia', '$so_luong', '$id_danh_muc', '$mo_ta', '$hinh_anh')";

    if (!mysqli_query($conn, $sql)) {
        die("SQL ERROR: " . mysqli_error($conn));
    }

    header("Location: index.php?page_layout=qlspham");
    exit();
}}

?>


<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm sản phẩm</title>
<style>
    p{font-weight:bold;margin:5px 0;}
    .container{
        border:1px solid black;
        border-radius:10px;
        width:35%;
        padding:20px;
        margin:50px auto;
    }
   input, select, textarea{
    width:100%;
    margin-bottom:10px;
    padding:5px;
    box-sizing: border-box;
}

    .warning{color:red;font-weight:bold;}
   


</style>
</head>
<body>

<div class="container">
<form method="post" enctype="multipart/form-data">
    <h1>Thêm sản phẩm</h1>

    <p>Tên sản phẩm</p>
    <input type="text" name="ten_san_pham">

    <p>Danh mục</p>
    <select name="id_danh_muc">
        <option value="">-- Chọn danh mục --</option>
        <?php while ($dm = mysqli_fetch_assoc($danh_muc)) { ?>
            <option value="<?= $dm['id'] ?>">
                <?= $dm['ten_danh_muc'] ?>
            </option>
        <?php } ?>
    </select>

    <p>Giá</p>
    <input type="number" name="gia">

    <p>Số lượng</p>
    <input type="number" name="so_luong">

    <p>Hình ảnh</p>
    <input type="file" name="hinh_anh">

    
    <p>Mô tả</p>
    <textarea name="mo_ta"></textarea>


    <input type="submit" name="submit" value="Lưu">

    <?php if (isset($loi)) echo "<p class='warning'>$loi</p>"; ?>
</form>
</div>

</body>
</html>
