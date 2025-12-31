<?php
// Logic PHP giữ nguyên
include "connect.php";

$so_san_pham = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM san_pham"));
$so_khach_hang = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM nguoi_dung WHERE id_quyen = 1"));
$so_danh_muc = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM danh_muc"));
$so_don_hang = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM don_hang"));

$sql_don_hang = mysqli_query($conn, "
    SELECT dh.id, nd.ho_ten, sp.ten_san_pham, ctdh.so_luong, ctdh.gia, dc.dia_chi, nd.so_dien_thoai
    FROM don_hang dh
    JOIN nguoi_dung nd ON dh.id_nguoi_dung = nd.id
    JOIN chi_tiet_don_hang ctdh ON dh.id = ctdh.id_don_hang
    JOIN san_pham sp ON ctdh.id_san_pham = sp.id
    JOIN dia_chi_giao_hang dc ON dh.id_dia_chi = dc.id
    ORDER BY dh.ngay_dat DESC LIMIT 5
");
?>

<style>
    /* CSS cục bộ cho bảng thống kê */
    .dashboard-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .card {
        color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: relative;
        height: 120px;
        box-sizing: border-box;
    }

    .card h3 { margin: 0; font-size: 15px; opacity: 0.9; font-weight: normal; }
    .card p { font-size: 36px; font-weight: bold; margin: 5px 0; }
    .card i { position: absolute; right: 15px; top: 25px; font-size: 45px; opacity: 0.3; }
    
    .card-footer {
        position: absolute; bottom: 0; left: 0; width: 100%;
        background: rgba(0,0,0,0.1); color: white;
        text-decoration: none; padding: 5px 0; text-align: center;
        font-size: 12px; display: block; border-radius: 0 0 5px 5px;
    }
    .card-footer:hover { background: rgba(0,0,0,0.2); }

    /* Màu nền */
    .bg-blue { background-color: #007bff; }
    .bg-green { background-color: #28a745; }
    .bg-yellow { background-color: #ffc107; color: #333 !important; }
    .bg-red { background-color: #dc3545; }
    
    /* Fix màu chữ cho ô vàng */
    .bg-yellow h3, .bg-yellow p, .bg-yellow i, .bg-yellow .card-footer { color: #333 !important; }

    /* Bảng */
    .table-box {
        background: white;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .table-box h2 { margin-top: 0; font-size: 18px; color: #333; margin-bottom: 15px; border-bottom: 2px solid #eee; padding-bottom: 10px; }

    table.tk-table { width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; }
    table.tk-table th { background-color: #343a40; color: white; padding: 10px; text-align: left; font-size: 13px; }
    table.tk-table td { padding: 10px; border-bottom: 1px solid #eee; color: #333; font-size: 14px; }
    table.tk-table tr:hover { background-color: #f8f9fa; }
    
    /* Responsive mobile */
    @media (max-width: 768px) {
        .dashboard-container { grid-template-columns: 1fr 1fr; }
    }
</style>

<h2 style="margin-top: 0; margin-bottom: 20px; color: #333; font-family: Arial, sans-serif;">
    <i class="fas fa-tachometer-alt"></i> Tổng quan hệ thống
</h2>

<div class="dashboard-container">
    <div class="card bg-blue">
        <h3>Sản phẩm</h3>
        <p><?= $so_san_pham ?></p>
        <i class="fas fa-box"></i>
        <a href="index.php?page_layout=qlspham" class="card-footer">Xem chi tiết &rarr;</a>
    </div>

    <div class="card bg-green">
        <h3>Khách hàng</h3>
        <p><?= $so_khach_hang ?></p>
        <i class="fas fa-users"></i>
        <a href="index.php?page_layout=nguoidung" class="card-footer">Xem chi tiết &rarr;</a>
    </div>

    <div class="card bg-yellow">
        <h3>Danh mục</h3>
        <p><?= $so_danh_muc ?></p>
        <i class="fas fa-list"></i>
        <a href="index.php?page_layout=qldanhmuc" class="card-footer">Xem chi tiết &rarr;</a>
    </div>

    <div class="card bg-red">
        <h3>Đơn hàng</h3>
        <p><?= $so_don_hang ?></p>
        <i class="fas fa-shopping-cart"></i>
        <a href="index.php?page_layout=donhang" class="card-footer">Xem chi tiết &rarr;</a>
    </div>
</div>

<div class="table-box">
    <h2>Đơn hàng mới nhất</h2>
    <table class="tk-table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Khách hàng</th>
                <th>Sản phẩm</th>
                <th>Tổng tiền</th>
                <th>Địa chỉ</th>
                <th>SĐT</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            while ($row = mysqli_fetch_assoc($sql_don_hang)) { ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><b><?= $row['ho_ten'] ?></b></td>
                <td><?= $row['ten_san_pham'] ?> (x<?= $row['so_luong'] ?>)</td>
                <td style="color:red; font-weight:bold;"><?= number_format($row['gia']) ?> đ</td>
                <td><?= $row['dia_chi'] ?></td>
                <td><?= $row['so_dien_thoai'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>