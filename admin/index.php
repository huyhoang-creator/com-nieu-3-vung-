<?php
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['user']) || $_SESSION['user']['vai_tro'] !== 'quan_ly') {
    header("Location: login.php");
    exit();
}

// Lấy controller và action
$controller = $_GET['controller'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';

switch ($controller) {
    case 'dashboard':
        include 'admin.php';
        break;

    case 'monan':
        require_once __DIR__ . '/controllers/monan_controller.php';
        $monan = new MonanController();
        $monan->$action();
        break;
        
    case 'chinhanh':
        require_once __DIR__ . '/controllers/chinhanh_controller.php';
        $chinhanh = new ChinhanhController();
        if (method_exists($chinhanh, $action)) {
            $chinhanh->$action();
        } else {
            echo "Action không tồn tại trong ChinhanhController.";
        }
        break;

    case 'nguoidung':
        require_once __DIR__ . '/controllers/nguoidung_controller.php';
        $nguoidung = new NguoidungController();
        if (method_exists($nguoidung, $action)) {
            $nguoidung->$action();
        } else {
            echo "Action không tồn tại trong NguoidungController.";
        }
        break;

    case 'datban':
        require_once __DIR__ . '/controllers/datban_controller.php';
        $datban = new DatbanController();
        if (method_exists($datban, $action)) {
            $datban->$action();
        } else {
            echo "Action không tồn tại trong DatbanController.";
        }
        break;

    default:
        include 'admin.php';
        break;
}