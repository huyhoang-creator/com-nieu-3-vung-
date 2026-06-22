<?php
include 'include/connect_db.php';

$page_title = 'Hóa đơn hoàn tất';

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $sql = "SELECT * FROM HOA_DON WHERE trang_thai = 'hoan_thanh' ORDER BY thoi_gian_tao DESC";
        $result = $conn->query($sql);
        $hoadons = $result->fetch_all(MYSQLI_ASSOC);
        include 'admin/views/hoadon/index.php';
        break;

    default:
        header("Location: index.php?controller=hoadon&action=index");
        exit();
}