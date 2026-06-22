<?php include 'views/layouts/header.php'; ?>
<a href="index.php?controller=datban&action=create">Thêm đặt bàn</a>
<h2>Sửa đặt bàn</h2>
<form method="post">
    <label>Tên người đặt: <input type="text" name="ten_nguoi_dat" value="<?= htmlspecialchars($datban['ten_nguoi_dat'] ?? '') ?>" required></label><br>
    <label>Số người: <input type="number" name="so_nguoi" value="<?= $datban['so_nguoi'] ?? 1 ?>" min="1" required></label><br>
    <label>Thời gian đặt: <input type="datetime-local" name="thoi_gian_dat" value="<?= date('Y-m-d\TH:i', strtotime($datban['thoi_gian_dat'] ?? '')) ?>" required></label><br>
    <label>Thời gian dự kiến: <input type="datetime-local" name="thoi_gian_du_kien" value="<?= date('Y-m-d\TH:i', strtotime($datban['thoi_gian_du_kien'] ?? '')) ?>" required></label><br>
    <label>Ghi chú: <textarea name="ghi_chu"><?= htmlspecialchars($datban['ghi_chu'] ?? '') ?></textarea></label><br>
    <label>Trạng thái:
        <select name="trang_thai">
            <option value="cho_xac_nhan" <?= ($datban['trang_thai'] ?? 'cho_xac_nhan') == 'cho_xac_nhan' ? 'selected' : '' ?>>Chờ xác nhận</option>
            <option value="da_xac_nhan" <?= ($datban['trang_thai'] ?? 'cho_xac_nhan') == 'da_xac_nhan' ? 'selected' : '' ?>>Đã xác nhận</option>
            <option value="da_huy" <?= ($datban['trang_thai'] ?? 'cho_xac_nhan') == 'da_huy' ? 'selected' : '' ?>>Đã hủy</option>
        </select>
    </label><br>
    <button type="submit">Cập nhật</button>
    <a href="index.php?controller=datban&action=index">Quay lại</a>
</form>
<?php include 'views/layouts/footer.php'; ?>