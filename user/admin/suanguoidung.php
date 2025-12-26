<?php
include("connect.php");
$id = $_GET['id'];

$user = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM nguoi_dung WHERE id=$id")
);

if (isset($_POST['submit'])) {
    $ho_ten = $_POST['ho_ten'];
    $email = $_POST['email'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $id_quyen = $_POST['id_quyen'];

    if ($_POST['mat_khau'] != "") {
        $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_DEFAULT);
        $sql = "UPDATE nguoi_dung SET
                ho_ten='$ho_ten',
                email='$email',
                so_dien_thoai='$so_dien_thoai',
                id_quyen=$id_quyen,
                mat_khau='$mat_khau'
                WHERE id=$id";
    } else {
        $sql = "UPDATE nguoi_dung SET
                ho_ten='$ho_ten',
                email='$email',
                so_dien_thoai='$so_dien_thoai',
                id_quyen=$id_quyen
                WHERE id=$id";
    }
    mysqli_query($conn,$sql);
    header("Location: index.php?page_layout=nguoidung");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sửa người dùng</title>
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
    background:orange;
    color:black;
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
<h2>Sửa người dùng</h2>

<form method="post">
    <label>Tên đăng nhập</label>
    <input type="text" value="<?= $user['ten_dang_nhap'] ?>" disabled>

    <label>Mật khẩu mới</label>
    <input type="password" name="mat_khau" placeholder="Để trống nếu không đổi">

    <label>Họ tên</label>
    <input type="text" name="ho_ten" value="<?= $user['ho_ten'] ?>">

    <label>Email</label>
    <input type="email" name="email" value="<?= $user['email'] ?>">

    <label>Số điện thoại</label>
    <input type="text" name="so_dien_thoai" value="<?= $user['so_dien_thoai'] ?>">

    <label>Quyền</label>
    <select name="id_quyen">
        <?php
        $q = mysqli_query($conn,"SELECT * FROM quyen");
        while($r = mysqli_fetch_assoc($q)){
            $selected = ($r['id'] == $user['id_quyen']) ? "selected" : "";
            echo "<option value='{$r['id']}' $selected>{$r['ten_quyen']}</option>";
        }
        ?>
    </select>

    <button type="submit" name="submit">Cập nhật</button>
</form>

<a href="index.php?page_layout=nguoidung">⬅ Quay lại</a>
</div>
</body>
</html>
