<?php
include "template/header_admin.php"
?>
 <!-- Main Content -->
 <div class="p-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Swap</h2>
                <div class="relative inline-block text-left">
                    <button id="menu-button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Change Swap
                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 011.414 0L10 13.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div id="dropdown-menu" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                        <a href="swapproduct.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Product</a>
                        <a href="swappoin.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Poin</a>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold mb-4">Recent</h3>
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Customer Name</th>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2">Amanda Salima</td>
                            <td class="border px-4 py-2">#25426</td>
                            <td class="border px-4 py-2">Nov 8th, 2024</td>
                            <td class="border px-4 py-2 text-green-500">Completed</td>
                            <td class="border px-4 py-2">
                                <button class="text-blue-500 hover:text-blue-700 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.121 2.121 0 013 0l1.5 1.5a2.121 2.121 0 010 3L7 19l-4 1 1-4L16.5 3.5z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Saskiw</td>
                            <td class="border px-4 py-2">#25427</td>
                            <td class="border px-4 py-2">Nov 8th, 2024</td>
                            <td class="border px-4 py-2 text-yellow-500">Pending</td>
                            <td class="border px-4 py-2">
                                <button class="text-blue-500 hover:text-blue-700 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.121 2.121 0 013 0l1.5 1.5a2.121 2.121 0 010 3L7 19l-4 1 1-4L16.5 3.5z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Widlw</td>
                            <td class="border px-4 py-2">#25428</td>
                            <td class="border px-4 py-2">Nov 8th, 2024</td>
                            <td class="border px-4 py-2 text-yellow-500">Pending</td>
                            <td class="border px-4 py-2">
                                <button class="text-blue-500 hover:text-blue-700 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.121 2.121 0 013 0l1.5 1.5a2.121 2.121 0 010 3L7 19l-4 1 1-4L16.5 3.5z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Dropdown Script -->
    <script>
        document.getElementById('menu-button').addEventListener('click', function(event) {
            var dropdownMenu = document.getElementById('dropdown-menu');
            dropdownMenu.classList.toggle('hidden');
        });

        window.addEventListener('click', function(event) {
            if (!event.target.matches('#menu-button')) {
                var dropdowns = document.getElementsByClassName('dropdown-content');
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (!openDropdown.classList.contains('hidden')) {
                        openDropdown.classList.add('hidden');
                    }
                }
            }
        });
    </script>
</body>
</html>
