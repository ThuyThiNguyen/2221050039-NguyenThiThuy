<?php
// Kết nối CSDL
if (!isset($conn)) include "connect.php";

// --- 1. XỬ LÝ CẬP NHẬT TRẠNG THÁI NHANH ---
if (isset($_GET['action']) && $_GET['action'] == 'update') {
    $id_dh = intval($_GET['id']);
    $id_stt_moi = intval($_GET['status_id']);
    
    // Cập nhật
    $sql_update = "UPDATE don_hang SET id_trang_thai = $id_stt_moi WHERE id = $id_dh";
    if(mysqli_query($conn, $sql_update)){
        // Dùng JS để chuyển hướng
        echo "<script>window.location.href='index.php?page_layout=donhang';</script>";
        exit();
    }
}

// --- 2. LẤY DANH SÁCH ĐƠN HÀNG ---
$sql = "SELECT dh.*, nd.ho_ten, tt.ten_trang_thai 
        FROM don_hang dh
        JOIN nguoi_dung nd ON dh.id_nguoi_dung = nd.id
        JOIN trang_thai tt ON dh.id_trang_thai = tt.id
        ORDER BY dh.ngay_dat DESC";
$query = mysqli_query($conn, $sql);
?>

<style>
    /* Badge trạng thái */
    .badge { padding: 5px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; }
    .bg-wait { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }   /* Chờ xử lý */
    .bg-ship { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }   /* Đang giao */
    .bg-done { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }   /* Hoàn thành */
    .bg-cancel { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; } /* Đã hủy */

    /* Bảng */
    .table-wrapper { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { background: #f8f9fa; color: #555; font-weight: 600; padding: 15px; font-size: 13px; border-bottom: 2px solid #eee; }
    td { padding: 12px 15px; border-bottom: 1px solid #eee; color: #333; font-size: 14px; vertical-align: middle; }
    tr:hover { background-color: #fcfcfc; }

    /* Nút thao tác nhanh */
    .btn-quick { 
        display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; 
        text-decoration: none; color: white; margin-right: 2px; transition: 0.2s;
    }
    .btn-quick:hover { opacity: 0.8; }
    .act-wait { background-color: #f6ad55; }
    .act-ship { background-color: #63b3ed; }
    .act-done { background-color: #48bb78; }
    .act-cancel { background-color: #fc8181; }
    
    .btn-detail { color: #3b82f6; font-weight: 500; text-decoration: none; font-size: 13px; }
    .btn-detail:hover { text-decoration: underline; }
</style>

<div class="page-header" style="margin-bottom: 20px;">
    <h2 style="font-size: 22px; font-weight: bold; color: #333;">Quản lý Đơn hàng</h2>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th style="width: 280px;">Cập nhật nhanh</th>
                <th style="text-align: right;">Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($query)): 
                // Gán màu badge
                $badge_class = "bg-wait";
                if($row['id_trang_thai'] == 2) $badge_class = "bg-ship";
                if($row['id_trang_thai'] == 3) $badge_class = "bg-done";
                if($row['id_trang_thai'] == 4) $badge_class = "bg-cancel";
            ?>
            <tr>
                <td><b>#<?= $row['id'] ?></b></td>
                <td><?= $row['ho_ten'] ?></td>
                <td style="color: #666; font-size: 13px;">
                    <?= date('d/m/Y', strtotime($row['ngay_dat'])) ?>
                </td>
                <td style="color: #d32f2f; font-weight: bold;">
                    <?= number_format($row['tong_tien']) ?> đ
                </td>
                <td>
                    <span class="badge <?= $badge_class ?>">
                        <?= $row['ten_trang_thai'] ?>
                    </span>
                </td>
                <td>
                    <a href="index.php?page_layout=donhang&action=update&id=<?= $row['id'] ?>&status_id=1" class="btn-quick act-wait" title="Chờ xử lý">Chờ</a>
                    <a href="index.php?page_layout=donhang&action=update&id=<?= $row['id'] ?>&status_id=2" class="btn-quick act-ship" title="Đang giao">Giao</a>
                    <a href="index.php?page_layout=donhang&action=update&id=<?= $row['id'] ?>&status_id=3" class="btn-quick act-done" title="Hoàn thành">Xong</a>
                    <a href="index.php?page_layout=donhang&action=update&id=<?= $row['id'] ?>&status_id=4" class="btn-quick act-cancel" title="Hủy đơn" onclick="return confirm('Xác nhận HỦY đơn hàng này?')">Hủy</a>
                </td>
                <td style="text-align: right;">
                    <a href="index.php?page_layout=chitietdonhang&id=<?= $row['id'] ?>" class="btn-detail">
                        Xem chi tiết &rarr;
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>