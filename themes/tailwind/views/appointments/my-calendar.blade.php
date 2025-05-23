<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký khám bệnh</title>
    <link rel="stylesheet" href="{{ asset('css/createAppointment.css') }}">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding-top: 120px; /* Đảm bảo nội dung không bị header cố định che */
            display: flex; /* Sử dụng flexbox cho toàn bộ body */
            min-height: 100vh;
        }
        .container {
            
            display: flex;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }
        aside.sidebar {
            width: 25%; /* Độ rộng của sidebar */
            margin-left: -25px;
            padding: 20px;
            position: relative;
            top: 0;
        }
        main {
            width: 70%; /* Độ rộng của main */
            padding: 20px;
            background-color: #f9f9f9; /* Màu nhạt cho form */
            border: 1px solid #e0e0e0; /* Viền nhạt */
            border-radius: 10px; /* Bo tròn viền */
            margin-left: 20px; /* Khoảng cách giữa sidebar và main */
            height: fit-content;
        }
        form {
            display: block;
            width: 100%;
            margin-top: 20px;
        }
        .form-row {
            display: flex;
            align-items: center;
            gap: 10px; /* Khoảng cách giữa các phần tử */
            margin-bottom: 10px;
        }
        label {
            font-weight: bold;
            min-width: 100px; /* Đảm bảo label có chiều rộng cố định */
        }
        select, input[type="date"], button {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px; /* Bo tròn cho select, input, và button */
            font-size: 16px;
            background-color: #fff; /* Nền trắng */
        }
        button {
            background-color: #026414;
            color: white;
            border: none;
            cursor: pointer;
            width: 100px; /* Độ rộng cố định cho button */
            padding: 10px;
            border-radius: 4px;
        }
        button:hover {
            background-color: #e60000;
        }
        .alert {
            margin: 10px 0;
            padding: 10px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="top-bar">
            <span>Địa chỉ: Tầng 1, Số 152 Xã Đàn - Đống Đa - Hà Nội</span>
            <span>Hotline: 024.367.XXX.XX - 082.999.XXXX</span>
        </div>
        <div class="logo-nav">
            <img src="{{ asset('image/logo1.png') }}" alt="" style="mix-blend-mode: multiply">
            <nav>
                <ul>
                    <li><a href="/homepage">Trang chủ</a></li>
                    <li><a href="/gioithieu">Giới thiệu</a></li>
                    <li><a href="#">Dịch vụ chính</a></li>
                    <li><a href="#">Tin tức</a></li>
                    <li><a href="#">Liên hệ</a></li>
                    <li><a href="{{ route('appointments.create') }}" class="btn-dk">Đăng ký khám</a></li>
                    @guest
                        <li><a href="/dangnhap">Đăng nhập</a></li>
                        <li><a href="/dangky">Đăng ký</a></li>
                    @endguest
                    @auth
                        <li class="dropdown">
                            <a href="#" class="dropbtn">
                                Xin chào, {{ Auth::user()->name }} <i class="arrow-down"></i>
                            </a>
                            <div class="dropdown-content">
                                <a href="/profile">Hồ sơ</a>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Đăng xuất
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    <div class="container" style="margin-top: 35px;">
        <aside class="sidebar">
            <h3>DANH MỤC BỆNH</h3>
            <ul>
                <li>Kế hoạch hóa gia đình</li>
                <li>Rối loạn kinh nguyệt</li>
                <li>Thẩm mỹ vùng kín</li>
                <li>Viêm phụ khoa</li>
                <li>Vô sinh hiếm muộn</li>
            </ul>

            <div class="appointment-box">
                <h4>ĐẶT LỊCH KHÁM</h4>
                <input type="text" placeholder="Họ và tên">
                <input type="text" placeholder="Số điện thoại">
                <select>
                    <option>Thời gian khám</option>
                    <option>08:00 - 09:00</option>
                    <option>09:00 - 10:00</option>
                </select>
                <button>ĐĂNG KÝ KHÁM</button>
            </div>
        </aside>

        <main>
            <h2 style="text-align:center;margin:20px 0;">Lịch hẹn của tôi</h2>
            <div id="my-calendar" style="max-width:900px;margin:0 auto;"></div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var calendarEl = document.getElementById('my-calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        locale: 'vi',
                        events: '/api/my-appointments',
                        eventColor: '#007bff',
                        eventDisplay: 'block',
                        eventClick: function(info) {
                            const event = info.event.extendedProps;
                            alert(
                                `Dịch vụ: ${event.service}\n` +
                                `Ca: ${event.shift}\n` +
                                `Bác sĩ: ${event.doctor}\n` +
                                `Trạng thái: ${event.status}`
                            );
                        }
                    });
                    calendar.render();
                });
            </script>
        </main>
    </div>

    
</body>
</html>

