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
                        <a href="shop.php" class="nav_link">CỬA HÀNG</a>
                    </li>

                    <li class="nav_item">
                        <a href="cart.php" class="nav_link">GIỎ HÀNG</a>
                    </li>

                    <li class="nav_item">
                        <a href="blog.php" class="nav_link">BLOG</a>
                    </li>

                    <li class="nav_item">
                        <a href="faq.php" class="nav_link active-link">CÂU HỎI</a>
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
        <!--=============== FAQ'S ===============-->
        <section class="questions section container">
            <h2 class="breadcrumb_title">FAQ's Page</h2>
            <h3 class="breadcrumb_subtitle">Trang chủ > <span>Câu hỏi</span></h3>

            <div class="questions_container grid">
                <div class="questions_group">
                    <div class="questions_item">
                        <div class="questions_header">
                            <i class="bx bx-plus questions_icon"></i>
                            <h3 class="questions_item-title">Chúng tôi có những loại sản phẩm nào cho thú cưng?</h3>
                        </div>
                        <div class="questions_content">
                            <p class="questions_description">
                                Chúng tôi cung cấp đa dạng sản phẩm cho thú cưng bao gồm thức ăn, đồ chơi, phụ kiện, đồ dùng vệ sinh và nhiều sản phẩm khác. 
                                Đặc biệt, chúng tôi có các dòng sản phẩm hữu cơ và tự nhiên, đảm bảo sức khỏe cho thú cưng của bạn.
                            </p>
                        </div>
                    </div>
            
                    <div class="questions_item">
                        <div class="questions_header">
                            <i class="bx bx-plus questions_icon"></i>
                            <h3 class="questions_item-title">Có chính sách đổi trả sản phẩm không?</h3>
                        </div>
                        <div class="questions_content">
                            <p class="questions_description">
                                Có, chúng tôi có chính sách đổi trả trong vòng 30 ngày nếu sản phẩm còn nguyên vẹn và chưa qua sử dụng. 
                                Nếu bạn nhận được sản phẩm bị lỗi hoặc không đúng với đơn hàng, hãy liên hệ với chúng tôi ngay để được hỗ trợ.
                            </p>
                        </div>
                    </div>
            
                    <div class="questions_item">
                        <div class="questions_header">
                            <i class="bx bx-plus questions_icon"></i>
                            <h3 class="questions_item-title">Thời gian giao hàng là bao lâu?</h3>
                        </div>
                        <div class="questions_content">
                            <p class="questions_description">
                                Thời gian giao hàng thường từ 3-5 ngày làm việc tùy thuộc vào địa điểm của bạn. 
                                Chúng tôi cũng cung cấp tùy chọn giao hàng nhanh trong vòng 24 giờ cho các đơn hàng gấp. 
                                Bạn sẽ nhận được thông báo về tình trạng đơn hàng qua email.
                            </p>
                        </div>
                    </div>
                    
                </div>
            
                <div class="questions_group">
                    <div class="questions_item">
                        <div class="questions_header">
                            <i class="bx bx-plus questions_icon"></i>
                            <h3 class="questions_item-title">Có dịch vụ giao hàng tận nhà không?</h3>
                        </div>
                        <div class="questions_content">
                            <p class="questions_description">
                                Có, chúng tôi cung cấp dịch vụ giao hàng tận nhà cho khách hàng trong khu vực thành phố. 
                                Đối với các khu vực ngoại thành, chúng tôi sẽ cố gắng hỗ trợ giao hàng trong thời gian sớm nhất có thể.
                            </p>
                        </div>
                    </div>
            
                    <div class="questions_item">
                        <div class="questions_header">
                            <i class="bx bx-plus questions_icon"></i>
                            <h3 class="questions_item-title">Sản phẩm của bạn có an toàn cho thú cưng không?</h3>
                        </div>
                        <div class="questions_content">
                            <p class="questions_description">
                                Tất cả sản phẩm của chúng tôi đều được kiểm định chất lượng và an toàn cho thú cưng. 
                                Chúng tôi cam kết chỉ cung cấp những sản phẩm được sản xuất từ nguyên liệu tự nhiên và không chứa hóa chất độc hại.
                            </p>
                        </div>
                    </div>
            
                    <div class="questions_item">
                        <div class="questions_header">
                            <i class="bx bx-plus questions_icon"></i>
                            <h3 class="questions_item-title">Có chương trình khuyến mãi nào không?</h3>
                        </div>
                        <div class="questions_content">
                            <p class="questions_description">
                                Chúng tôi thường xuyên có chương trình khuyến mãi và giảm giá cho các sản phẩm. 
                                Hãy theo dõi trang web của chúng tôi và đăng ký nhận bản tin để không bỏ lỡ bất kỳ ưu đãi nào. 
                                Ngoài ra, chúng tôi cũng có các chương trình khuyến mãi đặc biệt vào dịp lễ, Tết.
                            </p>
                        </div>
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