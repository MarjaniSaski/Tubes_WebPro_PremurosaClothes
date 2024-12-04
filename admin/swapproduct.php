<?php
include "template/header_admin.php"
?>  
    <!-- Main Content -->
    <div class="flex-1 p-10">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Swap &gt; Product</h2>
            <p class="text-gray-500 mb-6">This is a list of latest swap.</p>
        </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Customer Name</th>
                            <th class="py-2 px-4 border-b">Date</th>
                            <th class="py-2 px-4 border-b">Jenis Barang</th>
                            <th class="py-2 px-4 border-b">Jenis Bahan</th>
                            <th class="py-2 px-4 border-b">Details</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-4 border-b">#25426</td>
                            <td class="py-2 px-4 border-b">Amanda Salima</td>
                            <td class="py-2 px-4 border-b">Nov 8th, 2024</td>
                            <td class="py-2 px-4 border-b">Top</td>
                            <td class="py-2 px-4 border-b">Cotton</td> 
                            <td class="py-2 px-4 border-b"> 
                                <button onclick="showDetails('12.png')" class="text-blue-500 hover:text-blue-700 focus:outline-none"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h3m4 0H4m4 0h3m0-7h0m0 14h0m0-7h0m0 7h0M7 4h0m0 16h0" /> 
                                    </svg> 
                                </button>
                            </td>
                            <td class="py-2 px-4 border-b"><span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Completed</span></td>
                            <td class="border px-4 py-2">
                                <button onclick="showData('#25426')" class="text-blue-500 hover:text-blue-700 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.121 2.121 0 013 0l1.5 1.5a2.121 2.121 0 010 3L7 19l-4 1 1-4L16.5 3.5z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">#25427</td>
                            <td class="py-2 px-4 border-b">Saskiw</td>
                            <td class="py-2 px-4 border-b">Nov 8th, 2024</td>
                            <td class="py-2 px-4 border-b">Bottom</td>
                            <td class="py-2 px-4 border-b">Denim</td>
                            <td class="py-2 px-4 border-b"> 
                                <button onclick="showDetails('16.png')" class="text-blue-500 hover:text-blue-700 focus:outline-none"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h3m4 0H4m4 0h3m0-7h0m0 14h0m0-7h0m0 7h0M7 4h0m0 16h0" /> 
                                    </svg> 
                                </button>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-xs">Pending</span>
                            </td>
                            <td class="border px-4 py-2">
                                <button onclick="showData('#25427')" class="text-blue-500 hover:text-blue-700 focus:outline-none">
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
</div>
<!-- Modal --> 
 <div id="myModal" class="modal fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50"> 
    <div class="modal-content bg-white p-6 rounded-lg shadow-lg relative max-w-lg w-full"> 
        <span class="close absolute top-2 right-2 text-2xl cursor-pointer">&times;</span> 
        <img id="modalImage" src="" alt="Details Image" class="w-full h-auto rounded-lg"> 
    </div> 
</div>
<div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <div class="flex justify-between items-center">
            <h3 class="text-xl font-bold">Details</h3>
            <button onclick="closeDetails()" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="detailsContent" class="mt-4">
            <!-- Content will be injected here -->
        </div>
        <div class="mt-4">
            <label for="poinInput" class="block text-gray-700">Tambah Poin:</label>
            <input type="number" id="poinInput" class="border rounded py-2 px-3 mt-1 w-full" placeholder="Masukkan jumlah poin">
        </div>
        <div class="mt-4">
            <label for="statusSelect" class="block text-gray-700">Status:</label>
            <select id="statusSelect" class="border rounded py-2 px-3 mt-1 w-full">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="in_progress">In Progress</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <div class="mt-4 flex justify-between">
            <button class="bg-blue-500 text-white py-2 px-4 rounded" onclick="updateDetails()">UPDATE</button>
            <button class="bg-red-500 text-white py-2 px-4 rounded" onclick="closeDetails()">CANCEL</button>
        </div>
        </div>
    </div>
</div>   
<script>
//untuk show details 
function showDetails(imageSrc) { 
    var modal = document.getElementById("myModal"); 
    var modalImg = document.getElementById("modalImage");
    modal.style.display = "flex"; 
    modalImg.src = imageSrc; 
} 
    document.querySelector(".close").onclick = function() { 
    var modal = document.getElementById("myModal"); 
    modal.style.display = "none"; 
}
    window.onclick = function(event) { 
        var modal = document.getElementById("myModal"); 
        if (event.target == modal) { 
            modal.style.display = "none";
        }
     }
     const detailsData = {
        '#25426': {
            'date': 'Nov 8th, 2024',
            'customer': 'Amanda Salima',
            'jenisBarang': 'Top',
            'material': 'Cotton',
            'details': 'Barang masih bagus, hilang bagian kancing satu.',
            'status': 'Completed'
        },
        '#25427': {
            'date': 'Nov 9th, 2024',
            'customer': 'Saskiw',
            'jenisBarang': 'Jeans',
            'material': 'Denim',
            'details': 'Ada beberapa bekas noda minyak.',
            'status': 'Pending'
        },
        '#25428': {
            'date': 'Nov 10th, 2024',
            'customer': 'Widiw',
            'jenisBarang': 'Top',
            'material': 'Cotton',
            'details': '-',
            'status': 'Pending'
        }
    };

    function showData(id) {
        const data = detailsData[id];
        const detailsContent = document.getElementById('detailsContent');
        detailsContent.innerHTML = `
            <p><strong>ID:</strong> ${id}</p>
            <p><strong>Date:</strong> ${data.date}</p>
            <p><strong>Customer Name:</strong> ${data.customer}</p>
            <p><strong>Jenis Barang:</strong> ${data.jenisBarang}</p>
            <p><strong>Material:</strong> ${data.material}</p>
            <p><strong>Details:</strong> ${data.details}</p>
            <p><strong>Status:</strong> ${data.status}</p>
        `;
        document.getElementById('detailsModal').classList.remove('hidden');
    }

    function closeDetails() {
        document.getElementById('detailsModal').classList.add('hidden');
    }

    function updateDetails() { 
        const poinInput = document.getElementById('poinInput').value; 
        const statusSelect = document.getElementById('statusSelect').value; 
        alert(`Poin sebesar ${poinInput} telah ditambahkan! Status telah diubah menjadi ${statusSelect}!`); 
        const id = document.getElementById('detail-id').innerText; 
        const newStatus = document.getElementById('statusSelect').value; 
        const row = document.querySelector(`tr[data-id="${id}"]`); 
        row.cells[3].innerText = newStatus.charAt(0).toUpperCase() + newStatus.slice(1); 
        row.cells[3].className = `status ${newStatus.toLowerCase()}`; 
        closeDetails(); }
</script>
</body>
</html>