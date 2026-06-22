public function create()
{
    global $conn;
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ten_nguoi_dat = $_POST['ten_nguoi_dat'] ?? '';
        $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
        $so_nguoi = isset($_POST['so_nguoi']) ? (int)$_POST['so_nguoi'] : 0;
        $date = $_POST['date'] ?? '';
        $time = $_POST['time'] ?? '';
        $thoi_gian_dat = $date . ' ' . $time;
        $thoi_gian_du_kien = $thoi_gian_dat;
        $ghi_chu = $_POST['ghi_chu'] ?? '';
        $trang_thai = 'cho_xac_nhan';
        $id_chi_nhanh = isset($_POST['id_chi_nhanh']) ? (int)$_POST['id_chi_nhanh'] : 0;

        // Kiểm tra dữ liệu bắt buộc
        if (empty($ten_nguoi_dat) || empty($so_dien_thoai) || !$id_chi_nhanh) {
            $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin.";
            header("Location: index.php?controller=datban&action=create");
            exit();
        }

        $sql = "INSERT INTO DAT_BAN 
                (ten_nguoi_dat, so_dien_thoai, thoi_gian_dat, thoi_gian_du_kien, so_nguoi, ghi_chu, trang_thai, id_chi_nhanh) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssissii", $ten_nguoi_dat, $so_dien_thoai, $thoi_gian_dat, $thoi_gian_du_kien, $so_nguoi, $ghi_chu, $trang_thai, $id_chi_nhanh);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Đặt bàn thành công!";
        } else {
            $_SESSION['error'] = "Đặt bàn thất bại: " . $conn->error;
        }
        $stmt->close();
        header("Location: index.php?controller=datban&action=index");
        exit();
    }

    // Giao diện form (admin hoặc user)
    include 'views/datban/create.php';
}
