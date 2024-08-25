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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Admin Dashboard - E-commerce</title>
    <style>
        /* Các style đã được định nghĩa trước đó */
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
        }

        .products.section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .products_table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .product-table th, .product-table td {
            padding: 1rem;
            border: 1px solid #ddd;
            text-align: center;
        }   

        .product-table th {
            background-color: var(--container-color);
            color: var(--title-color);
        }

        .product-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .product-table tr:hover {
            background-color: #f1f1f1;
        }

        .add-product-btn {
            background-color: hsl(250, 60%, 50%);
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
        .product-card {
            background: var(--container-color);
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 1rem;
        }

        .product-card h3 {
            font-size: var(--h2-font-size);
            color: var(--title-color);
        }

        .product-card p {
            color: var(--text-color);
        }

        .product-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }

        .edit-btn, .delete-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
        }

        .edit-btn {
            background-color: hsl(60, 100%, 40%);
            color: #fff;
        }

        .delete-btn {
            background-color: hsl(0, 100%, 50%);
            color: #fff;
        }

        .edit-btn:hover {
            background-color: hsl(60, 100%, 30%);
        }

        .delete-btn:hover {
            background-color: hsl(0, 100%, 40%);
        }
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

        #add-product-form input {
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
            background-color: hsl(250, 60%, 50%); /* Màu nền cho nút lưu */
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

    </style>
</head>
<body>
    <header class="header">
        <div class="header_container">
            <h1>Quản trị viên</h1>
            <div class="header_btns">
                <a href="logout.php" class="button">Đăng xuất</a>
            </div>
        </div>
    </header>

    <main class="main">
        <section class="dashboard section">
            <h2 class="section_title">Bảng điều khiển</h2>
            <div class="dashboard_cards">
                <!-- <div class="card">
                    <h3>Khách hàng</h3>
                    <span id="customer-count">0</span>
                </div> -->

                <div class="card">
                    <h3>Đơn hàng</h3>
                    <span id="order-count"><?php echo $orderCount; ?></span>
                    <?php
                    $query = "SELECT * FROM orders";
                    $result = mysqli_query($conn, $query);
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='product-card'>";
                        echo "<p>" . $row['title'] . "</p>";
                        echo "</div>";
                    }
                    ?>
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
                <button id="save-product-btn">Lưu sản phẩm</button>
                <button id="cancel-btn">Hủy</button>
            </div>
            <table class="products_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <?php
                    // Lấy danh sách sản phẩm từ cơ sở dữ liệu
                    $query = "SELECT * FROM products";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . number_format($row['price'], 0, ',', '.') . " VNĐ</td>";
                        echo "<td class='product-actions'>";
                        echo "<button class='edit-btn' onclick='editProduct(" . $row['id'] . ")'>Chỉnh Sửa</button>";
                        echo "<button class='delete-btn' onclick='deleteProduct(" . $row['id'] . ")'>Xóa</button>";
                        echo "</td>";
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

            if (newName && newPrice) {
                fetch('add_product.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `name=${encodeURIComponent(newName)}&price=${encodeURIComponent(newPrice)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Thêm sản phẩm vào danh sách
                        const newRow = productList.insertRow();
                        newRow.innerHTML = `
                            <td>${data.id}</td>
                            <td>${newName}</td>
                            <td>${newPrice} VNĐ</td>
                            <td class='product-actions'>
                                <button class='edit-btn' onclick='editProduct(${data.id})'>Chỉnh Sửa</button>
                                <button class='delete-btn' onclick='deleteProduct(${data.id})'>Xóa</button>
                            </td>
                        `;
                        addProductForm.style.display = 'none'; // Ẩn form
                        document.getElementById('product-name').value = ''; // Xóa dữ liệu form
                        document.getElementById('product-price').value = '';
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
            const row = productList.querySelector(`tr:nth-child(${id})`);
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
                        const row = productList.querySelector(`tr:nth-child(${id})`);
                        productList.removeChild(row);
                    } else {
                        alert('Xóa không thành công!');
                    }
                });
            }
        }
    </script>
</body>
</html>
