<?php
session_start();
include 'include/connect_db.php';

// Kiểm tra giỏ hàng
if (empty($_SESSION['cart'])) {
    header('Location: menu.php');
    exit;
}

// Xử lý đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'place_order') {
    $response = ['success' => false, 'message' => ''];
    
    try {
        // Validate input
        $required_fields = ['customer_name', 'customer_phone', 'customer_email', 'delivery_address', 'payment_method'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Vui lòng điền đầy đủ thông tin!");
            }
        }
        
        // Validate email
        if (!filter_var($_POST['customer_email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email không hợp lệ!");
        }
        
        // Validate phone
        if (!preg_match('/^[0-9]{10,11}$/', $_POST['customer_phone'])) {
            throw new Exception("Số điện thoại không hợp lệ!");
        }
        
        // Lấy lại toàn bộ giỏ hàng từ session và xác nhận lại thông tin sản phẩm từ DB
        $cart = $_SESSION['cart'] ?? [];
        $total = 0;
        $total_items = 0;
        $order_items = [];
        foreach ($cart as $cart_key => $item) {
            $stmt = $conn->prepare("SELECT ten, gia, hinh_anh, trang_thai FROM MON_AN WHERE id = ?");
            $stmt->bind_param("i", $item['product_id']);
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();
            $quantity = $item['quantity'];
            $subtotal = $product['gia'] * $quantity;
            $total += $subtotal;
            $total_items += $quantity;
            $order_items[] = [
                'name' => $product['ten'],
                'price' => $product['gia'],
                'quantity' => $quantity,
                'subtotal' => $subtotal
            ];
        }
        
        // Get branch info for the first item
        $branch_id = $order_items[0]['branch_id'];
        $branch_query = "SELECT id, ten FROM CHI_NHANH WHERE id = ?";
        $stmt = $conn->prepare($branch_query);
        $stmt->bind_param("i", $branch_id);
        $stmt->execute();
        $branch_info = $stmt->get_result()->fetch_assoc();
        
        // Generate order number
        $order_number = 'DH' . date('YmdHis') . rand(1000, 9999);
        
        // Insert order into database
        $conn->begin_transaction();
        
        // Insert into HOA_DON
        $insert_order = "INSERT INTO HOA_DON (ma_hoa_don, id_chi_nhanh, tong_tien, thanh_tien, hinh_thuc, trang_thai, ghi_chu) 
                        VALUES (?, ?, ?, ?, ?, 'cho_xac_nhan', ?)";
        $stmt = $conn->prepare($insert_order);
        $delivery_type = $_POST['delivery_type'] ?? 'tai_cho';
        $notes = $_POST['notes'] ?? '';
        $stmt->bind_param("sidds", $order_number, $branch_id, $total, $total, $delivery_type, $notes);
        $stmt->execute();
        $order_id = $conn->insert_id;
        
        // Insert order details (you'll need to create this table)
        // For now, we'll store order details in session
        $_SESSION['order_details'] = [
            'order_id' => $order_id,
            'order_number' => $order_number,
            'customer_info' => [
                'name' => $_POST['customer_name'],
                'phone' => $_POST['customer_phone'],
                'email' => $_POST['customer_email'],
                'address' => $_POST['delivery_address']
            ],
            'items' => $order_items,
            'total' => $total,
            'payment_method' => $_POST['payment_method'],
            'delivery_type' => $delivery_type,
            'branch_info' => $branch_info
        ];
        
        $conn->commit();
        
        // Clear cart
        $_SESSION['cart'] = [];
        
        $response['success'] = true;
        $response['message'] = 'Đặt hàng thành công!';
        $response['order_number'] = $order_number;
        
    } catch (Exception $e) {
        $conn->rollback();
        $response['message'] = $e->getMessage();
    }
    
    echo json_encode($response);
    exit;
}

