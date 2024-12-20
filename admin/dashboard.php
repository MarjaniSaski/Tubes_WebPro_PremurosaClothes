<?php
include "template/header_admin.php"
?>
  <!-- Main Content -->
  <div class="flex-1">
            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-4">
                <!-- Total Penjualan -->
                <div class="bg-white p-4 rounded shadow">
                    <div class="flex items-center space-x-3">
                        <i class="bi bi-cart text-purple-500 text-3xl"></i>
                        <div>
                            <h2 class="text-gray-600 text-sm">Total Penjualan</h2>
                            <p class="text-xl font-bold text-gray-800">Rp 2.750.000</p>
                        </div>
                    </div>
                </div>
            
                <!-- Total Penukaran -->
                <div class="bg-white p-4 rounded shadow">
                    <div class="flex items-center space-x-3">
                        <i class="bi bi-arrow-repeat text-purple-500 text-3xl"></i>
                        <div>
                            <h2 class="text-gray-600 text-sm">Total Penukaran</h2>
                            <p class="text-xl font-bold text-gray-800">8</p>
                        </div>
                    </div>
                </div>
            
                <!-- Total Pengunjung -->
                <div class="bg-white p-4 rounded shadow">
                    <div class="flex items-center space-x-3">
                        <i class="bi bi-person text-purple-500 text-3xl"></i>
                        <div>
                            <h2 class="text-gray-600 text-sm">Total Pengunjung</h2>
                            <p class="text-xl font-bold text-gray-800">78</p>
                        </div>
                    </div>
                </div>
            
                <!-- Total Pesanan -->
                <div class="bg-white p-4 rounded shadow">
                    <div class="flex items-center space-x-3">
                        <i class="bi bi-box text-purple-500 text-3xl"></i>
                        <div>
                            <h2 class="text-gray-600 text-sm">Total Pesanan</h2>
                            <p class="text-xl font-bold text-gray-800">15</p>
                        </div>
                    </div>
                </div>
            </div>
            

            <!-- Sales Graph and New Arrivals -->
            <div class="grid grid-cols-3 gap-4 p-4">
                <!-- Sales Graph -->
                <div class="col-span-2 bg-white p-4 rounded shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-black text-xl font-semibold">Sale Graph</h2>
                        <div class="flex space-x-2">
                            <button class="px-4 py-1 text-sm font-medium text-white bg-purple-500 rounded">Monthly</button>
                            <button class="px-4 py-1 text-sm font-medium text-purple-500 bg-gray-100 rounded">Yearly</button>
                        </div>
                    </div>
                    <div class="w-full border-b-2 border-gray-300 mb-4"></div>
                    <div class="mt-4">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
                
                

                <!-- New Arrivals -->
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-black text-xl mb-2 font-semibold">New Arrival</h2>
                    <div class="w-full border-b-2 border-gray-300 mt-1 mb-4"></div>
                    <ul>
                        <li class="flex justify-between items-center mb-4">
                            <span>Blouse Pink Flower</span>
                            <span class="text-gray-700">Rp 200.000</span>
                        </li>
                        <li class="flex justify-between items-center mb-4">
                            <span>Blose Blue Flower</span>
                            <span class="text-gray-700">Rp 200.000</span>
                        </li>
                        <li class="flex justify-between items-center mb-4">
                            <span>Midi Dress</span>
                            <span class="text-gray-700">Rp 250.000</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span>T-Shirt Men</span>
                            <span class="text-gray-700">Rp 125.000</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Latest Customers and Top Products -->
            <div class="grid grid-cols-2 gap-4 mt-2 p-4">
                <!-- Latest Customers -->
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-black text-xl font-semibold mb-2">Latest Customers</h2>
                    <div class="w-full border-b-2 border-gray-300 mt-1 mb-4"></div>
                    <ul>
                        <li class="flex items-center mb-4">
                            <!-- Circle -->
                            <div class="w-8 h-8 rounded-full bg-purple-500 flex-shrink-0"></div>
                            <!-- Name and Email -->
                            <div class="ml-4">
                                <span class="block font-medium">Widya Mustika Sari</span>
                                <span class="block text-sm text-gray-500">widya@gmail.com</span>
                            </div>
                            <!-- Amount -->
                            <span class="ml-auto text-gray-700">Rp 150.000</span>
                        </li>
                        <li class="flex items-center mb-4">
                            <div class="w-8 h-8 rounded-full bg-purple-500 flex-shrink-0"></div>
                            <div class="ml-4">
                                <span class="block font-medium">Amanda Salima</span>
                                <span class="block text-sm text-gray-500">amanda@gmail.com</span>
                            </div>
                            <span class="ml-auto text-gray-700">Rp 150.000</span>
                        </li>
                        <li class="flex items-center mb-4">
                            <div class="w-8 h-8 rounded-full bg-purple-500 flex-shrink-0"></div>
                            <div class="ml-4">
                                <span class="block font-medium">Marjani Dzakiyyah Arifah</span>
                                <span class="block text-sm text-gray-500">marjani@gmail.com</span>
                            </div>
                            <span class="ml-auto text-gray-700">Rp 150.000</span>
                        </li>
                        <li class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-purple-500 flex-shrink-0"></div>
                            <div class="ml-4">
                                <span class="block font-medium">Amanda Dzakiyyah Sari</span>
                                <span class="block text-sm text-gray-500">amzari@gmail.com</span>
                            </div>
                            <span class="ml-auto text-gray-700">Rp 150.000</span>
                        </li>
                    </ul>
                </div>
                

                <!-- Top Products -->
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-black text-xl font-semibold mb-2">Top Products</h2>
                    <div class="w-full border-b-2 border-gray-300 mt-1 mb-4"></div>
                    <ul>
                        <li class="flex flex-col mb-4 border-b border-gray-200 pb-2">
                            <div class="flex justify-between items-center">
                                <span>Midi Dress</span>
                                <span class="text-gray-700">5 Sales</span>
                            </div>
                            <span class="text-sm text-gray-500 mt-1">Category: Dress</span>
                        </li>
                        <li class="flex flex-col mb-4 border-b border-gray-200 pb-2">
                            <div class="flex justify-between items-center">
                                <span>Cargo Army Men</span>
                                <span class="text-gray-700">2 Sales</span>
                            </div>
                            <span class="text-sm text-gray-500 mt-1">Category: Bottoms</span>
                        </li>
                        <li class="flex flex-col mb-4 border-b border-gray-200 pb-2">
                            <div class="flex justify-between items-center">
                                <span>Blouse Pink Flower</span>
                                <span class="text-gray-700">1 Sales</span>
                            </div>
                            <span class="text-sm text-gray-500 mt-1">Category: Tops</span>
                        </li>
                        <li class="flex flex-col">
                            <div class="flex justify-between items-center">
                                <span>Jeans</span>
                                <span class="text-gray-700">1 Sales</span>
                            </div>
                            <span class="text-sm text-gray-500 mt-1">Category: Bottoms</span>
                        </li>
                    </ul>
                </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-1gap-6 p-4 mt-2">
                    <div class="bg-white p-4 mb-4 rounded-lg shadow-lg">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-gray-800">Recent Orders</h2>
                            <button class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>
                        
                        <!-- Table Section -->
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <table class="w-full table-auto text-left text-sm">
                                <thead>
                                    <tr class="border-b bg-gray-50">
                                        <th class="py-3 px-4 text-gray-600"><input type="checkbox" /></th>
                                        <th class="py-3 px-4 text-gray-600">Product</th>
                                        <th class="py-3 px-4 text-gray-600">Order ID</th>
                                        <th class="py-3 px-4 text-gray-600">Date</th>
                                        <th class="py-3 px-4 text-gray-600">Customer Name</th>
                                        <th class="py-3 px-4 text-gray-600">Status</th>
                                        <th class="py-3 px-4 text-gray-600">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Order Row 1 -->
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4"><input type="checkbox" /></td>
                                        <td class="py-2 px-4">Lorem Ipsum</td>
                                        <td class="py-2 px-4">#25426</td>
                                        <td class="py-2 px-4">Nov 8th, 2024</td>
                                        <td class="py-2 px-4 flex items-center">
                                            <div class="w-2.5 h-2.5 bg-pink-500 rounded-full mr-2"></div>
                                            Amanda
                                        </td>
                                        <td class="py-2 px-4">
                                            <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i> Completed
                                            </span>
                                        </td>
                                        <td class="py-2 px-4">Rp 250.000</td>
                                    </tr>
                                    <!-- Order Row 2 -->
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4"><input type="checkbox" /></td>
                                        <td class="py-2 px-4">Lorem Ipsum</td>
                                        <td class="py-2 px-4">#25425</td>
                                        <td class="py-2 px-4">Nov 7th, 2024</td>
                                        <td class="py-2 px-4 flex items-center">
                                            <div class="w-2.5 h-2.5 bg-pink-500 rounded-full mr-2"></div>
                                            Salima
                                        </td>
                                        <td class="py-2 px-4">
                                            <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i> Completed
                                            </span>
                                        </td>
                                        <td class="py-2 px-4">Rp 250.000</td>
                                    </tr>
                                    <!-- Order Row 3 -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4"><input type="checkbox" /></td>
                                        <td class="py-2 px-4">Lorem Ipsum</td>
                                        <td class="py-2 px-4">#25424</td>
                                        <td class="py-2 px-4">Nov 6th, 2024</td>
                                        <td class="py-2 px-4 flex items-center">
                                            <div class="w-2.5 h-2.5 bg-pink-500 rounded-full mr-2"></div>
                                            Saski
                                        </td>
                                        <td class="py-2 px-4">
                                            <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full">
                                                <i class="fas fa-spinner mr-1"></i> In progress
                                            </span>
                                        </td>
                                        <td class="py-2 px-4">Rp 250.000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                
                        <!-- Button Section -->
                        <div class="mt-4 text-right">
                            <button class="px-4 py-2 text-sm font-medium text-white bg-purple-500 rounded hover:bg-purple-400 transition duration-300 ease-in-out">
                                SEE DETAILS &gt;
                            </button>
                        </div>
                    </div>
                </div>
                        

    <!-- Add Chart.js for the Graph -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Sales',
                    data: [100, 150, 200, 250, 300, 400],
                    borderColor: 'rgba(124, 58, 237, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
    </body>
</html>