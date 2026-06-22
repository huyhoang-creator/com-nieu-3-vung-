-- Tạo bảng NGUOI_DUNG (Người dùng/Khách hàng)
CREATE TABLE NGUOI_DUNG (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_dang_nhap VARCHAR(50) NOT NULL UNIQUE,
    mat_khau VARCHAR(255) NOT NULL,
    ho_ten VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    so_dien_thoai VARCHAR(15),
    dia_chi VARCHAR(255),
    ngay_dang_ky DATETIME DEFAULT CURRENT_TIMESTAMP,
    vai_tro ENUM('khach_hang', 'nhan_vien', 'quan_ly') DEFAULT 'khach_hang',
    trang_thai BOOLEAN DEFAULT TRUE
);

-- Tạo bảng VUNG_MIEN (Vùng miền: Bắc, Trung, Nam)
CREATE TABLE VUNG_MIEN (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(50) NOT NULL
);

-- Tạo bảng DANH_MUC (Danh mục món ăn)
CREATE TABLE DANH_MUC (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(100) NOT NULL,
    mo_ta TEXT,
    hinh_anh VARCHAR(255)
);

-- Tạo bảng MON_AN (Món ăn)
CREATE TABLE MON_AN (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(255) NOT NULL,
    mo_ta TEXT,
    gia DECIMAL(12, 2) NOT NULL,
    hinh_anh VARCHAR(255),
    id_danh_muc INT NOT NULL,
    id_vung_mien INT NOT NULL,
    dac_trung BOOLEAN DEFAULT FALSE,  -- Món đặc trưng của vùng miền
    trang_thai ENUM('con_mon', 'het_mon', 'tam_ngung') DEFAULT 'con_mon',
    FOREIGN KEY (id_danh_muc) REFERENCES DANH_MUC(id),
    FOREIGN KEY (id_vung_mien) REFERENCES VUNG_MIEN(id)
);

-- Tạo bảng CHI_NHANH (Chi nhánh nhà hàng)
CREATE TABLE CHI_NHANH (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(100) NOT NULL,
    dia_chi VARCHAR(255) NOT NULL,
    so_dien_thoai VARCHAR(15) NOT NULL,
    gio_mo_cua TIME NOT NULL,
    gio_dong_cua TIME NOT NULL,
    trang_thai BOOLEAN DEFAULT TRUE
);

-- Tạo bảng MON_AN_CHI_NHANH (Món ăn tại chi nhánh)
CREATE TABLE MON_AN_CHI_NHANH (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_mon_an INT NOT NULL,
    id_chi_nhanh INT NOT NULL,
    tinh_trang ENUM('con_mon', 'het_mon', 'tam_ngung') DEFAULT 'con_mon'
);

-- Tạo bảng DAT_BAN (Đặt bàn)
CREATE TABLE DAT_BAN (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_nguoi_dat VARCHAR(50) NOT NULL,
    so_dien_thoai VARCHAR(15),
    thoi_gian_dat DATETIME NOT NULL,
    thoi_gian_du_kien DATETIME NOT NULL,
    so_nguoi INT NOT NULL,
    ghi_chu TEXT,
    trang_thai ENUM('cho_xac_nhan', 'da_xac_nhan', 'dang_phuc_vu', 'da_huy', 'hoan_thanh') DEFAULT 'cho_xac_nhan',
    id_chi_nhanh INT NOT NULL,
    FOREIGN KEY (id_chi_nhanh) REFERENCES CHI_NHANH(id)
);

-- Tạo bảng GIO_HANG (Giỏ hàng)
CREATE TABLE GIO_HANG (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_nguoi_dung INT NOT NULL,
    ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_nguoi_dung) REFERENCES NGUOI_DUNG(id)
);

-- Tạo bảng GIO_HANG_CHI_TIET (Chi tiết giỏ hàng)
CREATE TABLE GIO_HANG_CHI_TIET (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_gio_hang INT NOT NULL,
    id_mon_an INT NOT NULL,
    so_luong INT NOT NULL DEFAULT 1,
    gia DECIMAL(12, 2) NOT NULL,
    FOREIGN KEY (id_gio_hang) REFERENCES GIO_HANG(id),
    FOREIGN KEY (id_mon_an) REFERENCES MON_AN(id)
)
-- Tạo bảng HOA_DON (Hóa đơn)
CREATE TABLE HOA_DON (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_hoa_don VARCHAR(50) NOT NULL UNIQUE,
    id_nguoi_dung INT,
    id_chi_nhanh INT NOT NULL,
    thoi_gian_tao DATETIME DEFAULT CURRENT_TIMESTAMP,
    tong_tien DECIMAL(12, 2) NOT NULL,
    thue_vat DECIMAL(12, 2) DEFAULT 0,
    thanh_tien DECIMAL(12, 2) NOT NULL,
    hinh_thuc ENUM('tai_cho', 'mang_ve', 'giao_hang') DEFAULT 'tai_cho',
    trang_thai ENUM('cho_xac_nhan', 'dang_xu_ly', 'hoan_thanh', 'da_huy') DEFAULT 'cho_xac_nhan',
    ghi_chu TEXT,
    FOREIGN KEY (id_nguoi_dung) REFERENCES NGUOI_DUNG(id),
    FOREIGN KEY (id_chi_nhanh) REFERENCES CHI_NHANH(id)
);


-- Trigger để tự động tạo ma_hoa_don dựa trên hash của id và thoi_gian_tao
DELIMITER //
CREATE TRIGGER trg_auto_generate_ma_hoa_don
BEFORE INSERT ON HOA_DON
FOR EACH ROW
BEGIN
    -- Đảm bảo NEW.id được gán sau khi insert (sử dụng NEW.id)
    SET NEW.ma_hoa_don = CONCAT(
        'HD', 
        LPAD(NEW.id, 5, '0'), 
        SUBSTRING(MD5(CONCAT(NEW.id, NEW.thoi_gian_tao)), 1, 10)
    );
END //
DELIMITER ;