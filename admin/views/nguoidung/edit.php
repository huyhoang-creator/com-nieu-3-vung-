<?php include 'views/layouts/header.php'; ?>
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-900"><?php echo $page_title ?? 'Chỉnh sửa người dùng'; ?></h3>
        <a href="/3mien_restaurant/index.php?controller=nguoidung&action=index" class="text-blue-500">Quay lại danh sách</a>
    </div>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></span>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></span>
        </div>
    <?php endif; ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="POST" action="/3mien_restaurant/index.php?controller=nguoidung&action=edit&id=<?php echo htmlspecialchars($nguoidung['id'] ?? ''); ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tên đăng nhập <span class="text-red-500">*</span></label>
                    <input type="text" name="ten_dang_nhap" value="<?php echo htmlspecialchars($nguoidung['ten_dang_nhap'] ?? ''); ?>" class="mt-1 p-2 w-full border rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Mật khẩu (để trống nếu không đổi)</label>
                    <input type="password" name="mat_khau" class="mt-1 p-2 w-full border rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Họ tên <span class="text-red-500">*</span></label>
                    <input type="text" name="ho_ten" value="<?php echo htmlspecialchars($nguoidung['ho_ten'] ?? ''); ?>" class="mt-1 p-2 w-full border rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($nguoidung['email'] ?? ''); ?>" class="mt-1 p-2 w-full border rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                    <input type="text" name="so_dien_thoai" value="<?php echo htmlspecialchars($nguoidung['so_dien_thoai'] ?? ''); ?>" class="mt-1 p-2 w-full border rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                    <input type="text" name="dia_chi" value="<?php echo htmlspecialchars($nguoidung['dia_chi'] ?? ''); ?>" class="mt-1 p-2 w-full border rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Vai trò <span class="text-red-500">*</span></label>
                    <select name="vai_tro" class="mt-1 p-2 w-full border rounded" required>
                        <option value="khach_hang" <?php echo ($nguoidung['vai_tro'] ?? 'khach_hang') === 'khach_hang' ? 'selected' : ''; ?>>Khách hàng</option>
                        <option value="nhan_vien" <?php echo ($nguoidung['vai_tro'] ?? 'khach_hang') === 'nhan_vien' ? 'selected' : ''; ?>>Nhân viên</option>
                        <option value="quan_ly" <?php echo ($nguoidung['vai_tro'] ?? 'khach_hang') === 'quan_ly' ? 'selected' : ''; ?>>Quản lý</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-primary px-4 py-2 rounded text-white">Cập nhật</button>
        </form>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>