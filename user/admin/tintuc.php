<?php
include "connect.php";
$sql = "SELECT * FROM tintuc ORDER BY id_tt DESC";
$query = mysqli_query($conn, $sql);
?>
<style>
    h1 { text-align: center; }
    table { width: 100%; margin: auto; border-collapse: collapse; }
    th, td { padding: 10px; text-align: center; }
    .xoa {
        background-color: red;
        padding: 5px 10px;
        color: white;
        border-radius: 5px;
    }
    .them {
        background-color: green;
        padding: 8px 16px;
        color: white;
        border-radius: 5px;
        margin-left: 5%;
        display: inline-block;
        margin-bottom: 10px;
    }
    .capnhat {
        background-color: yellow;
        padding: 5px 10px;
        color: black;
        border-radius: 5px;
    }
    img { width: 80px; object-fit: cover; }
    a { text-decoration: none; }
</style>

<div class="container-fluid">
    <h2>Quản lý Khuyến mãi / Tin tức</h2>
    <a href="index.php?page_layout=themtintuc" class="them">Thêm bài viết mới</a>
    <br><br>
    <table border="1">
        <thead>
            <tr>
                <th>Ảnh bìa</th>
                <th>Tiêu đề</th>
                <th>Mô tả ngắn</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($query)) { ?>
            <tr>
                <td>
                    <?php if($row['anh_bia'] != "") { ?>
                        <img src="../../image/<?php echo $row['anh_bia']; ?>">
                    <?php } else { echo "No Image"; } ?>
                </td>
                
                <td><?php echo $row['tieu_de']; ?></td>
                <td>
            <?= mb_strlen($row['mo_ta_ngan']) > 30 ? mb_substr($row['mo_ta_ngan'], 0, 30) . '...' : $row['mo_ta_ngan'] ?>
</td>
                
                <td>
                    <a class="capnhat" href="index.php?page_layout=suatintuc&id=<?php echo $row['id_tt']; ?>">Sửa</a>
                    
                    |
                    
                    <a class="xoa" onclick="return confirm('Bạn có chắc muốn xóa bài này?')" href="index.php?page_layout=xoatintuc&id=<?php echo $row['id_tt']; ?>">Xóa</a>
                </td>
            </tr>
            <?php } ?> </tbody>
    </table>
</div>