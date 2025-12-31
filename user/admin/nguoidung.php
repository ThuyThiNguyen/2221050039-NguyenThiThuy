<?php
// Kết nối CSDL
if (!isset($conn)) include "connect.php";

$sql = "SELECT nguoi_dung.*, quyen.ten_quyen
        FROM nguoi_dung
        LEFT JOIN quyen ON nguoi_dung.id_quyen = quyen.id
        ORDER BY id DESC";
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

    /* Badge Quyền */
    .role-badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
    .role-admin { background: #fee2e2; color: #ef4444; } /* Đỏ nhạt cho Admin */
    .role-user { background: #dcfce7; color: #16a34a; }  /* Xanh cho User */

    /* Actions */
    .btn-action { margin-right: 10px; text-decoration: none; font-size: 13px; font-weight: 600; }
    .edit { color: #3b82f6; }
    .delete { color: #ef4444; }
    .edit:hover, .delete:hover { text-decoration: underline; }
</style>

<div class="page-header">
    <h2 class="page-title">Quản lý Người dùng</h2>
    <a href="index.php?page_layout=themnguoidung" class="btn-add">
        <i class="fas fa-user-plus"></i> Thêm thành viên
    </a>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Tài khoản / Email</th>
                <th>SĐT</th>
                <th>Quyền hạn</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td>#<?= $row['id'] ?></td>
                <td>
                    <div style="font-weight: 600; color: #333;"><?= $row['ho_ten'] ?></div>
                </td>
                <td>
                    <div style="font-weight: bold; font-size: 13px;"><?= $row['ten_dang_nhap'] ?></div>
                    <div style="color: #666; font-size: 12px;"><?= $row['email'] ?></div>
                </td>
                <td><?= $row['so_dien_thoai'] ?></td>
                <td>
                    <?php 
                        // Giả sử ID quyền 1 là Admin, còn lại là User
                        $roleClass = ($row['id_quyen'] == 2) ? 'role-admin' : 'role-user';
                    ?>
                    <span class="role-badge <?= $roleClass ?>"><?= $row['ten_quyen'] ?></span>
                </td>
                <td>
                    <a href="index.php?page_layout=suanguoidung&id=<?= $row['id'] ?>" class="btn-action edit">
                        <i class="fas fa-edit"></i> Sửa
                    </a>
                    <a href="index.php?page_layout=xoanguoidung&id=<?= $row['id'] ?>" 
                       class="btn-action delete"
                       onclick="return confirm('CẢNH BÁO: Bạn có chắc muốn xóa người dùng này không?')">
                        <i class="fas fa-trash"></i> Xóa
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>