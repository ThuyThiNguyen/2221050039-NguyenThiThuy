<?php
include("connect.php");

if (isset($_POST['submit'])) {
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_DEFAULT);
    $ho_ten = $_POST['ho_ten'];
    $email = $_POST['email'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $id_quyen = $_POST['id_quyen'];

    mysqli_query($conn,
        "INSERT INTO nguoi_dung
        (ten_dang_nhap, mat_khau, ho_ten, email, so_dien_thoai, id_quyen)
        VALUES
        ('$ten_dang_nhap','$mat_khau','$ho_ten','$email','$so_dien_thoai',$id_quyen)"
    );

    header("Location: index.php?page_layout=nguoidung");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm người dùng</title>
<style>
body{
    font-family: Arial;
    background:#f5f5f5;
}
.container{
    width:500px;
    margin:50px auto;
    background:white;
    padding:20px;
    border-radius:8px;
}
h2{
    text-align:center;
}
input, select{
    width:100%;
    padding:8px;
    margin:5px 0 15px;
}
button{
    background:green;
    color:white;
    padding:10px;
    border:none;
    width:100%;
    border-radius:5px;
}
a{
    display:block;
    text-align:center;
    margin-top:10px;
}
</style>
</head>

<body>
<div class="container">
<h2>Thêm người dùng</h2>

<form method="post">
    <label>Tên đăng nhập</label>
    <input type="text" name="ten_dang_nhap" required>

    <label>Mật khẩu</label>
    <input type="password" name="mat_khau" required>

    <label>Họ tên</label>
    <input type="text" name="ho_ten">

    <label>Email</label>
    <input type="email" name="email">

    <label>Số điện thoại</label>
    <input type="text" name="so_dien_thoai">

    <label>Quyền</label>
    <select name="id_quyen">
        <?php
        $q = mysqli_query($conn,"SELECT * FROM quyen");
        while($r = mysqli_fetch_assoc($q)){
            echo "<option value='{$r['id']}'>{$r['ten_quyen']}</option>";
        }
        ?>
    </select>

    <button type="submit" name="submit">Thêm người dùng</button>
</form>

<a href="index.php?page_layout=nguoidung">⬅ Quay lại</a>
</div>
</body>
</html>
