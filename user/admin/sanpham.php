<?php
include("connect.php");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
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
        img{
            width: 80px;
        }
        a{
            text-decoration: none;
        }
    </style>
</head>
<body>

<h1>Quản lý sản phẩm</h1>
<a class="them" href="index.php?page_layout=themsanpham">+ Thêm sản phẩm</a>

<table border="1">
    <tr>
        <th>Tên sản phẩm</th>
        <th>Hình ảnh</th>
        <th>Danh mục</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Mô tả</th>
        <th>Chức năng</th>
    </tr>

<?php
$sql = "SELECT san_pham.*, danh_muc.ten_danh_muc 
        FROM san_pham 
        LEFT JOIN danh_muc ON san_pham.id_danh_muc = danh_muc.id";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
?>
    <tr>
          <td>
            <?= mb_strlen($row['ten_san_pham']) > 20 ? mb_substr($row['ten_san_pham'], 0, 30) . '...' : $row['ten_san_pham'] ?>
</td>
        <td>
            <?php if ($row['hinh_anh'] != "") { ?>
                <img src="../../image/<?= $row['hinh_anh'] ?>" width="80">

            <?php } ?>
        </td>
       <td>
            <?= mb_strlen($row['ten_danh_muc']) > 50 ? mb_substr($row['ten_danh_muc'], 0, 50) . '...' : $row['ten_danh_muc'] ?></td>
        <td><?= number_format($row['gia']) ?> đ</td>
        <td><?= $row['so_luong'] ?></td>
        <td>
            <?= mb_strlen($row['mo_ta']) > 50 ? mb_substr($row['mo_ta'], 0, 50) . '...' : $row['mo_ta'] ?>
</td>

        <td>
            <a class="capnhat"
               href="index.php?page_layout=suasanpham&id=<?= $row['id'] ?>">Sửa</a>
            |
            <a class="xoa"
               href="xoasanpham.php?id=<?= $row['id'] ?>"
               onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
        </td>
    </tr>
<?php } ?>

</table>

</body>
</html>
