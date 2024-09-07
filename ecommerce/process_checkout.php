<?php
include 'connectdb.php';

$data = json_decode(file_get_contents('php://input'), true);

// Kiểm tra xem dữ liệu có hợp lệ không
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'Dữ liệu JSON không hợp lệ.']);
    exit;
}

// Kiểm tra xem có dữ liệu không
if (empty($data['cart'])) {
    echo json_encode(['error' => 'Không có dữ liệu giỏ hàng gửi đến.']);
    exit;
}

// Lấy thông tin người dùng
$fullName = mysqli_real_escape_string($conn, $data['fullName']);
$address = mysqli_real_escape_string($conn, $data['address']);
$phone = mysqli_real_escape_string($conn, $data['phone']);

// Lưu thông tin vào cơ sở dữ liệu
foreach ($data['cart'] as $item) {
    if (!isset($item['title'], $item['price'], $item['quantity'])) {
        echo json_encode(['error' => 'Dữ liệu không đầy đủ.']);
        exit;
    }

    $title = mysqli_real_escape_string($conn, $item['title']);
    $price = mysqli_real_escape_string($conn, $item['price']);
    $quantity = mysqli_real_escape_string($conn, $item['quantity']);

    $query = "INSERT INTO orders (title, price, quantity, full_name, address, phone) VALUES ('$title', '$price', '$quantity', '$fullName', '$address', '$phone')";
    if (!mysqli_query($conn, $query)) {
        echo json_encode(['error' => 'Lỗi khi lưu dữ liệu: ' . mysqli_error($conn)]);
        exit;
    }
}

echo json_encode(['success' => true]);

?>
