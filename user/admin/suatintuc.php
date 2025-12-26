<?php
// 1. Lấy ID bài viết cần sửa từ URL
if(isset($_GET['id'])){
    $id_tt = $_GET['id'];
} else {
    // Nếu không có ID thì quay về trang danh sách (tránh lỗi)
    header('location: index.php?page_layout=qltintuc');
}

// 2. Lấy thông tin cũ của bài viết đó ra để hiển thị vào form
$sql = "SELECT * FROM tintuc WHERE id_tt = $id_tt";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);

// 3. Xử lý khi người dùng nhấn nút Cập nhật
if (isset($_POST['sbm'])) {
    $tieu_de = $_POST['tieu_de'];
    $mo_ta_ngan = $_POST['mo_ta_ngan'];
    $noi_dung = $_POST['noi_dung'];

    // Xử lý LOGIC ẢNH:
    // Nếu người dùng có chọn file ảnh mới
    if ($_FILES['anh_bia']['name'] != "") {
        $anh_bia = $_FILES['anh_bia']['name'];
        $anh_bia_tmp = $_FILES['anh_bia']['tmp_name'];
        move_uploaded_file($anh_bia_tmp, 'img/' . $anh_bia);
    } 
    // Nếu người dùng KHÔNG chọn ảnh mới -> Giữ nguyên tên ảnh cũ
    else {
        $anh_bia = $row['anh_bia'];
    }

    // Câu lệnh Update
    $sql_update = "UPDATE tintuc SET 
        tieu_de = '$tieu_de', 
        anh_bia = '$anh_bia', 
        mo_ta_ngan = '$mo_ta_ngan', 
        noi_dung = '$noi_dung' 
        WHERE id_tt = $id_tt";

    mysqli_query($conn, $sql_update);
    
    // Sửa xong thì quay về trang danh sách
    header('location: index.php?page_layout=qltintuc');
}
?>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<div class="container-fluid">
    <h2>Sửa bài viết: <?php echo $row['tieu_de']; ?></h2>
    
    <form method="POST" enctype="multipart/form-data">
        
        <p><b>Tiêu đề:</b></p>
        <input type="text" name="tieu_de" required style="width: 100%;" value="<?php echo $row['tieu_de']; ?>">
        
        <p><b>Ảnh bìa hiện tại:</b></p>
        <img src="img/<?php echo $row['anh_bia']; ?>" width="150px">
        
        <p><b>Chọn ảnh mới (Nếu muốn thay đổi):</b></p>
        <input type="file" name="anh_bia">

        <p><b>Mô tả ngắn:</b></p>
        <textarea name="mo_ta_ngan" style="width: 100%; height: 60px;"><?php echo $row['mo_ta_ngan']; ?></textarea>

        <p><b>Nội dung chi tiết:</b></p>
        <textarea name="noi_dung" id="editor1"><?php echo $row['noi_dung']; ?></textarea>
        
        <script>CKEDITOR.replace( 'editor1' );</script>
        
        <br><br>
        <button name="sbm" type="submit" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer;">Cập nhật</button>
        <a href="index.php?page_layout=qltintuc" style="margin-left: 10px; text-decoration: none; color: black;">Hủy bỏ</a>
    </form>
</div>