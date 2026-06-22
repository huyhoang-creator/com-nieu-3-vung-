<?php
session_start();

// Kiểm tra và khởi tạo session nếu chưa có
if (!isset($_SESSION)) {
    session_start();
}

// Giả sử đã kết nối với database (sử dụng file connect_db.php của bạn)
include 'include/connect_db.php';

// Xử lý đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $identifier = isset($_POST['identifier']) ? $_POST['identifier'] : '';
    $mat_khau = isset($_POST['mat_khau']) ? $_POST['mat_khau'] : '';

    if (empty($identifier) || empty($mat_khau)) {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } else {
        // Kiểm tra cả sdt và email
        $sql = "SELECT * FROM NGUOI_DUNG WHERE (so_dien_thoai = ? OR email = ?) AND trang_thai = TRUE";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $identifier, $identifier); // Sử dụng cùng giá trị cho cả hai trường
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($mat_khau, $user['mat_khau'])) {
            // Lưu thông tin session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'ho_ten' => $user['ho_ten'],
                'vai_tro' => $user['vai_tro']
            ];
            $_SESSION['is_admin'] = ($user['vai_tro'] === 'quan_ly');

            // Chuyển hướng dựa trên vai trò
            if ($_SESSION['is_admin']) {
                header("Location: /3mien_restaurant/admin/admin.php");
            } else {
                $error = "Bạn không có quyền truy cập admin!";
            }
        } else {
            $error = "Thông tin đăng nhập không đúng!";
        }
    }
    $stmt->close();
}

// Xử lý đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    // Kiểm tra số điện thoại hoặc email đã tồn tại
    $check_sql = "SELECT * FROM NGUOI_DUNG WHERE so_dien_thoai = ? OR email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $so_dien_thoai, $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows == 0) {
        $sql = "INSERT INTO NGUOI_DUNG (ten_dang_nhap, mat_khau, ho_ten, email, so_dien_thoai, dia_chi, vai_tro, trang_thai) VALUES (?, ?, ?, ?, ?, ?, 'khach_hang', TRUE)";
        $ten_dang_nhap = "user_" . $so_dien_thoai;
        $ho_ten = "Khách " . $so_dien_thoai;
        $dia_chi = "Chưa cập nhật";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $ten_dang_nhap, $mat_khau, $ho_ten, $email, $so_dien_thoai, $dia_chi);
        if ($stmt->execute()) {
            $user_id = $conn->insert_id;
            $sql = "SELECT * FROM NGUOI_DUNG WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $new_user = $result->fetch_assoc();

            // Lưu thông tin session cho người dùng mới
            $_SESSION['user'] = [
                'id' => $new_user['id'],
                'ho_ten' => $new_user['ho_ten'],
                'vai_tro' => $new_user['vai_tro']
            ];
            $_SESSION['is_admin'] = false;
            header("Location: index.php");
            exit();
        } else {
            $error = "Đăng ký thất bại! Vui lòng thử lại.";
        }
        $stmt->close();
    } else {
        $error = "Số điện thoại hoặc email đã được sử dụng!";
    }
    $check_stmt->close();
}

// Xử lý đăng xuất (nếu có)
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login_register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập/Đăng ký</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .tab {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .tab button {
            padding: 10px 20px;
            border: none;
            background-color: #f4a261;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .tab button.active {
            background-color: #e76f51;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #e76f51;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .error, .success {
            text-align: center;
            margin-bottom: 10px;
            color: #d32f2f;
        }
        .success {
            color: #2e7d32;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="tab">
            <button class="tablink active" onclick="openForm(event, 'login')">Đăng nhập</button>
            <button class="tablink" onclick="openForm(event, 'register')">Đăng ký</button>
        </div>

        <div id="login" class="form active">
            <h2>Đăng nhập</h2>
            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="identifier">Số điện thoại hoặc Email:</label>
                    <input type="text" id="identifier" name="identifier" required>
                </div>
                <div class="form-group">
                    <label for="mat_khau">Mật khẩu:</label>
                    <input type="password" id="mat_khau" name="mat_khau" required>
                </div>
                <button type="submit" name="login">Đăng nhập</button>
            </form>
        </div>

        <div id="register" class="form">
            <h2>Đăng ký</h2>
            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
            <?php if (isset($success)) echo "<div class='success'>$success</div>"; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="so_dien_thoai">Số điện thoại:</label>
                    <input type="text" id="so_dien_thoai" name="so_dien_thoai" required>
                </div>
                <div class="form-group">
                    <label for="mat_khau">Mật khẩu:</label>
                    <input type="password" id="mat_khau" name="mat_khau" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="submit" name="register">Đăng ký</button>
            </form>
        </div>
    </div>

    <script>
        function openForm(evt, formName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("form");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(formName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Hiển thị form đăng nhập mặc định
        document.getElementsByClassName("tablink")[0].click();
    </script>
</body>
</html>
<?php
// Đóng kết nối database
$conn->close();

// Hủy session nếu không còn cần thiết
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
}
?>