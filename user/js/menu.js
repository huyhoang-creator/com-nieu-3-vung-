// Cart functionality
// let cart = {};

document.addEventListener('DOMContentLoaded', function() {
    // Always render cart panel on page load
    renderCart();

    // Add to cart functionality
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (this.disabled) return;

            const productId = this.getAttribute('data-product-id');
            const branchId = this.getAttribute('data-branch-id');
            const productName = this.getAttribute('data-product-name');
            const productPrice = parseInt(this.getAttribute('data-product-price'));

            addToCart(productId, branchId, productName, productPrice);
        });
    });

    // Quantity controls
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const cartKey = this.getAttribute('data-cart-key');
            const isPlus = this.classList.contains('plus');
            const quantityInput = document.querySelector(`input[data-cart-key="${cartKey}"]`);
            let quantity = parseInt(quantityInput.value);

            if (isPlus) {
                quantity++;
            } else {
                quantity = Math.max(1, quantity - 1);
            }

            quantityInput.value = quantity;
            updateCartItem(cartKey, quantity);
        });
    });

    // Quantity input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const cartKey = this.getAttribute('data-cart-key');
            const quantity = Math.max(1, parseInt(this.value) || 1);
            this.value = quantity;
            updateCartItem(cartKey, quantity);
        });
    });

    // Remove item buttons
    document.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            const cartKey = this.getAttribute('data-cart-key');
            removeFromCart(cartKey);
        });
    });

    // Checkout button
    const checkoutBtn = document.querySelector('.checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            if (Object.keys(cart).length === 0) {
                showNotification('Giỏ hàng trống!', 'error');
                return;
            }
            checkoutModal.style.display = 'flex';
        });
    }

    // Form validation
    const form = document.querySelector('.filter-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    }

    // Search input enhancement
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 2 || this.value.length === 0) {
                    this.closest('form').submit();
                }
            }, 500);
        });
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        searchInput.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    }

    // Smooth scroll animations
    const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.product-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        card.style.transitionDelay = `${index * 0.1}s`;
        observer.observe(card);
    });

    // Prevent form double submission
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                setTimeout(() => {
                    submitBtn.disabled = false;
                }, 2000);
            }
        });
    });

    // Enhanced error handling
    window.addEventListener('error', function(e) {
        console.error('JavaScript Error:', e.error);
        showNotification('Có lỗi xảy ra. Vui lòng thử lại!', 'error');
    });

    // Page visibility API for cart sync
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            renderCart();
        }
    });

    // Modal checkout logic
    const checkoutModal = document.getElementById('checkout-modal');
    const closeCheckoutModal = document.querySelector('.close-checkout-modal');
    const checkoutFormModal = document.getElementById('checkout-form-modal');

    if (closeCheckoutModal && checkoutModal) {
        closeCheckoutModal.addEventListener('click', function() {
            checkoutModal.style.display = 'none';
        });
    }
    window.addEventListener('click', function(e) {
        if (e.target === checkoutModal) {
            checkoutModal.style.display = 'none';
        }
    });
    if (checkoutFormModal) {
        checkoutFormModal.addEventListener('submit', function(e) {
            e.preventDefault();
            // Validate đơn giản
            const name = this.customer_name.value.trim();
            const phone = this.customer_phone.value.trim();
            const email = this.customer_email.value.trim();
            const address = this.delivery_address.value.trim();
            if (!name || !phone || !email || !address) {
                showNotification('Vui lòng điền đầy đủ thông tin!', 'error');
                return;
            }
            // Hiển thị thông báo thành công (hoặc gửi AJAX lên server nếu muốn)
            showNotification('Đặt hàng thành công! (Demo)', 'success');
            checkoutModal.style.display = 'none';
            // Xóa giỏ hàng (demo)
            cart = {};
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
            updateCartDisplay();
        });
    }
});

