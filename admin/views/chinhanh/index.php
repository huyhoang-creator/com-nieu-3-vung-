<?php include 'views/layouts/header.php'; ?>
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <title><?= isset($page_title) ? $page_title : 'Quản chi nhánh' ?></title>
        <a href="index.php?controller=chinhanh&action=create" class="btn-primary px-4 py-2 rounded text-white">Thêm chi nhánh</a>
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
                    <th class="p-3">Tên chi nhánh</th>
                    <th class="p-3">Địa chỉ</th>
                    <th class="p-3">Số điện thoại</th>
                    <th class="p-3">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chinhanhs as $chinhanh): ?>
                <tr class="border-b">
                    <td class="p-3"><?php echo $chinhanh['id']; ?></td>
                    <td class="p-3"><?php echo $chinhanh['ten']; ?></td>
                    <td class="p-3"><?php echo $chinhanh['dia_chi']; ?></td>
                    <td class="p-3"><?php echo $chinhanh['so_dien_thoai']; ?></td>
                    <td class="p-3">
                        <a href="index.php?controller=chinhanh&action=edit&id=<?php echo $chinhanh['id']; ?>" class="text-blue-500 mr-2">Sửa</a>
                        <a href="index.php?controller=chinhanh&action=delete&id=<?php echo $chinhanh['id']; ?>" class="text-red-500">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>