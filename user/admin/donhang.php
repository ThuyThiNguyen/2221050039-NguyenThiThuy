<?php
include("../connect.php");

// 1. XỬ LÝ CẬP NHẬT TRẠNG THÁI KHI ẤN NÚT
if (isset($_GET['action']) && $_GET['action'] == 'update') {
    $id_dh = intval($_GET['id']);
    $id_stt_moi = intval($_GET['status_id']); 
    // Cập nhật id_trang_thai trong bảng don_hang
    mysqli_query($conn, "UPDATE don_hang SET id_trang_thai = $id_stt_moi WHERE id = $id_dh");
    header("Location: index.php?page_layout=donhang");
    exit();
}

// 2. LẤY DANH SÁCH ĐƠN HÀNG (JOIN để lấy tên trạng thái)
$sql = "SELECT dh.*, nd.ho_ten, tt.ten_trang_thai 
        FROM don_hang dh
        JOIN nguoi_dung nd ON dh.id_nguoi_dung = nd.id
        JOIN trang_thai tt ON dh.id_trang_thai = tt.id
        ORDER BY dh.ngay_dat DESC";
$query = mysqli_query($conn, $sql);
?>

<style>
    .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
    /* Màu sắc theo ID trạng thái trong database của bạn */
    .stt-1 { background: #fff3cd; color: #856404; } /* Đang xử lý */
    .stt-2 { background: #d1ecf1; color: #0c5460; } /* Đang giao */
    .stt-3 { background: #d4edda; color: #155724; } /* Hoàn thành */
    .stt-4 { background: #f8d7da; color: #721c24; } /* Hủy */
    
    .btn-update { text-decoration: none; font-size: 11px; padding: 2px 5px; border: 1px solid #ccc; color: #333; margin-right: 2px; }
    .btn-update:hover { background: #eee; }
</style>

<table class="table-order" width="100%" border="1" style="border-collapse: collapse;">
    <thead>
        <tr bgcolor="#f4f4f4">
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái hiện tại</th>
            <th>Cập nhật nhanh</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($query)): ?>
        <tr>
            <td>#<?= $row['id'] ?></td>
            <td><?= $row['ho_ten'] ?></td>
            <td><?= number_format($row['tong_tien']) ?>đ</td>
            <td>
                <span class="status-badge stt-<?= $row['id_trang_thai'] ?>">
                    <?= $row['ten_trang_thai'] ?>
                </span>
            </td>
            <td>
                <a class="btn-update" href="index.php?page_layout=donhang&action=update&id=<?= $row['id'] ?>&status_id=1">Chờ xử lý</a>
                <a class="btn-update" href="index.php?page_layout=donhang&action=update&id=<?= $row['id'] ?>&status_id=2">Đang giao</a>
                <a class="btn-update" href="index.php?page_layout=donhang&action=update&id=<?= $row['id'] ?>&status_id=3">Xong</a>
                <a class="btn-update" href="index.php?page_layout=donhang&action=update&id=<?= $row['id'] ?>&status_id=4" style="color:red">Hủy</a>
            </td>
            <td>
                <a href="index.php?page_layout=chitietdonhang&id=<?= $row['id'] ?>">Chi tiết</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>