<?php
// Kết nối
if (!isset($conn)) include "connect.php";
$id = intval($_GET['id']);

// Lấy thông tin đơn hàng
$donhang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM don_hang WHERE id=$id"));

// Xử lý form submit
if(isset($_POST['submit'])){
    $id_trang_thai = intval($_POST['id_trang_thai']);
    
    if(mysqli_query($conn, "UPDATE don_hang SET id_trang_thai=$id_trang_thai WHERE id=$id")){
        echo "<script>alert('Cập nhật thành công!'); window.location.href='index.php?page_layout=donhang';</script>";
        exit();
    }
}
?>

<style>
    .update-box { max-width: 400px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
    .update-title { font-size: 18px; font-weight: bold; margin-bottom: 20px; color: #333; }
    select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; margin-bottom: 20px; }
    .btn-save { width: 100%; padding: 10px; background: #3b82f6; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; }
    .btn-save:hover { background: #2563eb; }
</style>

<div class="update-box">
    <div class="update-title">Cập nhật trạng thái đơn #<?= $id ?></div>

    <form method="post">
        <label style="display:block; margin-bottom:10px; text-align:left; font-weight:600; font-size:14px; color:#555;">Chọn trạng thái:</label>
        <select name="id_trang_thai">
            <?php
            $q = mysqli_query($conn,"SELECT * FROM trang_thai");
            while($r = mysqli_fetch_assoc($q)){
                $selected = ($r['id'] == $donhang['id_trang_thai']) ? "selected" : "";
                echo "<option value='{$r['id']}' $selected>{$r['ten_trang_thai']}</option>";
            }
            ?>
        </select>
        
        <button type="submit" name="submit" class="btn-save">Lưu thay đổi</button>
    </form>
    
    <a href="index.php?page_layout=donhang" style="display:block; margin-top:15px; font-size:13px; color:#666;">Quay lại</a>
</div>