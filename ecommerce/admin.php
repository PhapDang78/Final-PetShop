<?php
include 'connectdb.php';
session_start();

// Kiểm tra nếu người dùng không phải là admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Chuyển hướng đến trang đăng nhập
    exit();
}

// Lấy số lượng đơn hàng và tổng tiền
$orderCountQuery = "SELECT COUNT(*) as order_count, SUM(price * quantity) as total_payment FROM orders";
$orderCountResult = mysqli_query($conn, $orderCountQuery);
$orderData = mysqli_fetch_assoc($orderCountResult);

$orderCount = $orderData['order_count'];
$totalPayment = $orderData['total_payment'];

// Lấy thông tin đơn hàng và khách hàng
$orderQuery = "SELECT * FROM orders";
$orderResult = mysqli_query($conn, $orderQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/colors/color-1.css">
    <title>Admin Dashboard - E-commerce</title>
    <style>
            /*=============== GLOBAL STYLES ===============*/
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--body-color);
            color: var(--text-color);
        }

        header {
            background: var(--container-color);
            box-shadow: 0 2px 5px var(--shadow);
        }

        h2.section_title {
            color: var(--title-color);
            margin-bottom: var(--mb-2);
        }

        /*=============== DASHBOARD STYLES ===============*/
        .dashboard {
            margin-bottom: 2rem;
        }

        .dashboard_cards {
            display: flex;
            gap: 2rem;
        }

        .card {
            background: var(--container-color);
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: var(--shadow);
            flex: 1;
            text-align: center;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px); /* Hiệu ứng nâng lên khi hover */
        }

        /*=============== TABLE STYLES ===============*/
        .products.section, .orders.section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .products_table, .orders_table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 1rem;
            border-radius: 0.5rem;
            overflow: hidden; /* Ẩn viền ngoài */
        }

        .products_table th, .products_table td,
        .orders_table th, .orders_table td {
            padding: 1rem;
            border: 1px solid #ddd;
            text-align: center;
        }

        .products_table th, .orders_table th {
            background-color: var(--first-color);
            color: white; /* Màu chữ tiêu đề bảng */
        }

        .products_table tr:nth-child(even), .orders_table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .products_table tr:hover, .orders_table tr:hover {
            background-color: #f1f1f1;
        }

        /*=============== BUTTON STYLES ===============*/
        .add-product-btn {
            background-color: var(--first-color);
            color: #fff;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background 0.3s;
        }

        .add-product-btn:hover {
            background-color: hsl(250, 60%, 40%);
        }

        /*=============== FORM STYLES ===============*/
        #add-product-form {
            margin-top: 1rem;
            display: none; /* Ẩn form mặc định */
            background: #fff;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 80%; /* Đặt chiều rộng của form */
            max-width: 500px; /* Chiều rộng tối đa */
            margin-left: auto; /* Căn giữa form */
            margin-right: auto; /* Căn giữa form */
        }

        #add-product-form h3 {
            margin-bottom: 1rem;
            font-size: 1.5rem; /* Kích thước tiêu đề */
            color: #333; /* Màu sắc tiêu đề */
        }

        #add-product-form label {
            display: block; /* Hiển thị label như một khối */
            margin-bottom: 0.5rem; /* Khoảng cách dưới label */
            color: #555; /* Màu sắc của label */
        }

        #add-product-form input,
        #add-product-form select {
            display: block;
            margin: 0.5rem 0 1rem; /* Khoảng cách trên và dưới */
            padding: 0.5rem;
            width: calc(100% - 1rem); /* Chiều rộng với khoảng cách */
            border: 1px solid #ddd; /* Viền cho input */
            border-radius: 0.25rem; /* Bo góc */
            font-size: 1rem; /* Kích thước chữ */
        }

        #add-product-form button {
            margin-top: 0.5rem; /* Khoảng cách trên nút */
            padding: 0.5rem 1rem; /* Padding cho nút */
            border: none; /* Bỏ viền */
            border-radius: 0.25rem; /* Bo góc */
            cursor: pointer; /* Con trỏ khi di chuột */
            transition: background 0.3s; /* Hiệu ứng chuyển đổi */
        }

        #save-product-btn {
            background-color: var(--first-color);
            color: #fff; /* Màu chữ */
        }

        #save-product-btn:hover {
            background-color: hsl(250, 60%, 40%); /* Màu nền khi hover */
        }

        #cancel-btn {
            background-color: #e74c3c; /* Màu nền cho nút hủy */
            color: #fff; /* Màu chữ */
        }

        #cancel-btn:hover {
            background-color: #c0392b; /* Màu nền khi hover */
        }

        /*=============== FOOTER STYLES ===============*/
        .footer {
            text-align: center;
            padding: 1rem;
            background-color: var(--first-color);
            color: white; /* Màu chữ footer */
        }

    </style>
