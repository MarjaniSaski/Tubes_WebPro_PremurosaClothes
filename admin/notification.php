<?php include "template/header_admin.php"; ?>

<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden notification-container">
        <!-- Header -->
        <div class="bg-purple-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-white text-xl font-semibold">Notifikasi</h1>
                <div class="flex items-center space-x-4">
                    <button id="markAllRead" class="text-purple-200 hover:text-white text-sm">
                        Tandai semua sudah dibaca
                    </button>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="bg-white border-b border-gray-200">
            <div class="flex" role="tablist">
                <button class="tab-btn px-6 py-3 text-purple-600 border-b-2 border-purple-600 font-medium" data-tab="all">
                    Semua <span id="all-count">(5)</span>
                </button>
                <button class="tab-btn px-6 py-3 text-gray-500 hover:text-purple-600" data-tab="orders">
                    Pesanan <span id="orders-count">(3)</span>
                </button>
                <button class="tab-btn px-6 py-3 text-gray-500 hover:text-purple-600" data-tab="pickups">
                    Penjemputan <span id="pickups-count">(2)</span>
                </button>
            </div>
        </div>

        <!-- Notification Lists -->
        <div class="overflow-y-auto scrollbar-custom" style="height: calc(100% - 8rem);">
            <div id="notification-list">
                <!-- Template notifikasi akan diisi oleh JavaScript -->
            </div>
        </div>
    </div>
</div>

<style>
.notification-container {
    height: calc(100vh - 2rem);
}

.notification-item {
    transition: all 0.2s ease;
}

.notification-item.unread {
    background-color: #f3e8ff;
}

.action-buttons {
    display: none;
}

.notification-item:hover .action-buttons {
    display: flex;
}

.scrollbar-custom::-webkit-scrollbar {
    width: 6px;
}

.scrollbar-custom::-webkit-scrollbar-thumb {
    background:rgb(219, 183, 252);
    border-radius: 3px;
}

.notification-item.read {
    background-color:rgb(219, 183, 252); /* Purple background for read notifications */
}

.notification-item.unread {
    background-color: #f3e8ff; /* Purple background for unread notifications */
}
</style>

<script>
const notifications = [
    {
        id: 1,
        type: 'order',
        title: 'Pesanan Baru #12345',
        content: 'Amanda Salima - Rp 299.000',
        time: '2 menit yang lalu',
        unread: true,
        icon: 'shopping-bag'
    },
    {
        id: 2,
        type: 'pickup',
        title: 'Permintaan Penjemputan #89012',
        content: 'Lokasi: Jl. Sukajadi No. 123, Bandung',
        time: '5 menit yang lalu',
        unread: true,
        icon: 'map-marker-alt'
    },
    {
        id: 3,
        type: 'order',
        title: 'Pesanan Baru #12346',
        content: 'Widya Mustika - Rp 190.000',
        time: '10 menit yang lalu',
        unread: true,
        icon: 'shopping-bag'
    }
];

function renderNotifications(filter = 'all') {
    const container = document.getElementById('notification-list');
    container.innerHTML = '';
    
    // Filter notifications based on selected tab (all, orders, pickups)
    const filteredNotifications = filter === 'all' 
        ? notifications 
        : notifications.filter(n => n.type === filter);

    filteredNotifications.forEach(notification => {
        const html = `
            <div class="notification-item ${notification.unread ? 'unread' : 'read'}" data-id="${notification.id}" onclick="toggleReadStatus(${notification.id})">
                <div class="p-4 border-b hover:bg-purple-50">
                    <div class="flex items-start space-x-4">
                        <div class="${notification.unread ? 'bg-purple-100' : 'bg-gray-100'} rounded-full p-2">
                            <i class="fas fa-${notification.icon} ${notification.unread ? 'text-purple-600' : 'text-gray-600'} text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-semibold text-gray-800">${notification.title}</h3>
                                    <p class="text-gray-600 mt-1">${notification.content}</p>
                                    <span class="text-sm text-gray-500">${notification.time}</span>
                                </div>
                                <div class="action-buttons space-x-2">
                                    <button onclick="markAsRead(${notification.id})" class="text-purple-600 hover:text-purple-800 p-1">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button onclick="deleteNotification(${notification.id})" class="text-red-600 hover:text-red-800 p-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += html;
    });
    
    updateCounts();
}

function updateCounts() {
    document.getElementById('all-count').textContent = `(${notifications.length})`;
    document.getElementById('orders-count').textContent = 
        `(${notifications.filter(n => n.type === 'order').length})`;
    document.getElementById('pickups-count').textContent = 
        `(${notifications.filter(n => n.type === 'pickup').length})`;
}

function markAsRead(id) {
    const notification = notifications.find(n => n.id === id);
    if (notification) {
        notification.unread = false;
        renderNotifications(currentTab);
    }
}

function deleteNotification(id) {
    const index = notifications.findIndex(n => n.id === id);
    if (index > -1) {
        notifications.splice(index, 1);
        renderNotifications(currentTab);
    }
}

function toggleReadStatus(id) {
    const notification = notifications.find(n => n.id === id);
    if (notification) {
        notification.unread = !notification.unread;
        renderNotifications(currentTab);
    }
}

let currentTab = 'all';

document.addEventListener('DOMContentLoaded', () => {
    renderNotifications(); // Initial render for "all" notifications

    // Tab handling
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('text-purple-600', 'border-b-2', 'border-purple-600');
                b.classList.add('text-gray-500');
            });
            e.target.classList.add('text-purple-600', 'border-b-2', 'border-purple-600');
            e.target.classList.remove('text-gray-500');
            
            // Update current tab and render notifications accordingly
            currentTab = btn.dataset.tab;
            renderNotifications(currentTab); // Re-render based on the selected tab
        });
    });

    // Mark all as read
    document.getElementById('markAllRead').addEventListener('click', () => {
        notifications.forEach(n => n.unread = false);
        renderNotifications(currentTab);
    });
});
</script>

<?php include "template/footer_admin.php"; ?>
