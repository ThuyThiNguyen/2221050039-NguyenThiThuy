<?php
include("../connect.php");
$id_dh = intval($_GET['id']);

// 1. Lấy thông tin tổng quan đơn hàng và thông tin khách hàng, địa chỉ
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

// 2. Lấy danh sách sản phẩm trong đơn hàng này
$sql_ct = "SELECT ct.*, sp.ten_san_pham, sp.hinh_anh 
           FROM chi_tiet_don_hang ct
           JOIN san_pham sp ON ct.id_san_pham = sp.id
           WHERE ct.id_don_hang = $id_dh";
$query_ct = mysqli_query($conn, $sql_ct);
?>

<style>
    .detail-container { max-width: 1000px; margin: 20px auto; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; }
    .card { background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 20px; }
    .header-row { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e53935; padding-bottom: 15px; margin-bottom: 25px; }
    .header-row h2 { margin: 0; color: #e53935; text-transform: uppercase; font-size: 22px; }
    
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
    .info-box h3 { font-size: 16px; border-left: 4px solid #e53935; padding-left: 10px; margin-bottom: 15px; text-transform: uppercase; }
    .info-box p { margin: 8px 0; font-size: 14px; }
    .info-box b { color: #555; }

    .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
    .pill-wait { background: #fff3cd; color: #856404; }
    .pill-done { background: #d4edda; color: #155724; }

    .product-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .product-table th { background: #f8f9fa; padding: 12px; text-align: left; font-size: 13px; color: #777; border-bottom: 1px solid #eee; }
    .product-table td { padding: 15px 12px; border-bottom: 1px solid #eee; font-size: 14px; }
    .img-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #eee; }
    
    .total-row { font-size: 18px; font-weight: bold; text-align: right; color: #e53935; }
    .btn-back { display: inline-block; text-decoration: none; color: #666; font-size: 14px; margin-bottom: 15px; }
    .btn-back:hover { color: #000; }
</style>

<div class="detail-container">
    <a href="index.php?page_layout=donhang" class="btn-back">← Quay lại danh sách đơn hàng</a>

    <div class="card">
        <div class="header-row">
            <h2>Chi tiết đơn hàng #<?= $id_dh ?></h2>
            <span class="status-pill pill-wait"><?= $dh['ten_trang_thai'] ?></span>
        </div>

        <div class="info-grid">
            <div class="info-box">
                <h3>Thông tin khách hàng</h3>
                <p><b>Họ tên:</b> <?= $dh['ho_ten'] ?></p>
                <p><b>Điện thoại:</b> <?= $dh['so_dien_thoai'] ?></p>
                <p><b>Email:</b> <?= $dh['email'] ?></p>
            </div>

            <div class="info-box">
                <h3>Địa chỉ nhận hàng</h3>
                <p><b>Địa chỉ:</b> <?= $dh['dia_chi'] ? $dh['dia_chi'] : '<i>Chưa có dữ liệu</i>' ?></p>
                <p><b>Khu vực:</b> <?= $dh['phuong_xa'] ?>, <?= $dh['quan_huyen'] ?>, <?= $dh['tinh_thanh'] ?></p>
                <p><b>Ngày đặt:</b> <?= date('d/m/Y H:i', strtotime($dh['ngay_dat'])) ?></p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="info-box">
            <h3>Danh sách món ăn</h3>
        </div>
        <table class="product-table">
            <thead>
                <tr>
                    <th width="80">Ảnh</th>
                    <th>Tên món ăn</th>
                    <th width="100">Số lượng</th>
                    <th width="120">Giá đơn vị</th>
                    <th width="120" style="text-align: right;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php while($item = mysqli_fetch_assoc($query_ct)): ?>
                <tr>
                    <td><img src="/2221050039/image/<?= $item['hinh_anh'] ?>" class="img-thumb"></td>
                    <td>
                        <b><?= $item['ten_san_pham'] ?></b><br>
                        <small style="color:#999">Mã SP: <?= $item['id_san_pham'] ?></small>
                    </td>
                    <td><?= $item['so_luong'] ?></td>
                    <td><?= number_format($item['gia']) ?>₫</td>
                    <td style="text-align: right; font-weight: bold;"><?= number_format($item['gia'] * $item['so_luong']) ?>₫</td>
                </tr>
                <?php endwhile; ?>
                <tr>
                    <td colspan="4" align="right" style="padding-top: 20px; border: none;">TỔNG CỘNG ĐƠN HÀNG:</td>
                    <td class="total-row" style="padding-top: 20px; border: none;"><?= number_format($dh['tong_tien']) ?>₫</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>