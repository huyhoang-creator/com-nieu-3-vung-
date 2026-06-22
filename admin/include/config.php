<?php
// Cấu hình hệ thống
define('BASE_URL', 'http://localhost/3mien_restaurant/admin');
define('SITE_NAME', 'Nhà hàng 3 miền - Admin');
define('UPLOAD_PATH', 'assets/uploads/');

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Session
session_start();

// Auto load classes
spl_autoload_register(function ($class_name) {
    $directories = [
        'models/',
        'controllers/',
        'config/'
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
?>