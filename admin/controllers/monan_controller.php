<?php
include 'include/connect_db.php';


class MonanController
{
    public function index()
    {
        global $conn;
        $sql = "SELECT * FROM MON_AN";
        $result = $conn->query($sql);
        $monans = $result->fetch_all(MYSQLI_ASSOC);
        include 'views/monan/index.php';
    }
    public function create()
{
    global $conn;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ten = $_POST['ten_mon_an'] ?? null;
        $gia = $_POST['gia'] ?? null;
        $mo_ta = $_POST['mo_ta'] ?? null;
        $id_danh_muc = $_POST['id_danh_muc'] ?? null; // Thêm trường từ form
        $id_vung_mien = $_POST['id_vung_mien'] ?? null; // Thêm trường từ form

        // Kiểm tra các giá trị bắt buộc
        if ($ten === null || $gia === null || $mo_ta === null || $id_danh_muc === null || $id_vung_mien === null) {
            $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin!";
            header("Location: index.php?controller=monan&action=create");
            exit();
        }

        $sql = "INSERT INTO MON_AN (ten, gia, mo_ta, id_danh_muc, id_vung_mien) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisii", $ten, $gia, $mo_ta, $id_danh_muc, $id_vung_mien); // i: integer cho id_danh_muc và id_vung_mien
        if ($stmt->execute()) {
            $_SESSION['success'] = "Thêm thành công!";
        } else {
            $_SESSION['error'] = "Thêm thất bại! " . $conn->error; // Thêm lỗi chi tiết để debug
        }
        $stmt->close();
        header("Location: index.php?controller=monan&action=index");
        exit();
    }
    include 'views/monan/create.php';
}

    public function edit()
    {
        global $conn;
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = "ID không hợp lệ!";
            header("Location: index.php?controller=monan&action=index");
            exit();
        }
        $sql = "SELECT * FROM MON_AN WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $monan = $stmt->get_result()->fetch_assoc();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten = $_POST['ten'];
            $gia = $_POST['gia'];
            $mo_ta = $_POST['mo_ta'];
            $sql = "UPDATE MON_AN SET ten = ?, gia = ?, mo_ta = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sisi", $ten, $gia, $mo_ta, $id);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Cập nhật thành công!";
            } else {
                $_SESSION['error'] = "Cập nhật thất bại!";
            }
            $stmt->close();
            header("Location: index.php?controller=monan&action=index");
            exit();
        }
        include 'views/monan/edit.php';
    }
public function delete()
{
    global $conn;
    $id = $_GET['id'] ?? null;

    if ($id) {

        $stmt2 = $conn->prepare("DELETE FROM MON_AN WHERE id = ?");
        $stmt2->bind_param("i", $id);
        if ($stmt2->execute()) {
            $_SESSION['success'] = "Xóa món ăn thành công!";
        } else {
            $_SESSION['error'] = "Xóa món ăn thất bại!";
        }
        $stmt2->close();
    } else {
        $_SESSION['error'] = "Không có ID để xóa.";
    }

    header("Location: index.php?controller=monan&action=index");
    exit();
}

}
