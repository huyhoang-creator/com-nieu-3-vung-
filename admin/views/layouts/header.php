<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Nhà hàng 3 miền - Hệ thống quản lý</title>
    <style>
        /* Reset và cài đặt cơ bản */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            min-height: 100vh;
        }

        /* Container */
        .container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 256px;
            background: linear-gradient(to bottom, #dc2626, #b91c1c);
            color: #ffffff;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        }

        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid #dc2626;
        }

        .sidebar-title {
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-items: center;
            margin-bottom: 4px;
        }

        .sidebar-title i {
            margin-right: 12px;
        }

        .sidebar-subtitle {
            font-size: 14px;
            color: #fee2e2;
        }

        .sidebar-nav {
            margin-top: 24px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .nav-item:hover {
            background-color: #b91c1c;
        }

        .nav-item i {
            width: 20px;
            margin-right: 12px;
        }

        .active {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border-right: 4px solid #fbbf24;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Top Header */
        .header {
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 32px;
            height: 32px;
            background-color: #dc2626;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar i {
            color: #ffffff;
            font-size: 14px;
        }

        .logout-btn {
            padding: 8px;
            color: #4b5563;
            text-decoration: none;
            transition: color 0.3s;
        }

        .logout-btn:hover {
            color: #dc2626;
        }

        /* Page Content */
        .content {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h1 class="sidebar-title">
                    <i class="fas fa-utensils"></i>
                    Nhà hàng 3 miền
                </h1>
                <p class="sidebar-subtitle">Hệ thống quản lý</p>
            </div>
            
            <nav class="sidebar-nav">
                <?php
                $current_page = $_GET['controller'] ?? 'dashboard';
                $menu_items = [
                    'dashboard' => ['icon' => 'fas fa-home', 'label' => 'Dashboard'],
                    'monan' => ['icon' => 'fas fa-utensils', 'label' => 'Quản lý món ăn'],
                    'hoadon' => ['icon' => 'fas fa-receipt', 'label' => 'Đơn hàng'],
                    'nguoidung' => ['icon' => 'fas fa-users', 'label' => 'Người dùng'],
                    'chinhanh' => ['icon' => 'fas fa-store', 'label' => 'Chi nhánh'],
                    'datban' => ['icon' => 'fas fa-calendar-alt', 'label' => 'Đặt bàn'],
                ];

                foreach ($menu_items as $key => $item):
                    $active_class = ($current_page === $key) ? 'active' : '';
                ?>
                <a href="index.php?controller=<?php echo $key; ?>&action=index" class="nav-item <?php echo $active_class; ?>">
                    <i class="<?php echo $item['icon']; ?>"></i>
                    <span class="nav-label"><?php echo $item['label']; ?></span>
                </a>
                <?php endforeach; ?>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Header -->
            <header class="header">
                <div class="header-content">
                    <div class="header-title">
                        <h2 class="page-title"><?php echo $page_title ?? 'Dashboard'; ?></h2>
                    </div>
                    
                    <div class="user-actions">
                        <div class="user-info">
                            <div class="avatar">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        
                        <a href="index.php?controller=auth&action=logout" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="content">