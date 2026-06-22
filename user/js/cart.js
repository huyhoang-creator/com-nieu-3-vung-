document.addEventListener('DOMContentLoaded', function() {
    // Initialize cart functionality
    initializeCart();
    
    // Attach event listeners
    attachEventListeners();
    
    // Update cart display
    updateCartDisplay();
});

function initializeCart() {
    // Load cart from session if available
    if (typeof cartData !== 'undefined') {
        window.cart = cartData;
    } else {
        window.cart = {};
    }
}

function attachEventListeners() {
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

    // Clear cart button
    const clearCartBtn = document.querySelector('.clear-cart-btn');
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', function() {
            if (confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?')) {
                clearCart();
            }
        });
    }

    // Checkout button
    const checkoutBtn = document.querySelector('.checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            proceedToCheckout();
        });
    }

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
}

function updateCartItem(cartKey, quantity) {
    const formData = new FormData();
    formData.append('action', 'update_cart');
    formData.append('cart_key', cartKey);
    formData.append('quantity', quantity);

    const cartItem = document.querySelector(`[data-cart-key="${cartKey}"]`);
    if (cartItem) {
        cartItem.classList.add('loading');
    }

    fetch('cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update local cart
            if (window.cart[cartKey]) {
                window.cart[cartKey].quantity = quantity;
            }
            
            // Update display
            updateCartItemDisplay(cartKey, quantity);
            updateCartSummary();
            showNotification('Đã cập nhật giỏ hàng!', 'success');
        } else {
            showNotification('Có lỗi xảy ra khi cập nhật!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra khi cập nhật giỏ hàng!', 'error');
    })
    .finally(() => {
        if (cartItem) {
            cartItem.classList.remove('loading');
        }
    });
}

function removeFromCart(cartKey) {
    const formData = new FormData();
    formData.append('action', 'remove_from_cart');
    formData.append('cart_key', cartKey);

    const cartItem = document.querySelector(`[data-cart-key="${cartKey}"]`);
    if (cartItem) {
        cartItem.classList.add('loading');
    }

    fetch('cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove from local cart
            delete window.cart[cartKey];
            
            // Remove from display with animation
            if (cartItem) {
                cartItem.style.transform = 'translateX(100%)';
                cartItem.style.opacity = '0';
                setTimeout(() => {
                    cartItem.remove();
                    updateCartDisplay();
                }, 300);
            }
            
            updateCartSummary();
            showNotification('Đã xóa sản phẩm khỏi giỏ hàng!', 'success');
        } else {
            showNotification('Có lỗi xảy ra khi xóa sản phẩm!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra khi xóa sản phẩm!', 'error');
    })
    .finally(() => {
        if (cartItem) {
            cartItem.classList.remove('loading');
        }
    });
}

function clearCart() {
    const formData = new FormData();
    formData.append('action', 'clear_cart');

    const cartItems = document.querySelector('.cart-items');
    const clearBtn = document.querySelector('.clear-cart-btn');
    
    if (clearBtn) {
        clearBtn.disabled = true;
        clearBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xóa...';
    }

    fetch('cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Clear local cart
            window.cart = {};
            
            // Animate removal of all items
            const items = document.querySelectorAll('.cart-item');
            items.forEach((item, index) => {
                setTimeout(() => {
                    item.style.transform = 'translateX(100%)';
                    item.style.opacity = '0';
                }, index * 100);
            });
            
            setTimeout(() => {
                location.reload();
            }, items.length * 100 + 500);
            
            showNotification('Đã xóa toàn bộ giỏ hàng!', 'success');
        } else {
            showNotification('Có lỗi xảy ra khi xóa giỏ hàng!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra khi xóa giỏ hàng!', 'error');
    })
    .finally(() => {
        if (clearBtn) {
            clearBtn.disabled = false;
            clearBtn.innerHTML = '<i class="fas fa-trash"></i> Xóa giỏ hàng';
        }
    });
}