function addToCart(productId, branchId, productName, productPrice) {
    const formData = new FormData();
    formData.append('action', 'add_to_cart');
    formData.append('product_id', productId);
    formData.append('branch_id', branchId);
    formData.append('quantity', 1);

    const button = document.querySelector(`[data-product-id="${productId}"]`);
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
    button.disabled = true;

    fetch('menu.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`Đã thêm "${productName}" vào giỏ hàng!`, 'success');

            const cartKey = `${productId}_${branchId}`;
            if (cart[cartKey]) {
                cart[cartKey].quantity += 1;
            } else {
                cart[cartKey] = {
                    product_id: productId,
                    branch_id: branchId,
                    name: productName,
                    price: productPrice,
                    quantity: 1
                };
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
            updateCartDisplay();

            button.innerHTML = '<i class="fas fa-check"></i> Đã thêm!';
            button.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';

            setTimeout(() => {
                button.innerHTML = originalText;
                button.style.background = '';
                button.disabled = false;
            }, 2000);
        } else {
            showNotification(data.message || 'Có lỗi xảy ra!', 'error');
            button.innerHTML = originalText;
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng!', 'error');
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

function updateCartItem(cartKey, quantity) {
    const formData = new FormData();
    formData.append('action', 'update_cart');
    formData.append('cart_key', cartKey);
    formData.append('quantity', quantity);

    fetch('menu.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (cart[cartKey]) {
                cart[cartKey].quantity = quantity;
                localStorage.setItem('cart', JSON.stringify(cart));
            }

            updateCartItemDisplay(cartKey, quantity);
            renderCart();
            updateCartDisplay();
        } else {
            showNotification('Có lỗi khi cập nhật giỏ hàng!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra!', 'error');
    });
}

function removeFromCart(cartKey) {
    if (!confirm('Bạn có chắc muốn xóa món này khỏi giỏ hàng?')) {
        return;
    }

    const formData = new FormData();
    formData.append('action', 'remove_from_cart');
    formData.append('cart_key', cartKey);

    fetch('menu.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            delete cart[cartKey];
            localStorage.setItem('cart', JSON.stringify(cart));

            const cartItem = document.querySelector(`[data-cart-key="${cartKey}"]`).closest('.cart-item');
            cartItem.style.animation = 'slideOutRight 0.3s ease-in forwards';

            setTimeout(() => {
                cartItem.remove();
                renderCart();
                updateCartDisplay();
            }, 300);

            showNotification('Đã xóa món khỏi giỏ hàng!', 'success');
        } else {
            showNotification('Có lỗi khi xóa món!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra!', 'error');
    });
}

