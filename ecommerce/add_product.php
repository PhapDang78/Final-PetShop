<?php
include 'connectdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $query = "INSERT INTO products (name, price) VALUES ('$name', '$price')";
    if (mysqli_query($conn, $query)) {
        $id = mysqli_insert_id($conn); // Lấy ID của sản phẩm vừa thêm
        echo json_encode(['status' => 'success', 'id' => $id]);
    } else {
        echo json_encode(['status' => 'error']);
    }
}
?>