// Calculate totals
$total = 0;
$total_items = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
    $total_items += $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - Nhà Hàng 3 Miền</title>
    <link rel="stylesheet" href="css/checkout.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <?php include 'include/header.php'; ?>
    </header>

    <div class="container">
        <div class="checkout-page">
            <div class="checkout-header">
                <h1><i class="fas fa-credit-card"></i> Thanh toán đơn hàng</h1>
                <p class="checkout-summary"><?php echo $total_items; ?> sản phẩm - Tổng: <?php echo number_format($total, 0, ',', '.'); ?>đ</p>
            </div>

            <div class="checkout-content">
                <div class="checkout-form-section">
                    <form id="checkout-form" class="checkout-form">
                        <input type="hidden" name="action" value="place_order">
                        
                        <!-- Customer Information -->
                        <div class="form-section">
                            <h3><i class="fas fa-user"></i> Thông tin khách hàng</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="customer_name">Họ và tên *</label>
                                    <input type="text" id="customer_name" name="customer_name" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="customer_phone">Số điện thoại *</label>
                                    <input type="tel" id="customer_phone" name="customer_phone" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="customer_email">Email *</label>
                                    <input type="email" id="customer_email" name="customer_email" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="delivery_address">Địa chỉ giao hàng *</label>
                                    <textarea id="delivery_address" name="delivery_address" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Options -->
                        <div class="form-section">
                            <h3><i class="fas fa-truck"></i> Hình thức nhận hàng</h3>
                            <div class="delivery-options">
                                <label class="delivery-option">
                                    <input type="radio" name="delivery_type" value="tai_cho" checked>
                                    <div class="option-content">
                                        <i class="fas fa-store"></i>
                                        <div>
                                            <strong>Ăn tại nhà hàng</strong>
                                            <span>Đến nhà hàng để thưởng thức</span>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="delivery-option">
                                    <input type="radio" name="delivery_type" value="mang_ve">
                                    <div class="option-content">
                                        <i class="fas fa-shopping-bag"></i>
                                        <div>
                                            <strong>Mang về</strong>
                                            <span>Đến nhà hàng để lấy đồ</span>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="delivery-option">
                                    <input type="radio" name="delivery_type" value="giao_hang">
                                    <div class="option-content">
                                        <i class="fas fa-motorcycle"></i>
                                        <div>
                                            <strong>Giao hàng</strong>
                                            <span>Giao đến địa chỉ của bạn</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="form-section">
                            <h3><i class="fas fa-credit-card"></i> Phương thức thanh toán</h3>
                            <div class="payment-options">
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="tien_mat" checked>
                                    <div class="option-content">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <div>
                                            <strong>Tiền mặt</strong>
                                            <span>Thanh toán khi nhận hàng</span>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="chuyen_khoan">
                                    <div class="option-content">
                                        <i class="fas fa-university"></i>
                                        <div>
                                            <strong>Chuyển khoản</strong>
                                            <span>Chuyển khoản ngân hàng</span>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="momo">
                                    <div class="option-content">
                                        <i class="fas fa-mobile-alt"></i>
                                        <div>
                                            <strong>MoMo</strong>
                                            <span>Thanh toán qua ví MoMo</span>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="zalopay">
                                    <div class="option-content">
                                        <i class="fas fa-qrcode"></i>
                                        <div>
                                            <strong>ZaloPay</strong>
                                            <span>Thanh toán qua ZaloPay</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        <div class="form-section">
                            <h3><i class="fas fa-sticky-note"></i> Ghi chú</h3>
                            <div class="form-group">
                                <label for="notes">Ghi chú đơn hàng (tùy chọn)</label>
                                <textarea id="notes" name="notes" rows="3" placeholder="Ghi chú về đơn hàng, yêu cầu đặc biệt..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="order-summary-section">
                    <div id="order-summary-js"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fas fa-check-circle success-icon"></i>
                <h2>Đặt hàng thành công!</h2>
            </div>
            <div class="modal-body">
                <p>Mã đơn hàng: <strong id="order-number"></strong></p>
                <p>Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ sớm nhất!</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="window.location.href='index.php'">
                    <i class="fas fa-home"></i> Về trang chủ
                </button>
            </div>
        </div>
    </div>

    <footer>
        <?php include 'include/footer.php'; ?>
    </footer>

    <script src="js/checkout.js"></script>
</body>
</html>
<?php $conn->close(); ?> 