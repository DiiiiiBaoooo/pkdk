<template>
    <div class="relative float-end cursor-pointer">
        <!-- Icon chuông -->
        <div @click="toggleNotifications">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-10 h-10 text-gray-700 hover:text-blue-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 00-4 0v1.341C8.67 6.165 8 7.388 8 9v5.159c0 .538-.214 1.055-.595 1.436L6 17h5m4 0v1a3 3 0 11-6 0v-1m6 0H9"
                />
            </svg>
            <!-- Badge số lượng thông báo chưa đọc -->
            <span
                v-if="unreadCount > 0"
                class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full animate-ping"
            ></span>
            <span
                v-if="unreadCount > 0"
                class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full"
            >
                {{ unreadCount }}
            </span>
        </div>
        <!-- Dropdown thông báo -->
        <div
            v-if="showNotifications"
            class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-10 max-h-96 overflow-y-auto"
        >
            <div class="py-1">
                <div
                    v-for="notification in notifications"
                    :key="notification.id"
                    class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer"
                    @click="goToChat(notification.sender_id)"
                >
                    <p><strong>{{ notification.sender_name }}</strong>: {{ notification.message }}</p>
                    <p class="text-xs text-gray-500">{{ notification.created_at }}</p>
                </div>
                <div v-if="!notifications.length" class="px-4 py-2 text-sm text-gray-500">
                    Không có thông báo mới
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    currentUser: { type: Object, required: true },
});

const notifications = ref([]);
const unreadCount = ref(0);
const showNotifications = ref(false);

const fetchNotifications = async () => {
    try {
        const response = await axios.get('/notifications');
        notifications.value = response.data.notifications;
        unreadCount.value = response.data.unread_count;
        console.log('Fetched notifications:', notifications.value);
    } catch (error) {
        console.error('Error fetching notifications:', error);
    }
};

const toggleNotifications = () => {
    showNotifications.value = !showNotifications.value;
    if (showNotifications.value) {
        markNotificationsAsRead();
    }
};

const markNotificationsAsRead = async () => {
    try {
        await axios.post('/notifications/mark-as-read');
        unreadCount.value = 0;
        console.log('Notifications marked as read');
    } catch (error) {
        console.error('Error marking notifications as read:', error);
    }
};

const goToChat = (senderId) => {
    showNotifications.value = false;
    window.location.href = `/chat/${senderId}`;
};

onMounted(() => {
    fetchNotifications();

    // Lắng nghe sự kiện thông báo mới
    const channel = window.Echo.private(`notifications.${props.currentUser.user_id}`);
    console.log('Subscribing to channel:', `notifications.${props.currentUser.user_id}`);

    // Debug kết nối WebSocket
    window.Echo.connector.pusher.connection.bind('connected', () => {
        console.log('WebSocket connected');
    });

    window.Echo.connector.pusher.connection.bind('disconnected', () => {
        console.log('WebSocket disconnected');
    });

    window.Echo.connector.pusher.connection.bind('error', (error) => {
        console.error('WebSocket error:', error);
    });

    channel.listen('NotificationSent', (e) => {
        console.log('Received notification:', e);
        notifications.value.unshift({
            id: e.id,
            message: e.message,
            sender_id: e.sender_id,
            sender_name: e.sender_name,
            created_at: e.created_at,
        });
        unreadCount.value++;
        console.log('Updated notifications:', notifications.value);
    });

    // Lưu channel để cleanup sau này
    window.notificationChannel = channel;
});

onUnmounted(() => {
    // Cleanup WebSocket listener
    if (window.notificationChannel) {
        window.notificationChannel.stopListening('NotificationSent');
        window.notificationChannel = null;
    }
});
</script>

<style scoped>
.notification-button {
    position: relative;
    cursor: pointer;
}

.notification-button svg {
    width: 24px;
    height: 24px;
    color: #4b5563;
    transition: color 0.3s ease;
}

.notification-button svg:hover {
    color: #2563eb;
}

.notification-badge {
    position: absolute;
    top: 0;
    right: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background-color: #2563eb;
    color: #fff;
    font-size: 10px;
}

.notification-badge:hover {
    background-color: #1d4ed8;
}
</style>
