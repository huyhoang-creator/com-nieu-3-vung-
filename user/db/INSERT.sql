

-- Thêm dữ liệu vào bảng NGUOI_DUNG
INSERT INTO NGUOI_DUNG (ten_dang_nhap, mat_khau, ho_ten, email, so_dien_thoai, dia_chi, vai_tro, trang_thai) VALUES
('admin', '123', 'Quản Trị Viên', 'admin@nhahang3mien.com', '0836938006', 'Hà Nội', 'quan_ly', TRUE),
('nhanvien01', '$2y$10$YourHashedPasswordHere', 'Nguyễn Văn A', 'nva@nhahang3mien.com', '0912345678', '123 Nguyễn Huệ, Quận 1, TP HCM', 'nhan_vien', TRUE),
('nhanvien02', '$2y$10$YourHashedPasswordHere', 'Trần Thị B', 'ttb@nhahang3mien.com', '0923456789', '456 Lê Lợi, Quận Hoàn Kiếm, Hà Nội', 'nhan_vien', TRUE),
('nhanvien03', '$2y$10$YourHashedPasswordHere', 'Lê Văn C', 'lvc@nhahang3mien.com', '0934567890', '789 Trần Phú, Đà Nẵng', 'nhan_vien', TRUE),
('nguoidung01', '$2y$10$YourHashedPasswordHere', 'Phạm Thị D', 'ptd@gmail.com', '0945678901', '234 Nguyễn Trãi, Quận 5, TP HCM', 'khach_hang', TRUE),
('nguoidung02', '$2y$10$YourHashedPasswordHere', 'Hoàng Văn E', 'hve@gmail.com', '0956789012', '567 Lý Thường Kiệt, Quận Hai Bà Trưng, Hà Nội', 'khach_hang', TRUE),
('nguoidung03', '$2y$10$YourHashedPasswordHere', 'Ngô Thị F', 'ntf@gmail.com', '0967890123', '890 Hùng Vương, Đà Nẵng', 'khach_hang', TRUE),
('nguoidung04', '$2y$10$YourHashedPasswordHere', 'Vũ Văn G', 'vvg@gmail.com', '0978901234', '123 Lê Duẩn, Quận 1, TP HCM', 'khach_hang', TRUE),
('nguoidung05', '$2y$10$YourHashedPasswordHere', 'Đặng Thị H', 'dth@gmail.com', '0989012345', '456 Bà Triệu, Quận Hoàn Kiếm, Hà Nội', 'khach_hang', TRUE),
('nguoidung06', '$2y$10$YourHashedPasswordHere', 'Bùi Văn I', 'bvi@gmail.com', '0990123456', '789 Nguyễn Văn Linh, Đà Nẵng', 'khach_hang', TRUE);
SELECT * FROM NGUOI_DUNG;
-- Thêm dữ liệu vào bảng VUNG_MIEN
INSERT INTO VUNG_MIEN (ten) VALUES
('Miền Bắc'),
('Miền Trung'),
('Miền Nam');
SELECT*FROM VUNG_MIEN;
-- Thêm dữ liệu vào bảng DANH_MUC
INSERT INTO DANH_MUC (ten) VALUES
('Món kho'),
('Món chính'),
('Món xào'),
('Canh - Súp '),
('Món rau'),
('Món bánh'),
('Món nước'),
('Đồ uống'),
('Món khác');
SELECT*FROM DANH_MUC;

-- Thêm dữ liệu vào bảng MON_AN (Miền Bắc)
INSERT INTO MON_AN (
    ten,
    mo_ta, 
    gia, 
    hinh_anh, 
    id_danh_muc, 
    id_vung_mien,
    dac_trung,
    trang_thai
) VALUES
-- Miền Bắc
('Nem rán', 'Nem rán giòn thơm với nhân thịt, nấm mèo, miến, cà rốt được bọc trong lớp bánh đa nem và chiên giòn', 120000, 'nem_ran.jpg', 2, 1, TRUE, 'con_mon'),
('Bánh cuốn', 'Bánh cuốn mỏng, mềm, thơm mùi gạo với nhân thịt băm, nấm mèo, hành khô', 85000, 'banh_cuon.jpg', 6, 1, TRUE, 'con_mon'),
('Phở', 'Phở bò với nước dùng ngọt thanh, bánh phở mềm, thịt bò tái thơm ngon', 95000, 'img/pho_bo.jpg', 2, 1, TRUE, 'con_mon'),

-- Miền Trung
('Bánh bèo Huế', 'Bánh bèo chan nước mắm chua ngọt và hành phi thơm phức', 80000, 'banh_beo.jpg', 6, 2, TRUE, 'con_mon'),
('Nem lụi Huế', 'Nem lụi nướng thơm lừng ăn kèm với bánh tráng, rau sống và nước chấm', 95000, 'nem_lui.jpg', 9, 2, TRUE, 'con_mon'),
('Bún bò Huế', 'Bún bò Huế với nước dùng đậm đà, cay nồng, thịt bò, giò heo, chả cua', 110000, 'bun_bo_hue.jpg', 2, 2, TRUE, 'con_mon'),

