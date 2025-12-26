<?php
if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='index.php?page_layout=dangnhap';</script>";
    exit();
}

$id_nguoi_dung = $_SESSION['user_id'];

// Lấy danh sách đơn hàng JOIN với trạng thái
$sql_ls = "SELECT dh.*, tt.ten_trang_thai 
           FROM don_hang dh
           JOIN trang_thai tt ON dh.id_trang_thai = tt.id
           WHERE dh.id_nguoi_dung = $id_nguoi_dung
           ORDER BY dh.ngay_dat DESC";
$query_ls = mysqli_query($conn, $sql_ls);
?>

<style>
    .ls-wrapper { max-width: 900px; margin: 40px auto; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 0 15px; }
    .ls-header { border-left: 5px solid #e53935; padding-left: 15px; margin-bottom: 30px; }
    .ls-header h2 { margin: 0; text-transform: uppercase; font-size: 24px; color: #333; }

    /* Style cho từng đơn hàng (Card) */
    .order-card { 
        background: #fff; border-radius: 10px; padding: 20px; margin-bottom: 20px; 
        box-shadow: 0 2px 15px rgba(0,0,0,0.08); border: 1px solid #f0f0f0;
        transition: transform 0.2s;
    }
    .order-card:hover { transform: translateY(-3px); }

    .card-top { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 12px; margin-bottom: 15px; }
    .order-id { font-weight: bold; color: #e53935; font-size: 16px; }
    .order-date { color: #888; font-size: 13px; }

    .card-body { display: flex; justify-content: space-between; align-items: flex-end; }
    .order-info p { margin: 5px 0; font-size: 14px; color: #555; }
    
    /* Trạng thái Pill */
    .status-pill { 
        padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase;
    }
    .stt-1 { background: #fff3cd; color: #856404; } /* Đang xử lý */
    .stt-2 { background: #d1ecf1; color: #0c5460; } /* Đang giao */
    .stt-3 { background: #d4edda; color: #155724; } /* Hoàn thành */
    .stt-4 { background: #f8d7da; color: #721c24; } /* Hủy */

    .order-price { text-align: right; }
    .total-label { font-size: 12px; color: #999; display: block; }
    .price-value { font-size: 20px; font-weight: bold; color: #333; }

    .btn-detail { 
        display: inline-block; margin-top: 15px; padding: 8px 20px; 
        background: #f5f5f5; color: #555; text-decoration: none; 
        font-size: 13px; border-radius: 5px; font-weight: bold;
    }
    .btn-detail:hover { background: #e0e0e0; }

    /* Thông báo hủy đơn */
    .cancel-reason { background: #fff5f5; border: 1px solid #feb2b2; padding: 10px; border-radius: 5px; margin-top: 10px; color: #c53030; font-size: 13px; display: flex; align-items: center; gap: 8px; }
</style>

<div class="ls-wrapper">
    <div class="ls-header">
        <h2>Lịch sử mua hàng</h2>
        <p style="color:#777; font-size: 14px;">Theo dõi tình trạng các đơn hàng bạn đã đặt</p>
    </div>

    <?php if(mysqli_num_rows($query_ls) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($query_ls)): ?>
        <div class="order-card">
            <div class="card-top">
                <div>
                    <span class="order-id">Đơn hàng #<?= $row['id'] ?></span>
                    <span class="order-date"> | <?= date('d/m/Y H:i', strtotime($row['ngay_dat'])) ?></span>
                </div>
                <span class="status-pill stt-<?= $row['id_trang_thai'] ?>">
                    <?= $row['ten_trang_thai'] ?>
                </span>
            </div>

            <div class="card-body">
                <div class="order-info">
                    <p><i class="fas fa-box"></i> Hình thức: Giao hàng tận nơi</p>
                    <p><i class="fas fa-wallet"></i> Thanh toán: Tiền mặt khi nhận hàng</p>
                    <a href="index.php?page_layout=chitiet_lichsu&id=<?= $row['id'] ?>" class="btn-detail">Xem món đã đặt</a>
                </div>
                
                <div class="order-price">
                    <span class="total-label">Tổng cộng</span>
                    <span class="price-value"><?= number_format($row['tong_tien']) ?>₫</span>
                </div>
            </div>

            <?php if($row['id_trang_thai'] == 4): ?>
                <div class="cancel-reason">
                    <i class="fas fa-exclamation-circle"></i>
                    Đơn hàng này đã bị từ chối/hủy. Vui lòng liên hệ Hotline nếu có thắc mắc.
                </div>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div style="text-align:center; padding: 50px;">
            <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" width="100" style="opacity: 0.3;">
            <p style="color:#999; margin-top:20px;">Bạn chưa đặt đơn hàng nào!</p>
            <a href="index.php?page_layout=menu" style="color:#e53935; text-decoration:none; font-weight:bold;">Đặt món ngay</a>
        </div>
    <?php endif; ?>
</div>