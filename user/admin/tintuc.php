<?php
if (!isset($conn)) include "connect.php";

$sql = "SELECT * FROM tintuc ORDER BY id_tt DESC";
$query = mysqli_query($conn, $sql);
?>

<style>
    /* CSS Bảng và Tiêu đề */
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .page-title { font-size: 22px; font-weight: bold; color: #333; margin: 0; }
    
    .btn-add {
        background-color: #38a169; color: white; padding: 10px 20px;
        border-radius: 6px; text-decoration: none; font-weight: 500;
        display: inline-flex; align-items: center; gap: 8px; transition: 0.2s;
    }
    .btn-add:hover { background-color: #2f855a; }

    .table-wrapper {
        background: white; border-radius: 10px; overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { background: #f8fafc; color: #64748b; font-weight: 600; padding: 15px; text-transform: uppercase; font-size: 12px; border-bottom: 1px solid #e2e8f0; }
    td { padding: 15px; border-bottom: 1px solid #e2e8f0; color: #334155; vertical-align: middle; }
    tr:hover { background-color: #f1f5f9; }

    .img-thumb { width: 80px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #eee; }

    .btn-action { margin-right: 10px; text-decoration: none; font-size: 13px; font-weight: 600; }
    .edit { color: #3b82f6; }
    .delete { color: #ef4444; }
    .edit:hover, .delete:hover { text-decoration: underline; }
</style>

<div class="page-header">
    <h2 class="page-title">Quản lý Tin tức / Khuyến mãi</h2>
    <a href="index.php?page_layout=themtintuc" class="btn-add">
        <i class="fas fa-plus"></i> Viết bài mới
    </a>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th style="width: 100px;">Ảnh bìa</th>
                <th>Tiêu đề</th>
                <th>Mô tả ngắn</th>
                <th style="width: 150px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($query)) { ?>
            <tr>
                <td>#<?= $row['id_tt'] ?></td>
                <td>
                    <?php if($row['anh_bia'] != "") { ?>
                        <img src="../../image/<?= $row['anh_bia'] ?>" class="img-thumb">
                    <?php } else { echo "<span style='color:#999; font-size:12px;'>No IMG</span>"; } ?>
                </td>
                <td>
                    <div style="font-weight: 600; font-size: 15px;"><?= $row['tieu_de'] ?></div>
                </td>
                <td style="color: #666; font-size: 13px;">
                    <?= mb_strlen($row['mo_ta_ngan']) > 60 ? mb_substr($row['mo_ta_ngan'], 0, 60) . '...' : $row['mo_ta_ngan'] ?>
                </td>
                <td>
                    <a href="index.php?page_layout=suatintuc&id=<?= $row['id_tt'] ?>" class="btn-action edit">
                        <i class="fas fa-edit"></i> Sửa
                    </a>
                    <a href="index.php?page_layout=xoatintuc&id=<?= $row['id_tt'] ?>" 
                       class="btn-action delete"
                       onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                        <i class="fas fa-trash"></i> Xóa
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>