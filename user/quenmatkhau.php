<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "connect.php";

$error = "";
$success = "";

if (isset($_POST['reset'])) {
    $user = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $new_pass = trim($_POST['new_pass']);

    // Kiểm tra khớp thông tin
    $check = mysqli_query($conn, "SELECT id FROM nguoi_dung WHERE ten_dang_nhap='$user' AND email='$email'");
    
    if (mysqli_num_rows($check) == 1) {
        $pass_hash = password_hash($new_pass, PASSWORD_DEFAULT);
        
        $sql = "UPDATE nguoi_dung SET mat_khau='$pass_hash' WHERE ten_dang_nhap='$user'";
        if (mysqli_query($conn, $sql)) {
            $success = "Đổi mật khẩu thành công! <a href='login.php'>Đăng nhập lại</a>";
        } else {
            $error = "Lỗi hệ thống!";
        }
    } else {
        $error = "Tên đăng nhập hoặc Email không đúng!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu</title>
    <style>
        /* Tận dụng lại CSS của đăng ký/đăng nhập */
        .auth-container {
            width: 100%; max-width: 400px; margin: 60px auto;
            background: #fff; padding: 30px; border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1); border: 1px solid #eee;
            font-family: Arial, sans-serif;
        }
        .auth-title { text-align: center; font-size: 24px; color: #333; margin-bottom: 25px; font-weight: bold; }
        .form-group { margin-bottom: 15px; }
        .form-label { display: block; margin-bottom: 5px; font-weight: 600; color: #555; font-size: 14px; }
        .form-input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .btn-auth { width: 100%; padding: 12px; background-color: #ff9800; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 16px; margin-top: 10px; }
        .btn-auth:hover { background-color: #e68900; }
        .msg-error { background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 5px; text-align: center; margin-bottom: 15px; }
        .msg-success { background: #dcfce7; color: #166534; padding: 10px; border-radius: 5px; text-align: center; margin-bottom: 15px; }
        .auth-links { text-align: center; margin-top: 20px; font-size: 14px; }
        .auth-links a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

    <div class="auth-container">
        <h2 class="auth-title">Lấy Lại Mật Khẩu</h2>

        <?php if ($error) echo "<div class='msg-error'>$error</div>"; ?>
        <?php if ($success) echo "<div class='msg-success'>$success</div>"; ?>

        <form method="post">
            <div class="form-group">
                <label class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email đăng ký</label>
                <input type="email" name="email" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Nhập mật khẩu mới</label>
                <input type="password" name="new_pass" class="form-input" required>
            </div>

            <button type="submit" name="reset" class="btn-auth">ĐỔI MẬT KHẨU</button>

            <div class="auth-links">
                <a href="login.php">Quay lại trang Đăng nhập</a>
            </div>
        </form>
    </div>

</body>
</html>