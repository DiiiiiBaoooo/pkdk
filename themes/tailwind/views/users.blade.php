<x-app-layout>
    <x-slot name="header">
        <notification-component :current-user='@json(Auth::user())' />
    </x-slot>
<div id="notification-container" class="  fixed top-0 right-0 m-4 p-4 bg-white shadow-lg rounded-lg">

</div>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8" style="margin-top: 100px;">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mt-4">Bệnh nhân</h2>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mt-4">
                        @foreach ($users as $user)
                        @if($user->role == 'patient')
                            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <a href="{{ route('chat', $user) }}" class="flex items-center w-full" data-user-id="{{ $user->user_id }}">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                            @if ($user->unreadMessages() > 0)
                                                <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-600 rounded-full notification-badge" data-user-id="{{ $user->user_id }}">
                                                    {{ $user->unreadMessages() }}
                                                </span>
                                            @endif
                                            @if ($user->isOnline())
                                                <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-600 rounded-full notification-badge" data-user-id="{{ $user->user_id }}">
                                                    Online
                                                </span>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endforeach
                    </div>
                    <h2 class="mt-4">Bác sĩ</h2>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mt-4">
                        @foreach ($users as $user)
                        @if($user->role == 'doctor')
                            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <a href="{{ route('chat', $user) }}" class="flex items-center w-full" data-user-id="{{ $user->user_id }}">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                            @if ($user->unreadMessages() > 0)
                                                <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-600 rounded-full notification-badge" data-user-id="{{ $user->user_id }}">
                                                    {{ $user->unreadMessages() }}
                                                </span>
                                            @endif
                                            @if ($user->isOnline())
                                                <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-600 rounded-full notification-badge" data-user-id="{{ $user->user_id }}">
                                                    Online
                                                </span>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endforeach
                    </div>
                    <h2 class="mt-4">Nhân sự</h2>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mt-4">
                        @foreach ($users as $user)
                        @if($user->role == 'hr')
                            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <a href="{{ route('chat', $user) }}" class="flex items-center w-full" data-user-id="{{ $user->user_id }}">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                            @if ($user->unreadMessages() > 0)
                                                <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-600 rounded-full notification-badge" data-user-id="{{ $user->user_id }}">
                                                    {{ $user->unreadMessages() }}
                                                </span>
                                            @endif
                                            @if ($user->isOnline())
                                                <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-600 rounded-full notification-badge" data-user-id="{{ $user->user_id }}">
                                                    Online
                                                </span>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endforeach
                    </div>
                    <h2 class="mt-4">Dược sĩ</h2>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mt-4">
                        @foreach ($users as $user)
                        @if($user->role == 'pharmacist')
                            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <a href="{{ route('chat', $user) }}" class="flex items-center w-full" data-user-id="{{ $user->user_id }}">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                            @if ($user->unreadMessages() > 0)
                                                <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-600 rounded-full notification-badge" data-user-id="{{ $user->user_id }}">
                                                    {{ $user->unreadMessages() }}
                                                </span>
                                            @endif
                                            @if ($user->isOnline())
                                                <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-600 rounded-full notification-badge" data-user-id="{{ $user->user_id }}">
                                                    Online
                                                </span>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endforeach
                    </div>
                    <h2 class="mt-4">Kế toán</h2>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mt-4">
                        @foreach ($users as $user)
                        @if($user->role == 'accountant')
                            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <a href="{{ route('chat', $user) }}" class="flex items-center w-full" data-user-id="{{ $user->user_id }}">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                            @if ($user->unreadMessages() > 0)
                                            <span class="unread-messages notification-badge" data-user-id="{{ $user->user_id }}">
                                                {{ $user->unreadMessages() }}
                                            </span>
                                            @endif
                                            @if ($user->isOnline())
                                                <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-600 rounded-full notification-badge" data-user-id="{{ $user->user_id }}">
                                                    Online
                                                </span>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@vite('themes/tailwind/css/users.css')
<style>
    #notification-container {
        position: fixed;
        top: 10px;
        padding: 10px;
        right: 10px;
        z-index: 1000;
        background-color:white;
    }
    
    .notification {
        background-color: #4caf50; /* màu xanh lá nổi bật */
        font-size: 16px;
        color: white;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        opacity: 0;
        animation: fadeInOut 9s ease-in-out forwards;
    }
    
    /* Hiệu ứng fade-in/fade-out */
    @keyframes fadeInOut {
        0% { opacity: 0; transform: translateY(-10px); }
        10% { opacity: 1; transform: translateY(0); }
        90% { opacity: 1; }
        100% { opacity: 0; transform: translateY(-10px); }
    }
    </style>
{{--     
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationContainer = document.getElementById('notification-container');
        const notificationBadges = document.querySelectorAll('.notification-badge');
        function showNotification(message){
    let notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = `Message: ${message}`;
    notificationContainer.appendChild(notification);
    notificationContainer.style.display = 'block';
    setTimeout(()=>{
        notificationContainer.removeChild(notification);
    }, 9000);
}

        // không lấy được id của user
        const userId = window.location.pathname.split('/').pop();
        window.Echo.private('users.89').listen('PrivateNotificationEvent',(e)=>{
            showNotification(e.message);
        });
    });
</script> --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const userId = window.location.pathname.split('/').pop();
        const notificationContainer = document.getElementById('notification-container');
        const targetBadge = document.querySelector(`.notification-badge[data-user-id="${userId}"]`);
        function showNotification(message, unread_messages){
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.textContent = `Message: ${message}`;

            // Thêm vào container
            notificationContainer.appendChild(notification);
            // cập nhật số tin nhắn chưa đọc
            const unreadMessages = document.getElementById('unread_messages');
            if (unreadMessages) {
                unreadMessages.innerText = unread_messages;
            }
            // Xóa sau 9s
            setTimeout(() => {
                notification.remove();
            }, 9000);
        }

        // Thay userId bằng user thực tế nếu cần
      

        // Lắng nghe kênh Private của user (thay bằng userId động nếu có)
        window.Echo.private(`users.${userId}`).listen('PrivateNotificationEvent', (e) => {
            showNotification(e.message, e.unread_messages);
        });
    });
</script> --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const userId = window.location.pathname.split('/').pop();
    const notificationContainer = document.getElementById('notification-container');

    function showNotification(message, unread_messages, targetUserId) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = `Message: ${message}`;

        notificationContainer.appendChild(notification);

        // Tìm badge theo data-user-id đúng user gửi notification
        const unreadMessagesBadge = document.querySelector(`.unread-messages[data-user-id="${targetUserId}"]`);

        if (unreadMessagesBadge) {
            unreadMessagesBadge = unread_messages;
        }

        setTimeout(() => {
            notification.remove();
        }, 4000);
    }

    // Lắng nghe kênh private user hiện tại
    window.Echo.private(`users.${userId}`).listen('PrivateNotificationEvent', (e) => {
        // e.message: nội dung tin nhắn
        // e.unread_messages: số lượng tin nhắn chưa đọc
        // e.user_id: user id người nhận hoặc gửi tùy backend bạn gửi
        showNotification(e.message, e.unread_messages, e.user_id || userId);
    });
});
</script>