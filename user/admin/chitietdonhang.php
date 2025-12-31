<?php
// Kết nối CSDL
if (!isset($conn)) include "connect.php";
$id_dh = intval($_GET['id']);

// 1. Lấy thông tin chung (Sửa LEFT JOIN dia_chi phòng trường hợp dữ liệu cũ bị thiếu)
$sql_dh = "SELECT dh.*, nd.ho_ten, nd.so_dien_thoai, nd.email, 
                  tt.ten_trang_thai, 
                  dc.dia_chi, dc.phuong_xa, dc.quan_huyen, dc.tinh_thanh
           FROM don_hang dh
           JOIN nguoi_dung nd ON dh.id_nguoi_dung = nd.id
           JOIN trang_thai tt ON dh.id_trang_thai = tt.id
           LEFT JOIN dia_chi_giao_hang dc ON dh.id_dia_chi = dc.id
           WHERE dh.id = $id_dh";

$res_dh = mysqli_query($conn, $sql_dh);
$dh = mysqli_fetch_assoc($res_dh);

// 2. Lấy chi tiết sản phẩm
$sql_ct = "SELECT ct.*, sp.ten_san_pham, sp.hinh_anh 
           FROM chi_tiet_don_hang ct
           JOIN san_pham sp ON ct.id_san_pham = sp.id
           WHERE ct.id_don_hang = $id_dh";
$query_ct = mysqli_query($conn, $sql_ct);
?>

<style>
    /* Bố cục Grid 2 cột */
    .detail-container { display: grid; grid-template-columns: 1fr 2fr; gap: 20px; font-family: Arial, sans-serif; }
    
    .card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .card-header { font-size: 16px; font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; color: #333; text-transform: uppercase; }

    .info-line { margin-bottom: 10px; font-size: 14px; color: #444; }
    .info-line strong { display: inline-block; width: 100px; color: #666; }

    /* Bảng sản phẩm */
    .table-detail { width: 100%; border-collapse: collapse; }
    .table-detail th { text-align: left; background: #f8f8f8; padding: 10px; font-size: 13px; color: #555; }
    .table-detail td { padding: 10px; border-bottom: 1px solid #eee; vertical-align: middle; font-size: 14px; }
    
    /* Ảnh nhỏ trong bảng */
    .thumb-img { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; }
    
    .total-price { font-size: 20px; font-weight: bold; color: #d32f2f; text-align: right; margin-top: 20px; }
    
    .btn-back { display: inline-flex; align-items: center; text-decoration: none; color: #555; font-weight: 500; margin-bottom: 15px; font-size: 14px; }
    .btn-back:hover { color: #000; }

    /* Responsive */
    @media (max-width: 768px) { .detail-container { grid-template-columns: 1fr; } }
</style>

<a href="index.php?page_layout=donhang" class="btn-back">
    <i class="fas fa-arrow-left"></i> &nbsp;Quay lại danh sách
</a>

<div class="detail-container">
    
    <div class="card">
        <div class="card-header">Thông tin đơn hàng</div>
        <div class="info-line"><strong>Mã đơn:</strong> #<?= $id_dh ?></div>
        <div class="info-line"><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($dh['ngay_dat'])) ?></div>
        <div class="info-line"><strong>Trạng thái:</strong> <span style="color:#0275d8; font-weight:bold;"><?= $dh['ten_trang_thai'] ?></span></div>

        <div class="card-header" style="margin-top: 25px;">Khách hàng</div>
        <div class="info-line"><strong>Họ tên:</strong> <?= $dh['ho_ten'] ?></div>
        <div class="info-line"><strong>SĐT:</strong> <?= $dh['so_dien_thoai'] ?></div>
        <div class="info-line"><strong>Email:</strong> <?= $dh['email'] ?></div>

        <div class="card-header" style="margin-top: 25px;">Địa chỉ giao</div>
        <?php if($dh['dia_chi']): ?>
            <div style="font-size: 14px; line-height: 1.5; color: #333;">
                <?= $dh['dia_chi'] ?><br>
                <?= $dh['phuong_xa'] ?>, <?= $dh['quan_huyen'] ?><br>
                <?= $dh['tinh_thanh'] ?>
            </div>
        <?php else: ?>
            <div style="color: #999; font-style: italic;">(Khách chưa nhập địa chỉ cụ thể)</div>
        <?php endif; ?>
    </div>

    <div class="card">
        <div class="card-header">Chi tiết sản phẩm</div>
        
        <table class="table-detail">
            <thead>
                <tr>
                    <th width="60">Ảnh</th>
                    <th>Tên món</th>
                    <th width="50" style="text-align: center;">SL</th>
                    <th width="100" style="text-align: right;">Đơn giá</th>
                    <th width="110" style="text-align: right;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $tong_tien_tinh = 0;
                while($item = mysqli_fetch_assoc($query_ct)): 
                    $thanh_tien = $item['gia'] * $item['so_luong'];
                    $tong_tien_tinh += $thanh_tien;
                ?>
                <tr>
                    <td>
                        <img src="../../image/<?= $item['hinh_anh'] ?>" class="thumb-img">
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #333;"><?= $item['ten_san_pham'] ?></div>
                    </td>
                    <td style="text-align: center; font-weight: bold;"><?= $item['so_luong'] ?></td>
                    <td style="text-align: right;"><?= number_format($item['gia']) ?> đ</td>
                    <td style="text-align: right; font-weight: bold; color: #333;"><?= number_format($thanh_tien) ?> đ</td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="total-price">
            Tổng thanh toán: <?= number_format($dh['tong_tien']) ?> đ
        </div>
    </div>
</div>