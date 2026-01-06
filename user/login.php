<?php
include "connect.php"; 
$error = "";

// 2. XỬ LÝ ĐĂNG NHẬP
if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, trim($_POST['username']));
    $pass = trim($_POST['password']);

    $sql = "SELECT * FROM nguoi_dung WHERE ten_dang_nhap='$user' LIMIT 1";
    $kq = mysqli_query($conn, $sql);

    if (mysqli_num_rows($kq) == 1) {
        $row = mysqli_fetch_assoc($kq);

        // Kiểm tra mật khẩu (Hỗ trợ cả cũ và mới)
        $checkParams = false;
        if (strlen($row['mat_khau']) >= 60 && password_verify($pass, $row['mat_khau'])) {
             $checkParams = true;
        } elseif ($pass == $row['mat_khau']) {
             $checkParams = true;
        }

        if ($checkParams) {
            $_SESSION['user'] = $row['ten_dang_nhap'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['quyen'] = $row['id_quyen'];
            $_SESSION['ho_ten'] = $row['ho_ten'];

            if ($row['id_quyen'] == 2) {
                header("Location: admin/index.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Mật khẩu không đúng!";
        }
    } else {
        $error = "Tài khoản không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <style>
        /* CSS KHÔNG DÙNG BODY - AN TOÀN KHI NHÚNG */
        .login-container {
            width: 100%;
            max-width: 400px;
            margin: 60px auto; /* Căn giữa và cách top 60px */
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border: 1px solid #eee;
            font-family: Arial, sans-serif;
        }

        .login-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box; /* Quan trọng để không bị vỡ khung */
            transition: 0.3s;
        }

        .form-input:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 5px rgba(59, 130, 246, 0.2);
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #d32f2f;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background-color: #b71c1c;
        }

        .error-box {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
            font-size: 14px;
        }

        .extra-links {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            font-size: 13px;
        }

        .extra-links a {
            text-decoration: none;
            color: #2563eb;
        }
        .extra-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2 class="login-title">Đăng Nhập</h2>

        <?php if ($error != "") { ?>
            <div class="error-box"><?= $error ?></div>
        <?php } ?>

        <form method="post">
            <div class="form-group">
                <label class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" class="form-input" placeholder="Nhập tài khoản..." required>
            </div>

            <div class="form-group">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-input" placeholder="Nhập mật khẩu..." required>
            </div>

            <button type="submit" name="login" class="btn-submit">ĐĂNG NHẬP</button>

            <div class="extra-links">
                <a href="dangky.php">Đăng ký tài khoản mới?</a>
                <a href="quenmatkhau.php">Quên mật khẩu?</a>
            </div>
        </form>
    </div>

</body>
</html>