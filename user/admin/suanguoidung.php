<?php
include("connect.php");
$id = $_GET['id'];
$user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM nguoi_dung WHERE id=$id"));

if (isset($_POST['submit'])) {
    $ho_ten = mysqli_real_escape_string($conn, $_POST['ho_ten']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $so_dien_thoai = mysqli_real_escape_string($conn, $_POST['so_dien_thoai']);
    $id_quyen = $_POST['id_quyen'];

    // Xử lý mật khẩu: Chỉ cập nhật nếu ô mật khẩu không trống
    if (!empty($_POST['mat_khau'])) {
        $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_DEFAULT);
        $sql = "UPDATE nguoi_dung SET
                ho_ten='$ho_ten', email='$email', so_dien_thoai='$so_dien_thoai',
                id_quyen='$id_quyen', mat_khau='$mat_khau'
                WHERE id=$id";
    } else {
        $sql = "UPDATE nguoi_dung SET
                ho_ten='$ho_ten', email='$email', so_dien_thoai='$so_dien_thoai',
                id_quyen='$id_quyen'
                WHERE id=$id";
    }
    
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Cập nhật thành công!'); window.location.href='index.php?page_layout=nguoidung';</script>";
        exit();
    }
}
?>

<style>
    /* Dùng chung style với trang thêm */
    .form-box { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto; }
    .form-title { font-size: 20px; font-weight: bold; margin-bottom: 20px; color: #333; text-align: center; border-bottom: 1px solid #eee; padding-bottom: 10px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { margin-bottom: 15px; }
    label { display: block; margin-bottom: 5px; font-weight: 600; color: #555; font-size: 14px; }
    input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; box-sizing: border-box; }
    .btn-submit { width: 100%; padding: 12px; background: #eab308; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; margin-top: 10px; }
    .btn-submit:hover { background: #ca8a04; }
    input:disabled { background: #f3f4f6; color: #999; cursor: not-allowed; }
</style>

<div class="form-box">
    <div class="form-title">Cập nhật thông tin: <?= $user['ten_dang_nhap'] ?></div>

    <form method="post">
        <div class="form-grid">
            <div class="form-group">
                <label>Tên đăng nhập (Không thể sửa)</label>
                <input type="text" value="<?= $user['ten_dang_nhap'] ?>" disabled>
            </div>

            <div class="form-group">
                <label>Mật khẩu mới (Để trống nếu không đổi)</label>
                <input type="password" name="mat_khau" placeholder="Nhập để đổi pass...">
            </div>

            <div class="form-group">
                <label>Họ tên</label>
                <input type="text" name="ho_ten" value="<?= $user['ho_ten'] ?>">
            </div>

            <div class="form-group">
                <label>Quyền hạn</label>
                <select name="id_quyen">
                    <?php
                    $q = mysqli_query($conn,"SELECT * FROM quyen");
                    while($r = mysqli_fetch_assoc($q)){
                        $selected = ($r['id'] == $user['id_quyen']) ? "selected" : "";
                        echo "<option value='{$r['id']}' $selected>{$r['ten_quyen']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= $user['email'] ?>">
            </div>

            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="so_dien_thoai" value="<?= $user['so_dien_thoai'] ?>">
            </div>
        </div>

        <button type="submit" name="submit" class="btn-submit">Lưu thay đổi</button>
    </form>
</div>