 <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý danh mục</title>
    <link rel="stylesheet" href="style.css">
    <style>
        h1{
            display: flex;
            justify-content: center;

        }
        table{
            width: 60%;
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
            border: 1px solid black;
            padding: 8px 16px;
            color: white;
            border-radius: 5px;
            margin-left: 280px;
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
    <h1>Quản lý danh mục</h1>
    <a class="them" href="index.php?page_layout=themdanhmuc">+ Thêm danh mục</a>
</div>

<table border="1">
    <tr>
        <th>Tên danh mục</th>
        <th>Chức năng</th>
    </tr>

    <?php
        $sql = "SELECT * FROM danh_muc";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
    ?>
    <tr>
        <td><?= $row['ten_danh_muc'] ?></td>
        <td>
            <a class="capnhat"
               href="index.php?page_layout=suadanhmuc&id=<?= $row['id'] ?>">Sửa
            </a>
            |
            <a class="xoa"
               href="xoadanhmuc.php?id=<?= $row['id'] ?>"
               onclick="return confirm('Bạn có chắc muốn xóa?')">
               Xóa
            </a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
 
 
