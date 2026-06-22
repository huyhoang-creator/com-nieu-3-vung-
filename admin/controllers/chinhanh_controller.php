<?php
require_once __DIR__ . '/../include/connect_db.php';

class ChinhanhController
{
    public function index()
    {
        global $conn;
        $sql = "SELECT * FROM CHI_NHANH";
        $result = $conn->query($sql);
        $chinhanhs = $result->fetch_all(MYSQLI_ASSOC);
        include 'views/chinhanh/index.php';
    }
    
    public function edit()
    {
        global $conn;
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = "ID không hợp lệ!";
            header("Location: index.php?controller=chinhanh&action=index");
            exit();
        }

        $stmt = $conn->prepare("SELECT * FROM CHI_NHANH WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $chinhanh = $stmt->get_result()->fetch_assoc();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten = $_POST['ten'];
            $dia_chi = $_POST['dia_chi'];
            $so_dien_thoai = $_POST['so_dien_thoai'];
            $gio_mo_cua = $_POST['gio_mo_cua'];
            $gio_dong_cua = $_POST['gio_dong_cua'];
            $trang_thai = isset($_POST['trang_thai']) ? 1 : 0;

            $stmt = $conn->prepare("UPDATE CHI_NHANH SET ten = ?, dia_chi = ?, so_dien_thoai = ?, gio_mo_cua = ?, gio_dong_cua = ?, trang_thai = ? WHERE id = ?");
            $stmt->bind_param("ssssssi", $ten, $dia_chi, $so_dien_thoai, $gio_mo_cua, $gio_dong_cua, $trang_thai, $id);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Cập nhật thành công!";
            } else {
                $_SESSION['error'] = "Cập nhật thất bại!";
            }

            $stmt->close();
            header("Location: index.php?controller=chinhanh&action=index");
            exit();
        }

        include 'views/chinhanh/edit.php';
    }

    public function delete()
{
    global $conn;
    $id = $_GET['id'] ?? null;

    if ($id) {
        // 1. Lấy toàn bộ bàn ăn thuộc chi nhánh
        $stmt_ban = $conn->prepare("SELECT id FROM BAN_AN WHERE id_chi_nhanh = ?");
        $stmt_ban->bind_param("i", $id);
        $stmt_ban->execute();
        $result = $stmt_ban->get_result();

        // Duyệt từng bàn ăn để xóa liên kết ở các bảng phụ thuộc
        while ($ban = $result->fetch_assoc()) {
            $ban_an_id = $ban['id'];

            // 2. Xóa hóa đơn liên quan
            $stmt_hd = $conn->prepare("DELETE FROM HOA_DON WHERE id_ban_an = ?");
            $stmt_hd->bind_param("i", $ban_an_id);
            $stmt_hd->execute();
            $stmt_hd->close();

            // 3. Xóa đặt bàn liên quan
            $stmt_db = $conn->prepare("DELETE FROM DAT_BAN WHERE id_ban_an = ?");
            $stmt_db->bind_param("i", $ban_an_id);
            $stmt_db->execute();
            $stmt_db->close();
        }
        $stmt_ban->close();

        // 4. Xóa món ăn của chi nhánh
        $stmt1 = $conn->prepare("DELETE FROM MON_AN_CHI_NHANH WHERE id_chi_nhanh = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();

        // 5. Xóa bàn ăn
        $stmt2 = $conn->prepare("DELETE FROM BAN_AN WHERE id_chi_nhanh = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->close();

        // 6. Xóa chi nhánh
        $stmt = $conn->prepare("DELETE FROM CHI_NHANH WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Xóa chi nhánh thành công!";
        } else {
            $_SESSION['error'] = "Xóa chi nhánh thất bại!";
        }

        $stmt->close();
    }

    header("Location: index.php?controller=chinhanh&action=index");
    exit();
}


}
