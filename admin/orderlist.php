<?php
include "template/header_admin.php"
?>

<!-- Main Content -->
<div class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold">Order List</h2>
                <div class="flex items-center space-x-4">
                    <div class="text-gray-500">Nov 16, 2024 - Feb 29, 2024</div>
                    <button class="bg-white border border-gray-300 rounded px-4 py-2">Change Status</button>
                </div>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <h3 class="text-xl font-semibold mb-4">Recent Purchases</h3>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Product</th>
                            <th class="py-2 px-4 border-b">Order ID</th>
                            <th class="py-2 px-4 border-b">Date</th>
                            <th class="py-2 px-4 border-b">Customer Name</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-4 border-b">Lorem Ipsum</td>
                            <td class="py-2 px-4 border-b">#25426</td>
                            <td class="py-2 px-4 border-b">Nov 8th, 2024</td>
                            <td class="py-2 px-4 border-b">Amanda</td>
                            <td class="py-2 px-4 border-b">
                                <select class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">
                                    <option value="completed">Completed</option>
                                    <option value="pending">Pending</option>
                                    <option value="in-progress">In progress</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </td>
                            <td class="py-2 px-4 border-b">Rp 250.000</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">Lorem Ipsum</td>
                            <td class="py-2 px-4 border-b">#25425</td>
                            <td class="py-2 px-4 border-b">Nov 7th, 2024</td>
                            <td class="py-2 px-4 border-b">Salima</td>
                            <td class="py-2 px-4 border-b">
                                <select class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">
                                    <option value="completed">Completed</option>
                                    <option value="pending">Pending</option>
                                    <option value="in-progress">In progress</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </td>
                            <td class="py-2 px-4 border-b">Rp 250.000</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">Lorem Ipsum</td>
                            <td class="py-2 px-4 border-b">#25424</td>
                            <td class="py-2 px-4 border-b">Nov 6th, 2024</td>
                            <td class="py-2 px-4 border-b">Alex</td>
                            <td class="py-2 px-4 border-b">
                                <select class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs">
                                    <option value="completed">Completed</option>
                                    <option value="pending">Pending</option>
                                    <option value="in-progress">In progress</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </td>
                            <td class="py-2 px-4 border-b">Rp 200.000</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">Lorem Ipsum</td>
                            <td class="py-2 px-4 border-b">#25423</td>
                            <td class="py-2 px-4 border-b">Nov 5th, 2024</td>
                            <td class="py-2 px-4 border-b">Rina</td>
                            <td class="py-2 px-4 border-b">
                                <select class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs">
                                    <option value="completed">Completed</option>
                                    <option value="pending">Pending</option>
                                    <option value="in-progress">In progress</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </td>
                            <td class="py-2 px-4 border-b">Rp 150.000</td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex justify-between items-center mt-4">
                    <span class="text-gray-600 text-sm">Showing 1 to 4 of 50 entries</span>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 border rounded-md text-gray-600 bg-white">Previous</button>
                        <button class="px-3 py-1 border rounded-md text-gray-600 bg-white">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 