function renderCart() {
    // Lấy cart từ localStorage nếu có
    let cartData = localStorage.getItem('cart');
    if (cartData) {
        cart = JSON.parse(cartData);
    }
    const cartItemsContainer = document.querySelector('.cart-items');
    const cartTotalElement = document.querySelector('.cart-total');
    const cartCount = document.querySelector('.cart-count');
    let total = 0;
    let totalItems = 0;

    if (cartItemsContainer) {
        cartItemsContainer.innerHTML = '';

        if (Object.keys(cart).length > 0) {
            Object.entries(cart).forEach(([cartKey, item]) => {
                const subtotal = item.price * item.quantity;
                total += subtotal;
                totalItems += item.quantity;

                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.setAttribute('data-cart-key', cartKey);
                cartItem.innerHTML = `
                    <div class="cart-item-info">
                        <h4>${htmlspecialchars(item.name)}</h4>
                        <p class="cart-item-price">${formatPrice(item.price)}</p>
                    </div>
                    <div class="cart-item-controls">
                        <div class="quantity-controls">
                            <button class="quantity-btn minus" data-cart-key="${cartKey}">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="quantity-input" 
                                   value="${item.quantity}" 
                                   min="1" max="99"
                                   data-cart-key="${cartKey}">
                            <button class="quantity-btn plus" data-cart-key="${cartKey}">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div class="cart-item-subtotal">
                            ${formatPrice(subtotal)}
                        </div>
                        <button class="remove-item-btn" data-cart-key="${cartKey}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                cartItemsContainer.appendChild(cartItem);
            });

            if (cartTotalElement) {
                cartTotalElement.innerHTML = `<strong>Tổng cộng: ${formatPrice(total)}</strong>`;
            }
        } else {
            cartItemsContainer.innerHTML = `
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <p>Giỏ hàng trống</p>
                </div>
            `;
            if (cartTotalElement) {
                cartTotalElement.innerHTML = '<strong>Tổng cộng: 0đ</strong>';
            }
        }
    }

    if (cartCount) {
        cartCount.textContent = totalItems;
    }

    attachEventListeners();
}

function attachEventListeners() {
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const cartKey = this.getAttribute('data-cart-key');
            const isPlus = this.classList.contains('plus');
            const quantityInput = document.querySelector(`input[data-cart-key="${cartKey}"]`);
            let quantity = parseInt(quantityInput.value);

            if (isPlus) {
                quantity++;
            } else {
                quantity = Math.max(1, quantity - 1);
            }

            quantityInput.value = quantity;
            if (cart[cartKey]) {
                cart[cartKey].quantity = quantity;
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
                updateCartDisplay();
            }
        });
    });

    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const cartKey = this.getAttribute('data-cart-key');
            const quantity = Math.max(1, parseInt(this.value) || 1);
            this.value = quantity;
            if (cart[cartKey]) {
                cart[cartKey].quantity = quantity;
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
                updateCartDisplay();
            }
        });
    });

    document.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            const cartKey = this.getAttribute('data-cart-key');
            if (cart[cartKey]) {
                delete cart[cartKey];
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
                updateCartDisplay();
            }
        });
    });

    // Checkout button
    const checkoutBtn = document.querySelector('.checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            if (Object.keys(cart).length === 0) {
                showNotification('Giỏ hàng trống!', 'error');
                return;
            }
            checkoutModal.style.display = 'flex';
        });
    }
}

function updateCartItemDisplay(cartKey, quantity) {
    const subtotalElement = document.querySelector(`[data-cart-key="${cartKey}"]`)
        .closest('.cart-item').querySelector('.cart-item-subtotal');
    if (subtotalElement && cart[cartKey]) {
        const subtotal = cart[cartKey].price * quantity;
        subtotalElement.textContent = formatPrice(subtotal);
    }
}

function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
}

function showNotification(message, type = 'success') {
    document.querySelectorAll('.notification').forEach(n => n.remove());

    const notification = document.createElement('div');
    notification.className = `notification ${type}`;

    const icon = type === 'success' ? 'check-circle' :
                 type === 'error' ? 'times-circle' : 'info-circle';

    notification.innerHTML = `
        <i class="fas fa-${icon}"></i>
        ${message}
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.4s ease-in forwards';
        setTimeout(() => {
            if (notification.parentNode) notification.remove();
        }, 400);
    }, 3000);
}

function htmlspecialchars(str) {
    return str
        .replace(/&/g, "&")
        .replace(/</g, "<")
        .replace(/>/g, ">")
        .replace(/'/g, "'");
}

function validateForm() {
    const branchSelect = document.getElementById('branchSelect');
    if (!branchSelect.value || branchSelect.value === '0') {
        showNotification('Vui lòng chọn chi nhánh!', 'error');
        branchSelect.focus();
        return false;
    }
    return true;
}

function updateCartDisplay() {
    // Update cart count in header if exists
    const cartCountElements = document.querySelectorAll('.cart-count');
    const totalItems = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
    
    cartCountElements.forEach(element => {
        element.textContent = totalItems;
        if (totalItems === 0) {
            element.style.display = 'none';
        } else {
            element.style.display = 'flex';
        }
    });
}