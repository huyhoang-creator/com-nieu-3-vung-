<?php include 'views/layouts/header.php'; ?>
<div class="space-y-6">
    <h3 class="text-lg font-semibold text-gray-900"><?php echo $page_title; ?></h3>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <span><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <span><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
        </div>
    <?php endif; ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3">Mã hóa đơn</th>
                    <th class="p-3">Tên khách hàng</th>
                    <th class="p-3">Thành tiền</th>
                    <th class="p-3">Thời gian tạo</th>
                    <th class="p-3">Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hoadons as $hoadon): ?>
                <tr class="border-b">
                    <td class="p-3"><?php echo $hoadon['ma_hoa_don']; ?></td>
                    <td class="p-3"><?php echo $hoadon['ten_khach_hang'] ?? 'Khách lẻ'; ?></td>
                    <td class="p-3"><?php echo number_format($hoadon['thanh_tien'] ?? 0); ?>đ</td>
                    <td class="p-3"><?php echo date('d/m/Y H:i', strtotime($hoadon['thoi_gian_tao'])); ?></td>
                    <td class="p-3">Hoàn thành</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>