<?php include 'views/layouts/header.php'; ?>

<h2>Danh sách đặt bàn</h2>
<?php if (isset($_SESSION['success'])): ?>
    <p style="color: green;"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red;"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Tên người đặt</th>
        <th>Thời gian đặt</th>
        <th>Thời gian dự kiến</th>
        <th>Số người</th>
        <th>Ghi chú</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($datbans as $row): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['ten_nguoi_dat'] ?? '') ?></td>
        <td><?= $row['thoi_gian_dat'] ?></td>
        <td><?= $row['thoi_gian_du_kien'] ?></td>
        <td><?= $row['so_nguoi'] ?></td>
        <td><?= htmlspecialchars($row['ghi_chu'] ?? '') ?></td>
        <td><?= $row['trang_thai'] ?></td>
        <td>
            <a href="index.php?controller=datban&action=edit&id=<?= $row['id'] ?>">Sửa</a> |
            <a href="index.php?controller=datban&action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Xóa đặt bàn này?')">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include 'views/layouts/footer.php'; ?>