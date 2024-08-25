/*=============== SHOW MENU ===============*/
const navMenu = document.getElementById('nav-menu'),
	navToggle = document.getElementById('nav-toggle'),
	navClose = document.getElementById('nav-close')

/*===== MENU SHOW =====*/
/* Validate if constant exists */
if(navToggle) { 
	navToggle.addEventListener("click", () => {
		navMenu.classList.add('show-menu')
	})
}

/*===== MENU HIDDEN =====*/
/* Validate if constant exists */
if(navClose) {
	navClose.addEventListener("click", () => {
	navMenu.classList.remove('show-menu')
	})
}

/*=============== SHOW CART ===============*/
const cart = document.getElementById('cart'),
	cartShop = document.getElementById('cart-shop'),
	cartClose = document.getElementById('cart-close')

/*===== CART SHOW =====*/
/* Validate if constant exists */
if(cartShop) { 
	cartShop.addEventListener("click", () => {
		cart.classList.add('show-cart')
	})
}

/*===== CART HIDDEN =====*/
/* Validate if constant exists */
if(cartClose) {
	cartClose.addEventListener("click", () => {
	cart.classList.remove('show-cart')
	})
}


/*=============== SHOW LOGIN ===============*/
const login = document.getElementById('login'),
	loginButton = document.getElementById('login-button'),
	loginClose = document.getElementById('login-close')

/*===== LOGIN SHOW =====*/
/* Validate if constant exists */
if(loginButton) { 
	loginButton.addEventListener("click", () => {
		login.classList.add('show-login')
	})
}

/*===== LOGIN HIDDEN =====*/
/* Validate if constant exists */
if(loginClose) {
	loginClose.addEventListener("click", () => {
	login.classList.remove('show-login')
	})
}

/*=============== HOME SWIPER ===============*/
var homeSwiper = new Swiper(".home-swiper", {
	spaceBetween: 30,
	Loop: 'true',

	pagination:{
		el: ".swiper-pagination",
		clickable: true,
	}
});

/*=============== CHANGE BACKGROUND HEADER ===============*/
function scrollHeader() {
	const header = document.getElementById('header');
	// when the scroll is greater than 50 viewport height, add the scroll-header class to the header tag
	if(this.scrollY >= 50) header.classList.add('scroll-header'); 
	else header.classList.remove('scroll-header');
} 
window.addEventListener('scroll', scrollHeader)

/*=============== NEW SWIPER ===============*/
var newSwiper = new Swiper(".new-swiper", {
	spaceBetween: 16,
	centeredSlides: true,
	slidesPerView: "auto",
	loop: 'true',
});

/*=============== SHOW SCROLL UP ===============*/ 
function scrollUp() {
	const scrollUp = document.getElementById('scroll-up');
	if(this.scrollY >= 350) scrollUp.classList.add('show-scroll'); 
	else scrollUp.classList.remove('show-scroll')
}
window.addEventListener('scroll', scrollUp)

/*=============== LIGHT BOX ===============*/


/*=============== QUESTIONS ACCORDION ===============*/
const accordionItem = document.querySelectorAll('.questions_item');

accordionItem.forEach((item) => {
    const accordionHeader = item.querySelector('.questions_header');

    accordionHeader.addEventListener('click', () => {
        const openItem = document.querySelector('.accordion-open');
        
        // Đóng item đã mở nếu có
        if (openItem && openItem !== item) {
            openItem.classList.remove('accordion-open');
            openItem.querySelector('.questions_content').style.height = '0px';
        }

        toggleItem(item);
    });
});

const toggleItem = (item) => {
    const accordionContent = item.querySelector('.questions_content');
    if (item.classList.contains('accordion-open')) {
        accordionContent.style.height = '0px';
        item.classList.remove('accordion-open');
    } else {
        accordionContent.style.height = accordionContent.scrollHeight + 'px';
        item.classList.add('accordion-open');
    }
};

