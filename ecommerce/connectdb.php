<?php
$servername = "localhost"; 
$username = "root"; // Thay đổi thành tên người dùng của bạn
$password = ""; // Để trống nếu không có mật khẩu
$dbname = "final"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