function updateCartItemDisplay(cartKey, quantity) {
    const cartItem = document.querySelector(`[data-cart-key="${cartKey}"]`);
    if (!cartItem) return;

    const quantityInput = cartItem.querySelector('.quantity-input');
    const subtotalElement = cartItem.querySelector('.subtotal-amount');
    
    if (quantityInput) {
        quantityInput.value = quantity;
    }
    
    if (subtotalElement && window.cart[cartKey]) {
        const subtotal = window.cart[cartKey].price * quantity;
        subtotalElement.textContent = formatPrice(subtotal);
    }
}

function updateCartSummary() {
    let total = 0;
    let totalItems = 0;
    
    Object.values(window.cart).forEach(item => {
        total += item.price * item.quantity;
        totalItems += item.quantity;
    });
    
    // Update summary display
    const summaryItems = document.querySelectorAll('.summary-item');
    summaryItems.forEach(item => {
        const label = item.querySelector('span:first-child');
        const value = item.querySelector('span:last-child');
        
        if (label && value) {
            if (label.textContent.includes('Tổng sản phẩm')) {
                value.textContent = `${totalItems} món`;
            } else if (label.textContent.includes('Tạm tính') || label.textContent.includes('Tổng cộng')) {
                value.textContent = formatPrice(total);
            }
        }
    });
}

function updateCartDisplay() {
    // Update cart count in header if exists
    const cartCountElements = document.querySelectorAll('.cart-count');
    const totalItems = Object.values(window.cart).reduce((sum, item) => sum + item.quantity, 0);
    
    cartCountElements.forEach(element => {
        element.textContent = totalItems;
    });
}

function proceedToCheckout() {
    if (Object.keys(window.cart).length === 0) {
        showNotification('Giỏ hàng trống!', 'error');
        return;
    }
    window.location.href = 'checkout.php';
}

function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
}

function showNotification(message, type = 'success') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create new notification
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    // Hide notification after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Utility function to escape HTML
function htmlspecialchars(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

// Enhanced error handling
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
    showNotification('Có lỗi xảy ra. Vui lòng thử lại!', 'error');
});

// Page visibility API for cart sync
document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        updateCartDisplay();
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + Enter to proceed to checkout
    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
        e.preventDefault();
        const checkoutBtn = document.querySelector('.checkout-btn');
        if (checkoutBtn && !checkoutBtn.disabled) {
            proceedToCheckout();
        }
    }
    
    // Escape to clear cart
    if (e.key === 'Escape') {
        const clearCartBtn = document.querySelector('.clear-cart-btn');
        if (clearCartBtn) {
            clearCart();
        }
    }
});

// Smooth scroll to top when clicking on cart items
document.querySelectorAll('.cart-item').forEach(item => {
    item.addEventListener('click', function(e) {
        if (e.target.closest('.quantity-btn') || e.target.closest('.remove-item-btn')) {
            return;
        }
        
        // Smooth scroll to top
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});

// Add loading animation for better UX
function addLoadingAnimation(element) {
    element.classList.add('loading');
    element.style.position = 'relative';
}

function removeLoadingAnimation(element) {
    element.classList.remove('loading');
}

// Auto-save cart to localStorage as backup
function saveCartToStorage() {
    try {
        localStorage.setItem('cart_backup', JSON.stringify(window.cart));
    } catch (e) {
        console.warn('Could not save cart to localStorage:', e);
    }
}

// Load cart from localStorage if session is lost
function loadCartFromStorage() {
    try {
        const backup = localStorage.getItem('cart_backup');
        if (backup && Object.keys(window.cart).length === 0) {
            window.cart = JSON.parse(backup);
            showNotification('Đã khôi phục giỏ hàng từ bộ nhớ!', 'info');
        }
    } catch (e) {
        console.warn('Could not load cart from localStorage:', e);
    }
}

// Save cart periodically
setInterval(saveCartToStorage, 30000); // Every 30 seconds

// Load cart on page load
loadCartFromStorage(); 