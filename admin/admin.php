<?php
session_start();
// Kiểm tra đăng nhập
if (!isset($_SESSION['user']) || $_SESSION['user']['vai_tro'] !== 'quan_ly') {
    header("Location: login.php");
    exit();
}

// Đặt tiêu đề trang
$page_title = 'Dashboard';

// Kết nối database
include 'include/connect_db.php';

// Truy vấn dữ liệu thống kê cho tổng khách hàng và tổng món ăn
$sql_stats = "SELECT 
    (SELECT COUNT(*) FROM NGUOI_DUNG WHERE vai_tro = 'khach_hang') as total_customers,
    (SELECT COUNT(*) FROM MON_AN) as total_dishes";
$result_stats = $conn->query($sql_stats);
$stats = $result_stats->fetch_assoc();

include 'views/layouts/header.php';
?>
<style>
    /* Dashboard Container */
.dashboard-container {
    padding: 24px;
    max-width: 1200px;
    margin: 0 auto;
}

/* Statistics Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-3px);
}

.stat-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stat-text {
    flex: 1;
}

.stat-label {
    font-size: 16px;
    color: #6b7280;
    margin-bottom: 8px;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon i {
    color: #ffffff;
    font-size: 24px;
}

/* Quick Actions */
.quick-actions-section {
    margin-top: 40px;
}

.actions-title {
    font-size: 24px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 20px;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.action-item {
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    display: flex;
    align-items: center;
    text-decoration: none;
    transition: transform 0.2s, box-shadow 0.2s;
}

.action-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
}

.action-item i {
    font-size: 28px;
    margin-right: 16px;
}

.action-text {
    flex: 1;
}

.action-label {
    font-size: 18px;
    font-weight: 500;
    color: #1f2937;
}

.action-description {
    font-size: 14px;
    color: #6b7280;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .stats-grid, .actions-grid {
        grid-template-columns: 1fr;
    }

    .stat-card, .action-item {
        padding: 16px;
    }

    .stat-value {
        font-size: 24px;
    }

    .actions-title {
        font-size: 20px;
    }
}
</style>

<div class="dashboard-container">
    <!-- Statistics Cards (Only Total Customers and Total Dishes) -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-text">
                    <p class="stat-label">Tổng khách hàng</p>
                    <p class="stat-value"><?php echo number_format($stats['total_customers'] ?? 0); ?></p>
                </div>
                <div class="stat-icon" style="background-color: #3b82f6;">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-text">
                    <p class="stat-label">Tổng món ăn</p>
                    <p class="stat-value"><?php echo number_format($stats['total_dishes'] ?? 0); ?></p>
                </div>
                <div class="stat-icon" style="background-color: #f59e0b;">
                    <i class="fas fa-utensils"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions-section">
        <h3 class="actions-title">Thao tác nhanh</h3>
        <div class="actions-grid">
            <a href="index.php?controller=monan&action=create" class="action-item">
                <i class="fas fa-plus-circle" style="color: #dc2626;"></i>
                <div class="action-text">
                    <p class="action-label">Thêm món ăn</p>
                    <p class="action-description">Thêm món ăn mới</p>
                </div>
            </a>

            <a href="index.php?controller=hoadon&action=index" class="action-item">
                <i class="fas fa-receipt" style="color: #3b82f6;"></i>
                <div class="action-text">
                    <p class="action-label">Xem đơn hàng</p>
                    <p class="action-description">Quản lý đơn hàng</p>
                </div>
            </a>

            <a href="index.php?controller=nguoidung&action=index" class="action-item">
                <i class="fas fa-user-plus" style="color: #10b981;"></i>
                <div class="action-text">
                    <p class="action-label">Thêm người dùng</p>
                    <p class="action-description">Thêm nhân viên mới</p>
                </div>
            </a>
            </a>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>