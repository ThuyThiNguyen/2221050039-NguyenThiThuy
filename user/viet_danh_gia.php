<?php
$id_sp = intval($_GET['id_sp']);
$id_user = $_SESSION['user_id'];

// Xử lý khi khách hàng gửi form
if (isset($_POST['btn_gui_dg'])) {
    $so_sao = intval($_POST['so_sao']);
    $noi_dung = mysqli_real_escape_string($conn, $_POST['noi_dung']);

    // Lưu vào bảng danh_gia
    $sql_dg = "INSERT INTO danh_gia (id_nguoi_dung, id_san_pham, so_sao, noi_dung) 
               VALUES ($id_user, $id_sp, $so_sao, '$noi_dung')";
    
    if (mysqli_query($conn, $sql_dg)) {
        echo "<script>alert('Cảm ơn bạn đã đánh giá món ăn!'); location.href='index.php?page_layout=chitietsanpham&id=$id_sp';</script>";
        exit();
    }
}

// Lấy tên sản phẩm để hiển thị cho khách biết đang đánh giá món nào
$sp_info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ten_san_pham FROM san_pham WHERE id = $id_sp"));
?>

<div class="ls-wrapper" style="max-width: 600px;">
    <div class="ls-header">
        <h2>Viết đánh giá</h2>
        <p style="color:#777; font-size: 14px;">Đánh giá cho món: <strong><?= $sp_info['ten_san_pham'] ?></strong></p>
    </div>

    <form method="POST" style="background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 2px 15px rgba(0,0,0,0.1);">
        <div style="margin-bottom: 20px;">
            <label style="font-weight: bold; display: block; margin-bottom: 10px;">Bạn thấy món này thế nào?</label>
            <select name="so_sao" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                <option value="5">⭐⭐⭐⭐⭐ Tuyệt vời</option>
                <option value="4">⭐⭐⭐⭐ Ngon</option>
                <option value="3">⭐⭐⭐ Bình thường</option>
                <option value="2">⭐⭐ Tệ</option>
                <option value="1">⭐ Rất tệ</option>
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="font-weight: bold; display: block; margin-bottom: 10px;">Cảm nghĩ của bạn:</label>
            <textarea name="noi_dung" rows="6" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;" placeholder="Món ăn có vừa vị không, giao hàng có nhanh không?..." required></textarea>
        </div>

        <button type="submit" name="btn_gui_dg" style="width: 100%; padding: 15px; background: #e53935; color: #fff; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; text-transform: uppercase;">Gửi bình luận ngay</button>
        <a href="javascript:history.back()" style="display: block; text-align: center; margin-top: 15px; color: #888; text-decoration: none;">Bỏ qua</a>
    </form>
</div>