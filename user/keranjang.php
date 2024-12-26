<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';
?>
<style>
    .cart-section {
        background-color: white;
        border-radius: 8px;
        margin-bottom: 1px;  /* Reduced margin between sections */
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .quantity-input {
        width: 40px;
        height: 24px;
        text-align: center;
        border: 1px solid #F7A8D3;
        border-radius: 4px;
        margin: 0 8px; 
        color:  #F7A8D3;
    }
    .btn-quantity {
        width: 24px;
        height: 24px;
        border: 1px solid  #F7A8D3;
        border-radius: 4px;
        background: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #F7A8D3;
    }
    .btn-quantity:hover {
        background: #F7A8D3;
        color: white;
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
    .voucher-label {
        color: #666;
        margin-right: 16px;
        display: flex;
        align-items: center;
    }
    .voucher-input {
        border: none;
        outline: none;
        width: 100%;
        color: #666;
    }
    .voucher-input::placeholder {
        color: #999;
        font-size: 0.9em;
    }
</style>
<div class="bg-pink-100">
    <div class="container mx-auto p-4">
        <!-- Header Section -->
        <div class="cart-section p-4 mb-4">
            <div class="grid grid-cols-6 gap-4">
                <div class="col-span-2">
                    <input type="checkbox" id="selectAll" class="mr-2">
                    Produk
                </div>
                <div>Harga Satuan</div>
                <div>Kuantitas</div>
                <div>Total Harga</div>
                <div>Aksi</div>
            </div>
        </div>

        <!-- Cart Items Section -->
        <div class="cart-section p-4">
            <!-- Item 1 -->
            <div class="grid grid-cols-6 gap-4 items-center py-4 border-b">
                <div class="col-span-2 flex items-center">
                    <input type="checkbox" class="product-checkbox mr-2">
                    <img src="<?= HOST ?>/foto/10.png" alt="Floral Puff Midi Dress" class="w-20 h-20 object-cover rounded">
                    <div class="ml-4">
                        <h3 class="font-medium">Floral Puff Midi Dress</h3>
                        <p class="text-gray-500">Variasi: White, S</p>
                    </div>
                </div>
                <div>Rp359.000</div>
                <div class="flex items-center">
                    <button class="btn-quantity decrease">-</button>
                    <input type="number" class="quantity-input" value="1" min="1" data-price="359000">
                    <button class="btn-quantity increase">+</button>
                </div>
                <div class="subtotal">Rp359.000</div>
                <div>
                    <button class="delete-item text-pink-400 hover:text-pink-600" data-id="1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="grid grid-cols-6 gap-4 items-center py-4 border-b">
                <div class="col-span-2 flex items-center">
                    <input type="checkbox" class="product-checkbox mr-2">
                    <img src="<?= HOST ?>/foto/15.png" alt="Unisex Shirt" class="w-20 h-20 object-cover rounded">
                    <div class="ml-4">
                        <h3 class="font-medium">Unisex Shirt</h3>
                        <p class="text-gray-500">Variasi: White, L</p>
                    </div>
                </div>
                <div>Rp199.000</div>
                <div class="flex items-center">
                    <button class="btn-quantity decrease">-</button>
                    <input type="number" class="quantity-input" value="1" min="1" data-price="199000">
                    <button class="btn-quantity increase">+</button>
                </div>
                <div class="subtotal">Rp199.000</div>
                <div>
                    <button class="delete-item text-pink-400 hover:text-pink-600" data-id="2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>

            </div>

            <!-- Item 3 -->
            <div class="grid grid-cols-6 gap-4 items-center py-4">
                <div class="col-span-2 flex items-center">
                    <input type="checkbox" class="product-checkbox mr-2">
                    <img src="<?= HOST ?>/foto/14.png" alt="Pink Floral Blouse" class="w-20 h-20 object-cover rounded">
                    <div class="ml-4">
                        <h3 class="font-medium">Pink Floral Blouse</h3>
                        <p class="text-gray-500">Variasi: Pink, S</p>
                    </div>
                </div>
                <div>Rp239.000</div>
                <div class="flex items-center">
                    <button class="btn-quantity decrease">-</button>
                    <input type="number" class="quantity-input" value="1" min="1" data-price="239000">
                    <button class="btn-quantity increase">+</button>
                </div>
                <div class="subtotal">Rp239.000</div>
                <div>
                    <button class="delete-item text-pink-400 hover:text-pink-600" data-id="3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
        <!-- Footer Section -->
    <div class="container mx-auto p-4">
        <div class="cart-section p-4">
            <!-- Voucher Section -->
            <div class="flex items-center justify-between border-b pb-4">
                <div class="flex items-center flex-1">
                    <svg class="w-5 h-5 mr-2 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                    <span class="font-medium mr-4">Voucher</span>
                    <input type="text" placeholder="Gunakan/ masukkan voucher" class="voucher-input flex-1">
                </div>
            </div>

            <!-- Total and Checkout Section -->
            <div class="flex justify-end items-center pt-4">
                <div class="mr-8">
                    <span class="font-medium">Total</span>
                    <span class="font-bold text-xl ml-4 total-price">Rp0</span>
                </div>
                <button class="checkout-btn ">CHECKOUT</button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAllCheckbox = document.getElementById('selectAll');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    const totalPriceElement = document.querySelector('.total-price');

    // Select All Functionality
    selectAllCheckbox.addEventListener('change', function () {
        productCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateTotal();
    });

    // Event delegation for quantity controls
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('btn-quantity')) {
            const input = event.target.closest('.flex').querySelector('.quantity-input');
            const currentValue = parseInt(input.value) || 1;

            if (event.target.classList.contains('decrease') && currentValue > 1) {
                input.value = currentValue - 1;
            } else if (event.target.classList.contains('increase')) {
                input.value = currentValue + 1;
            }

            updateSubtotal(input);
            updateTotal();
        }
    });

    // Update subtotal when quantity changes
    function updateSubtotal(input) {
        const quantity = parseInt(input.value) || 1;
        const price = parseInt(input.dataset.price) || 0;
        const subtotal = quantity * price;

        const subtotalElement = input.closest('.grid').querySelector('.subtotal');
        subtotalElement.textContent = `Rp${formatNumber(subtotal)}`;
    }

    // Update total price
    function updateTotal() {
        let total = 0;

        productCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const gridItem = checkbox.closest('.grid');
                const quantity = parseInt(gridItem.querySelector('.quantity-input').value) || 1;
                const price = parseInt(gridItem.querySelector('.quantity-input').dataset.price) || 0;
                total += quantity * price;
            }
        });

        totalPriceElement.textContent = `Rp${formatNumber(total)}`;
    }

    // Format number to include dots for thousands
    function formatNumber(number) {
        return number.toLocaleString('id-ID');
    }

    // Add change event listeners to product checkboxes
    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotal);
    });

    // Add input event listeners to quantity inputs
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('input', function () {
            if (this.value < 1) this.value = 1; // Ensure minimum value is 1
            updateSubtotal(this);
            updateTotal();
        });
    });

    // Function to delete item
    document.addEventListener('click', function (event) {
        if (event.target.closest('.delete-item')) {
            const button = event.target.closest('.delete-item');
            const gridItem = button.closest('.grid');

            // Remove the item from DOM
            gridItem.remove();

            // Update the total price
            updateTotal();
        }
    });
});
</script>
<?php
include "template/footer_user.php"
?>
</body>
</html>

