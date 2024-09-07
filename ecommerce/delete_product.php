<?php
session_start();
include 'connectdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $id = $_POST['id'];

    // Kiểm tra thời gian tạo sản phẩm
    $checkQuery = $conn->prepare("SELECT created_at FROM products WHERE id = ?");
    $checkQuery->bind_param("i", $id);
    $checkQuery->execute();
    $result = $checkQuery->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $createdAt = new DateTime($product['created_at']);
        $now = new DateTime();
        $interval = $now->diff($createdAt);

        // Kiểm tra xem sản phẩm có được thêm trong vòng 30 ngày không
        if ($interval->days <= 30) {
            // Xóa sản phẩm
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error']);
            }

            $stmt->close();
        } else {
            echo json_encode(['status' => 'forbidden', 'message' => 'Sản phẩm này không thể xóa sau 30 ngày.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại.']);
    }

    $checkQuery->close();
}
$conn->close();
?>
