<?php include 'views/layouts/header.php'; ?>
<div class="space-y-6">
    <title><?= isset($page_title) ? $page_title : 'Quản chi nhánh' ?></title>
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
        <form method="POST" action="index.php?controller=chinhanh&action=edit&id=<?php echo $chinhanh['id']; ?>">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tên chi nhánh</label>
                <input type="text" name="ten_chi_nhanh" value="<?php echo $chinhanh['ten']; ?>" class="mt-1 p-2 w-full border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                <textarea name="dia_chi" class="mt-1 p-2 w-full border rounded" rows="3" required><?php echo $chinhanh['dia_chi']; ?></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                <input type="text" name="so_dien_thoai" value="<?php echo $chinhanh['so_dien_thoai']; ?>" class="mt-1 p-2 w-full border rounded" required>
            </div>
            <button type="submit" class="btn-primary px-4 py-2 rounded text-white">Cập nhật</button>
        </form>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>