<?php
session_start();
include 'connectdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    // Lấy và kiểm tra dữ liệu đầu vào
    $id = intval($_POST['id']); // Chuyển đổi ID sang kiểu số nguyên
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']); // Chuyển đổi giá sang kiểu số thực

    // Kiểm tra xem các trường không được để trống
    if (empty($name) || $price <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Tên sản phẩm và giá phải hợp lệ.']);
        exit();
    }

    // Cập nhật sản phẩm
    $stmt = $conn->prepare("UPDATE products SET name = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $price, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Cập nhật sản phẩm thành công.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không có thay đổi nào được thực hiện hoặc sản phẩm không tồn tại.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Bạn không có quyền thực hiện hành động này.']);
}

$conn->close();
?>
