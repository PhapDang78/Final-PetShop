<?php
session_start();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connectdb.php'; // Kết nối cơ sở dữ liệu

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: admin.php"); // Chuyển hướng đến trang admin
            exit();
        } else {
            $error = "Mật khẩu không đúng.";
        }
    } else {
        $error = "Tên người dùng không tồn tại.";
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
    <title>Đăng Nhập</title>
</head>
<body>
    <div class="login-container">
        <h2>Đăng Nhập</h2>
        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="username">Tên người dùng:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
            <a href="#" class="button">Đăng Nhập</a>
        </form>
    </div>
</body>
</html>
