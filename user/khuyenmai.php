<?php
include "connect.php";

// --- PHẦN 1: XỬ LÝ PHÂN TRANG ---
// 1. Xác định trang hiện tại
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// 2. Số lượng bài viết mỗi trang (4 bài)
$rows_per_page = 4;
$per_row = $page * $rows_per_page - $rows_per_page;

// 3. Tính tổng số trang
$total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tintuc"));
$total_pages = ceil($total_rows / $rows_per_page);

// 4. Lấy dữ liệu với LIMIT
$sql = "SELECT * FROM tintuc ORDER BY id_tt DESC LIMIT $per_row, $rows_per_page";
$query = mysqli_query($conn, $sql);
?>

<div class="promotion-container">
    <h2>Khuyến mãi & Tin tức</h2>
    <div class="promotion-list">
        <?php
        while($row = mysqli_fetch_array($query)){
        ?>
            <div class="promo-item" style="display: flex; margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 15px;">
                
                <div class="promo-img" style="width: 30%; margin-right: 20px;">
                    <a href="index.php?page_layout=chitiet&id=<?php echo $row['id_tt']; ?>">
                        <img src="/2221050039/image/<?php echo $row['anh_bia']; ?>" style="width: 100%; object-fit: cover;">
                    </a>
                </div>

                <div class="promo-info" style="width: 70%;">
                    <h3>
                        <a href="index.php?page_layout=chitiet&id=<?php echo $row['id_tt']; ?>" style="text-decoration: none; color: #333;">
                            <?php echo $row['tieu_de']; ?>
                        </a>
                    </h3>
                    <p style="color: #666; font-size: 14px;">
                        <?php echo $row['mo_ta_ngan']; ?>
                    </p>
                    <a href="index.php?page_layout=chitiet&id=<?php echo $row['id_tt']; ?>" style="color: red;">Xem chi tiết >></a>
                </div>
            </div>
        <?php
        } 
        ?>
    </div>

    <?php if($total_pages > 1) { ?>
        <div style="text-align: center; margin-top: 20px;">
            <?php for($i = 1; $i <= $total_pages; $i++) { ?>
                <a href="index.php?page_layout=khuyenmai&page=<?php echo $i; ?>" 
                   style="display: inline-block; padding: 5px 10px; margin: 0 5px; border: 1px solid #ccc; text-decoration: none; color: #333; <?php if($i==$page) echo 'background: red; color: white; border-color: red;'; ?>">
                    <?php echo $i; ?>
                </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>