</head>
<body>
    <header class="header" id="header">
        <nav class="nav container">
            <a href="index.php" class="nav_logo">
                <img src="assets/img/logo/Remove-bg.ai_1722440725057.png" alt="">
            </a>
            <div class="nav_menu" id="nav-menu">
                <h1>Quản trị viên</h1>
            </div>
            <div class="nav_btns">
                <a href="logout.php" class="button">Đăng xuất</a>
            </div>
        </nav>
    </header>

    <main class="main">
        <section class="dashboard section">
            <h2 class="section_title">Doanh Thu</h2>
            <div class="dashboard_cards">
                <div class="card">
                    <h3>Đơn hàng</h3>
                    <span id="order-count"><?php echo $orderCount; ?></span>
                </div>
                
                <div class="card">
                    <h3>Tổng thanh toán</h3>
                    <span id="total-payment"><?php echo number_format($totalPayment, 3,'.', ',') . ' VNĐ'; ?></span>
                </div>
            </div>
        </section>

        <section class="products section">
            <h2 class="section_title">Quản lý sản phẩm</h2>
            <button id="add-product" class="add-product-btn">Thêm sản phẩm</button>
            <div id="add-product-form">
                <h3>Thêm sản phẩm mới</h3>
                <label for="product-name">Tên sản phẩm:</label>
                <input type="text" id="product-name" required>
                <label for="product-price">Giá sản phẩm:</label>
                <input type="number" id="product-price" required>
                <label for="product-category">Phân loại sản phẩm:</label>
                <select id="product-category" required>
                    <option value="">Chọn phân loại</option>
                    <option value="balo">Balo</option>
                    <option value="quần áo">Quần áo</option>
                    <option value="chuồng chó">Chuồng chó</option>
                    <option value="thức ăn cho chó">Thức ăn cho chó</option>
                    <option value="thức ăn cho mèo">Thức ăn cho mèo</option>
                    <option value="đồ chơi">Đồ chơi</option>
                </select>
                <label for="product-image">Hình ảnh sản phẩm:</label>
                <input type="file" id="product-image" accept="image/*" required>
                <button id="save-product-btn">Lưu sản phẩm</button>
                <button id="cancel-btn">Hủy</button>
            </div>
            <table class="products_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Giá</th>
                        <th>Loại Sản Phẩm</th>
                        <th>Chỉnh Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <?php
                    // Lấy danh sách sản phẩm từ cơ sở dữ liệu
                    $query = "SELECT * FROM products";
                    $result = mysqli_query($conn, $query);
                    
                    if (!$result) {
                        die("Lỗi truy vấn: " . mysqli_error($conn));
                    }
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr data-id='" . $row['id'] . "'>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . number_format($row['price'], 0, '.', '.') . " VNĐ</td>";
                        echo "<td>" . htmlspecialchars($row['category']) . "</td>"; // Hiển thị phân loại
                        echo "<td class='product-actions'>";
                        echo "<button class='edit-btn' onclick='editProduct(" . $row['id'] . ")'>Chỉnh Sửa</button>";
                        echo "</td>";
                        echo "<td class='product-actions'>";
                        echo "<button class='delete-btn' onclick='deleteProduct(" . $row['id'] . ")'>Xóa</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    
                    ?>
                </tbody>
            </table>
        </section>

        <section class="orders section">
            <h2 class="section_title">Danh sách đơn hàng</h2>
            <table class="orders_table">
                <thead>
                    <tr>
                        <th>ID Đơn Hàng</th>
                        <th>Tên Khách Hàng</th>
                        <th>Địa Chỉ</th>
                        <th>Số Điện Thoại</th>
                        <th>Mặt Hàng</th>
                        <th>Số Lượng</th>
                        <th>Tổng Giá</th>
                    </tr>
                </thead>
                <tbody id="order-list">
                    <?php
                    // Hiển thị danh sách đơn hàng
                    while ($order = mysqli_fetch_assoc($orderResult)) {
                        echo "<tr>";
                        echo "<td>" . $order['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($order['full_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['address']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['quantity']) . "</td>";
                        echo "<td>" . number_format($order['price'] * $order['quantity'], 3, '.', '.') . " VNĐ</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer class="footer">
        <span>&#169; 2024 E-commerce. Tất cả quyền được bảo lưu.</span>
    </footer>

    <script>
        const productList = document.getElementById('product-list');
        const addProductForm = document.getElementById('add-product-form');
        const saveProductBtn = document.getElementById('save-product-btn');
        const cancelBtn = document.getElementById('cancel-btn');

        // Hiển thị form thêm sản phẩm
        document.getElementById('add-product').onclick = function() {
            addProductForm.style.display = 'block';
        };

        // Lưu sản phẩm mới
        saveProductBtn.onclick = function() {
            const newName = document.getElementById('product-name').value;
            const newPrice = document.getElementById('product-price').value;
            const newImage = document.getElementById('product-image').files[0];
            const newCategory = document.getElementById('product-category').value;

            if (newName && newPrice && newImage && newCategory) {
                const formData = new FormData();
                formData.append('name', newName);
                formData.append('price', newPrice);
                formData.append('image', newImage);
                formData.append('category', newCategory); // Thêm phân loại vào FormData

                fetch('add_product.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Thêm sản phẩm vào danh sách
                        const newRow = productList.insertRow();
                        newRow.setAttribute('data-id', data.id);
                        newRow.innerHTML = `
                            <td>${data.id}</td>
                            <td>${newName}</td>
                            <td>${newPrice} VNĐ</td>
                            <td>${newCategory}</td> <!-- Hiển thị phân loại -->
                            <td class='product-actions'>
                                <button class='edit-btn' onclick='editProduct(${data.id})'>Chỉnh Sửa</button>
                            </td>
                            <td class='product-actions'>
                                <button class='delete-btn' onclick='deleteProduct(${data.id})'>Xóa</button>
                            </td>
                        `;
                        // Reset form
                        addProductForm.style.display = 'none';
                        document.getElementById('product-name').value = '';
                        document.getElementById('product-price').value = '';
                        document.getElementById('product-image').value = '';
                        document.getElementById('product-category').value = ''; 
                    } else {
                        alert('Thêm sản phẩm không thành công!');
                    }
                });
            }
        };

        // Hủy thêm sản phẩm
        cancelBtn.onclick = function() {
            addProductForm.style.display = 'none'; // Ẩn form
        };

        // Chức năng chỉnh sửa sản phẩm
        function editProduct(id) {
            const row = productList.querySelector(`tr[data-id='${id}']`);
            const name = row.cells[1].innerText;
            const price = row.cells[2].innerText.replace(' VNĐ', '');

            const newName = prompt("Nhập tên sản phẩm mới:", name);
            const newPrice = prompt("Nhập giá sản phẩm mới:", price);

            if (newName && newPrice) {
                // Cập nhật sản phẩm trong cơ sở dữ liệu
                fetch('update_product.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}&name=${encodeURIComponent(newName)}&price=${encodeURIComponent(newPrice)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        row.cells[1].innerText = newName;
                        row.cells[2].innerText = newPrice + ' VNĐ';
                    } else {
                        alert('Cập nhật không thành công!');
                    }
                });
            }
        }

        // Chức năng xóa sản phẩm
        function deleteProduct(id) {
            const confirmDelete = confirm("Bạn có chắc chắn muốn xóa sản phẩm này?");
            if (confirmDelete) {
                fetch('delete_product.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Xóa sản phẩm khỏi giao diện người dùng
                        const row = productList.querySelector(`tr[data-id='${id}']`);
                        if (row) {
                            row.remove();
                        }
                    } else {
                        alert('Xóa không thành công!');
                    }
                });
            }
        }
    </script>
</body>
</html>
