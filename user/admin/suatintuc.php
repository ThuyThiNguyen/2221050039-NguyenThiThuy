<?php
include "connect.php";
if(isset($_GET['id'])){
    $id_tt = $_GET['id'];
    $sql = "SELECT * FROM tintuc WHERE id_tt = $id_tt";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);
} else {
    echo "<script>window.location.href='index.php?page_layout=qltintuc';</script>";
    exit();
}

if (isset($_POST['sbm'])) {
    $tieu_de = mysqli_real_escape_string($conn, $_POST['tieu_de']);
    $mo_ta_ngan = mysqli_real_escape_string($conn, $_POST['mo_ta_ngan']);
    $noi_dung = mysqli_real_escape_string($conn, $_POST['noi_dung']);

    // Xử lý ảnh
    $anh_bia = $row['anh_bia']; // Mặc định là ảnh cũ
    if (!empty($_FILES['anh_bia']['name'])) {
        // Đã sửa đường dẫn upload
        $target_dir = "../../image/";
        
        $anh_moi = time() . "_" . basename($_FILES['anh_bia']['name']);
        if(move_uploaded_file($_FILES['anh_bia']['tmp_name'], $target_dir . $anh_moi)){
            $anh_bia = $anh_moi;
        }
    }

    $sql_update = "UPDATE tintuc SET 
        tieu_de = '$tieu_de', 
        anh_bia = '$anh_bia', 
        mo_ta_ngan = '$mo_ta_ngan', 
        noi_dung = '$noi_dung' 
        WHERE id_tt = $id_tt";

    if(mysqli_query($conn, $sql_update)){
        echo "<script>alert('Cập nhật thành công!'); window.location.href='index.php?page_layout=qltintuc';</script>";
        exit();
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
    .btn-submit { width: 100%; padding: 12px; background: #eab308; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; margin-top: 10px; }
    .btn-submit:hover { background: #ca8a04; }
    .img-preview { margin-top: 10px; border-radius: 5px; border: 1px solid #ddd; padding: 2px; width: 120px; }
</style>

<div class="form-box">
    <div class="form-title">Chỉnh Sửa Bài Viết</div>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Tiêu đề</label>
            <input type="text" name="tieu_de" required value="<?= $row['tieu_de'] ?>">
        </div>
        
        <div class="form-group">
            <label>Ảnh bìa</label>
            <input type="file" name="anh_bia">
            <?php if($row['anh_bia']) { ?>
                <img src="../../image/<?= $row['anh_bia'] ?>" class="img-preview">
            <?php } ?>
        </div>

        <div class="form-group">
            <label>Mô tả ngắn</label>
            <textarea name="mo_ta_ngan" rows="3"><?= $row['mo_ta_ngan'] ?></textarea>
        </div>

        <div class="form-group">
            <label>Nội dung chi tiết</label>
            <textarea name="noi_dung" id="editor1"><?= $row['noi_dung'] ?></textarea>
            <script>CKEDITOR.replace( 'editor1' );</script>
        </div>
        
        <button name="sbm" type="submit" class="btn-submit">Cập nhật bài viết</button>
    </form>
</div>