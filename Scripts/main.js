
// 1. XỬ LÝ BỘ LỌC VÀ SẮP XẾP
function autoSubmitFilter() {
    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.submit();
    }
}

function sortProducts(sortValue) {
    let urlParams = new URLSearchParams(window.location.search);
    urlParams.set('sort', sortValue);
    urlParams.set('page', '1');
    window.location.href = 'sanpham.php?' + urlParams.toString();
}

// 2. TĂNG GIẢM SỐ LƯỢNG (DÙNG CHUNG CHO CẢ TRANG XEM VÀ GIỎ HÀNG)
function changeQty(amt) {
    let qtyInput = document.getElementById('cart_qty') || document.getElementById('quantity_input');
    if (qtyInput) {
        let val = parseInt(qtyInput.value, 10) + amt;
        let maxQty = parseInt(qtyInput.dataset.max || '0', 10);
        if (val >= 1 && (maxQty < 1 || val <= maxQty)) qtyInput.value = val;
    }
}

// 3. HIỆN/ẨN MINI CART (SIDE CART)
function toggleMiniCart() {
    const miniCart = document.getElementById('miniCart');
    const overlay = document.getElementById('cartOverlay');
    
    if (miniCart && overlay) {
        miniCart.classList.toggle('show');
        overlay.classList.toggle('show');
        
        document.body.style.overflow = miniCart.classList.contains('show') ? 'hidden' : 'auto';
    }
}
window.onclick = function(event) {
    if (event.target.id === 'cartOverlay') {
        toggleMiniCart();
    }
}

// 4. LOAD DỮ LIỆU GIỎ HÀNG TỪ SESSION
function loadMiniCart() {
    fetch('laygiohang.php')
    .then(response => response.json())
    .then(data => {
        const cartList = document.getElementById('cart-items-list');
        const cartTotal = document.getElementById('cart-total');
        const cartCount = document.getElementById('cart-count');
        
        if (cartList && cartTotal) {
            cartList.innerHTML = data.html; 
            cartTotal.innerText = data.total; 
            if (cartCount) cartCount.innerText = data.count; 
        }
    })
    .catch(error => console.error('Lỗi load giỏ hàng:', error));
}

// Tự động load ngay khi mở trang
document.addEventListener('DOMContentLoaded', loadMiniCart);

// 5. THÊM VÀO GIỎ HÀNG (AJAX)
function addToCart(productId) {
    let selectedSize = document.querySelector('input[name="size"]:checked');
    if (!selectedSize) {
        alert("VUI LÒNG CHỌN SIZE TRƯỚC KHI THÊM VÀO GIỎ HÀNG!");
        return;
    }

    let qty = document.getElementById('cart_qty').value;
    let size = selectedSize.value;

    let formData = new FormData();
    formData.append('id_sp', productId);
    formData.append('size', size);
    formData.append('sl', qty);

    fetch('themgiohang_xuly.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadMiniCart(); 
            toggleMiniCart(); 
        } else {
            alert(data.message || 'Không thể thêm sản phẩm vào giỏ hàng.');
        }
    })
    .catch(error => {
        console.error('Lỗi thêm giỏ hàng:', error);
        alert('Không thể kết nối để thêm sản phẩm vào giỏ hàng.');
    });
}

// 6. XÓA SẢN PHẨM KHỎI GIỎ HÀNG
function removeFromCart(cartId) {
    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?")) {
        let formData = new FormData();
        formData.append('cart_id', cartId);

        fetch('xoagiohang.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                loadMiniCart(); 
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Lỗi khi xóa:', error));
    }
}

// 7. MUA NGAY (THÊM XONG CHUYỂN TRANG THANH TOÁN)
function buyNow(productId) {
    let selectedSize = document.querySelector('input[name="size"]:checked');
    if (!selectedSize) {
        alert("VUI LÒNG CHỌN SIZE TRƯỚC KHI MUA HÀNG!");
        return;
    }

    let qty = document.getElementById('cart_qty').value;
    let size = selectedSize.value;

    let formData = new FormData();
    formData.append('id_sp', productId);
    formData.append('size', size);
    formData.append('sl', qty);

    fetch('themgiohang_xuly.php', { method: 'POST', body: formData })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            window.location.href = 'thanhtoan.php'; 
        } else {
            alert(data.message || 'Không thể đặt sản phẩm này.');
        }
    })
    .catch(error => {
        console.error('Lỗi mua ngay:', error);
        alert('Không thể kết nối để thêm sản phẩm vào giỏ hàng.');
    });
}