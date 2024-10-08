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
        <!--=============== HOME ===============-->
        <section class="home container">
            <div class="swiper home-swiper">
                <div class="swiper-wrapper">
                    <!-- HOME SWIPER 1-->
                    <section class="swiper-slide">
                        <div class="home_content grid">
                            <div class="home_group">
                                <img src="assets/img/slide-3.png" alt="" class="home_img">
                                <div class="home_indicator"></div>

                                <div class="home_details-img">
                                    <h4 class="home_details-title">Ba lô phi hành gia</h4>
                                    <span class="home_details-subtitle">Chất liệu "Da"</span>
                                </div>
                            </div>

                            <div class="home data">
                                <h3 class="home_subtitle">#1 Bán chạy</h3>
                                <h1 class="home _title">BẢN GỐC <br> 100% CHÍNH HÃNG <br> FREESHIP!!</h1>
                                <p class="home_description">Balo phi hành gia có thiết kế thông minh, thông thoáng giúp cho thú cưng của bạn thoải mái và an toàn khi di chuyển. Vòm kính có thể thay thế bằng lưới nhựa và phù hợp với nhu cầu của bạn. Lưới nhựa tặng kèm ngay bên trong Balo phi hành gia mà bạn không cần phải mua thêm.</p>
                                
                                <div class="home_buttons">
                                    <a href="details.php?id=1" class="button">MUA NGAY</a>
                                    <a href="details.php?id=1" class="button--link button--flex">Xem chi tiết
                                        <i class="bx bx-right-arrow-alt button_icon"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- HOME SWIPER 2-->
                    <section class="swiper-slide">
                        <div class="home_content grid">
                            <div class="home_group">
                                <img src="assets/img/slide-2.png" alt="" class="home_img">
                                <div class="home_indicator"></div>

                                <div class="home_details-img">
                                    <h4 class="home_details-title">Royal Canin Mini Puppy 800g</h4>
                                    <span class="home_details-subtitle">Royal Canin</span>
                                </div>
                            </div>

                            <div class="home data">
                                <h3 class="home_subtitle">#1 THỨC ĂN CHO CHÓ</h3>
                                <h1 class="home _title">BÁN CHẠY <br> KHÔNG CHẤT BẢO QUẢN <br> FREESHIP!!</h1>
                                <p class="home_description">Giúp duy trì sức khoẻ tiêu hóa của chó
                                    Hỗ trợ nhu cầu năng lượng cao ở mọi giai đoạn phát triển của chó
                                    Thiết kế hạt giúp giảm sự hình thành cao răng 
                                    Hỗ trợ hệ miễn dịch khỏe mạnh giúp chó chống lại bệnh tật
                                    100% dinh dưỡng cân bằng
                                    100% đảm bảo an toàn.</p>
                                
                                <div class="home_buttons">
                                    <a href="details.php?id=2" class="button">MUA NGAY</a>
                                    <a href="details.php?id=2" class="button--link button--flex">Xem chi tiết 
                                        <i class="bx bx-right-arrow-alt button_icon"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- HOME SWIPER 3-->
                    <section class="swiper-slide">
                        <div class="home_content grid">
                            <div class="home_group">
                                <img src="assets/img/slide-1.png" alt="" class="home_img">
                                <div class="home_indicator"></div>

                                <div class="home_details-img">
                                    <h4 class="home_details-title">Royal canin kitten 36 - 1kg</h4>
                                    <span class="home_details-subtitle">Royal Canin</span>
                                </div>
                            </div>

                            <div class="home data">
                                <h3 class="home_subtitle">#1 Thức ăn cho mèo</h3>
                                <h1 class="home _title">BÁN CHẠY <br> KHÔNG CHẤT BẢO QUẢN <br> FREESHIP!!</h1>
                                <p class="home_description">• Protein dễ hoà tan để tối đa hoá việc hấp thụ <br>
                                    dinh dưỡng va đảm bảo cho mèo con có hệ
                                    tiêu hoá hoàn toàn khỏe mạnh.</p>
                                
                                <div class="home_buttons">
                                    <a href="details.php?id=3" class="button">MUA NGAY</a>
                                    <a href="details.php?id=3" class="button--link button--flex">Xem chi tiết
                                        <i class="bx bx-right-arrow-alt button_icon"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="swiper-pagination"></div>
            </div>
        </section>

        <!--=============== DISCOUNT ===============-->
        <section class="discount section">
            <div class="discount_container container grid">
                <img src="assets/img/discount.png" alt="" class="discount_img">
               
                <div class="discount_data">
                    <h2 class="discount_title">Giảm giá 50% <br> Cho sản phẩm mới</h2>
                    <a href="shop.php" class="button">Đi đến</a>
                </div>
            </div>
        </section>

        <!--=============== NEW ARRIVALS ===============-->
        <section class="new section">
            <h2 class="section_title">Hàng Mới Về</h2>

            <div class="new_container container">
                <div class="swiper new-swiper">
                    <div class="swiper-wrapper">
                        <!--NEW CONTENT 1-->
                        <div class="new_content swiper-slide">
                            <div class="new_tag">New</div>
                            <img src="assets/img/new-1.png" alt="" class="new_img">
                            <h3 class="new title">Áo Hoodie Cho Chó Dễ Thương</h3>
                            <span class="new_subtitle">Flannel Puppy</span>
                            <div class="new_prices">
                                <span class="new_price">130,000 VNĐ</span>
                                <span class="new_discount">271,000 VNĐ</span>
                            </div>
                            <a href="details.php?id=4" class="button new_button-cart"> 
                                <i class="bx bx-cart-alt new_icon"></i>
                               
                            </a>
                            <a href="details.php?id=4" class="button new_button-show"> 
                                <i class='bx bxs-show new_icon'></i>
                            </a>
                        </div>

                        <!--NEW CONTENT 2-->
                        <div class="new_content swiper-slide">
                            <div class="new_tag">New</div>
                            <img src="assets/img/new-2.png" alt="" class="new_img">
                            <h3 class="new title">Quần Áo Thú Cưng Polo Sọc</h3>
                            <span class="new_subtitle">Cotton</span>
                            <div class="new_prices">
                                <span class="new_price">125,000 VNĐ</span>
                                <span class="new_discount">250,000 VNĐ</span>
                            </div>
                            <a href="details.php?id=5" class="button new_button-cart"> 
                                <i class="bx bx-cart-alt new_icon"></i>
                               
                            </a>
                            <a href="details.php?id=5" class="button new_button-show"> 
                                <i class='bx bxs-show new_icon'></i>
                            </a>
                        </div>

                        <!--NEW CONTENT 3-->
                        <div class="new_content swiper-slide">
                            <div class="new_tag">New</div>
                            <img src="assets/img/new-3.png" alt="" class="new_img">
                            <h3 class="new title">Áo Thú Cưng Ấm Áp Mùa Đông</h3>
                            <span class="new_subtitle">Nerhemg</span>
                            <div class="new_prices">
                                <span class="new_price">100,000 VNĐ</span>
                                <span class="new_discount">200,000 VNĐ</span>
                            </div>
                            <a href="details.php?id=6" class="button new_button-cart"> 
                                <i class="bx bx-cart-alt new_icon"></i>
                               
                            </a>
                            <a href="details.php?id=6" class="button new_button-show"> 
                                <i class='bx bxs-show new_icon'></i>
                            </a>
                        </div>

                        <!--NEW CONTENT 4-->
                        <div class="new_content swiper-slide">
                            <div class="new_tag">New</div>
                            <img src="assets/img/new-4.png" alt="" class="new_img">
                            <h3 class="new title">Áo Thú Cưng Ấm Áp Mùa Đông</h3>
                            <span class="new_subtitle">nerhemg</span>
                            <div class="new_prices">
                                <span class="new_price">100,000 VNĐ</span>
                                <span class="new_discount">200,000 VNĐ</span>
                            </div>
                            <a href="details.php?id=7" class="button new_button-cart"> 
                                <i class="bx bx-cart-alt new_icon"></i>
                               
                            </a>
                            <a href="details.php?id=7" class="button new_button-show"> 
                                <i class='bx bxs-show new_icon'></i>
                            </a>
                        </div>

                        <!--NEW CONTENT 5-->
                        <div class="new_content swiper-slide">
                            <div class="new_tag">New</div>
                            <img src="assets/img/new-5.png" alt="" class="new_img">
                            <h3 class="new title">Áo Sơ Mi Cổ Tròn Khủng Long</h3>
                            <span class="new_subtitle">Cotton</span>
                            <div class="new_prices">
                                <span class="new_price">75,000 VNĐ</span>
                                <span class="new_discount">150,000 VNĐ</span>
                            </div>
                            <a href="details.php?id=8" class="button new_button-cart"> 
                                <i class="bx bx-cart-alt new_icon"></i>
                               
                            </a>
                            <a href="details.php?id=8" class="button new_button-show"> 
                                <i class='bx bxs-show new_icon'></i>
                            </a>
                        </div>

                        <!--NEW CONTENT 6-->
                        <div class="new_content swiper-slide">
                            <div class="new_tag">New</div>
                            <img src="assets/img/new-6.png" alt="" class="new_img">
                            <h3 class="new title">Áo Len Ấm Áp Dễ Thương</h3>
                            <span class="new_subtitle">Len</span>
                            <div class="new_prices">
                                <span class="new_price">130,000 VNĐ</span>
                                <span class="new_discount">240,000 VNĐ</span>
                            </div>
                            <a href="details.php?id=9" class="button new_button-cart"> 
                                <i class="bx bx-cart-alt new_icon"></i>
                               
                            </a>
                            <a href="details.php?id=9" class="button new_button-show"> 
                                <i class='bx bxs-show new_icon'></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            </section>

        <!--=============== STEPS ===============-->
        <section class="steps section container">
            <div class="steps_bg">
                <h2 class="section_title">Làm Sao Để Đặt Hàng <br> Từ DPet?</h2>
                <div class="steps_container grid">
                    <!-- STEP CARD 1 -->
                    <div class="steps_card">