/*=============== Views Details ===============*/
  // Dữ liệu sản phẩm
const products = [
	{
		id: 1,
		title: "Ba lô phi hành gia",
		price: "200,000 VNĐ",
		discount: "400,000 VNĐ",
		description: "Balo phi hành gia nhựa trong, balo vận chuyển cho chó mèo nhiều màu, chất liệu không gây độc hại.",
		img: "assets/img/slide-3.png"
	},

	{
		id: 2,
		title: "ROYAL CANIN Mini Puppy 800g",
		price: "180,000 VNĐ",
		discount: "360,000 VNĐ",
		description: "Thức ăn cho chó con, giàu dinh dưỡng và chất lượng.",
		img: "assets/img/slide-2.png"
	},

	{
		id: 3,
		title: "Royal canin kitten 36 - 1kg",
		price: "160,000 VNĐ",
		discount: "320,000 VNĐ",
		description: "Protein dễ hoà tan để tối đa hoá việc hấp thụ dinh dưỡng va đảm bảo cho mèo con có hệ tiêu hoá hoàn toàn khỏe mạnh.",
		img: "assets/img/slide-1.png"
	},

	{
        id: 4,
        title: "Áo Hoodie Cho Chó Dễ Thương",
        price: "130,000 VNĐ",
        discount: "271,000 VNĐ",
        description: "Áo hoodie dễ thương cho chó, chất liệu flannel.",
        img: "assets/img/new-1.png"
    },
    {
        id: 5,
        title: "Quần Áo Thú Cưng Polo Sọc",
        price: "125,000 VNĐ",
        discount: "250,000 VNĐ",
        description: "Quần áo polo sọc cho thú cưng, chất liệu cotton.",
        img: "assets/img/new-2.png"
    },
    {
        id: 6,
        title: "Áo Thú Cưng Ấm Áp Mùa Đông",
        price: "100,000 VNĐ",
        discount: "200,000 VNĐ",
        description: "Áo ấm áp cho thú cưng, chất liệu mềm mại.",
        img: "assets/img/new-3.png"
    },
    {
        id: 7,
        title: "Áo Thú Cưng Ấm Áp Mùa Đông",
        price: "100,000 VNĐ",
        discount: "200,000 VNĐ",
        description: "Áo ấm áp cho thú cưng, chất liệu mềm mại.",
        img: "assets/img/new-4.png"
    },
    {
        id: 8,
        title: "Áo Sơ Mi Cổ Tròn Khủng Long",
        price: "75,000 VNĐ",
        discount: "150,000 VNĐ",
        description: "Áo sơ mi dễ thương cho thú cưng, chất liệu cotton.",
        img: "assets/img/new-5.png"
    },
    {
        id: 9,
        title: "Áo Len Ấm Áp Dễ Thương",
        price: "130,000 VNĐ",
        discount: "240,000 VNĐ",
        description: "Áo len ấm áp cho thú cưng, chất liệu len.",
        img: "assets/img/new-6.png"
    },
	{
        id: 10,
        title: "Chuồng chó bằng nhôm",
        price: "200,000 VNĐ",
        discount: "250,000 VNĐ",
        description: "Chuồng chó bằng nhôm, bền và nhẹ.",
        img: "assets/img/imghavebg/chuongcho1.jpg"
    },
    {
        id: 11,
        title: "Chuồng chó ấm áp",
        price: "180,000 VNĐ",
        discount: "220,000 VNĐ",
        description: "Chuồng chó ấm áp cho mùa đông.",
        img: "assets/img/imghavebg/chuongcho2.jpg"
    },
    {
        id: 12,
        title: "Chuồng chó nghèo",
        price: "5,000 VNĐ",
        discount: "10,000 VNĐ",
        description: "Chuồng chó giá rẻ.",
        img: "assets/img/imghavebg/chuongcho3.jpg"
    },
    {
        id: 13,
        title: "Lồng sắt",
        price: "7,000 VNĐ",
        discount: "28,000 VNĐ",
        description: "Lồng sắt cho chó, chắc chắn và an toàn.",
        img: "assets/img/imghavebg/chuongcho4.jpg"
    },
	{
        id: 14,
        title: "Thức ăn hạt Dog Mania Premium",
        price: "348,000 VNĐ",
        discount: "510,000 VNĐ",
        description: "Thức ăn hạt Dog Mania Premium, dinh dưỡng đầy đủ cho chó.",
        img: "assets/img/fooddog-1.png"
    },
    {
        id: 15,
        title: "Đồ Ăn Cho Chó Vị Thịt Bò Và Rau Củ Pedigree (3Kg)",
        price: "170,000 VNĐ",
        discount: "300,000 VNĐ",
        description: "Đồ ăn cho chó vị thịt bò và rau củ, dinh dưỡng cân bằng.",
        img: "assets/img/fooddog-2.png"
    },
    {
        id: 16,
        title: "DOG MANIA Premium Puppy vị hỗn hợp",
        price: "120,000 VNĐ",
        discount: "220,000 VNĐ",
        description: "Thức ăn cho chó con DOG MANIA Premium vị hỗn hợp.",
        img: "assets/img/fooddog-3.png"
    },
	{
        id: 17,
        title: "LOFFE Kucing Backpack",
        price: "395,000 VNĐ",
        discount: "599,000 VNĐ",
        description: "Balo LOFFE Kucing, chất liệu nhựa bền đẹp.",
        img: "assets/img/balo-1.png"
    },
    {
        id: 18,
        title: "LOFFE Supreme",
        price: "395,000 VNĐ",
        discount: "599,000 VNĐ",
        description: "Balo LOFFE Supreme, chất liệu nhựa cao cấp.",
        img: "assets/img/balo-2.png"
    },
    {
        id: 19,
        title: "LeShang LS006",
        price: "150,000 VNĐ",
        discount: "200,000 VNĐ",
        description: "Balo LeShang LS006, chất liệu vải bền.",
        img: "assets/img/balo-3.png"
    },
	{
        id: 20,
        title: "Lược Chải Lông Cho Chó Mèo",
        price: "8,000 VNĐ",
        discount: "26,000 VNĐ",
        description: "Lược chải lông cho chó mèo, giúp lông mềm mượt.",
        img: "assets/img/dochoi-1.png"
    },
    {
        id: 21,
        title: "Đồ Chơi Banh Cao Su Cho Chó Mèo",
        price: "42,000 VNĐ",
        discount: "50,000 VNĐ",
        description: "Đồ chơi banh cao su, an toàn cho thú cưng.",
        img: "assets/img/dochoi-2.png"
    },
    {
        id: 22,
        title: "Giường Chó Mèo Zerti",
        price: "266,000 VNĐ",
        discount: "380,000 VNĐ",
        description: "Giường cho chó mèo Zerti, êm ái và thoải mái.",
        img: "assets/img/dochoi-3.png"
    },
    {
        id: 23,
        title: "Trò chơi thú cưng cho mèo ăn chậm và đồ chơi khay thức ăn cho chó",
        price: "179,000 VNĐ",
        discount: "260,000 VNĐ",
        description: "Trò chơi cho mèo và chó, giúp thú cưng ăn chậm lại.",
        img: "assets/img/dochoi-4.png"
    },

    {
        id: 24,
        title: "Whiskas Adult Ocean Fish",
        price: "115,000 VNĐ",
        discount: "160,000 VNĐ",
        description: "Thức ăn cho mèo Whiskas, vị cá đại dương.",
        img: "assets/img/foodcat-1.png"
    },
    {
        id: 25,
        title: "CATIDEA Fairy Chef British Shorthair",
        price: "200,000 VNĐ",
        discount: "315,000 VNĐ",
        description: "Thức ăn cho mèo CATIDEA, phù hợp với giống British Shorthair.",
        img: "assets/img/foodcat-2.png"
    },
    {
        id: 26,
        title: "CATIDEA Basic Meat Freeze Dried",
        price: "430,000 VNĐ",
        discount: "580,000 VNĐ",
        description: "Thức ăn thịt đông khô CATIDEA, dinh dưỡng cao.",
        img: "assets/img/foodcat-3.png"
    }

];

