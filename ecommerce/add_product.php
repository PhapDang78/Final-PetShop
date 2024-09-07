<?php
include 'connectdb.php';
session_start();

// Kiểm tra quyền truy cập
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['status' => 'forbidden', 'message' => 'Không có quyền truy cập.']);
    exit();
}

// Kiểm tra xem có dữ liệu được gửi không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Xử lý hình ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageType = $_FILES['image']['type'];

        // Kiểm tra định dạng hình ảnh
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($imageType, $allowedTypes)) {
            echo json_encode(['status' => 'error', 'message' => 'Định dạng hình ảnh không hợp lệ.']);
            exit();
        }

        // Đường dẫn lưu hình ảnh
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $imagePath = $uploadDir . basename($imageName);

        // Di chuyển hình ảnh vào thư mục uploads
        if (move_uploaded_file($imageTmpPath, $imagePath)) {
            // Lưu thông tin sản phẩm vào cơ sở dữ liệu
            $stmt = $conn->prepare("INSERT INTO products (name, price, img) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $name, $price, $imagePath);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo json_encode(['status' => 'success', 'id' => $stmt->insert_id]);
            } else {
                echo json_encode(['status' => 'error']);
            }

            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Không thể tải lên hình ảnh.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không có hình ảnh nào được tải lên.']);
    }
}

$conn->close();
?>
