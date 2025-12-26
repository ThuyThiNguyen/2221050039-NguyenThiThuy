<?php
include "connect.php";

// 1. Lấy ID bài viết từ đường dẫn URL
if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    // 2. Lấy nội dung bài viết đó
    $sql = "SELECT * FROM tintuc WHERE id_tt = $id";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
}
?>

<div class="detail-container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <h1><?php echo $row['tieu_de']; ?></h1>

    <p style="color: #999;">Ngày đăng: <?php echo $row['ngay_dang']; ?></p>
     <img src="/2221050039/image/<?php echo $row['anh_bia']; ?>" style="width: 100%; object-fit: cover;">
    
    <hr>
    
    <div class="content">
        <?php echo $row['noi_dung']; ?>
    </div>
</div>