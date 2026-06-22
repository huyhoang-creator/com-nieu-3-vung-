document.addEventListener('DOMContentLoaded', function() {
    // Initialize checkout functionality
    initializeCheckout();
    
    // Attach event listeners
    attachEventListeners();
    
    // Load cart data from session storage
    loadCartData();
    
    renderOrderSummary();
    window.addEventListener('storage', function(e) {
        if (e.key === 'cart' || e.key === 'cart_backup') {
            renderOrderSummary();
        }
    });
});

function initializeCheckout() {
    // Set default values for form fields
    setDefaultFormValues();
    
    // Initialize form validation
    initializeFormValidation();
}

function attachEventListeners() {
    // Form submission
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', handleFormSubmission);
    }
    
    // Real-time form validation
    const formInputs = document.querySelectorAll('input, textarea');
    formInputs.forEach(input => {
        input.addEventListener('blur', validateField);
        input.addEventListener('input', clearFieldError);
    });
    
    // Delivery type change
    const deliveryOptions = document.querySelectorAll('input[name="delivery_type"]');
    deliveryOptions.forEach(option => {
        option.addEventListener('change', handleDeliveryTypeChange);
    });
    
    // Payment method change
    const paymentOptions = document.querySelectorAll('input[name="payment_method"]');
    paymentOptions.forEach(option => {
        option.addEventListener('change', handlePaymentMethodChange);
    });
    
    // Prevent form double submission
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                setTimeout(() => {
                    submitBtn.disabled = false;
                }, 5000);
            }
        });
    });
}

function setDefaultFormValues() {
    // Set default values if available in localStorage
    const savedData = localStorage.getItem('checkout_form_data');
    if (savedData) {
        try {
            const data = JSON.parse(savedData);
            Object.keys(data).forEach(key => {
                const field = document.querySelector(`[name="${key}"]`);
                if (field) {
                    field.value = data[key];
                }
            });
        } catch (e) {
            console.warn('Could not load saved form data:', e);
        }
    }
}

function initializeFormValidation() {
    // Add validation rules
    window.validationRules = {
        customer_name: {
            required: true,
            minLength: 2,
            maxLength: 50,
            pattern: /^[a-zA-ZÀ-ỹ\s]+$/
        },
        customer_phone: {
            required: true,
            pattern: /^[0-9]{10,11}$/
        },
        customer_email: {
            required: true,
            pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        },
        delivery_address: {
            required: true,
            minLength: 10,
            maxLength: 200
        }
    };
}

function validateField(event) {
    const field = event.target;
    const fieldName = field.name;
    const value = field.value.trim();
    
    if (!window.validationRules[fieldName]) return;
    
    const rules = window.validationRules[fieldName];
    let isValid = true;
    let errorMessage = '';
    
    // Required validation
    if (rules.required && !value) {
        isValid = false;
        errorMessage = 'Trường này là bắt buộc';
    }
    
    // Min length validation
    if (isValid && rules.minLength && value.length < rules.minLength) {
        isValid = false;
        errorMessage = `Tối thiểu ${rules.minLength} ký tự`;
    }
    
    // Max length validation
    if (isValid && rules.maxLength && value.length > rules.maxLength) {
        isValid = false;
        errorMessage = `Tối đa ${rules.maxLength} ký tự`;
    }
    
    // Pattern validation
    if (isValid && rules.pattern && !rules.pattern.test(value)) {
        isValid = false;
        switch (fieldName) {
            case 'customer_phone':
                errorMessage = 'Số điện thoại không hợp lệ';
                break;
            case 'customer_email':
                errorMessage = 'Email không hợp lệ';
                break;
            case 'customer_name':
                errorMessage = 'Tên chỉ được chứa chữ cái và khoảng trắng';
                break;
            default:
                errorMessage = 'Giá trị không hợp lệ';
        }
    }
    
    // Update field status
    updateFieldStatus(field, isValid, errorMessage);
    
    return isValid;
}

