<?php
$servername = "localhost";
$username = "root";  // Hoặc tên người dùng CSDL của bạn
$password = "";      // Mật khẩu của CSDL
$database = "3_MIEN_RESTAURANT";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

mysqli_set_charset($conn, "utf8"); // Đảm bảo hiển thị tiếng Việt


