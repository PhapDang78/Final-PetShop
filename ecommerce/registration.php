    <?php
            include 'connectdb.php'; // Kết nối cơ sở dữ liệu
    session_start();
    $error = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu
        $email = $_POST['email']; // Lấy email từ form

        // Kiểm tra xem tên người dùng đã tồn tại chưa
        $checkUser = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($checkUser);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Tên người dùng hoặc email đã tồn tại.";
        } else {
            // Thêm người dùng mới vào cơ sở dữ liệu
            $sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'user')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $password, $email);
            
            if ($stmt->execute()) {
                header("Location: login.php"); // Chuyển hướng đến trang đăng nhập
                exit();
            } else {
                $error = "Có lỗi xảy ra. Vui lòng thử lại.";
            }
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--=============== BOXICONS ===============-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

        <!--=============== SWIPER CSS ===============-->
        <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">

        <!--=============== CSS ===============-->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/colors/color-1.css">
        <title>Đăng Ký</title>
        <style>
            .register-container {
                position: relative; /* Để có thể sử dụng z-index */
                z-index: 1; /* Đảm bảo nó nằm dưới header */
                margin-top: calc(var(--header-height) + 2rem); /* Đẩy xuống dưới header */
                padding: 2rem; /* Thêm padding cho phần nội dung */
                background-color: var(--container-color); /* Màu nền */
                border-radius: 8px; /* Bo góc */
                box-shadow: 0 2px 10px var(--shadow); /* Đổ bóng cho đẹp */
                max-width: 400px; /* Chiều rộng tối đa */
                margin-left: auto; /* Canh giữa */
                margin-right: auto; /* Canh giữa */
                text-align: center; /* Canh giữa nội dung */
            }

            .register-container h2 {
                font-size: var(--h2-font-size); /* Kích thước tiêu đề */
                margin-bottom: var(--mb-2); /* Khoảng cách dưới tiêu đề */
            }

            .register-container label {
                display: block; /* Đảm bảo label chiếm toàn bộ chiều rộng */
                margin-bottom: var(--mb-0-5); /* Khoảng cách dưới label */
                color: var(--title-color); /* Màu chữ */
            }

            .register-container input {
                width: 100%; /* Chiều rộng đầy đủ */
                padding: 0.5rem; /* Padding cho input */
                border: 1px solid var(--scroll-bar-color); /* Viền cho input */
                border-radius: 4px; /* Bo góc cho input */
                margin-bottom: var(--mb-1); /* Khoảng cách dưới input */
            }

            .register-container button {
                background-color: var(--first-color); /* Màu nền cho nút */
                color: #fff; /* Màu chữ */
                padding: 0.75rem 1.5rem; /* Padding cho nút */
                border: none; /* Không viền */
                border-radius: 4px; /* Bo góc cho nút */
                cursor: pointer; /* Con trỏ khi hover */
                transition: background-color 0.3s; /* Hiệu ứng chuyển màu */
            }

            .register-container button:hover {
                background-color: var(--first-color-alt); /* Màu nền khi hover */
            }

            .register-container p {
                margin-top: 1rem; /* Khoảng cách trên */
            }

            .register-container a {
                color: var(--first-color); /* Màu chữ cho liên kết */
                text-decoration: underline; /* Gạch chân cho liên kết */
            }

        </style>
    </head>
    <body>
            <!--=============== HEADER ===============-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="index.php" class="nav_logo">
                <!-- <i class="bx bxs-shopping-bags nav_Logo-icon"></i>  -->
                 <img src="assets/img/logo/Remove-bg.ai_1722440725057.png" alt="">
            </a>
            <div class="nav_menu" id="nav-menu">
                <ul class="nav_list">
                    <li class="nav_item">
                        <a href="index.php" class="nav_link active-link">TRANG CHỦ</a>
                    </li>

                    <li class="nav_item">
                        <a href="shop.php" class="nav_link">CỬA HÀNG</a>
                    </li>

                    <li class="nav_item">
                        <a href="cart.php" class="nav_link">GIỎ HÀNG</a>
                    </li>

                    <li class="nav_item">
                        <a href="blog.php" class="nav_link">BLOG</a>
                    </li>

                    <li class="nav_item">
                        <a href="faq.php" class="nav_link">CÂU HỎI</a>
                    </li>

                    <li class="nav_item">
                        <a href="contact.php" class="nav_link">LIÊN HỆ</a>
                    </li>

                </ul>

                <div class="nav_close" id="nav-close"> 
                    <i class="bx bx-x"></i>
                </div>
            </div>

            <div class="nav_btns">
                <div class="login_toggle" id="login-button"> 
                    <i class="bx bx-user"></i>
                </div>

                <div class="nav_shop" id="cart-shop">
                    <i class="bx bx-shopping-bag"></i>
                </div>

                <div class="nav_toggle" id="nav-toggle"> 
                    <i class="bx bx-grid-alt"></i>
                </div>

            </div>
        </nav>
    </header>
    <!--=============== CART ===============-->
    <div class="cart" id="cart">
        <i class="bx bx-x cart_close" id="cart-close"></i>
    
        <h2 class="cart_title-center">Giỏ hàng</h2>
        <div class="cart_container" id="cart-items">
            <!-- Các sản phẩm sẽ được thêm vào đây thông qua JavaScript -->
        </div>
    
        <div class="cart_prices">
            <span class="cart_prices-item" id="item-count">0 mặt hàng</span>
            <span class="cart_prices-total" id="total-price">0 VNĐ</span>
        </div>
        
        <div>
            <a href="cart.php" class="button">Thanh Toán</a>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartContainer = document.getElementById('cart-items');
            const itemCount = document.getElementById('item-count');
            const totalPrice = document.getElementById('total-price');
            const cart = JSON.parse(localStorage.getItem('cart')) || [];

            function renderCart() {
                cartContainer.innerHTML = '';
                let total = 0;

                if (cart.length === 0) {
                    cartContainer.innerHTML = '<p>Giỏ hàng của bạn trống.</p>';
                    itemCount.textContent = 0;
                    totalPrice.textContent = '0 VNĐ';
                } else {
                    cart.forEach(item => {
                        total += parseFloat(item.price) * parseInt(item.quantity);
                        cartContainer.innerHTML += `
                            <article class="cart_card">
                                <div class="cart_box">
                                    <img src="${item.img}" alt="${item.title}" class="cart_img">
                                </div>
                                <div class="cart_details">
                                    <h3 class="cart_title">${item.title}</h3>
                                    <span class="cart_price">${item.price} VNĐ</span>
                                    <div class="cart_amount">
                                        <div class="cart_amount-content">
                                            <span class="cart_amount-box decrease" data-id="${item.id}">
                                                <i class="bx bx-minus"></i>
                                            </span>
                                            <span class="cart_amount-number">${item.quantity}</span>
                                            <span class="cart_amount-box increase" data-id="${item.id}">
                                                <i class="bx bx-plus"></i>
                                            </span>
                                        </div>
                                        <i class="bx bx-trash-alt cart_amount-trash remove" data-id="${item.id}"></i>
                                    </div>
                                </div>
                            </article>
                        `;
                    });

                    itemCount.textContent = `${cart.length} mặt hàng`;
                    totalPrice.textContent = `${total.toLocaleString()},000 VNĐ`;

                    document.querySelectorAll('.increase').forEach(button => {
                        button.addEventListener('click', function() {
                            const productId = parseInt(this.dataset.id);
                            updateCartQuantity(productId, 1);
                        });
                    });

                    document.querySelectorAll('.decrease').forEach(button => {
                        button.addEventListener('click', function() {
                            const productId = parseInt(this.dataset.id);
                            updateCartQuantity(productId, -1);
                        });
                    });

                    document.querySelectorAll('.remove').forEach(button => {
                        button.addEventListener('click', function() {
                            const productId = parseInt(this.dataset.id);
                            removeFromCart(productId);
                        });
                    });
                }
            }

            function updateCartQuantity(productId, change) {
                const item = cart.find(product => product.id === productId);
                if (item) {
                    item.quantity += change;
                    if (item.quantity <= 0) {
                        cart.splice(cart.indexOf(item), 1);
                    }
                    localStorage.setItem('cart', JSON.stringify(cart));
                    renderCart();
                }
            }

            function removeFromCart(productId) {
                const itemIndex = cart.findIndex(product => product.id === productId);
                if (itemIndex > -1) {
                    cart.splice(itemIndex, 1);
                    localStorage.setItem('cart', JSON.stringify(cart));
                    renderCart();
                }
            }

            renderCart();
        });
    </script>
    

        <div class="register-container">
            <h2>Đăng Ký</h2>
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="" method="POST" onsubmit="return validateEmail();">
                <label for="username">Tên người dùng:</label>
                <input type="text" id="username" name="username" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Đăng Ký</button>
            </form>
            <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
        </div>
        
        <script>
            function validateEmail() {
                const email = document.getElementById('email').value;
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    alert('Vui lòng nhập địa chỉ email hợp lệ.');
                    return false;
                }
                return true;
            }
        </script>
       <footer class="footer section">
        <div class="footer_container container grid">
            <!-- NỘI DUNG FOOTER 1 -->
            <div class="footer_content">
                <a href="#" class="footer_logo">
                     DP PET
                </a>
    
                <p class="footer_description">Thưởng thức chương trình giảm giá lớn nhất <br> trong đời bạn.</p>
    
                <div class="footer_social">
                    <a href="#" class="footer_social-link"><i class="bx bxl-facebook"></i></a>
                    <a href="#" class="footer_social-link"><i class="bx bxl-instagram-alt"></i></a>
                    <a href="#" class="footer_social-link"><i class="bx bxl-twitter"></i></a>
                </div>
            </div>
    
            <!-- NỘI DUNG FOOTER 2 -->
            <div class="footer_content">
                <h3 class="footer_title">Về chúng tôi</h3>
    
                <ul class="footer_links">
                    <li><a href="#" class="footer_link">Giới thiệu</a></li>
                    <li><a href="#" class="footer_link">Hỗ trợ khách hàng</a></li>
                    <li><a href="#" class="footer_link">Trung tâm hỗ trợ</a></li>
                </ul>
            </div>
    
            <!-- NỘI DUNG FOOTER 3 -->
            <div class="footer_content">
                <h3 class="footer_title">Dịch vụ của chúng tôi</h3>
    
                <ul class="footer_links">
                    <li><a href="#" class="footer_link">Cửa hàng</a></li>
                    <li><a href="#" class="footer_link">Giảm giá</a></li>
                    <li><a href="#" class="footer_link">Phương thức giao hàng</a></li>
                </ul>
            </div>
    
            <!-- NỘI DUNG FOOTER 4 -->
            <div class="footer_content">
                <h3 class="footer_title">Công ty chúng tôi</h3>
    
                <ul class="footer_links">
                    <li><a href="#" class="footer_link">Đăng ký</a></li>
                    <li><a href="#" class="footer_link">Liên hệ với chúng tôi</a></li>
                    <li><a href="#" class="footer_link">Giới thiệu</a></li>
                </ul>
            </div>
        </div>
    
        <span class="footer_copy">&#169; Crypticalcoder. Tất cả quyền được bảo lưu</span>
    </footer>
    

    <!--=============== SCROLL UP ===============-->
    <a href="#" class="scrollup" id="scroll-up">
        <i class="bx bx-up-arrow-alt scrollup_icon"></i>
    </a>
    <!--=============== STYLE SWITCHER ===============-->

    <!--=============== SWIPER JS ===============-->
    <script src="assets/js/swiper-bundle.min.js"></script>

    <!--=============== JS ===============-->
    <script src="assets/js/main.js"></script>
</body>
</html>