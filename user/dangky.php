<?php
// Kiểm tra session an toàn
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "connect.php";

$error = "";
$success = "";

if (isset($_POST['register'])) {
    $user = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $pass = trim($_POST['password']);
    $repass = trim($_POST['repassword']);
    $ho_ten = mysqli_real_escape_string($conn, trim($_POST['fullname']));
    $sdt = mysqli_real_escape_string($conn, trim($_POST['phone']));

    if ($pass != $repass) {
        $error = "Mật khẩu nhập lại không khớp!";
    } else {
        // Kiểm tra tài khoản/email đã tồn tại
        $check = mysqli_query($conn, "SELECT id FROM nguoi_dung WHERE ten_dang_nhap='$user' OR email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Tài khoản hoặc Email đã tồn tại!";
        } else {
            // Mã hóa mật khẩu
            $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
            $id_quyen = 1; // Mặc định là khách hàng

            $sql = "INSERT INTO nguoi_dung (ten_dang_nhap, mat_khau, ho_ten, email, so_dien_thoai, id_quyen) 
                    VALUES ('$user', '$pass_hash', '$ho_ten', '$email', '$sdt', '$id_quyen')";
            
            if (mysqli_query($conn, $sql)) {
                $success = "Đăng ký thành công! <a href='login.php'>Đăng nhập ngay</a>";
            } else {
                $error = "Lỗi hệ thống: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký thành viên</title>
    <style>
        /* CSS AN TOÀN - KHÔNG DÙNG BODY */
        .auth-container {
            width: 100%;
            max-width: 450px; /* Rộng hơn chút vì form dài */
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border: 1px solid #eee;
            font-family: Arial, sans-serif;
        }

        .auth-title { text-align: center; font-size: 24px; color: #333; margin-bottom: 25px; font-weight: bold; }
        
        .form-group { margin-bottom: 15px; }
        .form-label { display: block; margin-bottom: 5px; font-weight: 600; color: #555; font-size: 14px; }
        .form-input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .form-input:focus { border-color: #3b82f6; outline: none; }

        .btn-auth { width: 100%; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 16px; margin-top: 10px; }
        .btn-auth:hover { background-color: #218838; }

        .msg-error { background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 5px; text-align: center; margin-bottom: 15px; font-size: 14px; }
        .msg-success { background: #dcfce7; color: #166534; padding: 10px; border-radius: 5px; text-align: center; margin-bottom: 15px; font-size: 14px; }
        
        .auth-links { text-align: center; margin-top: 20px; font-size: 14px; }
        .auth-links a { color: #007bff; text-decoration: none; }
        .auth-links a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="auth-container">
        <h2 class="auth-title">Đăng Ký Thành Viên</h2>

        <?php if ($error) echo "<div class='msg-error'>$error</div>"; ?>
        <?php if ($success) echo "<div class='msg-success'>$success</div>"; ?>

        <form method="post">
            <div class="form-group">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="fullname" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" required>
            </div>
             <div class="form-group">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Nhập lại mật khẩu</label>
                <input type="password" name="repassword" class="form-input" required>
            </div>

            <button type="submit" name="register" class="btn-auth">ĐĂNG KÝ</button>

            <div class="auth-links">
                Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a>
            </div>
        </form>
    </div>

</body>
</html>