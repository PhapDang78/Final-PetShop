<?php
include 'connectdb.php'; // Kết nối cơ sở dữ liệu
session_start(); // Khởi tạo phiên
$error = ''; // Biến để lưu thông báo lỗi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']; // Nhận email từ form
    $password = $_POST['password']; // Nhận mật khẩu từ form

    // Kiểm tra thông tin đăng nhập (ví dụ: kiểm tra trong cơ sở dữ liệu)
    $query = "SELECT * FROM users WHERE email = ?"; // Giả sử bạn có bảng users
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) { // Giả sử mật khẩu được mã hóa
            $_SESSION['username'] = $user['username']; // Lưu tên người dùng vào phiên
            header('Location: ' . $_SERVER['PHP_SELF']); // Chuyển hướng về trang hiện tại
            exit();
        } else {
            $error = 'Mật khẩu không đúng!'; // Lưu thông báo lỗi
        }
    } else {
        $error = 'Email không tồn tại!'; // Lưu thông báo lỗi
    }
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

    <title>Responsive e-commerce website - Crypticalcoder</title>
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
                        <a href="index.php" class="nav_link">TRANG CHỦ</a>
                    </li>

                    <li class="nav_item">
                        <a href="shop.php" class="nav_link  active-link">CỬA HÀNG</a>
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


    <!--=============== LOGIN ===============-->
    <div class="login" id="login">
        <i class="bx bx-x login_close" id="login-close"></i>

        <h2 class="login_title-center">Đăng nhập</h2>

        <?php if (isset($_SESSION['username'])): ?>
        <!-- Nếu người dùng đã đăng nhập -->
        <div class="user-info">
            <p>Xin chào, <?php echo $_SESSION['username']; ?>!</p>
            <a href="logout.php" class="button">Đăng xuất</a>
        </div>
        <?php else: ?>
            <!-- Nếu người dùng chưa đăng nhập -->
            <form action="" method="POST" class="login_form grid">
                <div class="login_content">
                    <label for="email" class="login_label">Email</label>
                    <input type="email" class="login_input" name="email" required>
                </div>

                <div class="login_content">
                    <label for="password" class="login_label">Mật khẩu</label>
                    <input type="password" class="login_input" name="password" required>
                </div>

                <?php if ($error): ?>
                    <p style="color: red;"><?php echo $error; ?></p> <!-- Hiển thị thông báo lỗi -->
                <?php endif; ?>

                <div>
                    <button type="submit" class="button">Đăng Nhập</button>
                </div>

                <div>
                    <p class="signup">Bạn chưa có tài khoản? <a href="registration.php">Đăng ký</a></p>
                </div>
            </form>
        <?php endif; ?>
    </div>
    <!--=============== MAIN ===============-->
    <main class="main">
        <!--=============== SHOP ===============-->
        <section class="shop section container">
            <h2 class="breadcrumb_title">Shop Page</h2>
            <h3 class="breadcrumb_subtitle">Trang chủ > <span>Cửa hàng</span> > <span>Chuồng chó</span></h3>

            <div class="shop_container grid">
                <div class="sidebar">
                    <h3 class="filter_title">đồ dành cho chó</h3>
                    <hr>

                    <div class="filter_content">
                        <a class="filter_subtitle" href="chuongcho.php">Chuồng chó</a>
                        <a class="filter_subtitle" href="do.php">Quần áo</a>
                        <a class="filter_subtitle" href="fooddog.php">Thức ăn</a>
                        <a class="filter_subtitle" href="play.php">Đồ chơi thú cưng</a>

                        <!-- classfilter gần như là bỏ -->

                        
                    </div>
                    <br>
                    
                    <h3 class="filter_title">đồ dành cho mèo</h3>
                    <hr>

                    <div class="filter_content">
                        <a class="filter_subtitle" href="balocat.php">Balo cho mèo</a>
                        <a class="filter_subtitle" href="do.php">Quần áo</a>
                        <a class="filter_subtitle" href="foodcat.php">Thức ăn</a>
                        <a class="filter_subtitle" href="play.php">Đồ chơi thú cưng</a>

                        <!-- classfilter gần như là bỏ -->

                        
                    </div>
            
                    
                </div>
            
                <div class="shop_items grid">
                    <!-- Sản phẩm 1 -->
                    <div class="shop_content">
                        <div class="shop_tag">New</div>
                        <img src="assets/img/imghavebg/chuongcho1.jpg" alt="" class="shop_img">
                        <h3 class="shop_title">Chuồng chó bằng nhôm</h3>
                        <span class="shop_subtitle">Accessory</span>
                        <div class="sgop_prices">
                            <span class="shop_price">200,000 VNĐ</span>
                            <span class="shop_discounts">250,000 VNĐ</span>
                        </div>
                        <a href="details.php?id=10" class="button shop_button-cart"> 
                            <i class="bx bx-cart-alt shop_icon-cart"></i>
                           
                        </a>
                        <a href="details.php?id=10" class="button shop_button-show"> 
                            <i class='bx bxs-show shop_icon-show'></i>
                        </a>
                    </div>
                
                    <!-- Sản phẩm 2 -->
                    <div class="shop_content">
                        <div class="shop_tag">Sales</div>
                        <img src="assets/img/imghavebg/chuongcho2.jpg" alt="" class="shop_img">
                        <h3 class="shop_title">Chuồng chó ấm áp</h3>
                        <span class="shop_subtitle">Accessory</span>
                        <div class="sgop_prices">
                            <span class="shop_price">180,000 VNĐ</span>
                            <span class="shop_discounts">220,000 VNĐ</span>
                        </div>
                        <a href="details.php?id=11" class="button shop_button-cart"> 
                            <i class="bx bx-cart-alt shop_icon-cart"></i>
                           
                        </a>
                        <a href="details.php?id=11" class="button shop_button-show"> 
                            <i class='bx bxs-show shop_icon-show'></i>
                        </a>
                    </div>
                
                    <!-- Sản phẩm 3 -->
                    <div class="shop_content">
                        <div class="shop_tag">Sale</div>
                        <img src="assets/img/imghavebg/chuongcho3.jpg" alt="" class="shop_img">
                        <h3 class="shop_title">Chuồng chó nghèo</h3>
                        <span class="shop_subtitle">Accessory</span>
                        <div class="sgop_prices">
                            <span class="shop_price">5,000 VNĐ</span>
                            <span class="shop_discounts">10,000 VNĐ</span>
                        </div>
                        <a href="details.php?id=12" class="button shop_button-cart"> 
                            <i class="bx bx-cart-alt shop_icon-cart"></i>
                           
                        </a>
                        <a href="details.php?id=12" class="button shop_button-show"> 
                            <i class='bx bxs-show shop_icon-show'></i>
                        </a>
                    </div>
                
                    <!-- Sản phẩm 4 -->
                    <div class="shop_content">
                        <div class="shop_tag">New</div>
                        <img src="assets/img/imghavebg/chuongcho4.jpg" alt="" class="shop_img">
                        <h3 class="shop_title">Lồng sắt</h3>
                        <span class="shop_subtitle">Accessory</span>
                        <div class="sgop_prices">
                            <span class="shop_price">7,000 VNĐ</span>
                            <span class="shop_discounts">28,000 VNĐ</span>
                        </div>
                        <a href="details.php?id=13" class="button shop_button-cart"> 
                            <i class="bx bx-cart-alt shop_icon-cart"></i>
                           
                        </a>
                        <a href="details.php?id=13" class="button shop_button-show"> 
                            <i class='bx bxs-show shop_icon-show'></i>
                        </a>
                    </div>
                </div>
                
            </div>
            
        </section>
    </main>

    <!--=============== FOOTER ===============-->
    <footer class="footer section">
        <div class="footer_container container grid">
            <!-- NỘI DUNG FOOTER 1 -->
            <div class="footer_content">
                <a href="#" class="footer_logo">
                    DP PET                </a>
    
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