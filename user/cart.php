<?php
session_start();
include 'include/connect_db.php';

$cart = $_SESSION['cart'] ?? [];
$total = 0;
$total_items = 0;

// Xử lý cập nhật số lượng
if (isset($_POST['action']) && $_POST['action'] === 'update_cart' && isset($_POST['cart_key'], $_POST['quantity'])) {
    $cart_key = $_POST['cart_key'];
    $quantity = max(1, intval($_POST['quantity']));
    if (isset($_SESSION['cart'][$cart_key])) {
        $_SESSION['cart'][$cart_key]['quantity'] = $quantity;
    }
    header('Location: cart.php'); exit;
}
// Xử lý xóa món
if (isset($_POST['action']) && $_POST['action'] === 'remove_from_cart' && isset($_POST['cart_key'])) {
    $cart_key = $_POST['cart_key'];
    if (isset($_SESSION['cart'][$cart_key])) {
        unset($_SESSION['cart'][$cart_key]);
    }
    header('Location: cart.php'); exit;
}

// Xử lý xóa toàn bộ giỏ hàng
if (isset($_POST['action']) && $_POST['action'] === 'clear_cart') {
    $_SESSION['cart'] = [];
    echo json_encode(['success' => true]);
    exit;
}

// Tính tổng tiền
$total = 0;
$total_items = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
    $total_items += $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - Nhà Hàng 3 Miền</title>
    <link rel="stylesheet" href="css/cart.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <?php include 'include/header.php'; ?>
    </header>

    <div class="container">
        <div class="cart-page">
            <div class="cart-header">
                <h1><i class="fas fa-shopping-cart"></i> Giỏ hàng của bạn</h1>
                <p class="cart-summary"><?php echo $total_items; ?> sản phẩm trong giỏ hàng</p>
            </div>

            <?php if (!empty($cart)): ?>
                <div class="cart-content">
                    <div class="cart-items">
                        <?php foreach ($cart as $cart_key => $item): 
                            $stmt = $conn->prepare("SELECT ten, gia, hinh_anh, trang_thai FROM MON_AN WHERE id = ?");
                            $stmt->bind_param("i", $item['product_id']);
                            $stmt->execute();
                            $product = $stmt->get_result()->fetch_assoc();
                            $quantity = $item['quantity'];
                            $subtotal = $product['gia'] * $quantity;
                            $total += $subtotal;
                            $total_items += $quantity;
                        ?>
                        <div class="cart-item">
                            <img src="img/<?php echo htmlspecialchars($product['hinh_anh']); ?>" alt="" style="width:60px;height:60px;object-fit:cover;">
                            <div>
                                <h4><?php echo htmlspecialchars($product['ten']); ?></h4>
                                <p>Giá: <?php echo number_format($product['gia'], 0, ',', '.'); ?>đ</p>
                                <form method="post" action="cart.php" style="display:flex;align-items:center;gap:8px;">
                                    <input type="hidden" name="cart_key" value="<?php echo $cart_key; ?>">
                                    <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1" style="width:50px;">
                                    <button type="submit" name="action" value="update_cart">Cập nhật</button>
                                    <button type="submit" name="action" value="remove_from_cart">Xóa</button>
                                </form>
                            </div>
                            <div class="cart-item-subtotal"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</div>
                        </div>
                        <?php endforeach; ?>
                        <div class="cart-total">
                            <strong>Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?>đ</strong>
                        </div>
                    </div>

                    <div class="cart-summary-panel">
                        <div class="cart-summary-content">
                            <h3>Thông tin đơn hàng</h3>
                            
                            <div class="summary-item">
                                <span>Tổng sản phẩm:</span>
                                <span><?php echo $total_items; ?> món</span>
                            </div>
                            
                            <div class="summary-item">
                                <span>Tạm tính:</span>
                                <span><?php echo number_format($total, 0, ',', '.'); ?>đ</span>
                            </div>
                            
                            <div class="summary-item">
                                <span>Phí vận chuyển:</span>
                                <span>Miễn phí</span>
                            </div>
                            
                            <div class="summary-item total">
                                <span>Tổng cộng:</span>
                                <span><?php echo number_format($total, 0, ',', '.'); ?>đ</span>
                            </div>
                            
                            <div class="cart-actions">
                                <button class="btn btn-secondary clear-cart-btn">
                                    <i class="fas fa-trash"></i> Xóa giỏ hàng
                                </button>
                                
                                <button class="btn btn-primary checkout-btn">
                                    <i class="fas fa-credit-card"></i> Tiến hành thanh toán
                                </button>
                            </div>
                            
                            <div class="cart-note">
                                <p><i class="fas fa-info-circle"></i> Đơn hàng sẽ được xử lý trong vòng 15-30 phút</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-cart">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h2>Giỏ hàng trống</h2>
                    <p>Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                    <a href="menu.php" class="btn btn-primary">
                        <i class="fas fa-utensils"></i> Xem menu
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <?php include 'include/footer.php'; ?>
    </footer>

    <script src="js/cart.js"></script>
</body>
</html>
<?php $conn->close(); ?> 