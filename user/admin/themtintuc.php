<?php
if (isset($_POST['sbm'])) {
    $tieu_de = $_POST['tieu_de'];
    $anh_bia = $_FILES['anh_bia']['name'];
    $anh_bia_tmp = $_FILES['anh_bia']['tmp_name'];
    $mo_ta_ngan = $_POST['mo_ta_ngan'];
    $noi_dung = $_POST['noi_dung'];

    // Upload ảnh
    move_uploaded_file($anh_bia_tmp, 'img/' . $anh_bia);

    $sql = "INSERT INTO tintuc (tieu_de, anh_bia, mo_ta_ngan, noi_dung) 
            VALUES ('$tieu_de', '$anh_bia', '$mo_ta_ngan', '$noi_dung')";
    mysqli_query($conn, $sql);
    header('location: index.php?page_layout=qltintuc');
}
?>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<div class="container-fluid">
    <h2>Thêm bài khuyến mãi mới</h2>
    <form method="POST" enctype="multipart/form-data">
        <p>Tiêu đề:</p>
        <input type="text" name="tieu_de" required style="width: 100%;">
        
        <p>Ảnh bìa (Thumbnail bên ngoài):</p>
        <input type="file" name="anh_bia" required>

        <p>Mô tả ngắn:</p>
        <textarea name="mo_ta_ngan" style="width: 100%; height: 60px;"></textarea>

        <p>Nội dung chi tiết:</p>
        <textarea name="noi_dung" id="editor1"></textarea>
        <script>CKEDITOR.replace( 'editor1' );</script>
        
        <br>
        <button name="sbm" type="submit">Thêm mới</button>
    </form>
</div>