function updateFieldStatus(field, isValid, errorMessage = '') {
    const formGroup = field.closest('.form-group');
    
    // Remove existing error/success classes
    formGroup.classList.remove('error', 'success');
    
    // Remove existing error message
    const existingError = formGroup.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    if (isValid) {
        formGroup.classList.add('success');
    } else {
        formGroup.classList.add('error');
        
        // Add error message
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message';
        errorElement.textContent = errorMessage;
        formGroup.appendChild(errorElement);
    }
}

function clearFieldError(event) {
    const field = event.target;
    const formGroup = field.closest('.form-group');
    
    // Remove error class and message on input
    formGroup.classList.remove('error');
    const errorMessage = formGroup.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
}

function handleDeliveryTypeChange(event) {
    const deliveryType = event.target.value;
    const addressField = document.getElementById('delivery_address');
    const addressLabel = addressField.previousElementSibling;
    
    // Update address field based on delivery type
    switch (deliveryType) {
        case 'tai_cho':
            addressLabel.textContent = 'Địa chỉ nhà hàng';
            addressField.placeholder = 'Chọn chi nhánh để ăn tại nhà hàng';
            break;
        case 'mang_ve':
            addressLabel.textContent = 'Địa chỉ nhà hàng';
            addressField.placeholder = 'Chọn chi nhánh để lấy đồ';
            break;
        case 'giao_hang':
            addressLabel.textContent = 'Địa chỉ giao hàng *';
            addressField.placeholder = 'Nhập địa chỉ giao hàng chi tiết';
            break;
    }
    
    // Update validation rules for address
    if (deliveryType === 'giao_hang') {
        window.validationRules.delivery_address.required = true;
    } else {
        window.validationRules.delivery_address.required = false;
    }
}

function handlePaymentMethodChange(event) {
    const paymentMethod = event.target.value;
    
    // Update payment method display
    const paymentOptions = document.querySelectorAll('.payment-option');
    paymentOptions.forEach(option => {
        option.classList.remove('selected');
    });
    
    event.target.closest('.payment-option').classList.add('selected');
    
    // Show additional info for specific payment methods
    showPaymentMethodInfo(paymentMethod);
}

function showPaymentMethodInfo(paymentMethod) {
    // Remove existing payment info
    const existingInfo = document.querySelector('.payment-info');
    if (existingInfo) {
        existingInfo.remove();
    }
    
    if (paymentMethod === 'chuyen_khoan') {
        const paymentSection = document.querySelector('.form-section:has(.payment-options)');
        const infoDiv = document.createElement('div');
        infoDiv.className = 'payment-info';
        infoDiv.innerHTML = `
            <div class="bank-info">
                <h4><i class="fas fa-university"></i> Thông tin chuyển khoản</h4>
                <p><strong>Ngân hàng:</strong> Vietcombank</p>
                <p><strong>Số tài khoản:</strong> 1234567890</p>
                <p><strong>Chủ tài khoản:</strong> NHA HANG 3 MIEN</p>
                <p><strong>Nội dung:</strong> [Mã đơn hàng] - [Tên khách hàng]</p>
            </div>
        `;
        paymentSection.appendChild(infoDiv);
    }
}

function handleFormSubmission(event) {
    event.preventDefault();
    
    // Validate all fields
    const form = event.target;
    const formData = new FormData(form);
    let isValid = true;
    
    // Validate each field
    const requiredFields = ['customer_name', 'customer_phone', 'customer_email', 'delivery_address'];
    requiredFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (field && !validateField({ target: field })) {
            isValid = false;
        }
    });
    
    if (!isValid) {
        showNotification('Vui lòng kiểm tra lại thông tin!', 'error');
        return;
    }
    
    // Save form data to localStorage
    saveFormData(formData);
    
    // Submit order
    submitOrder(formData);
}

function saveFormData(formData) {
    const data = {};
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    localStorage.setItem('checkout_form_data', JSON.stringify(data));
}

function getCartData() {
    let cart = {};
    try {
        cart = JSON.parse(localStorage.getItem('cart')) || {};
    } catch (e) {}
    return cart;
}