let quantity = 1;

// Lấy tham số id từ URL
const urlParams = new URLSearchParams(window.location.search);
const productId = parseInt(urlParams.get('id'));

// Tìm sản phẩm tương ứng
const product = products.find(p => p.id === productId);

// Hiển thị thông tin sản phẩm
if (product) {
	document.getElementById('product-details').innerHTML = `
		<div class="product_images grid">
			<div class="product_img">
				<div class="details_img-tag">New</div> 
				<img src="${product.img}" alt="${product.title}">
			</div>
		</div>
		<div class="product_info">
			<h3 class="details">${product.title}</h3>
			<div class="rating">
				<div class="stars">
					<i class="bx bxs-star"></i>
					<i class="bx bxs-star"></i>
					<i class="bx bxs-star"></i>
					<i class="bx bxs-star"></i>
					<i class="bx bxs-star"></i>
					<i class="bx bxs-star"></i>
				</div>
				<span class="reviews_count">40 + Reviews</span>
			</div>
			<div class="details_prices">
				<span class="details_price">${product.price}</span>
				<span class="details_discount">${product.discount}</span>
				<span class="discout_percentage">SALE OFF</span>
			</div>
			<div class="details_description">
				<h3 class="description_title">Chi tiết sản phẩm</h3>
				<div class="description_details">
					<p>${product.description}</p>
				</div>
			</div>
			<div class="cart_amount">
				<div class="cart_amount-content">
					<span class="cart_amount-box" id="decrease">
						<i class="bx bx-minus"></i>
					</span>
					<span class="cart_amount-number" id="amount">1</span>
					<span class="cart_amount-box" id="increase">
						<i class="bx bx-plus"></i>
					</span>
				</div>
			</div>
			<a href="#" class="button" onclick="addToCart(${product.id})">Thêm vào giỏ</a>
            <a href="cart.php" class="button" onclick="addToCart(${product.id})">Mua Ngay</a>
		</div>
	`;

	// Thêm sự kiện cho các nút tăng và giảm
	document.getElementById('increase').addEventListener('click', function() {
	    let amountElement = document.getElementById('amount');
	    let currentAmount = parseInt(amountElement.textContent);
	    amountElement.textContent = currentAmount + 1;
	});

	document.getElementById('decrease').addEventListener('click', function() {
	    let amountElement = document.getElementById('amount');
	    let currentAmount = parseInt(amountElement.textContent);
	    if (currentAmount > 1) { // Đảm bảo số lượng không giảm xuống dưới 1
	        amountElement.textContent = currentAmount - 1;
	    }
	});

} else {
	document.getElementById('product-details').innerHTML = `<p>Không tìm thấy sản phẩm.</p>`;
}


/*=============== ADD CART ===============*/
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    const amountElement = document.getElementById('amount');
    const quantity = parseInt(amountElement.textContent);

    if (product) {
        const cartItem = {
            id: product.id,
            title: product.title,
            price: product.price,
            quantity: quantity,
            img: product.img
        };

        // Lấy giỏ hàng từ localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        const existingProduct = cart.find(item => item.id === productId);
        if (existingProduct) {
            // Nếu có, cập nhật số lượng
            existingProduct.quantity += quantity;
        } else {
            // Nếu chưa, thêm sản phẩm mới vào giỏ
            cart.push(cartItem);
        }

        // Lưu giỏ hàng vào localStorage
        localStorage.setItem('cart', JSON.stringify(cart));

        // Hiển thị thông báo
        alert(`${product.title} đã được thêm vào giỏ hàng!`);

        location.reload();
    }
}




