<?php
session_start();
session_unset(); // Xóa tất cả các biến phiên
session_destroy(); // Hủy phiên
header("Location: login.php"); // Chuyển hướng đến trang đăng nhập
exit();
?>

