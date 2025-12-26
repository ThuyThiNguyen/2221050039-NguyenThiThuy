<?php
if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='index.php?page_layout=dangnhap';</script>";
    exit();
}

$id_dh = intval($_GET['id']);
$id_nguoi_dung = $_SESSION['user_id'];

// 1. Kiểm tra quyền sở hữu đơn hàng
$sql_check = "SELECT dh.*, tt.ten_trang_thai 
              FROM don_hang dh 
              JOIN trang_thai tt ON dh.id_trang_thai = tt.id
              WHERE dh.id = $id_dh AND dh.id_nguoi_dung = $id_nguoi_dung";
$res_check = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($res_check) == 0) {
    echo "<div class='container' style='padding:50px; text-align:center;'><h3>Đơn hàng không tồn tại hoặc bạn không có quyền truy cập.</h3></div>";
    exit();
}
$dh = mysqli_fetch_assoc($res_check);

// 2. Lấy danh sách món ăn trong đơn
$sql_ct = "SELECT ct.*, sp.ten_san_pham, sp.hinh_anh 
           FROM chi_tiet_don_hang ct
           JOIN san_pham sp ON ct.id_san_pham = sp.id
           WHERE ct.id_don_hang = $id_dh";
$query_ct = mysqli_query($conn, $sql_ct);
?>

<style>
    .ct-wrapper { max-width: 700px; margin: 40px auto; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 0 15px; }
    .btn-back { text-decoration: none; color: #666; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 20px; transition: 0.2s; }
    .btn-back:hover { color: #e53935; }
    
    .ct-card { background: #fff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #eee; }
    
    .ct-header { background: #fcfcfc; padding: 25px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; }
    .ct-header h3 { margin: 0; font-size: 20px; color: #333; }
    
    .product-list { padding: 10px 25px; }
    .product-item { display: flex; align-items: center; padding: 15px 0; border-bottom: 1px solid #f9f9f9; }
    .product-item:last-child { border-bottom: none; }
    
    .product-img { width: 70px; height: 70px; object-fit: cover; border-radius: 10px; margin-right: 20px; background: #f5f5f5; }
    
    .product-info { flex-grow: 1; }
    .product-name { font-weight: bold; font-size: 16px; color: #333; margin-bottom: 4px; display: block; }
    .product-qty { color: #888; font-size: 13px; }
    
    .product-subtotal { text-align: right; font-weight: 600; color: #333; font-size: 15px; }

    /* CSS CHO NÚT ĐÁNH GIÁ MỚI THÊM */
    .btn-review {
        display: inline-block;
        margin-top: 8px;
        padding: 4px 12px;
        background: #f4b966;
        color: #fff;
        text-decoration: none;
        font-size: 11px;
        font-weight: bold;
        border-radius: 4px;
        text-transform: uppercase;
    }
    .btn-review:hover { background: #e53935; }

    .summary-box { padding: 25px; background: #fafafa; border-top: 2px dashed #eee; }
    .summary-line { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: #666; }
    .final-total { font-size: 24px; font-weight: bold; color: #e53935; margin-top: 15px; border-top: 1px solid #eee; padding-top: 15px; }
    
    .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
    .stt-1 { background: #fff3cd; color: #856404; }
    .stt-3 { background: #d4edda; color: #155724; }
    .stt-4 { background: #f8d7da; color: #721c24; }
</style>

<div class="ct-wrapper">
    <a href="index.php?page_layout=lichsu" class="btn-back">
        <i class="fas fa-chevron-left"></i> Quay lại đơn hàng của tôi
    </a>

    <div class="ct-card">
        <div class="ct-header">
            <div>
                <h3>Mã đơn: #<?= $id_dh ?></h3>
                <small style="color:#999"><?= date('d/m/Y H:i', strtotime($dh['ngay_dat'])) ?></small>
            </div>
            <span class="status-pill stt-<?= $dh['id_trang_thai'] ?>">
                <?= $dh['ten_trang_thai'] ?>
            </span>
        </div>

        <div class="product-list">
            <?php while($item = mysqli_fetch_assoc($query_ct)): ?>
            <div class="product-item">
                <img src="/2221050039/image/<?= $item['hinh_anh'] ?>" class="product-img" onerror="this.src='image/no-image.png'">
                <div class="product-info">
                    <span class="product-name"><?= $item['ten_san_pham'] ?></span>
                    <span class="product-qty"><?= number_format($item['gia']) ?>₫ x <?= $item['so_luong'] ?></span>
                    
                    <?php if($dh['id_trang_thai'] == 3): ?>
                        <br>
                        <a href="index.php?page_layout=viet_danh_gia&id_sp=<?= $item['id_san_pham'] ?>" class="btn-review">
                            <i class="fas fa-star"></i> Đánh giá món
                        </a>
                    <?php endif; ?>
                </div>
                <div class="product-subtotal">
                    <?= number_format($item['gia'] * $item['so_luong']) ?>₫
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <div class="summary-box">
            <div class="summary-line">
                <span>Tạm tính món ăn</span>
                <span><?= number_format($dh['tong_tien']) ?>₫</span>
            </div>
            <div class="summary-line">
                <span>Phí vận chuyển (Đồng giá)</span>
                <span>0₫</span>
            </div>
            <div class="summary-line final-total">
                <span>TỔNG THANH TOÁN</span>
                <span><?= number_format($dh['tong_tien']) ?>₫</span>
            </div>
            <p style="text-align: center; color: #999; font-size: 12px; margin-top: 20px;">
                Cảm ơn bạn đã tin tưởng và đặt món tại cửa hàng!
            </p>
        </div>
    </div>
</div>