<?php
// Kết nối (nếu index chưa có)

if (!isset($conn)) include "connect.php";

// Truy vấn sản phẩm + Tên danh mục
$sql = "SELECT san_pham.*, danh_muc.ten_danh_muc 
        FROM san_pham 
        LEFT JOIN danh_muc ON san_pham.id_danh_muc = danh_muc.id
        ORDER BY san_pham.id DESC";
$result = mysqli_query($conn, $sql);
?>

<style>
    /* Header & Button */
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .page-title { font-size: 22px; font-weight: bold; color: #333; margin: 0; }
    
    .btn-add {
        background-color: #38a169; color: white; padding: 10px 20px;
        border-radius: 6px; text-decoration: none; font-weight: 500;
        display: inline-flex; align-items: center; gap: 8px; transition: 0.2s;
    }
    .btn-add:hover { background-color: #2f855a; }

    /* Table Styles */
    .table-wrapper {
        background: white; border-radius: 10px; overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { background: #f8fafc; color: #64748b; font-weight: 600; padding: 15px; text-transform: uppercase; font-size: 12px; border-bottom: 1px solid #e2e8f0; }
    td { padding: 15px; border-bottom: 1px solid #e2e8f0; color: #334155; vertical-align: middle; }
    tr:hover { background-color: #f1f5f9; }

    /* Product Image */
    .img-thumb {
        width: 60px; height: 60px; object-fit: cover;
        border-radius: 8px; border: 1px solid #eee;
    }

    /* Actions */
    .btn-action { margin-right: 8px; text-decoration: none; font-size: 14px; font-weight: 500; }
    .edit { color: #3b82f6; }
    .delete { color: #ef4444; }
    .edit:hover, .delete:hover { text-decoration: underline; }
    
    .price-tag { font-weight: bold; color: #ef4444; }
    .stock-tag { background: #e0f2fe; color: #0284c7; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; }
</style>

<div class="page-header">
    <h2 class="page-title">Quản lý Sản phẩm</h2>
    <a href="index.php?page_layout=themsanpham" class="btn-add">
        <i class="fas fa-plus"></i> Thêm mới
    </a>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th style="width: 80px;">Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Giá bán</th>
                <th>Kho</th>
                <th style="width: 150px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td>#<?= $row['id'] ?></td>
                <td>
                    <?php if ($row['hinh_anh'] != "") { ?>
                        <img src="../../image/<?= $row['hinh_anh'] ?>" class="img-thumb">
                    <?php } else { ?>
                        <div class="img-thumb" style="background:#eee; display:flex; align-items:center; justify-content:center; color:#999; font-size:10px;">No IMG</div>
                    <?php } ?>
                </td>
                <td>
                    <div style="font-weight: 600;"><?= $row['ten_san_pham'] ?></div>
                    <div style="font-size: 12px; color: #888; margin-top: 3px;">
                        <?= mb_substr($row['mo_ta'], 0, 40) ?>...
                    </div>
                </td>
                <td><span style="color: #555;"><?= $row['ten_danh_muc'] ?></span></td>
                <td class="price-tag"><?= number_format($row['gia']) ?> đ</td>
                <td><span class="stock-tag">SL: <?= $row['so_luong'] ?></span></td>
                <td>
                    <a href="index.php?page_layout=suasanpham&id=<?= $row['id'] ?>" class="btn-action edit">
                        <i class="fas fa-edit"></i> Sửa
                    </a>
                    <a href="index.php?page_layout=xoasanpham&id=<?= $row['id'] ?>" 
                       class="btn-action delete"
                       onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                        <i class="fas fa-trash"></i> Xóa
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>