<div class="steps_card-number">01</div>
                        <h3 class="steps_card-title">Chọn Sản Phẩm</h3>
                        <p class="steps_card-description">
                            Chúng tôi có nhiều loại sản phẩm bạn có thể lựa chọn.
                        </p>
                    </div>

                    <!-- STEP CARD 2 -->
                    <div class="steps_card">
                        <div class="steps_card-number">02</div>
                        <h3 class="steps_card-title">Đặt Hàng</h3>
                        <p class="steps_card-description">
                            Sau khi đơn hàng của bạn được thiết lập, chúng tôi sẽ chuyển sang bước tiếp theo là vận chuyển.
                        </p>
                    </div>

                    <!-- STEP CARD 3 -->
                    <div class="steps_card">
                        <div class="steps_card-number">03</div>
                        <h3 class="steps_card-title">Giao Hàng Tận Nơi</h3>
                        <p class="steps_card-description">
                            Quy trình giao hàng của chúng tôi rất dễ dàng, bạn nhận được đơn hàng trực tiếp tại nhà.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!--=============== NEWSLETTER ===============-->
        <section class="newsletter section">
            <div class="newsletter_container container">
                <h2 class="section_title">Bản Tin</h2>
                <p class="newsletter_description">
                    Khuyến mãi sản phẩm mới và bán hàng.
                </p>

                <form action="" class="newsletter_form">
                    <input type="text" placeholder="Nhập Email của bạn" class="newsletter_input">
                    <button class="button">ĐĂNG KÝ</button>
                </form>
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