-- Miền Nam
('Gỏi cuốn', 'Gỏi cuốn tôm thịt tươi mát với rau sống và bún', 75000, 'goi_cuon.jpg', 6, 3, TRUE, 'con_mon'),
('Bò bía', 'Bò bía với nhân trứng, lạp xưởng, đậu phộng, rau thơm', 65000, 'bo_bia.jpg', 6, 3, TRUE, 'con_mon'),
('Hủ tiếu Nam Vang', 'Hủ tiếu với nước dùng trong veo, thịt bò, tôm, lòng heo và rau thơm', 95000, 'hu_tieu.jpg', 2, 3, TRUE, 'con_mon'),

-- Đồ uống
('Trà sen Hà Nội', 'Trà ướp hương sen thơm ngát', 35000, 'tra_sen.jpg', 8, 1, TRUE, 'con_mon'),
('Nước sấu', 'Nước sấu truyền thống Hà Nội chua ngọt mát lạnh', 30000, 'nuoc_sau.jpg', 8, 1, TRUE, 'con_mon'),
('Trà đào cam sả', 'Trà đào thơm ngọt với cam và sả', 40000, 'tra_dao.jpg', 8, 1, FALSE, 'con_mon');

-- Thêm dữ liệu vào bảng CHI_NHANH
INSERT INTO CHI_NHANH (
    ten, dia_chi, 
    so_dien_thoai, 
    gio_mo_cua, 
    gio_dong_cua, 
    trang_thai
    ) VALUES
('Nhà hàng 3 Miền Hà Nội', '123 Phan Chu Trinh, Hoàn Kiếm, Hà Nội', '0243123456', '10:00:00', '22:00:00', TRUE),
('Nhà hàng 3 Miền TP HCM', '456 Lê Lợi, Quận 1, TP HCM', '0283456789', '10:00:00', '22:00:00', TRUE),
('Nhà hàng 3 Miền Đà Nẵng', '789 Trần Phú, Hải Châu, Đà Nẵng', '0236789012', '10:00:00', '22:00:00', TRUE);

-- Thêm dữ liệu vào bảng MON_AN_CHI_NHANH
INSERT INTO MON_AN_CHI_NHANH (
    id_mon_an, 
    id_chi_nhanh, 
    tinh_trang
    ) VALUES
-- Chi nhánh Hà Nội
(1, 1, 'con_mon'),
(2, 1, 'con_mon'),
(3, 1, 'con_mon'),
(4, 1, 'con_mon'),
(5, 1, 'con_mon'),
(6, 1, 'con_mon'),
-- Chi nhánh TP HCM
(1, 2, 'con_mon'),
(2, 2, 'con_mon'),
(3, 2, 'con_mon'),
(4, 2, 'con_mon'),
(5, 2, 'con_mon'),
(6, 2, 'con_mon'),
-- Chi nhánh Đà Nẵng
(1, 3, 'con_mon'),
(2, 3, 'con_mon'),
(3, 3, 'con_mon'),
(4, 3, 'con_mon'),
(5, 3, 'con_mon'),
(6, 3, 'con_mon');

-- Thêm dữ liệu vào bảng DAT_BAN
INSERT INTO DAT_BAN (
    ten_nguoi_dat, 
    id_chi_nhanh, 
    thoi_gian_dat, 
    thoi_gian_du_kien, 
    so_nguoi, 
    ghi_chu, 
    trang_thai
) VALUES
('Lê Hồng Đỉnh',1,  '2025-05-20 09:00:00', '2025-05-21 18:00:00', 4, 'Kỷ niệm sinh nhật', 'da_xac_nhan'),
('Võ Thị Thảo',1, '2025-05-20 10:30:00', '2025-05-21 19:00:00', 4, 'Gặp đối tác', 'da_xac_nhan'),
('Hà Nhật Nguyên Vũ',1, '2025-05-20 11:00:00', '2025-05-22 20:00:00', 6, 'Liên hoan gia đình', 'cho_xac_nhan');

-- Thêm dữ liệu vào bảng HOA_DON
INSERT INTO HOA_DON (
    id_nguoi_dung,
    id_chi_nhanh,
    thoi_gian_tao,
    tong_tien,
    thue_vat,
    thanh_tien,
    hinh_thuc,
    trang_thai,
    ghi_chu
) VALUES
(5, 1, '2025-05-18 19:30:00', 500000, 42500, 467500, 'mang_ve', 'hoan_thanh', 'Khách hài lòng với món ăn'),
(6, 1, '2025-05-19 20:15:00', 650000, 58500, 643500, 'mang_ve', 'hoan_thanh', 'Phục vụ tốt'),
(7, 1, '2025-05-20 12:30:00', 350000, 35000, 385000, 'mang_ve', 'hoan_thanh', 'Đóng gói cẩn thận'),
(8, 1, '2025-05-20 18:45:00', 200000, 20000, 220000, 'mang_ve', 'hoan_thanh', 'Giao tới địa chỉ công ty'),
(9, 1, '2025-05-20 19:30:00', 900000, 80000, 880000, 'mang_ve', 'hoan_thanh', 'Tiệc gia đình');
