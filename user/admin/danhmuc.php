<?php
// Không cần include connect.php lại nếu index.php đã có, nhưng thêm vào để chắc chắn không lỗi
if (!isset($conn)) {
    include "connect.php";
}

$sql = "SELECT * FROM danh_muc ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<style>
    /* CSS cục bộ cho trang danh mục */
    .header-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .btn-add {
        background-color: #38a169; /* Màu xanh lá */
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: 0.3s;
    }
    .btn-add:hover { background-color: #2f855a; }

    /* Table styles kế thừa style sạch sẽ */
    .table-list {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .table-list th {
        background-color: #edf2f7;
        color: #4a5568;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
        border-bottom: 2px solid #e2e8f0;
    }

    .table-list td {
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
        color: #2d3748;
    }

    .table-list tr:last-child td { border-bottom: none; }
    .table-list tr:hover { background-color: #f7fafc; }

    /* Nút hành động */
    .action-link {
        margin-right: 10px;
        text-decoration: none;
        font-weight: 500;
        font-size: 13px;
    }
    .btn-edit { color: #3182ce; }
    .btn-delete { color: #e53e3e; }
    .btn-edit:hover, .btn-delete:hover { text-decoration: underline; }
</style>

<div class="header-action">
    <h2 style="font-size: 20px; color: #2d3748; font-weight: bold;">Quản lý Danh mục</h2>
    <a href="index.php?page_layout=themdanhmuc" class="btn-add">
        <i class="fas fa-plus"></i> Thêm mới
    </a>
</div>

<table class="table-list">
    <thead>
        <tr>
            <th style="width: 10%;">ID</th>
            <th>Tên danh mục</th>
            <th style="width: 20%;">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td>#<?= $row['id'] ?></td>
            <td style="font-weight: 500;"><?= $row['ten_danh_muc'] ?></td>
            <td>
                <a href="index.php?page_layout=suadanhmuc&id=<?= $row['id'] ?>" class="action-link btn-edit">
                    <i class="fas fa-edit"></i> Sửa
                </a>
                
                <a href="index.php?page_layout=xoadanhmuc&id=<?= $row['id'] ?>" 
                   class="action-link btn-delete"
                   onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục: <?= $row['ten_danh_muc'] ?>?');">
                    <i class="fas fa-trash-alt"></i> Xóa
                </a>
            </td>
        </tr>
        <?php 
            }
        } else {
            echo "<tr><td colspan='3' style='text-align:center; padding: 20px; color: #718096;'>Chưa có danh mục nào.</td></tr>";
        }
        ?>
    </tbody>
</table>