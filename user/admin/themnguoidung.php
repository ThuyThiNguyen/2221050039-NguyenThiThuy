<?php
include "connect.php";

$loi = "";
if (isset($_POST['submit'])) {
    $ten_dang_nhap = mysqli_real_escape_string($conn, $_POST['ten_dang_nhap']);
    $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_DEFAULT); // Mã hóa mật khẩu
    $ho_ten = mysqli_real_escape_string($conn, $_POST['ho_ten']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $so_dien_thoai = mysqli_real_escape_string($conn, $_POST['so_dien_thoai']);
    $id_quyen = $_POST['id_quyen'];

    // Kiểm tra trùng tên đăng nhập
    $check = mysqli_query($conn, "SELECT * FROM nguoi_dung WHERE ten_dang_nhap = '$ten_dang_nhap'");
    
    if (mysqli_num_rows($check) > 0) {
        $loi = "Tên đăng nhập đã tồn tại!";
    } else {
        $sql = "INSERT INTO nguoi_dung (ten_dang_nhap, mat_khau, ho_ten, email, so_dien_thoai, id_quyen)
                VALUES ('$ten_dang_nhap','$mat_khau','$ho_ten','$email','$so_dien_thoai','$id_quyen')";
        
        if(mysqli_query($conn, $sql)){
            echo "<script>alert('Thêm thành công!'); window.location.href='index.php?page_layout=nguoidung';</script>";
            exit();
        } else {
            $loi = "Lỗi SQL: " . mysqli_error($conn);
        }
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
    input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; box-sizing: border-box; }
    .btn-submit { width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; margin-top: 10px; }
    .btn-submit:hover { background: #2563eb; }
    .error-msg { color: red; text-align: center; margin-bottom: 15px; }
</style>

<div class="form-box">
    <div class="form-title">Thêm Người Dùng Mới</div>
    <?php if($loi) echo "<p class='error-msg'>$loi</p>"; ?>

    <form method="post">
        <div class="form-grid">
            <div class="form-group">
                <label>Tên đăng nhập (*)</label>
                <input type="text" name="ten_dang_nhap" required placeholder="VD: admin123">
            </div>

            <div class="form-group">
                <label>Mật khẩu (*)</label>
                <input type="password" name="mat_khau" required placeholder="******">
            </div>

            <div class="form-group">
                <label>Họ và tên</label>
                <input type="text" name="ho_ten" placeholder="VD: Nguyễn Văn A">
            </div>

            <div class="form-group">
                <label>Quyền hạn</label>
                <select name="id_quyen">
                    <?php
                    $q = mysqli_query($conn,"SELECT * FROM quyen");
                    while($r = mysqli_fetch_assoc($q)){
                        echo "<option value='{$r['id']}'>{$r['ten_quyen']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="email@example.com">
            </div>

            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="so_dien_thoai" placeholder="09xxxxxxxx">
            </div>
        </div>

        <button type="submit" name="submit" class="btn-submit">Thêm người dùng</button>
    </form>
</div>