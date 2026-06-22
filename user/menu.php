<?php 
session_start();
include 'include/connect_db.php'; 

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xử lý thêm vào giỏ hàng bằng form POST
if (isset($_POST['action']) && $_POST['action'] === 'add_to_cart' && isset($_POST['product_id'], $_POST['branch_id'])) {
    $product_id = intval($_POST['product_id']);
    $branch_id = intval($_POST['branch_id']);
    $quantity = intval($_POST['quantity']) ?: 1;
    
    // Kiểm tra món có sẵn tại chi nhánh không
    $check_query = "SELECT macn.tinh_trang, ma.ten, ma.gia 
                    FROM MON_AN_CHI_NHANH macn 
                    JOIN MON_AN ma ON macn.id_mon_an = ma.id 
                    WHERE macn.id_mon_an = ? AND macn.id_chi_nhanh = ? AND macn.tinh_trang = 'con_mon'";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $product_id, $branch_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $cart_key = $product_id . '_' . $branch_id;
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        if (isset($_SESSION['cart'][$cart_key])) {
            $_SESSION['cart'][$cart_key]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$cart_key] = [
                'product_id' => $product_id,
                'branch_id' => $branch_id,
                'name' => $product['ten'],
                'price' => $product['gia'],
                'quantity' => $quantity
            ];
        }
        header("Location: menu.php?branch=$branch_id");
        exit;
    } else {
        $add_error = 'Món ăn không có sẵn.';
    }
}

// Xử lý cập nhật giỏ hàng
if (isset($_POST['action']) && $_POST['action'] === 'update_cart' && isset($_POST['cart_key'], $_POST['quantity'])) {
    $cart_key = $_POST['cart_key'];
    $quantity = intval($_POST['quantity']);
    if ($quantity > 0 && isset($_SESSION['cart'][$cart_key])) {
        $_SESSION['cart'][$cart_key]['quantity'] = $quantity;
    }
    $branch_id = isset($_GET['branch']) ? intval($_GET['branch']) : (isset($_POST['branch_id']) ? intval($_POST['branch_id']) : 0);
    header('Location: menu.php?branch=' . $branch_id);
    exit;
}

// Xử lý xóa khỏi giỏ hàng
if (isset($_POST['action']) && $_POST['action'] === 'remove_from_cart' && isset($_POST['cart_key'])) {
    $cart_key = $_POST['cart_key'];
    if (isset($_SESSION['cart'][$cart_key])) {
        unset($_SESSION['cart'][$cart_key]);
    }
    $branch_id = isset($_GET['branch']) ? intval($_GET['branch']) : (isset($_POST['branch_id']) ? intval($_POST['branch_id']) : 0);
    header('Location: menu.php?branch=' . $branch_id);
    exit;
}

// Lấy chi nhánh được chọn
$selected_branch = isset($_GET['branch']) ? intval($_GET['branch']) : 0;
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_filter = isset($_GET['category']) ? intval($_GET['category']) : 0;
?>

