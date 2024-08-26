<?php
session_start();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connectdb.php'; // Kết nối cơ sở dữ liệu

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu
    $email = $_POST['email']; // Lấy email từ form

    // Kiểm tra xem tên người dùng đã tồn tại chưa
    $checkUser = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($checkUser);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Tên người dùng hoặc email đã tồn tại.";
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'user')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $email);
        
        if ($stmt->execute()) {
            header("Location: login.php"); // Chuyển hướng đến trang đăng nhập
            exit();
        } else {
            $error = "Có lỗi xảy ra. Vui lòng thử lại.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Đăng Ký</title>
</head>
<body>
    <div class="register-container">
        <h2>Đăng Ký</h2>
        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="" method="POST" onsubmit="return validateEmail();">
            <label for="username">Tên người dùng:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Đăng Ký</button>
        </form>
        <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
    </div>
    
    <script>
        function validateEmail() {
            const email = document.getElementById('email').value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Vui lòng nhập địa chỉ email hợp lệ.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
