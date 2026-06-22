<?php
include 'include/connect_db.php';

class DatbanController
{
    public function index()
    {
        global $conn;
        $sql = "SELECT db.*, cn.ten AS ten_chi_nhanh 
                FROM DAT_BAN db 
                LEFT JOIN CHI_NHANH cn ON db.id_chi_nhanh = cn.id 
                ORDER BY db.thoi_gian_dat DESC";
        $result = $conn->query($sql);
        $datbans = $result->fetch_all(MYSQLI_ASSOC);
        include 'views/datban/index.php';
    }

    public function create()
    {
        global $conn;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $ten_nguoi_dat = $_POST['ten_nguoi_dat'];
            $so_dien_thoai = $_POST['so_dien_thoai'];
            $so_nguoi = (int)$_POST['so_nguoi'];
            $date = $_POST['date'];
            $time = $_POST['time'];
            $thoi_gian_dat = $date . ' ' . $time;
            $thoi_gian_du_kien = $thoi_gian_dat; // Có thể điều chỉnh logic
            $ghi_chu = $_POST['ghi_chu'] ?? '';
            $trang_thai = 'cho_xac_nhan';
            $id_chi_nhanh = (int)$_POST['id_chi_nhanh'];

            $sql = "INSERT INTO DAT_BAN (ten_nguoi_dat, so_dien_thoai, thoi_gian_dat, thoi_gian_du_kien, so_nguoi, ghi_chu, trang_thai, id_chi_nhanh) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
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
  
        include __DIR__ . '/../../admin.php';
    }

    public function edit()
    {
        global $conn;
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = "ID không hợp lệ!";
            header("Location: index.php?controller=datban&action=index");
            exit();
        }
        $sql = "SELECT * FROM DAT_BAN WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $datban = $stmt->get_result()->fetch_assoc();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten_nguoi_dat = $_POST['ten_nguoi_dat'];
            $so_dien_thoai = $_POST['so_dien_thoai'];
            $so_nguoi = $_POST['so_nguoi'];
            $thoi_gian_dat = $_POST['thoi_gian_dat'];
            $thoi_gian_du_kien = $_POST['thoi_gian_du_kien'];
            $ghi_chu = $_POST['ghi_chu'] ?? '';
            $trang_thai = $_POST['trang_thai'];
            $id_chi_nhanh = $_POST['id_chi_nhanh'];
            $sql = "UPDATE DAT_BAN SET ten_nguoi_dat = ?, so_dien_thoai = ?, thoi_gian_dat = ?, thoi_gian_du_kien = ?, so_nguoi = ?, ghi_chu = ?, trang_thai = ?, id_chi_nhanh = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssissii", $ten_nguoi_dat, $so_dien_thoai, $thoi_gian_dat, $thoi_gian_du_kien, $so_nguoi, $ghi_chu, $trang_thai, $id_chi_nhanh, $id);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Cập nhật thành công!";
            } else {
                $_SESSION['error'] = "Cập nhật thất bại!";
            }
            $stmt->close();
            header("Location: index.php?controller=datban&action=index");
            exit();
        }
        include 'views/datban/edit.php';
    }

    public function delete()
    {
        global $conn;
        $id = $_GET['id'] ?? null;
        if ($id) {
            $stmt = $conn->prepare("DELETE FROM DAT_BAN WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Xóa đặt bàn thành công!";
            } else {
                $_SESSION['error'] = "Xóa đặt bàn thất bại!";
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = "Không có ID để xóa.";
        }
        header("Location: index.php?controller=datban&action=index");
        exit();
    }
}