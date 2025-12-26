<?php
include "connect.php";

/* Đếm số lượng */
$so_san_pham = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM san_pham"));

$so_khach_hang = mysqli_num_rows(mysqli_query(
    $conn,
    "SELECT id FROM nguoi_dung WHERE id_quyen = 1"
));

$so_danh_muc = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM danh_muc"));

$so_don_hang = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM don_hang"));

/* Đơn hàng mới */
$sql_don_hang = mysqli_query($conn, "
    SELECT 
        dh.id,
        nd.ho_ten,
        sp.ten_san_pham,
        ctdh.so_luong,
        ctdh.gia,
        dc.dia_chi,
        nd.so_dien_thoai
    FROM don_hang dh
    JOIN nguoi_dung nd ON dh.id_nguoi_dung = nd.id
    JOIN chi_tiet_don_hang ctdh ON dh.id = ctdh.id_don_hang
    JOIN san_pham sp ON ctdh.id_san_pham = sp.id
    JOIN dia_chi_giao_hang dc ON dh.id_dia_chi = dc.id
    ORDER BY dh.ngay_dat DESC
    LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng thống kê</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Bảng thống kê</h1>

<!-- BOX THỐNG KÊ -->
<div class="box">
    <div class="item blue">
        <h2>Sản phẩm</h2>
        <p><?= $so_san_pham ?></p>
        <a href="index.php?page_layout=qlspham">xem chi tiết →</a>
    </div>

    <div class="item purple">
        <h2>Khách hàng</h2>
        <p><?= $so_khach_hang ?></p>
        <a href="index.php?page_layout=nguoidung">xem chi tiết →</a>
    </div>

    <div class="item green">
        <h2>Danh mục</h2>
        <p><?= $so_danh_muc ?></p>
        <a href="index.php?page_layout=qldanhmuc">xem chi tiết →</a>
    </div>

    <div class="item red">
        <h2>Đơn hàng</h2>
        <p><?= $so_don_hang ?></p>
        <a href="index.php?page_layout=donhang">xem chi tiết →</a>
    </div>
</div>

<!-- ĐƠN HÀNG MỚI -->
<h2 class="title">Đơn hàng mới</h2>

<table>
    <tr>
        <th>STT</th>
        <th>Tên</th>
        <th>Tên sản phẩm / Số lượng</th>
        <th>Giá sản phẩm</th>
        <th>Địa chỉ</th>
        <th>Số điện thoại</th>
    </tr>

    <?php $i = 1; while ($row = mysqli_fetch_assoc($sql_don_hang)) { ?>
    <tr>
        <td><?= $i++ ?></td>
        <td><?= $row['ho_ten'] ?></td>
        <td><?= $row['ten_san_pham'] ?> (<?= $row['so_luong'] ?>)</td>
        <td class="price"><?= number_format($row['gia']) ?> VND</td>
        <td><?= $row['dia_chi'] ?></td>
        <td><?= $row['so_dien_thoai'] ?></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
