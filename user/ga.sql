CREATE DATABASE IF NOT EXISTS cua_hang_ga_ran;
USE cua_hang_ga_ran;
1️⃣ BẢNG PHÂN QUYỀN

CREATE TABLE quyen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_quyen VARCHAR(50) NOT NULL
);
INSERT INTO quyen (ten_quyen)
VALUES ('Khách hàng'), ('Admin');
2️⃣ BẢNG NGƯỜI DÙNG
CREATE TABLE nguoi_dung (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_dang_nhap VARCHAR(50),
    mat_khau VARCHAR(255),
    ho_ten VARCHAR(100),
    email VARCHAR(150) UNIQUE,
    so_dien_thoai VARCHAR(20),
    id_quyen INT,
    FOREIGN KEY (id_quyen) REFERENCES quyen(id)
);
3️⃣ BẢNG DANH MỤC MÓN ĂN

CREATE TABLE danh_muc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_danh_muc VARCHAR(100) NOT NULL
);

INSERT INTO danh_muc (ten_danh_muc) VALUES
('Gà rán'),
('Cơm'),
('Burger'),
('OTOKÉ Combo'),
('Thức ăn kèm'),
('Tráng miệng & Thức uống');

4️⃣ BẢNG SẢN PHẨM

CREATE TABLE san_pham (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_san_pham VARCHAR(200) NOT NULL,
    hinh_anh VARCHAR(255),
    mo_ta TEXT,
    gia INT NOT NULL,
    so_luong INT DEFAULT 0,
    id_danh_muc INT,
    FOREIGN KEY (id_danh_muc) REFERENCES danh_muc(id)
        ON DELETE SET NULL ON UPDATE CASCADE
);
5️⃣ BẢNG ĐỊA CHỈ GIAO HÀNG

CREATE TABLE dia_chi_giao_hang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_nguoi_dung INT,
    dia_chi VARCHAR(255),
    phuong_xa VARCHAR(100),
    quan_huyen VARCHAR(100),
    tinh_thanh VARCHAR(100),
    mac_dinh BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_nguoi_dung) REFERENCES nguoi_dung(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);
6️⃣ BẢNG GIỎ HÀNG

CREATE TABLE gio_hang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_nguoi_dung INT UNIQUE,
    tong_tien INT DEFAULT 0,
    FOREIGN KEY (id_nguoi_dung) REFERENCES nguoi_dung(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);
7️⃣ CHI TIẾT GIỎ HÀNG

CREATE TABLE chi_tiet_gio_hang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_gio_hang INT,
    id_san_pham INT,
    so_luong INT DEFAULT 1,
    gia INT,
    FOREIGN KEY (id_gio_hang) REFERENCES gio_hang(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_san_pham) REFERENCES san_pham(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);
8️⃣ BẢNG COMBO (OTOKÉ COMBO)

CREATE TABLE combo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_combo VARCHAR(200),
    mo_ta TEXT,
    gia_combo INT,
    hinh_anh VARCHAR(255)
);
🔹 Chi tiết combo
CREATE TABLE chi_tiet_combo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_combo INT,
    id_san_pham INT,
    so_luong INT DEFAULT 1,
    FOREIGN KEY (id_combo) REFERENCES combo(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_san_pham) REFERENCES san_pham(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);
9️⃣ BẢNG TRẠNG THÁI ĐƠN HÀNG

CREATE TABLE trang_thai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_trang_thai VARCHAR(50)
);

INSERT INTO trang_thai (ten_trang_thai)
VALUES ('Đang xử lý'), ('Đang giao'), ('Hoàn thành'), ('Hủy');
🔟 BẢNG ĐƠN HÀNG

CREATE TABLE don_hang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_nguoi_dung INT,
    tong_tien INT,
    id_trang_thai INT,
    id_dia_chi INT,
    ngay_dat DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_nguoi_dung) REFERENCES nguoi_dung(id),
    FOREIGN KEY (id_trang_thai) REFERENCES trang_thai(id),
    FOREIGN KEY (id_dia_chi) REFERENCES dia_chi_giao_hang(id)
);
1️⃣1️⃣ CHI TIẾT ĐƠN HÀNG

CREATE TABLE chi_tiet_don_hang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_don_hang INT,
    id_san_pham INT,
    so_luong INT,
    gia INT,
    FOREIGN KEY (id_don_hang) REFERENCES don_hang(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_san_pham) REFERENCES san_pham(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);
1️⃣2️⃣ THANH TOÁN

CREATE TABLE thanh_toan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_don_hang INT,
    phuong_thuc VARCHAR(50), -- COD, Chuyển khoản
    so_tien INT,
    trang_thai VARCHAR(50), -- Đã thanh toán / Chưa thanh toán
    FOREIGN KEY (id_don_hang) REFERENCES don_hang(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);
1️⃣3️⃣ ĐÁNH GIÁ SẢN PHẨM

CREATE TABLE danh_gia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_nguoi_dung INT,
    id_san_pham INT,
    so_sao INT CHECK (so_sao BETWEEN 1 AND 5),
    noi_dung TEXT,
    ngay_danh_gia DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_nguoi_dung) REFERENCES nguoi_dung(id)
        ON DELETE CASCADE,
    FOREIGN KEY (id_san_pham) REFERENCES san_pham(id)
        ON DELETE CASCADE
);
