<?php include 'views/layouts/header.php'; ?>
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-900"><?php echo $page_title ?? 'Người dùng'; ?></h3>
        <a href="index.php?controller=nguoidung&action=create" class="btn-primary px-4 py-2 rounded text-white">Thêm người dùng</a>
    </div>
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
                    <th class="p-3">ID</th>
                    <th class="p-3">Tên đăng nhập</th>
                    <th class="p-3">Họ tên</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Số điện thoại</th>
                    <th class="p-3">Địa chỉ</th>
                    <th class="p-3">Vai trò</th>
                    <th class="p-3">Trạng thái</th>
                    <th class="p-3">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nguoidungs as $nguoidung): ?>
                <tr class="border-b">
                    <td class="p-3"><?php echo $nguoidung['id']; ?></td>
                    <td class="p-3"><?php echo $nguoidung['ten_dang_nhap'] ?? ''; ?></td>
                    <td class="p-3"><?php echo $nguoidung['ho_ten'] ?? ''; ?></td>
                    <td class="p-3"><?php echo $nguoidung['email'] ?? ''; ?></td>
                    <td class="p-3"><?php echo $nguoidung['so_dien_thoai'] ?? ''; ?></td>
                    <td class="p-3"><?php echo $nguoidung['dia_chi'] ?? ''; ?></td>
                    <td class="p-3"><?php echo $nguoidung['vai_tro'] ?? 'khach_hang'; ?></td>
                    <td class="p-3"><?php echo $nguoidung['trang_thai'] ? 'Hoạt động' : 'Ngưng hoạt động'; ?></td>
                    <td class="p-3">
                        <a href="index.php?controller=nguoidung&action=edit&id=<?php echo $nguoidung['id']; ?>" class="text-blue-500 mr-2">Sửa</a>
                        <a href="index.php?controller=nguoidung&action=delete&id=<?php echo $nguoidung['id']; ?>" class="text-red-500" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>