<!-- Phần HTML giữ nguyên như code gốc -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhà Hàng 3 Miền - Menu</title>
    <link rel="stylesheet" href="css/menu.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <?php include 'include/header.php'; ?>
    </header>
    
    <div class="container">
        <!-- Control Panel -->
        <div class="control-panel">
            <form method="GET" class="filter-form">
                <!-- Branch Selection -->
                <div class="branch-select-section">
                    <label for="branchSelect">
                        <i class="fas fa-map-marker-alt"></i> Chọn chi nhánh:
                    </label>
                    <select name="branch" id="branchSelect" class="branch-dropdown" onchange="this.form.submit()">
                        <option value="0">-- Chọn chi nhánh --</option>
                        <?php
                        $branches_result = $conn->query("SELECT id, ten, dia_chi FROM CHI_NHANH WHERE trang_thai = 1");
                        while ($branch = $branches_result->fetch_assoc()) {
                            $selected = ($selected_branch == $branch['id']) ? 'selected' : '';
                            echo "<option value='" . $branch['id'] . "' {$selected}>" . 
                                 htmlspecialchars($branch['ten']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Search and Category -->
                <div class="search-section">
                    <div class="search-bar">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" placeholder="Tìm kiếm tên món..." 
                               class="search-input" value="<?php echo htmlspecialchars($search_term); ?>">
                    </div>
                    
                    <select name="category" class="category-dropdown">
                        <option value="0">Tất cả danh mục</option>
                        <?php
                        $categories_result = $conn->query("SELECT id, ten FROM DANH_MUC ORDER BY ten");
                        while ($cat = $categories_result->fetch_assoc()) {
                            $selected = ($category_filter == $cat['id']) ? 'selected' : '';
                            echo "<option value='" . $cat['id'] . "' {$selected}>" . 
                                 htmlspecialchars($cat['ten']) . "</option>";
                        }
                        ?>
                    </select>
                    
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </form>
        </div>

        <div class="main-content">
            <!-- Products Section -->
            <div class="products-section">
                <?php if ($selected_branch > 0): ?>
                    <?php
                    // Lấy thông tin chi nhánh
                    $branch_info_query = "SELECT ten, dia_chi FROM CHI_NHANH WHERE id = ?";
                    $stmt = $conn->prepare($branch_info_query);
                    $stmt->bind_param("i", $selected_branch);
                    $stmt->execute();
                    $branch_info = $stmt->get_result()->fetch_assoc();
                    ?>
                    
                    <div class="branch-info">
                        <h2><i class="fas fa-store"></i> <?php echo htmlspecialchars($branch_info['ten']); ?></h2>
                        <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($branch_info['dia_chi']); ?></p>
                    </div>

                    <?php
                    // Xây dựng query lấy sản phẩm
                    $query = "SELECT ma.id, ma.ten, ma.mo_ta, ma.gia, ma.hinh_anh, ma.dac_trung,
                                     dm.ten as danh_muc, vm.ten as vung_mien,
                                     COALESCE(macn.tinh_trang, 'het_mon') as tinh_trang
                              FROM MON_AN ma 
                              JOIN DANH_MUC dm ON ma.id_danh_muc = dm.id 
                              JOIN VUNG_MIEN vm ON ma.id_vung_mien = vm.id
                              LEFT JOIN MON_AN_CHI_NHANH macn ON ma.id = macn.id_mon_an AND macn.id_chi_nhanh = ?
                              WHERE ma.trang_thai = 'con_mon'";
                    
                    $params = [$selected_branch];
                    $types = "i";
                    
                    if (!empty($search_term)) {
                        $query .= " AND ma.ten LIKE ?";
                        $params[] = "%{$search_term}%";
                        $types .= "s";
                    }
                    
                    if ($category_filter > 0) {
                        $query .= " AND ma.id_danh_muc = ?";
                        $params[] = $category_filter;
                        $types .= "i";
                    }
                    
                    $query .= " ORDER BY ma.ten ASC";
                    
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param($types, ...$params);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    ?>

                    <div class="products-grid">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($product = $result->fetch_assoc()): ?>
                                <div class="product-card" data-product-id="<?php echo $product['id']; ?>">
                                    <div class="product-image">
                                        <?php if ($product['hinh_anh']): ?>
                                            <img src="img/<?php echo htmlspecialchars($product['hinh_anh']); ?>" 
                                                 alt="<?php echo htmlspecialchars($product['ten']); ?>"
                                                 onerror="this.src='https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&w=400'">
                                        <?php else: ?>
                                            <img src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&w=400" 
                                                 alt="<?php echo htmlspecialchars($product['ten']); ?>">
                                        <?php endif; ?>
                                        
                                        <?php if ($product['dac_trung']): ?>
                                            <div class="specialty-badge">
                                                <i class="fas fa-star"></i> Đặc trưng
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="region-badge">
                                            <?php echo htmlspecialchars($product['vung_mien']); ?>
                                        </div>
                                    </div>
                                    
                                    <div class="product-content">
                                        <h3 class="product-name"><?php echo htmlspecialchars($product['ten']); ?></h3>
                                        <p class="product-description"><?php echo htmlspecialchars($product['mo_ta']); ?></p>
                                        <div class="product-category"><?php echo htmlspecialchars($product['danh_muc']); ?></div>
                                        
                                        <div class="product-status <?php echo $product['tinh_trang'] === 'con_mon' ? 'available' : 'unavailable'; ?>">
                                            <i class="fas fa-<?php echo $product['tinh_trang'] === 'con_mon' ? 'check-circle' : 'times-circle'; ?>"></i>
                                            <?php echo $product['tinh_trang'] === 'con_mon' ? 'Còn món' : 'Hết món'; ?>
                                        </div>
                                        
                                        <div class="product-footer">
                                            <span class="product-price">
                                                <?php echo $product['gia'] ? number_format($product['gia'], 0, ',', '.') . 'đ' : 'Liên hệ'; ?>
                                            </span>
                                            
                                            <?php if ($product['tinh_trang'] === 'con_mon'): ?>
                                                <form method="post" style="display:inline;">
                                                    <input type="hidden" name="action" value="add_to_cart">
                                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                    <input type="hidden" name="branch_id" value="<?php echo $selected_branch; ?>">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="add-to-cart-btn">
                                                        <i class="fas fa-plus"></i> Thêm vào giỏ
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <button class="add-to-cart-btn disabled" disabled>
                                                    <i class="fas fa-times"></i> Hết món
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="no-products">
                                <i class="fas fa-search"></i>
                                <h3>Không tìm thấy sản phẩm</h3>
                                <p>Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="select-branch-message">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>Vui lòng chọn chi nhánh</h3>
                        <p>Chọn chi nhánh để xem danh sách sản phẩm có sẵn</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Cart Section -->
            <div class="cart-section">
                <div class="cart-header">
                    <h3><i class="fas fa-shopping-cart"></i> Giỏ hàng</h3>
                    <span class="cart-count">0</span>
                </div>
                <div class="cart-content">
                    <div class="cart-items">
<?php
$cart = $_SESSION['cart'] ?? [];
$total = 0;
$total_items = 0;
if (!empty($cart)):
    foreach ($cart as $cart_key => $item):
        $stmt = $conn->prepare("SELECT ten, gia, hinh_anh FROM MON_AN WHERE id = ?");
        $stmt->bind_param("i", $item['product_id']);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();
        $quantity = $item['quantity'];
        $subtotal = $product['gia'] * $quantity;
        $total += $subtotal;
        $total_items += $quantity;
?>
    <div class="cart-item">
        <img src="img/<?php echo htmlspecialchars($product['hinh_anh']); ?>" alt="" style="width:40px;height:40px;object-fit:cover;">
        <div>
            <h4><?php echo htmlspecialchars($product['ten']); ?></h4>
            <p>Giá: <?php echo number_format($product['gia'], 0, ',', '.'); ?>đ</p>
            <form method="post" action="menu.php" style="display:flex;align-items:center;gap:8px;">
                <input type="hidden" name="cart_key" value="<?php echo $cart_key; ?>">
                <input type="hidden" name="branch_id" value="<?php echo $selected_branch; ?>">
                <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1" style="width:40px;">
                <button type="submit" name="action" value="update_cart">Cập nhật</button>
                <button type="submit" name="action" value="remove_from_cart">Xóa</button>
            </form>
        </div>
        <div class="cart-item-subtotal"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</div>
    </div>
<?php
    endforeach;
else:
?>
    <div class="empty-cart">
        <i class="fas fa-shopping-cart"></i>
        <p>Giỏ hàng trống</p>
    </div>
<?php endif; ?>
                    </div>
                    <div class="cart-summary">
                        <div class="cart-total">
                            <strong>Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?>đ</strong>
                        </div>
                        <div class="cart-actions">
                            <button class="checkout-btn" onclick="window.location.href='checkout.php'">
                                <i class="fas fa-credit-card"></i> Thanh toán
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <?php include 'include/footer.php'; ?>
    </footer>

    <script src="js/menu.js"></script>

    <?php if (isset(
        $_POST['action']) && $_POST['action'] === 'add_to_cart' && isset($add_success) && $add_success): ?>
        <div class="alert alert-success">Đã thêm vào giỏ hàng!</div>
    <?php elseif (isset($add_error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($add_error); ?></div>
    <?php endif; ?>
</body>
</html>
<?php $conn->close(); ?>