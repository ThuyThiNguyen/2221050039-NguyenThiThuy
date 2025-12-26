<?php
include("connect.php");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng</title>
    <style>
        h1{
            text-align: center;
        }
        table{
            width: 100%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td{
            padding: 10px;
            text-align: center;
        }
        .xoa{
            background-color: red;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .them{
            background-color: green;
            padding: 8px 16px;
            color: white;
            border-radius: 5px;
            margin-left: 5%;
            display: inline-block;
            margin-bottom: 10px;
        }
        .capnhat{
            background-color: yellow;
            padding: 5px 10px;
            color: black;
            border-radius: 5px;
        }
        a{
            text-decoration: none;
        }
    </style>
</head>
<body>

<h1>Quản lý người dùng</h1>
<a class="them" href="index.php?page_layout=themnguoidung">+ Thêm người dùng</a>

<table border="1">
    <tr>
        <th>Tên đăng nhập</th>
        <th>Họ tên</th>
        <th>Email</th>
        <th>Số điện thoại</th>
        <th>Quyền</th>
        <th>Chức năng</th>
    </tr>

<?php
$sql = "SELECT nguoi_dung.*, quyen.ten_quyen
        FROM nguoi_dung
        LEFT JOIN quyen ON nguoi_dung.id_quyen = quyen.id";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
?>
    <tr>
        <td><?= $row['ten_dang_nhap'] ?></td>
        <td><?= $row['ho_ten'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['so_dien_thoai'] ?></td>
        <td><?= $row['ten_quyen'] ?></td>
        <td>
            <a class="capnhat"
               href="index.php?page_layout=suanguoidung&id=<?= $row['id'] ?>">Sửa</a>
            |
            <a class="xoa"
               href="xoanguoidung.php?id=<?= $row['id'] ?>"
               onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">Xóa</a>
        </td>
    </tr>
<?php } ?>

</table>

</body>
</html>
