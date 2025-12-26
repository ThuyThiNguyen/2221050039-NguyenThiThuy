<?php

// XỬ LÝ ĐĂNG NHẬP
if (isset($_POST['login'])) {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    $sql = "SELECT * FROM nguoi_dung 
            WHERE ten_dang_nhap='$user' 
            AND mat_khau='$pass' 
            LIMIT 1";

    $kq = mysqli_query($conn, $sql);

    if (mysqli_num_rows($kq) == 1) {
        $row = mysqli_fetch_assoc($kq);

        $_SESSION['user']  = $row['ten_dang_nhap'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['quyen'] = $row['id_quyen'];

        // PHÂN QUYỀN
        if ($row['id_quyen'] == 2) {
            header("Location: admin/index.php"); // ADMIN
        } else {
            header("Location: index.php"); // USER
        }
        exit();
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        form {
            width: 300px;
            margin: 100px auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form div {
            margin-bottom: 15px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 8px;
            background-color: #e53935;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #c62828;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<form method="post">
    <div class="form">
        <h1>Đăng nhập</h1>

        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>

        <div>
            <div>Tài khoản</div>
            <input type="text" name="username" required>
        </div>

        <div>
            <div>Mật khẩu</div>
            <input type="password" name="password" required>
            <a href="#">Quên mật khẩu</a>
        </div>

        <div>
            <input type="submit" name="login" value="Đăng nhập">
        </div>

        <div style="text-align:center">
            Bạn chưa có tài khoản? <a href="#">Đăng ký</a>
        </div>
    </div>
</form>

</body>
</html>
