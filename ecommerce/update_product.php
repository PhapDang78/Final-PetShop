<?php
session_start();
include 'connectdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("UPDATE products SET name = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $price, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
}
$conn->close();
?>
