<?php
include 'connectdb.php';

$data = json_decode(file_get_contents('php://input'), true);

// Kiểm tra xem dữ liệu có hợp lệ không
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'Dữ liệu JSON không hợp lệ.']);
    exit;
}

// Kiểm tra xem có dữ liệu không
if (empty($data)) {
    echo json_encode(['error' => 'Không có dữ liệu gửi đến.']);
    exit;
}

// Kiểm tra kết nối cơ sở dữ liệu
if (!$conn) {
    echo json_encode(['error' => 'Không thể kết nối đến cơ sở dữ liệu.']);
    exit;
}

// Lưu thông tin vào cơ sở dữ liệu
foreach ($data as $item) {
    if (!isset($item['title'], $item['price'], $item['quantity'])) {
        echo json_encode(['error' => 'Dữ liệu không đầy đủ.']);
        exit;
    }

    $title = mysqli_real_escape_string($conn, $item['title']);
    $price = mysqli_real_escape_string($conn, $item['price']);
    $quantity = mysqli_real_escape_string($conn, $item['quantity']);

    $query = "INSERT INTO orders (title, price, quantity) VALUES ('$title', '$price', '$quantity')";
    if (!mysqli_query($conn, $query)) {
        echo json_encode(['error' => 'Lỗi khi lưu dữ liệu: ' . mysqli_error($conn)]);
        exit;
    }
}

echo json_encode(['success' => true]);
?>
