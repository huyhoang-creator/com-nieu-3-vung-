<?php
include 'include/connect_db.php';

class NguoidungController
{
    public function index()
    {
        global $conn;
        $sql = "SELECT * FROM NGUOI_DUNG";
        $result = $conn->query($sql);
        $nguoidungs = $result->fetch_all(MYSQLI_ASSOC);
        include 'views/nguoidung/index.php';
    }

    
    public function create()
        {
            global $conn;
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $ten_dang_nhap = $_POST['ten_dang_nhap'];
                $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_DEFAULT);
                $ho_ten = $_POST['ho_ten'];
                $email = $_POST['email'];
                $so_dien_thoai = $_POST['so_dien_thoai'] ?? null;
                $dia_chi = $_POST['dia_chi'] ?? null;
                $vai_tro = $_POST['vai_tro'] ?? 'khach_hang';

                $sql = "INSERT INTO NGUOI_DUNG (ten_dang_nhap, mat_khau, ho_ten, email, so_dien_thoai, dia_chi, vai_tro) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssss", $ten_dang_nhap, $mat_khau, $ho_ten, $email, $so_dien_thoai, $dia_chi, $vai_tro);
                if ($stmt->execute()) {
                    $_SESSION['success'] = "Thêm người dùng thành công!";
                } else {
                    $_SESSION['error'] = "Thêm người dùng thất bại!";
                }
                $stmt->close();
                header("Location: index.php?controller=nguoidung&action=index");
                exit();
            }
            include 'views/nguoidung/create.php';
        }

    public function edit()
    {
        global $conn;
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = "ID không hợp lệ!";
            header("Location: index.php?controller=nguoidung&action=index");
            exit();
        }
        $sql = "SELECT * FROM NGUOI_DUNG WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $nguoidung = $stmt->get_result()->fetch_assoc();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten_dang_nhap = $_POST['ten_dang_nhap'];
            $mat_khau = !empty($_POST['mat_khau']) ? password_hash($_POST['mat_khau'], PASSWORD_DEFAULT) : $nguoidung['mat_khau'];
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? null;
            $dia_chi = $_POST['dia_chi'] ?? null;
            $vai_tro = $_POST['vai_tro'] ?? 'khach_hang';

            $sql = "UPDATE NGUOI_DUNG SET ten_dang_nhap = ?, mat_khau = ?, ho_ten = ?, email = ?, so_dien_thoai = ?, dia_chi = ?, vai_tro = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssi", $ten_dang_nhap, $mat_khau, $ho_ten, $email, $so_dien_thoai, $dia_chi, $vai_tro, $id);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Cập nhật người dùng thành công!";
            } else {
                $_SESSION['error'] = "Cập nhật người dùng thất bại!";
            }
            $stmt->close();
            header("Location: index.php?controller=nguoidung&action=index");
            exit();
        }
        include 'views/nguoidung/edit.php';
    }

    public function delete()
    {
        global $conn;
        $id = $_GET['id'] ?? null;

        if ($id) {
            $sql = "DELETE FROM NGUOI_DUNG WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Xóa người dùng thành công!";
            } else {
                $_SESSION['error'] = "Xóa người dùng thất bại!";
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = "Không có ID để xóa.";
        }

        header("Location: index.php?controller=nguoidung&action=index");
        exit();
    }
}