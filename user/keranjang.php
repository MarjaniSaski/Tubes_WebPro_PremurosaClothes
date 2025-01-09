<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Premurosa Clothes</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body{
            background-color:rgb(252, 217, 237) ;
        }
        .cart-section {
            background-color: white;
            border-radius: 8px;
            margin-bottom: 1px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .quantity-input {
            width: 40px;
            height: 24px;
            text-align: center;
            border: 1px solid #F7A8D3;
            border-radius: 4px;
            margin: 0 8px;
            color:rgb(249, 134, 197);
        }

        .btn-quantity {
            width: 24px;
            height: 24px;
            border: 1px solid #F7A8D3;
            border-radius: 4px;
            background: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #F7A8D3;
            transition: all 0.2s ease;
        }

        .btn-quantity:hover {
            background:rgb(255, 109, 189);
            color: white;
        }

        .btn-quantity:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .voucher-container {
            border-top: 1px solid #eee;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            background: white;
            margin-bottom: 1px;
        }

        .checkout-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 1rem;
            background: white;
            border-radius: 0 0 8px 8px;
        }

        .checkout-btn {
            background-color: #F7A8D3;
            color: white;
            border-radius: 20px;
            padding: 8px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .checkout-btn:hover {
            background-color: #f391c7;
        }

        .checkout-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .voucher-input {
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 8px 12px;
            outline: none;
            width: 100%;
            color: #666;
            transition: border-color 0.2s ease;
        }

        .voucher-input:focus {
            border-color: #F7A8D3;
        }

        .voucher-input::placeholder {
            color: #999;
            font-size: 0.9em;
        }

        .empty-cart {
            text-align: center;
            padding: 2rem;
            color: #666;
        }

        .delete-item {
            transition: all 0.2s ease;
        }

        .delete-item:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="container mx-auto p-4">
        <!-- Header Section -->
        <div class="cart-section p-4 mb-4">
            <div class="grid grid-cols-6 gap-4 font-medium">
                <div class="col-span-2">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" id="selectAll" class="mr-2 cursor-pointer">
                        <span>Pilih Semua Produk</span>
                    </label>
                </div>
                <div>Harga Satuan</div>
                <div>Kuantitas</div>
                <div>Total Harga</div>
                <div>Aksi</div>
            </div>
        </div>

        <!-- Cart Items Section -->
        <div class="cart-section p-4" id="cartItems">
            <!-- Dynamic cart items will be loaded here -->
        </div>

        <!-- Footer Section -->
        <div class="cart-section mt-4">
            <!-- Voucher Section -->
            <div class="voucher-container">
                <div class="flex items-center flex-1">
                    <svg class="w-5 h-5 mr-2 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                    <span class="font-medium mr-4">Voucher</span>
                    <input type="text" id="voucherInput" 
                           placeholder="Masukkan kode voucher" 
                           class="voucher-input">
                    <button id="applyVoucher" 
                            class="ml-4 px-4 py-2 bg-pink-400 text-white rounded-md hover:bg-pink-500 transition-colors">
                        Terapkan
                    </button>
                </div>
            </div>

            <!-- Total and Checkout Section -->
            <div class="checkout-container">
                <div class="mr-8 text-right">
                    <div class="mb-2">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="subtotal-price ml-2">Rp0</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-gray-600">Diskon Voucher:</span>
                        <span class="discount-amount ml-2">-Rp0</span>
                    </div>
                    <div>
                        <span class="font-medium">Total:</span>
                        <span class="total-price font-bold text-xl ml-2">Rp0</span>
                    </div>
                </div>
                <button id="checkoutBtn" class="checkout-btn" disabled>
                    Buat Pesanan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Cart data structure
    const cartItems = [
        {
            id: 1,
            name: "Floral Puff Midi Dress",
            variant: "White, S",
            price: 359000,
            image: "<?= HOST ?>/foto/10.png",
            quantity: 1
        },
        {
            id: 2,
            name: "Unisex Shirt",
            variant: "White, L",
            price: 199000,
            image: "<?= HOST ?>/foto/15.png",
            quantity: 1
        },
        {
            id: 3,
            name: "Pink Floral Blouse",
            variant: "Pink, S",
            price: 239000,
            image: "<?= HOST ?>/foto/14.png",
            quantity: 1
        }
    ];

    const cartItemsContainer = document.getElementById('cartItems');
    const selectAllCheckbox = document.getElementById('selectAll');
    const checkoutBtn = document.getElementById('checkoutBtn');
    let appliedVoucher = null;

    // Render cart items
    function renderCartItems() {
        if (cartItems.length === 0) {
            cartItemsContainer.innerHTML = `
                <div class="empty-cart">
                    <p>Keranjang belanja Anda kosong</p>
                    <a href="products.php" class="text-pink-400 hover:text-pink-600">
                        Lanjutkan Belanja
                    </a>
                </div>`;
            return;
        }

        cartItemsContainer.innerHTML = cartItems.map(item => `
            <div class="grid grid-cols-6 gap-4 items-center py-4 border-b last:border-b-0" data-id="${item.id}">
                <div class="col-span-2 flex items-center">
                    <input type="checkbox" class="product-checkbox mr-2" ${item.selected ? 'checked' : ''}>
                    <img src="${item.image}" alt="${item.name}" class="w-20 h-20 object-cover rounded">
                    <div class="ml-4">
                        <h3 class="font-medium">${item.name}</h3>
                        <p class="text-gray-500">Variasi: ${item.variant}</p>
                    </div>
                </div>
                <div>Rp${formatNumber(item.price)}</div>
                <div class="flex items-center">
                    <button class="btn-quantity decrease" ${item.quantity <= 1 ? 'disabled' : ''}>-</button>
                    <input type="number" class="quantity-input" value="${item.quantity}" min="1" data-price="${item.price}">
                    <button class="btn-quantity increase">+</button>
                </div>
                <div class="subtotal">Rp${formatNumber(item.price * item.quantity)}</div>
                <div>
                    <button class="delete-item text-pink-400 hover:text-pink-600" data-id="${item.id}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        `).join('');

        updateTotal();
    }

    // Format number to Indonesian currency format
    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    // Update subtotal for an item
    function updateSubtotal(input) {
        const quantity = parseInt(input.value) || 1;
        const price = parseInt(input.dataset.price) || 0;
        const subtotal = quantity * price;
        
        const subtotalElement = input.closest('.grid').querySelector('.subtotal');
        subtotalElement.textContent = `Rp${formatNumber(subtotal)}`;
    }

    // Calculate and update total price
    function updateTotal() {
        let subtotal = 0;
        const checkboxes = document.querySelectorAll('.product-checkbox');
        
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const gridItem = checkbox.closest('.grid');
                const quantity = parseInt(gridItem.querySelector('.quantity-input').value) || 1;
                const price = parseInt(gridItem.querySelector('.quantity-input').dataset.price) || 0;
                subtotal += quantity * price;
            }
        });

        const discount = calculateDiscount(subtotal);
        const total = subtotal - discount;

        document.querySelector('.subtotal-price').textContent = `Rp${formatNumber(subtotal)}`;
        document.querySelector('.discount-amount').textContent = `-Rp${formatNumber(discount)}`;
        document.querySelector('.total-price').textContent = `Rp${formatNumber(total)}`;
        
        // Enable/disable checkout button
        checkoutBtn.disabled = total <= 0;
    }

    // Calculate discount based on applied voucher
    function calculateDiscount(subtotal) {
        if (!appliedVoucher) return 0;
        
        // Add your voucher logic here
        return 0; // Placeholder
    }

    // Event Listeners
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateTotal();
    });

    document.addEventListener('click', function(event) {
        // Quantity buttons
        if (event.target.classList.contains('btn-quantity')) {
            const input = event.target.closest('.flex').querySelector('.quantity-input');
            const decreaseBtn = event.target.closest('.flex').querySelector('.decrease');
            const currentValue = parseInt(input.value) || 1;

            if (event.target.classList.contains('decrease')) {
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                }
            } else if (event.target.classList.contains('increase')) {
                input.value = currentValue + 1;
            }

            // Update the state of the decrease button
            decreaseBtn.disabled = parseInt(input.value) <= 1;

            updateSubtotal(input);
            updateTotal();
        }

        // Delete item
        if (event.target.closest('.delete-item')) {
            const button = event.target.closest('.delete-item');
            const itemId = parseInt(button.dataset.id);

            Swal.fire({
                title: 'Hapus Item?',
                text: 'Apakah Anda yakin ingin menghapus item ini dari keranjang?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const index = cartItems.findIndex(item => item.id === itemId);
                    if (index !== -1) {
                        cartItems.splice(index, 1);
                        renderCartItems();
                        Swal.fire('Berhasil', 'Item telah dihapus.', 'success');
                    }
                }
            });
        }
    });

    // Voucher application
    document.getElementById('applyVoucher').addEventListener('click', function() {
        const voucherCode = document.getElementById('voucherInput').value.trim();

        if (!voucherCode) {
            Swal.fire('Error', 'Masukkan kode voucher', 'error');
            return;
        }

        // Add your voucher validation logic here
        appliedVoucher = null; // Placeholder
        updateTotal();

        Swal.fire('Berhasil', 'Voucher berhasil diterapkan', 'success');
    });

    // Checkout button click handler
    checkoutBtn.addEventListener('click', function() {
        const selectedItems = cartItems.filter((item, index) => 
            document.querySelectorAll('.product-checkbox')[index].checked
        );

        if (selectedItems.length === 0) {
            Swal.fire('Error', 'Pilih minimal satu produk untuk checkout', 'error');
            return;
        }

        // Add your checkout logic here
        console.log('Selected items for checkout:', selectedItems);
    });

    // Initialize cart
    renderCartItems();
});

</script>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/footer_user.php'; ?>
</body>
</html>