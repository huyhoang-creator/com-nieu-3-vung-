<?php
// Kiểm tra nếu session chưa được khởi động thì khởi động
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['user']) || $_SESSION['user']['vai_tro'] !== 'quan_ly') {
    header("Location: login.php");
    exit();
}

// Đặt tiêu đề trang
$page_title = 'Thêm món ăn';

include 'views/layouts/header.php';
?>
<style>
    /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Dashboard Container (for admin.php) */
.dashboard-container {
    padding: 32px;
    max-width: 1280px;
    margin: 0 auto;
    background-color: #f9fafb;
}

/* Statistics Cards (for admin.php) */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    margin-bottom: 48px;
}

.stat-card {
    background: linear-gradient(145deg, #ffffff, #f1f5f9);
    border-radius: 16px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
    padding: 24px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
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
    font-weight: 500;
    color: #4b5563;
    margin-bottom: 8px;
    text-transform: uppercase;
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #1f2937;
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(145deg, #e5e7eb, #d1d5db);
}

.stat-icon i {
    color: #ffffff;
    font-size: 28px;
}

/* Quick Actions (for admin.php) */
.quick-actions-section {
    margin-top: 48px;
}

.actions-title {
    font-size: 26px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 24px;
    letter-spacing: -0.5px;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
}

.action-item {
    background: linear-gradient(145deg, #ffffff, #f1f5f9);
    border-radius: 16px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
    padding: 24px;
    display: flex;
    align-items: center;
    text-decoration: none;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.action-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
}

.action-item i {
    font-size: 32px;
    margin-right: 20px;
    transition: transform 0.3s ease;
}

.action-item:hover i {
    transform: scale(1.1);
}

.action-text {
    flex: 1;
}

.action-label {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
}

.action-description {
    font-size: 14px;
    color: #6b7280;
    margin-top: 4px;
}

/* Form Styles (for create.php - nguoidung and monan) */
.form-container {
    padding: 32px;
    max-width: 1280px;
    margin: 0 auto;
    background-color: #f9fafb;
}

.form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    padding-bottom: 16px;
    border-bottom: 2px solid #e5e7eb;
}

.form-title {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    letter-spacing: -0.5px;
}

.back-link {
    font-size: 16px;
    font-weight: 500;
    color: #3b82f6;
    text-decoration: none;
    transition: color 0.3s ease, transform 0.3s ease;
}

.back-link:hover {
    color: #1e40af;
    transform: translateX(-4px);
}

.alert {
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 32px;
    font-size: 16px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 12px;
}

.alert-success {
    background: linear-gradient(145deg, #d1fae5, #a7f3d0);
    border: 1px solid #10b981;
    color: #065f46;
}

.alert-error {
    background: linear-gradient(145deg, #fee2e2, #fecaca);
    border: 1px solid #ef4444;
    color: #991b1b;
}

.form-card {
    background: linear-gradient(145deg, #ffffff, #f1f5f9);
    border-radius: 16px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
    padding: 32px;
    border: 1px solid #e5e7eb;
}

.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    font-size: 16px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 10px;
}

.required {
    color: #ef4444;
    font-size: 16px;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    font-size: 16px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background-color: #ffffff;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: #dc2626;
    box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
}

.form-input:invalid:focus {
    border-color: #ef4444;
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
}

.form-input[type="number"]::-webkit-inner-spin-button,
.form-input[type="number"]::-webkit-outer-spin-button {
    opacity: 1;
}

.btn-primary {
    display: inline-block;
    padding: 12px 24px;
    font-size: 16px;
    font-weight: 600;
    color: #ffffff;
    background: linear-gradient(145deg, #dc2626, #b91c1c);
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(145deg, #b91c1c, #991b1b);
    transform: translateY(-2px);
}

.btn-primary:active {
    transform: translateY(0);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .dashboard-container, .form-container {
        padding: 16px;
    }

    .stats-grid, .actions-grid {
        grid-template-columns: 1fr;
    }

    .stat-card, .action-item, .form-card {
        padding: 20px;
    }

    .stat-value {
        font-size: 28px;
    }

    .actions-title, .form-title {
        font-size: 22px;
    }

    .form-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .back-link {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .stat-value {
        font-size: 24px;
    }

    .action-item i {
        font-size: 28px;
    }

    .form-input {
        padding: 10px 12px;
        font-size: 14px;
    }

    .btn-primary {
        padding: 10px 20px;
        font-size: 14px;
    }
}
</style>

<div class="form-container">
    <title>Thêm món ăn</title>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <span><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></span>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <span><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></span>
        </div>
    <?php endif; ?>
    <div class="form-card">
        <form method="POST" action="index.php?controller=monan&action=create">
            <div class="form-group">
                <label class="form-label">Tên món ăn <span class="required">*</span></label>
                <input type="text" name="ten_mon_an" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Giá <span class="required">*</span></label>
                <input type="number" name="gia" step="0.01" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Mô tả</label>
                <textarea name="mo_ta" class="form-input" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Danh mục <span class="required">*</span></label>
                <select name="id_danh_muc" class="form-input" required>
                    <?php
                    $danhmuc_sql = "SELECT * FROM DANH_MUC";
                    $danhmuc_result = $conn->query($danhmuc_sql);
                    while ($row = $danhmuc_result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['ten']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Vùng miền <span class="required">*</span></label>
                <select name="id_vung_mien" class="form-input" required>
                    <?php
                    $vungmien_sql = "SELECT * FROM VUNG_MIEN";
                    $vungmien_result = $conn->query($vungmien_sql);
                    while ($row = $vungmien_result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['ten']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn-primary">Thêm mới</button>
        </form>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>