function renderOrderSummary() {
    const cart = getCartData();
    const orderSummary = document.getElementById('order-summary-js');
    if (!orderSummary) return;
    let total = 0, totalItems = 0;
    let html = '<h3><i class="fas fa-receipt"></i> Tóm tắt đơn hàng</h3>';
    html += '<div class="order-items">';
    const cartKeys = Object.keys(cart);
    if (cartKeys.length === 0) {
        html += '<p>Giỏ hàng trống.</p>';
    } else {
        cartKeys.forEach(key => {
            const item = cart[key];
            const subtotal = item.price * item.quantity;
            total += subtotal;
            totalItems += item.quantity;
            html += `<div class="order-item">
                <div class="item-info">
                    <h4>${htmlspecialchars(item.name)}</h4>
                    <p class="item-branch">Chi nhánh: ${item.branch_id || ''}</p>
                    <p class="item-quantity">Số lượng: ${item.quantity}</p>
                </div>
                <div class="item-price">${formatPrice(subtotal)}</div>
            </div>`;
        });
    }
    html += '</div>';
    html += `<div class="order-total">
        <div class="total-item"><span>Tạm tính:</span><span>${formatPrice(total)}</span></div>
        <div class="total-item"><span>Phí vận chuyển:</span><span>Miễn phí</span></div>
        <div class="total-item final"><span>Tổng cộng:</span><span>${formatPrice(total)}</span></div>
    </div>`;
    orderSummary.innerHTML = html;
}

function submitOrder(formData) {
    const cart = getCartData();
    formData.append('cart_data', JSON.stringify(cart));
    const submitBtn = document.querySelector('.place-order-btn');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    
    fetch('checkout.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessModal(data.order_number);
            showNotification('Đặt hàng thành công!', 'success');
            
            // Clear cart from localStorage
            localStorage.removeItem('cart_backup');
            sessionStorage.removeItem('checkout_cart');
        } else {
            showNotification(data.message || 'Có lỗi xảy ra khi đặt hàng!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra khi đặt hàng!', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}

function showSuccessModal(orderNumber) {
    const modal = document.getElementById('success-modal');
    const orderNumberElement = document.getElementById('order-number');
    
    if (orderNumberElement) {
        orderNumberElement.textContent = orderNumber;
    }
    
    modal.classList.add('show');
    
    // Auto hide modal after 5 seconds
    setTimeout(() => {
        modal.classList.remove('show');
    }, 5000);
}

function loadCartData() {
    // Load cart data from session storage
    const cartData = sessionStorage.getItem('checkout_cart');
    if (cartData) {
        try {
            window.cart = JSON.parse(cartData);
        } catch (e) {
            console.warn('Could not load cart data:', e);
        }
    }
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

// Utility functions
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
}

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

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + Enter to submit form
    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
        e.preventDefault();
        const submitBtn = document.querySelector('.place-order-btn');
        if (submitBtn && !submitBtn.disabled) {
            document.getElementById('checkout-form').dispatchEvent(new Event('submit'));
        }
    }
    
    // Escape to go back
    if (e.key === 'Escape') {
        history.back();
    }
});

// Auto-save form data periodically
setInterval(() => {
    const form = document.getElementById('checkout-form');
    if (form) {
        const formData = new FormData(form);
        saveFormData(formData);
    }
}, 30000); // Every 30 seconds

// Form field auto-complete enhancement
document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"]').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.02)';
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
    });
});

// Smooth scroll to form sections
document.querySelectorAll('.form-section h3').forEach(header => {
    header.addEventListener('click', function() {
        this.closest('.form-section').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
});

// Add visual feedback for form interactions
document.querySelectorAll('.delivery-option, .payment-option').forEach(option => {
    option.addEventListener('click', function() {
        // Add ripple effect
        const ripple = document.createElement('div');
        ripple.className = 'ripple';
        ripple.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: rgba(102, 126, 234, 0.3);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        `;
        
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
});

// Add CSS for ripple effect
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .delivery-option,
    .payment-option {
        position: relative;
        overflow: hidden;
    }
`;
document.head.appendChild(style);