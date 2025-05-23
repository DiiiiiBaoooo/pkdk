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
            <h2>Đăng ký lịch khám</h2>
            {{-- hiển thị theo alert --}}
            @if(session('error'))
            <script>
                window.alert('{{ session('error') }}');
            </script>
            @endif
            @if(session('success'))
            <script>
                window.alert('{{ session('success') }}');
            </script>
            @endif

            <form method="POST" action="{{ route('appointments.store') }}">
                @csrf
                <select name="service_id" id="service_id" required>
                    <option >-- Chọn dịch vụ --</option>
                    @foreach($services as $service)
                        <option value="{{ $service->service_id }}">{{ $service->name }}</option>
                    @endforeach
                </select>

                <select name="doctor_id" id="doctor_id" required>
                    <option value="">-- Chọn bác sĩ --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->doctor_id }}">{{ $doctor->user->name ?? $doctor->name }}</option>
                    @endforeach
                </select>

                <div id="work-schedule-info" style="margin-top: 20px; padding: 15px; background: #fffbe6; border: 1px solid #f5c518; border-radius: 6px;">
                    <strong>Lịch làm việc của bác sĩ sẽ hiển thị ở đây...</strong>
                </div>

                <div id="work-schedule-calendar" style="margin-top: 20px;"></div>

                <input type="hidden" name="appointment_date" id="appointment_date">
                <input type="hidden" name="appointment_shift" id="appointment_shift">

                <button type="submit">Đăng ký</button>
            </form>
        </main>
    </div>

    
</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const doctorSelect = document.getElementById("doctor_id");
        const calendarDiv = document.getElementById("work-schedule-calendar");
        const appointmentDateInput = document.getElementById("appointment_date");
        const appointmentShiftInput = document.getElementById("appointment_shift");

        let calendar = null;

        doctorSelect.addEventListener("change", function () {
            const doctorId = this.value;
            if (!doctorId) {
                if (calendar) calendar.destroy();
                calendarDiv.innerHTML = "<strong>Vui lòng chọn bác sĩ.</strong>";
                return;
            }

            fetch(`/api/doctors/${doctorId}/work-schedule`)
                .then(response => response.json())
                .then(data => {
                    if (calendar) calendar.destroy();
                    if (!data.length) {
                        calendarDiv.innerHTML = "<em>Bác sĩ chưa có lịch làm việc.</em>";
                        return;
                    }
                    calendarDiv.innerHTML = ""; // clear

                    // Chuyển đổi dữ liệu sang event cho FullCalendar
                    const events = data.map(item => ({
                        title: item.shift.charAt(0).toUpperCase() + item.shift.slice(1),
                        start: item.work_date,
                        extendedProps: { shift: item.shift }
                    }));

                    calendar = new FullCalendar.Calendar(calendarDiv, {
                        initialView: 'dayGridMonth',
                        locale: 'vi',
                        events: events,
                        eventClick: function(info) {
                            appointmentDateInput.value = info.event.startStr;
                            appointmentShiftInput.value = info.event.extendedProps.shift;

                            // Reset all events to default color
                            calendar.getEvents().forEach(function(event) {
                                event.setProp('backgroundColor', '#3c8dbc');
                                event.setProp('borderColor', '#3c8dbc');
                            });

                            // Set selected event to green
                            info.event.setProp('backgroundColor', '#28a745');
                            info.event.setProp('borderColor', '#28a745');
                        }
                    });
                    calendar.render();
                })
                .catch(err => {
                    console.error("Lỗi:", err);
                    calendarDiv.innerHTML = "<span style='color:red;'>Không thể tải lịch làm việc.</span>";
                });
        });
    });
</script>
