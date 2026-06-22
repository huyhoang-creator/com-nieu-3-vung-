<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhà Hàng Gia Đình - Ẩm Thực Truyền Thống Việt Nam</title>
    <meta name="description" content="Thưởng thức những món ăn đặc sắc được chế biến từ nguyên liệu tươi ngon nhất, mang đến hương vị truyền thống Việt Nam">
    <link href="https://fonts.googleapis.com/css2?family=Tilt+Neon:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --golden: #D4AF37;
            --golden-light: #F4E8B8;
            --golden-dark: #B8941F;
            --warm-brown: #8B4513;
            --cream: #FFF8DC;
            --dark-brown: #5D2F0A;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #FFF8DC 0%, #F5E6B3 100%);
            min-height: 100vh;
        }

        .font-tilt-neon {
            font-family: 'Tilt Neon', sans-serif;
        }

        /* Header Styles */
        .header {
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo {
            width: 3rem;
            height: 3rem;
            background: var(--golden);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.25rem;
            font-family: 'Tilt Neon', sans-serif;
        }

        .logo-text h1 {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--dark-brown);
            font-family: 'Tilt Neon', sans-serif;
        }

        .logo-text p {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .header-info {
            display: none;
            align-items: center;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .header-info {
                display: flex;
            }
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .cart-button {
            position: relative;
            padding: 0.75rem;
            background: var(--golden);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
        }

        .cart-button:hover {
            background: var(--golden-dark);
        }

        .cart-count {
            position: absolute;
            top: -0.5rem;
            right: -0.5rem;
            background: #ef4444;
            color: white;
            font-size: 0.75rem;
            border-radius: 50%;
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Main Content */
        .main-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 3rem 1rem;
        }

        .hero-section {
            text-align: center;
            margin-bottom: 4rem;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--dark-brown);
            font-family: 'Tilt Neon', sans-serif;
            margin-bottom: 1rem;
        }

        @media (min-width: 768px) {
            .hero-title {
                font-size: 3rem;
            }
        }

        .hero-description {
            font-size: 1.125rem;
            color: var(--warm-brown);
            max-width: 32rem;
            margin: 0 auto;
        }

        /* Category Filter */
        .category-filter {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .category-button {
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s;
            transform: scale(1);
            cursor: pointer;
            border: none;
        }

        .category-button:hover {
            transform: scale(1.05);
        }

        .category-button.active {
            background: linear-gradient(135deg, var(--golden) 0%, var(--golden-dark) 100%);
            color: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .category-button:not(.active) {
            background: white;
            color: #374151;
            border: 1px solid #e5e7eb;
        }

        .category-button:not(.active):hover {
            border-color: var(--golden);
            color: var(--golden);
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Product Card */
        .product-card {
            background: linear-gradient(135deg, #FFFFFF 0%, #FAFAFA 100%);
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s;
            transform: scale(1);
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 25px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .product-image-container {
            position: relative;
        }

        .product-image {
            width: 100%;
            height: 12rem;
            object-fit: cover;
        }

        .info-button {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            padding: 0.5rem;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
        }

        .info-button:hover {
            background: white;
        }

        .product-content {
            padding: 1.5rem;
        }

        .product-name {
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--dark-brown);
            font-family: 'Tilt Neon', sans-serif;
            margin-bottom: 0.5rem;
        }

        .product-description {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .chef-notes {
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: var(--golden-light);
            border-radius: 0.5rem;
            display: none;
        }

        .chef-notes.show {
            display: block;
        }

        .chef-notes-label {
            font-size: 0.75rem;
            color: var(--dark-brown);
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .chef-notes-text {
            font-size: 0.875rem;
            color: var(--warm-brown);
            font-style: italic;
        }

        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--golden);
            font-family: 'Tilt Neon', sans-serif;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .quantity-btn {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            transition: all 0.2s;
            transform: scale(1);
            background: linear-gradient(135deg, var(--golden) 0%, var(--golden-dark) 100%);
            border: none;
            cursor: pointer;
        }

        .quantity-btn:hover {
            transform: scale(1.1);
        }

        .quantity-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .quantity-display {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--dark-brown);
            min-width: 2rem;
            text-align: center;
        }

        .add-to-cart-btn {
            background: linear-gradient(135deg, var(--golden) 0%, var(--golden-dark) 100%);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s;
            transform: scale(1);
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
        }

        .add-to-cart-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 50;
            display: none;
        }

        .modal-overlay.show {
            display: block;
        }

        .cart-modal {
            position: fixed;
            right: 0;
            top: 0;
            height: 100%;
            width: 100%;
            max-width: 28rem;
            background: white;
            box-shadow: 0 25px 25px -5px rgba(0, 0, 0, 0.25);
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--dark-brown);
            font-family: 'Tilt Neon', sans-serif;
        }

        .close-btn {
            padding: 0.5rem;
            background: none;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .close-btn:hover {
            background: #f3f4f6;
        }

        .modal-content {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
        }

        .empty-cart {
            text-align: center;
            padding: 3rem 0;
        }

        .empty-cart-icon {
            width: 4rem;
            height: 4rem;
            margin: 0 auto 1rem;
            color: #d1d5db;
        }

        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .cart-item {
            background: #f9fafb;
            border-radius: 0.5rem;
            padding: 1rem;
        }

        .cart-item-content {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .cart-item-image {
            width: 4rem;
            height: 4rem;
            border-radius: 0.5rem;
            object-fit: cover;
        }

        .cart-item-details {
            flex: 1;
            min-width: 0;
        }

        .cart-item-name {
            font-weight: 600;
            color: var(--dark-brown);
            font-size: 0.875rem;
        }

        .cart-item-price {
            color: var(--golden);
            font-weight: bold;
            margin-top: 0.25rem;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 0.75rem;
        }

        .cart-quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cart-quantity-btn {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background: var(--golden);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            cursor: pointer;
        }

        .cart-quantity-display {
            font-size: 0.875rem;
            font-weight: 600;
            min-width: 1.5rem;
            text-align: center;
        }

        .remove-btn {
            color: #ef4444;
            font-size: 0.875rem;
            background: none;
            border: none;
            cursor: pointer;
        }

        .remove-btn:hover {
            color: #dc2626;
        }

        .cart-footer {
            border-top: 1px solid #e5e7eb;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-label {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--dark-brown);
        }

        .total-amount {
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--golden);
            font-family: 'Tilt Neon', sans-serif;
        }

        .checkout-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--golden) 0%, var(--golden-dark) 100%);
            color: white;
            padding: 0.75rem;
            border-radius: 9999px;
            font-size: 1rem;
            border: none;
            cursor: pointer;
        }

        /* Order Form */
        .order-modal {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .order-modal.show {
            display: flex;
        }

        .order-form-container {
            position: relative;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 25px 25px -5px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 28rem;
            max-height: 90vh;
            overflow-y: auto;
        }

        .order-form-header {
            position: sticky;
            top: 0;
            background: white;
            border-radius: 1rem 1rem 0 0;
            border-bottom: 1px solid #e5e7eb;
            padding: 1.5rem;
        }

        .order-form {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--golden);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            resize: none;
            
        }

        .form-textarea:focus {
            outline: none;
            border-color: var(--golden);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--golden) 0%, var(--golden-dark) 100%);
            color: white;
            padding: 0.75rem;
            border-radius: 9999px;
            font-size: 1rem;
            border: none;
            cursor: pointer;
        }

        /* Icons */
        .icon {
            width: 1rem;
            height: 1rem;
            display: inline-block;
        }

        .icon-lg {
            width: 1.5rem;
            height: 1.5rem;
        }

        /* Utility Classes */
        .hidden {
            display: none;
        }

        .text-center {
            text-align: center;
        }

        .text-gray-500 {
            color: #6b7280;
        }

        .text-xl {
            font-size: 1.25rem;
        }

        .py-16 {
            padding-top: 4rem;
            padding-bottom: 4rem;
        }

        /* Phản hồi & Đặt bàn nhanh Section (theo mẫu hình) */
        .feedback-booking-section {
            background: #f7ecd9;
            border-radius: 2rem;
            margin: 2.5rem auto 2rem auto;
            max-width: 1200px;
            box-shadow: 0 2px 16px 0 rgba(0,0,0,0.04);
            padding: 2.5rem 2rem 2rem 2rem;
        }
        .fb-booking-container {
            display: flex;
            flex-wrap: wrap;
            gap: 2.5rem;
        }
        .fb-left {
            flex: 1.2;
            min-width: 320px;
            max-width: 420px;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .fb-feedback-title {
            font-size: 1rem;
            color: #5D2F0A;
            margin-bottom: 0.5rem;
        }
        .fb-feedback-btn {
            background: #f7ecd9;
            border: 1.5px solid #d4af37;
            color: #8B4513;
            border-radius: 2rem;
            padding: 0.4rem 1.5rem;
            font-size: 0.95rem;
            cursor: pointer;
            margin-bottom: 0.5rem;
            transition: background 0.2s, color 0.2s;
        }
        .fb-feedback-btn:hover {
            background: #d4af37;
            color: #fff;
        }
        .fb-email-label {
            font-size: 0.98rem;
            margin-bottom: 0.3rem;
            color: #5D2F0A;
        }
        .fb-email-input {
            width: 100%;
            padding: 0.7rem 1rem;
            border-radius: 0.4rem;
            border: 1px solid #d1bfa3;
            font-size: 1rem;
            background: #fff;
        }
        .fb-contact-label {
            font-size: 0.98rem;
            color: #5D2F0A;
            margin-bottom: 0.2rem;
        }
        .fb-contact-row {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-size: 0.97rem;
            color: #5D2F0A;
            margin-bottom: 0.2rem;
        }
        .fb-icon {
            font-size: 1.1rem;
            margin-top: 0.1rem;
        }
        .fb-columns {
            display: flex;
            gap: 2.5rem;
            margin-top: 1.2rem;
        }
        .fb-col {
            min-width: 110px;
        }
        .fb-col-title {
            font-weight: bold;
            color: #5D2F0A;
            margin-bottom: 0.5rem;
            font-size: 1.02rem;
        }
        .fb-col ul {
            list-style: none;
            padding: 0;
            font-size: 0.97rem;
            color: #222;
        }
        .fb-col ul li {
            margin-bottom: 0.2rem;
        }
        .fb-right {
            flex: 1.5;
            min-width: 320px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            background: #f7ecd9;
            border-radius: 1.5rem;
            padding: 2rem 2rem 2rem 2rem;
            box-shadow: 0 1px 8px 0 rgba(0,0,0,0.03);
        }
        .fb-booking-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #5D2F0A;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .fb-logo-mini {
            font-size: 1.1rem;
            background: #d4af37;
            color: #fff;
            border-radius: 0.7rem;
            padding: 0.1rem 0.7rem;
            margin-left: 0.3rem;
        }
        .fb-booking-form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .fb-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d1bfa3;
            font-size: 1rem;
            background: #fff;
            margin-bottom: 0.1rem;
        }
        .fb-row {
            display: flex;
            gap: 1rem;
        }
        .fb-row .fb-input {
            flex: 1;
        }
        .fb-textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d1bfa3;
            font-size: 1rem;
            background: #fff;
            min-height: 80px;
            resize: none;
        }
        @media (max-width: 900px) {
            .fb-booking-container {
                flex-direction: column;
            }
            .fb-right {
                margin-top: 2rem;
            }
            .fb-columns {
                gap: 1.2rem;
            }
        }

        /* Phản hồi & Đặt bàn nhanh (theo mẫu hình) */
        .feedback-reservation-section {
            background: #f7ecd9;
            border-radius: 2rem;
            padding: 2.5rem 1.5rem 2.5rem 1.5rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 2px 16px 0 rgba(0,0,0,0.04);
        }
        .feedback-reservation-container {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        @media (min-width: 900px) {
            .feedback-reservation-container {
                flex-direction: row;
                gap: 3rem;
            }
        }
        .feedback-left {
            flex: 1.2;
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }
        .feedback-title {
            font-size: 1rem;
            color: #5D2F0A;
            margin-bottom: 0.5rem;
        }
        .feedback-btn {
            background: #fff;
            border: 1.5px solid #d4af37;
            color: #8B4513;
            border-radius: 2rem;
            padding: 0.4rem 1.5rem;
            font-size: 0.95rem;
            margin-bottom: 0.7rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .feedback-btn:hover {
            background: #f4e8b8;
        }
        .feedback-subscribe-label {
            font-size: 0.95rem;
            color: #5D2F0A;
            margin-bottom: 0.3rem;
        }
        .feedback-email-input {
            width: 100%;
            max-width: 420px;
            padding: 0.7rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            margin-bottom: 0.7rem;
        }
        .feedback-contact-label {
            font-size: 0.95rem;
            color: #5D2F0A;
            margin-bottom: 0.2rem;
        }
        .feedback-contact-row {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-size: 0.97rem;
            color: #5D2F0A;
            margin-bottom: 0.2rem;
        }
        .feedback-contact-icon {
            font-size: 1.1rem;
            margin-top: 0.1rem;
        }
        .feedback-columns {
            display: flex;
            gap: 2.5rem;
            margin-top: 1.2rem;
            flex-wrap: wrap;
        }
        .feedback-col {
            min-width: 120px;
        }
        .feedback-col-title {
            font-weight: bold;
            color: #5D2F0A;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            letter-spacing: 0.5px;
        }
        .feedback-col ul {
            list-style: none;
            padding-left: 0;
            font-size: 0.97rem;
            color: #222;
        }
        .feedback-col ul li {
            margin-bottom: 0.2rem;
        }
        .reservation-right {
            flex: 1.5;
            background: #f7ecd9;
            border-radius: 1.2rem;
            padding: 1.5rem 1.5rem 1.5rem 1.5rem;
            box-shadow: 0 1px 8px 0 rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            align-items: stretch;
            min-width: 320px;
        }
        .reservation-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #5D2F0A;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .reservation-logo {
            font-size: 1.1rem;
            background: #d4af37;
            color: #fff;
            border-radius: 1rem;
            padding: 0.1rem 0.7rem;
            margin-left: 0.3rem;
        }
        .reservation-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .reservation-input {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            margin-bottom: 0.1rem;
        }
        .reservation-row {
            display: flex;
            gap: 1rem;
        }
        .reservation-row .reservation-input {
            flex: 1;
        }
        .reservation-textarea {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            resize: none;
            min-height: 70px;
        }
        .reservation-submit {
            background: linear-gradient(135deg, #d4af37 0%, #b8941f 100%);
            color: #fff;
            padding: 0.7rem 0;
            border-radius: 2rem;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            font-weight: 600;
            margin-top: 0.5rem;
            transition: background 0.2s;
        }
        .reservation-submit:hover {
            background: #b8941f;
        }
        /* END Phản hồi & Đặt bàn nhanh */
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="logo-section">
                <div class="logo">NH</div>
                <div class="logo-text">
                    <h1>Nhà Hàng Gia Đình</h1>
                    <p>Ẩm thực truyền thống Việt Nam</p>
                </div>
            </div>
            
            <div class="header-info">
                <div class="info-item">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Hồ Chí Minh</span>
                </div>
                <div class="info-item">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span>0901 234 567</span>
                </div>
            </div>

            <button class="cart-button" onclick="openCart()">
                <svg class="icon-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"/>
                </svg>
                <span class="cart-count hidden" id="cartCount">0</span>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-container">
        <div class="hero-section">
            <h1 class="hero-title">DANH MỤC SẢN PHẨM</h1>
            <p class="hero-description">
                Khám phá những món ăn đặc sắc được chế biến từ nguyên liệu tươi ngon nhất,
                mang đến hương vị truyền thống Việt Nam
            </p>
        </div>

        <!-- Category Filter -->
        <div class="category-filter">
            <button class="category-button active" onclick="filterCategory('all')">Tất cả</button>
            <button class="category-button" onclick="filterCategory('canh')">Món Canh</button>
            <button class="category-button" onclick="filterCategory('mon-chinh')">Món Chính</button>
            <button class="category-button" onclick="filterCategory('nuoc-uong')">Nước Uống</button>
            <button class="category-button" onclick="filterCategory('mon-thit')">Món Thịt</button>
        </div>

        <!-- Product Grid -->
        <div class="product-grid" id="productGrid">
            <!-- Products will be loaded here by JavaScript -->
        </div>

        <div class="text-center py-16 hidden" id="noProducts">
            <p class="text-xl text-gray-500">Không có sản phẩm nào trong danh mục này</p>
        </div>

        <!-- Phản hồi & Đặt bàn nhanh (theo mẫu hình) -->
        <section class="feedback-reservation-section" style="margin-top: 3rem; margin-bottom: 3rem;">
            <div class="feedback-reservation-container">
                <!-- Cột trái: Phản hồi, email, liên hệ, cột thông tin -->
                <div class="feedback-left">
                    <div class="feedback-title">Phản hồi về dịch vụ của chúng tôi</div>
                    <button class="feedback-btn">Chúng tôi lắng nghe bạn</button>
                    <div class="feedback-subscribe-label">Nhập email để nhận thông tin khuyến mãi</div>
                    <input class="feedback-email-input" type="email" placeholder="Email của bạn...">
                    <div class="feedback-contact-label">Thông tin liên hệ</div>
                    <div class="feedback-contact-row">
                        <span class="feedback-contact-icon">📍</span>
                        <span>Địa chỉ: 46 Võ Văn Tần, phường 5, quận 3<br>Hồ Chí Minh, Việt Nam</span>
                    </div>
                    <div class="feedback-contact-row">
                        <span class="feedback-contact-icon">📞</span>
                        <span>Hotline: 09..</span>
                    </div>
                    <div class="feedback-columns">
                        <div class="feedback-col">
                            <div class="feedback-col-title">VỀ CHÚNG TÔI</div>
                            <ul>
                                <li>Giới thiệu</li>
                                <li>Đội ngũ văn hóa</li>
                                <li>Thực đơn</li>
                                <li>Hệ thống chi nhánh</li>
                                <li>Blog/tin tức</li>
                                <li>Chính sách bảo mật<br>và quyền riêng tư</li>
                                <li>Liên hệ</li>
                            </ul>
                        </div>
                        <div class="feedback-col">
                            <div class="feedback-col-title">DỊCH VỤ</div>
                            <ul>
                                <li>Đặt bàn</li>
                                <li>Đặt hàng</li>
                                <li>Theo dõi đơn hàng</li>
                                <li>Khách hàng thân thiết</li>
                            </ul>
                        </div>
                        <div class="feedback-col">
                            <div class="feedback-col-title">THỰC ĐƠN</div>
                            <ul>
                                <li><b>Miền Bắc</b></li>
                                <li><b>Miền Trung</b></li>
                                <li><b>Miền Nam</b></li>
                                <li>Đặc sản</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Cột phải: Form đặt bàn -->
                <div class="reservation-right">
                    <div class="reservation-title">
                        Đặt Bàn Ngay <span class="reservation-logo">🍲</span>
                    </div>
                    <form class="reservation-form">
                        <input type="text" class="reservation-input" placeholder="Họ Và Tên">
                        <input type="tel" class="reservation-input" placeholder="Số điện thoại">
                        <div class="reservation-row">
                            <input type="text" class="reservation-input" placeholder="dd/mm/yyyy" onfocus="(this.type='date')" onblur="(this.type='text')">
                            <input type="text" class="reservation-input" placeholder="--:-- --" onfocus="(this.type='time')" onblur="(this.type='text')">
                        </div>
                        <input type="number" class="reservation-input" placeholder="Số Người*" min="1" max="20">
                        <textarea class="reservation-textarea" placeholder="Ghi chú đặt biệt, món ăn yêu thích, dị ứng thực phẩm..."></textarea>
                        <button type="submit" class="reservation-submit">Xác nhận đặt bàn</button>
                    </form>
                </div>
            </div>
        </section>
        <style>
        .feedback-reservation-section {
            background: #f7ecd9;
            border-radius: 2rem;
            padding: 2.5rem 1.5rem 2.5rem 1.5rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 2px 16px 0 rgba(0,0,0,0.04);
        }
        .feedback-reservation-container {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        @media (min-width: 900px) {
            .feedback-reservation-container {
                flex-direction: row;
                gap: 3rem;
            }
        }
        .feedback-left {
            flex: 1.2;
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }
        .feedback-title {
            font-size: 1rem;
            color: #5D2F0A;
            margin-bottom: 0.5rem;
        }
        .feedback-btn {
            background: #fff;
            border: 1.5px solid #d4af37;
            color: #8B4513;
            border-radius: 2rem;
            padding: 0.4rem 1.5rem;
            font-size: 0.95rem;
            margin-bottom: 0.7rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .feedback-btn:hover {
            background: #f4e8b8;
        }
        .feedback-subscribe-label {
            font-size: 0.95rem;
            color: #5D2F0A;
            margin-bottom: 0.3rem;
        }
        .feedback-email-input {
            width: 100%;
            max-width: 420px;
            padding: 0.7rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            margin-bottom: 0.7rem;
        }
        .feedback-contact-label {
            font-size: 0.95rem;
            color: #5D2F0A;
            margin-bottom: 0.2rem;
        }
        .feedback-contact-row {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-size: 0.97rem;
            color: #5D2F0A;
            margin-bottom: 0.2rem;
        }
        .feedback-contact-icon {
            font-size: 1.1rem;
            margin-top: 0.1rem;
        }
        .feedback-columns {
            display: flex;
            gap: 2.5rem;
            margin-top: 1.2rem;
            flex-wrap: wrap;
        }
        .feedback-col {
            min-width: 120px;
        }
        .feedback-col-title {
            font-weight: bold;
            color: #5D2F0A;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            letter-spacing: 0.5px;
        }
        .feedback-col ul {
            list-style: none;
            padding-left: 0;
            font-size: 0.97rem;
            color: #222;
        }
        .feedback-col ul li {
            margin-bottom: 0.2rem;
        }
        .reservation-right {
            flex: 1.5;
            background: #f7ecd9;
            border-radius: 1.2rem;
            padding: 1.5rem 1.5rem 1.5rem 1.5rem;
            box-shadow: 0 1px 8px 0 rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            align-items: stretch;
            min-width: 320px;
        }
        .reservation-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #5D2F0A;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .reservation-logo {
            font-size: 1.1rem;
            background: #d4af37;
            color: #fff;
            border-radius: 1rem;
            padding: 0.1rem 0.7rem;
            margin-left: 0.3rem;
        }
        .reservation-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .reservation-input {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            margin-bottom: 0.1rem;
        }
        .reservation-row {
            display: flex;
            gap: 1rem;
        }
        .reservation-row .reservation-input {
            flex: 1;
        }
        .reservation-textarea {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            resize: none;
            min-height: 70px;
        }
        .reservation-submit {
            background: linear-gradient(135deg, #d4af37 0%, #b8941f 100%);
            color: #fff;
            padding: 0.7rem 0;
            border-radius: 2rem;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            font-weight: 600;
            margin-top: 0.5rem;
            transition: background 0.2s;
        }
        .reservation-submit:hover {
            background: #b8941f;
        }
        /* END Phản hồi & Đặt bàn nhanh */
    </style>
    </main>

    <!-- Cart Modal -->
    <div class="modal-overlay" id="cartModal" onclick="closeCart()">
        <div class="cart-modal" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2 class="modal-title">Giỏ hàng của bạn</h2>
                <button class="close-btn" onclick="closeCart()">
                    <svg class="icon-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="modal-content">
                <div class="empty-cart" id="emptyCart">
                    <svg class="empty-cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 12H6L5 9z"/>
                    </svg>
                    <p class="text-gray-500">Giỏ hàng trống</p>
                </div>

                <div class="cart-items hidden" id="cartItems">
                    <!-- Cart items will be loaded here -->
                </div>
            </div>

            <div class="cart-footer hidden" id="cartFooter">
                <div class="cart-total">
                    <span class="total-label">Tổng cộng:</span>
                    <span class="total-amount" id="totalAmount">0₫</span>
                </div>
                <button class="checkout-btn" onclick="openOrderForm()">Đặt hàng ngay</button>
            </div>
        </div>
    </div>

    <!-- Order Form Modal -->
    <div class="modal-overlay order-modal" id="orderModal" onclick="closeOrderForm()">
        <div class="order-form-container" onclick="event.stopPropagation()">
            <div class="order-form-header">
                <div class="modal-header">
                    <h2 class="modal-title">Đặt Bàn Ngay</h2>
                    <button class="close-btn" onclick="closeOrderForm()">
                        <svg class="icon-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <form class="order-form" onsubmit="submitOrder(event)">
                <div class="form-group">
                    <label class="form-label">Họ và tên *</label>
                    <input type="text" class="form-input" name="customerName" required placeholder="Nhập họ và tên">
                </div>

                <div class="form-group">
                    <label class="form-label">Số điện thoại *</label>
                    <input type="tel" class="form-input" name="phone" required placeholder="Nhập số điện thoại">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2h3z"/>
                            </svg>
                            Ngày *
                        </label>
                        <input type="date" class="form-input" name="date" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Giờ *
                        </label>
                        <input type="time" class="form-input" name="time" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                        Số người *
                    </label>
                    <input type="number" class="form-input" name="people" min="1" max="20" value="2" required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Ghi chú đặc biệt
                    </label>
                    <textarea class="form-textarea" name="notes" rows="4" placeholder="Ghi chú đặt biệt, món ăn yêu thích, dị ứng thức phẩm..."></textarea>
                </div>

                <button type="submit" class="submit-btn">Xác nhận đặt bàn</button>
            </form>
        </div>
    </div>

    <script>
        // Product data
        const products = [
            // Canh (Soups)
            {
                id: 1,
                name: 'Canh Chua Cá Bông Lau',
                price: 85000,
                image: 'https://images.pexels.com/photos/8753657/pexels-photo-8753657.jpeg?auto=compress&cs=tinysrgb&w=500',
                category: 'canh',
                description: 'Canh chua truyền thống với cá bông lau tươi ngon, cà chua, dứa và rau thơm',
                chefNotes: 'Được nấu từ nước dùng xương heo, vị chua thanh mát, thích hợp cho ngày hè',
                available: true
            },
            {
                id: 2,
                name: 'Canh Bí Đỏ Tôm Khô',
                price: 65000,
                image: 'https://images.pexels.com/photos/7626185/pexels-photo-7626185.jpeg?auto=compress&cs=tinysrgb&w=500',
                category: 'canh',
                description: 'Canh bí đỏ ngọt thanh với tôm khô thơm lừng',
                chefNotes: 'Bí đỏ được chọn lựa kỹ càng, tôm khô Cà Mau đảm bảo chất lượng',
                available: true
            },
            {
                id: 3,
                name: 'Canh Rau Muống Tôm',
                price: 55000,
                image: 'https://images.pexels.com/photos/8753754/pexels-photo-8753754.jpeg?auto=compress&cs=tinysrgb&w=500',
                category: 'canh',
                description: 'Canh rau muống xanh mướt với tôm tươi',
                chefNotes: 'Rau muống tươi từ vườn, tôm sú tươi ngon, nước dùng trong vắt',
                available: true
            },
            // Món chính (Main dishes)
            {
                id: 4,
                name: 'Cơm Tấm Sườn Nướng',
                price: 75000,
                image: 'https://images.pexels.com/photos/8753711/pexels-photo-8753711.jpeg?auto=compress&cs=tinysrgb&w=500',
                category: 'mon-chinh',
                description: 'Cơm tấm thơm dẻo với sườn nướng BBQ, chà bông, trứng ốp la',
                chefNotes: 'Sườn non ướp gia vị đặc biệt, nướng than hồng thơm phức',
                available: true
            },
            {
                id: 5,
                name: 'Bún Bò Huế',
                price: 70000,
                image: 'https://images.pexels.com/photos/8753695/pexels-photo-8753695.jpeg?auto=compress&cs=tinysrgb&w=500',
                category: 'mon-chinh',
                description: 'Bún bò Huế cay nồng với thịt bò, chả cua, giò heo',
                chefNotes: 'Nước dùng ninh từ xương bò 8 tiếng, gia vị chuẩn vị Huế',
                available: true
            },
            {
                id: 6,
                name: 'Phở Bò Đặc Biệt',
                price: 80000,
                image: 'https://images.pexels.com/photos/8753699/pexels-photo-8753699.jpeg?auto=compress&cs=tinysrgb&w=500',
                category: 'mon-chinh',
                description: 'Phở bò truyền thống với thịt bò tái, chín, gân, sách',
                chefNotes: 'Nước dùng trong vắt từ xương bò Úc, bánh phở làm thủ công',
                available: true
            },
            // Nước uống (Beverages)
            {
                id: 7,
                name: 'Nước Mía Tươi',
                price: 25000,
                image: 'https://images.pexels.com/photos/5946623/pexels-photo-5946623.jpeg?auto=compress&cs=tinysrgb&w=500',
                category: 'nuoc-uong',
                description: 'Nước mía tươi ép, mát lành và ngọt thanh',
                chefNotes: 'Mía được chọn từ vùng Đồng Tháp, ép tươi mỗi ngày',
                available: true
            },
            {
                id: 8,
                name: 'Trà Đá Chanh',
                price: 20000,
                image: 'https://images.pexels.com/photos/1435735/pexels-photo-1435735.jpeg?auto=compress&cs=tinysrgb&w=500',
                category: 'nuoc-uong',
                description: 'Trà đá chanh tươi mát, giải khát hiệu quả',
                chefNotes: 'Chanh tươi Đà Lạt, trà đen thơm đậm đà',
                available: true
            },
            {
                id: 9,
                name: 'Sinh Tố Bơ',
                price: 35000,
                image: 'https://images.pexels.com/photos/2235928/pexels-photo-2235928.jpeg?auto=compress&cs=tinysrgb&w=500',
                category: 'nuoc-uong',
                description: 'Sinh tố bơ béo ngậy với sữa đặc và đá viên',
                chefNotes: 'Bơ 034 Đắk Lắk chín mềm, sữa đặc nguyên chất',
                available: true
            },
            // Món thịt (Meat dishes)
            {
                id: 10,
                name: 'Thịt Nướng Lá Lốt',
                price: 95000,
                image: 'https://images.pexels.com/photos/8679530/pexels-photo-8679530.jpeg?auto=compress&cs=tinysrgb&w=500',
                category: 'mon-thit',
                description: 'Thịt heo băm ướp gia vị cuốn lá lốt nướng than',
                chefNotes: 'Thịt heo tươi ba chỉ, lá lốt rừng thơm đặc trưng',
                available: true
            },
            {
                id: 11,
                name: 'Bò Nướng Lụi',
                price: 120000,
                image: 'https://images.pexels.com/photos/8753721/pexels-photo-8753721.jpeg?auto=compress&cs=tinysrgb&w=500',
                category: 'mon-thit',
                description: 'Bò nướng lụi thơm phức với bánh tráng, rau thơm',
                chefNotes: 'Thịt bò Úc thượng hạng, ướp gia vị độc quyền của nhà hàng',
                available: true
            },
            {
                id: 12,
                name: 'Gà Nướng Mật Ong',
                price: 150000,
                image: 'https://images.pexels.com/photos/8679466/pexels-photo-8679466.jpeg?auto=compress&cs=tinysrgb&w=500',
                category: 'mon-thit',
                description: 'Gà ta nướng mật ong thơm lừng, da vàng giòn',
                chefNotes: 'Gà ta Đông Tảo 1.2kg, mật ong nguyên chất U Minh',
                available: true
            }
        ];

        // Global variables
        let currentCategory = 'all';
        let cartItems = [];
        let productQuantities = {};

        // Initialize quantities for all products
        products.forEach(product => {
            productQuantities[product.id] = 1;
        });

        // Format price function
        function formatPrice(price) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
            }).format(price);
        }

        // Filter products by category
        function filterCategory(category) {
            currentCategory = category;
            
            // Update active button
            document.querySelectorAll('.category-button').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            renderProducts();
        }

        // Render products
        function renderProducts() {
            const productGrid = document.getElementById('productGrid');
            const noProducts = document.getElementById('noProducts');
            
            let filteredProducts = products;
            if (currentCategory !== 'all') {
                filteredProducts = products.filter(product => product.category === currentCategory);
            }
            
            if (filteredProducts.length === 0) {
                productGrid.innerHTML = '';
                noProducts.classList.remove('hidden');
                return;
            }
            
            noProducts.classList.add('hidden');
            
            productGrid.innerHTML = filteredProducts.map(product => `
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="${product.image}" alt="${product.name}" class="product-image">
                        <button class="info-button" onclick="toggleChefNotes(${product.id})">
                            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                    </div>

                    <div class="product-content">
                        <h3 class="product-name">${product.name}</h3>
                        <p class="product-description">${product.description}</p>

                        <div class="chef-notes" id="chefNotes${product.id}">
                            <p class="chef-notes-label">Ghi chú từ đầu bếp:</p>
                            <p class="chef-notes-text">${product.chefNotes}</p>
                        </div>

                        <div class="product-footer">
                            <span class="product-price">${formatPrice(product.price)}</span>
                            
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="updateQuantity(${product.id}, -1)" ${productQuantities[product.id] <= 1 ? 'disabled' : ''}>
                                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                </button>
                                
                                <span class="quantity-display" id="quantity${product.id}">${productQuantities[product.id]}</span>
                                
                                <button class="quantity-btn" onclick="updateQuantity(${product.id}, 1)">
                                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button class="add-to-cart-btn" onclick="addToCart(${product.id})" ${!product.available ? 'disabled' : ''}>
                            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"/>
                            </svg>
                            <span>Thêm vào giỏ</span>
                        </button>
                    </div>
                </div>
            `).join('');
        }

        // Toggle chef notes
        function toggleChefNotes(productId) {
            const chefNotes = document.getElementById(`chefNotes${productId}`);
            chefNotes.classList.toggle('show');
        }

        // Update quantity
        function updateQuantity(productId, change) {
            const newQuantity = Math.max(1, productQuantities[productId] + change);
            productQuantities[productId] = newQuantity;
            
            const quantityDisplay = document.getElementById(`quantity${productId}`);
            if (quantityDisplay) {
                quantityDisplay.textContent = newQuantity;
            }
            
            // Update button states
            const minusBtn = document.querySelector(`button[onclick="updateQuantity(${productId}, -1)"]`);
            if (minusBtn) {
                minusBtn.disabled = newQuantity <= 1;
            }
        }

        // Add to cart
        function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            const quantity = productQuantities[productId];
            
            const existingItem = cartItems.find(item => item.id === productId);
            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cartItems.push({ ...product, quantity });
            }
            
            // Reset quantity to 1
            productQuantities[productId] = 1;
            const quantityDisplay = document.getElementById(`quantity${productId}`);
            if (quantityDisplay) {
                quantityDisplay.textContent = 1;
            }
            
            updateCartDisplay();
        }

        // Update cart display
        function updateCartDisplay() {
            const cartCount = document.getElementById('cartCount');
            const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
            
            if (totalItems > 0) {
                cartCount.textContent = totalItems;
                cartCount.classList.remove('hidden');
            } else {
                cartCount.classList.add('hidden');
            }
        }

        // Open cart
        function openCart() {
            const cartModal = document.getElementById('cartModal');
            const emptyCart = document.getElementById('emptyCart');
            const cartItemsContainer = document.getElementById('cartItems');
            const cartFooter = document.getElementById('cartFooter');
            
            cartModal.classList.add('show');
            
            if (cartItems.length === 0) {
                emptyCart.classList.remove('hidden');
                cartItemsContainer.classList.add('hidden');
                cartFooter.classList.add('hidden');
            } else {
                emptyCart.classList.add('hidden');
                cartItemsContainer.classList.remove('hidden');
                cartFooter.classList.remove('hidden');
                
                renderCartItems();
                updateCartTotal();
            }
        }

        // Close cart
        function closeCart() {
            document.getElementById('cartModal').classList.remove('show');
        }

        // Render cart items
        function renderCartItems() {
            const cartItemsContainer = document.getElementById('cartItems');
            
            cartItemsContainer.innerHTML = cartItems.map(item => `
                <div class="cart-item">
                    <div class="cart-item-content">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                        
                        <div class="cart-item-details">
                            <h3 class="cart-item-name">${item.name}</h3>
                            <p class="cart-item-price">${formatPrice(item.price)}</p>
                            
                            <div class="cart-item-controls">
                                <div class="cart-quantity-controls">
                                    <button class="cart-quantity-btn" onclick="updateCartQuantity(${item.id}, ${item.quantity - 1})" ${item.quantity <= 1 ? 'disabled' : ''}>
                                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </button>
                                    
                                    <span class="cart-quantity-display">${item.quantity}</span>
                                    
                                    <button class="cart-quantity-btn" onclick="updateCartQuantity(${item.id}, ${item.quantity + 1})">
                                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <button class="remove-btn" onclick="removeFromCart(${item.id})">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Update cart quantity
        function updateCartQuantity(productId, newQuantity) {
            if (newQuantity <= 0) {
                removeFromCart(productId);
                return;
            }
            
            const item = cartItems.find(item => item.id === productId);
            if (item) {
                item.quantity = newQuantity;
                renderCartItems();
                updateCartTotal();
                updateCartDisplay();
            }
        }

        // Remove from cart
        function removeFromCart(productId) {
            cartItems = cartItems.filter(item => item.id !== productId);
            
            if (cartItems.length === 0) {
                document.getElementById('emptyCart').classList.remove('hidden');
                document.getElementById('cartItems').classList.add('hidden');
                document.getElementById('cartFooter').classList.add('hidden');
            } else {
                renderCartItems();
                updateCartTotal();
            }
            
            updateCartDisplay();
        }

        // Update cart total
        function updateCartTotal() {
            const totalAmount = cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);
            document.getElementById('totalAmount').textContent = formatPrice(totalAmount);
        }

        // Open order form
        function openOrderForm() {
            closeCart();
            document.getElementById('orderModal').classList.add('show');
        }

        // Close order form
        function closeOrderForm() {
            document.getElementById('orderModal').classList.remove('show');
        }

        // Submit order
        function submitOrder(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const orderData = {
                customerName: formData.get('customerName'),
                phone: formData.get('phone'),
                date: formData.get('date'),
                time: formData.get('time'),
                people: formData.get('people'),
                notes: formData.get('notes'),
                items: cartItems,
                total: cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0)
            };
            
            console.log('Order submitted:', orderData);
            alert('Đặt hàng thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất.');
            
            // Reset form and cart
            event.target.reset();
            cartItems = [];
            updateCartDisplay();
            closeOrderForm();
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderProducts();
        });
    </script>
</body>
</html>