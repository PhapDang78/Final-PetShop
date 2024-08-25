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
                        <a href="cart.php" class="nav_link  active-link">GIỎ HÀNG</a>
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

    <!--=============== LOGIN ===============-->
    <div class="login" id="login">
        <i class="bx bx-x login_close" id="login-close"></i>

        <h2 class="login_title-center">Đăng nhập</h2>
        
        <form action="" class="login_form grid">
            <div class="login_content">
                <label for="" class="login_label">Email</label>
                <input type="email" class="login_input">
            </div>
            
            <div class="login_content">
                <label for="" class="login_label">Mật khẩu</label>
                <input type="password" class="login_input">
            </div>
            
            <div>
                <a href="#" class="button">Đăng Nhập</a>
            </div>

            <div>
                <p class="signup">Bạn chưa có tài khoản? <a href="registration.php">Đăng ký</a></p>
            </div>
            
        </form>
    </div>

    <!--=============== MAIN ===============-->
    <main class="main">
        <!--=============== CART ===============-->
        <section class="cart__page section container">
            <div class="cart_container grid" id="cart-items"></div>
            <div class="cart_summary">
                <h3>Tổng sản phẩm: <span id="item-count">0</span></h3>
                <h3>Tổng giá tiền: <span id="total-price">0 VNĐ</span></h3>
                <button id="checkout-button" class="button">Thanh Toán</button>
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const cartContainer = document.getElementById('cart-items');
    const itemCount = document.getElementById('item-count');
    const totalPrice = document.getElementById('total-price');
    const checkoutButton = document.getElementById('checkout-button');
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    function renderCart() {
        cartContainer.innerHTML = '';
        let total = 0;
        let totalItems = 0;

        if (cart.length === 0) {
            cartContainer.innerHTML = '<p>Giỏ hàng của bạn trống.</p>';
            itemCount.textContent = 0; // Đặt số lượng sản phẩm về 0
            totalPrice.textContent = '0 VNĐ'; // Đặt tổng giá về 0
        } else {
            cart.forEach(item => {
                total += parseFloat(item.price) * item.quantity;
                totalItems += item.quantity;

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

            itemCount.textContent = totalItems;
            totalPrice.textContent = `${total.toLocaleString()},000 VNĐ`;

            // Thêm sự kiện cho các nút tăng và giảm
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
                const index = cart.indexOf(item);
                if (index > -1) {
                    cart.splice(index, 1);
                }
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }
    }

    function removeFromCart(productId) {
        const index = cart.findIndex(product => product.id === productId);
        if (index > -1) {
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }
        renderCart();
    }

    // Xử lý sự kiện cho nút thanh toán
    checkoutButton.addEventListener('click', function() {
        if (cart.length === 0) {
            alert('Giỏ hàng của bạn trống. Vui lòng thêm sản phẩm trước khi thanh toán.');
            return;
        }

        console.log(cart);
        // Gửi thông tin giỏ hàng đến server
        fetch('process_checkout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(cart),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Có lỗi xảy ra trong quá trình thanh toán.');
            }
            return response.json();
        })
        .then(data => {
            alert('Thanh toán thành công!'); // Hoặc xử lý theo phản hồi từ server
            localStorage.removeItem('cart'); // Xóa giỏ hàng sau khi thanh toán
            renderCart(); // Cập nhật lại giỏ hàng
        })
        .catch(error => {
            alert(`Lỗi: ${error.message}`);
        });
        
    });
    // Render giỏ hàng khi trang được tải
    renderCart();
});

    </script>
    
    
    
</body>
</html>