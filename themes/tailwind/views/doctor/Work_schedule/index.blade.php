<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch làm việc</title>
    <link rel="stylesheet" href="/css/doctor.css">
    <!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.css' rel='stylesheet' />

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>


    <style>
      .profile-container {
    display: flex;
    justify-content: center; /* căn giữa theo chiều ngang */
    margin: 40px auto;
    max-width: 1000px;
    background-color: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

/* Cột bên trái */
.profile-menu {
    width: 250px;
    background-color: #f0f0f5; /* nền xám nhạt */
    padding: 20px;
    box-sizing: border-box;
    border-right: 1px solid #ddd;
    min-height: 100%;
}

.profile-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.profile-menu ul li {
    margin-bottom: 12px;
}

.profile-menu ul li a {
    text-decoration: none;
    color: #333;
    display: block;
    padding: 10px 14px;
    border-radius: 6px;
    transition: background-color 0.2s;
}

.profile-menu ul li a:hover {
    background-color: #dbe4ff; /* màu hover xanh nhạt */
}

/* Cột nội dung bên phải */
.profile-info {
    flex: 1;
    padding: 30px;
    background-color: #ffffff;
    box-sizing: border-box;
}

.profile-info h2 {
    margin-top: 0;
    color: #2c3e50;
}

.profile-info p {
    margin: 10px 0;
    font-size: 16px;
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
           <img src="/image/logo1.png" alt="" style="mix-blend-mode:multiply">
            <nav>
                <ul>
                    <li><a href="/homepage">Trang chủ</a></li>
                    <li><a href="/gioithieu">Giới thiệu</a></li>
                    <li><a href="#">Dịch vụ chính</a></li>
                    <li><a href="#">Tin tức</a></li>
                    <li><a href="#">Liên hệ</a></li>
                  @if(Auth::check())
                  @if(Auth::user()->role == 'patient')
                    <li><a href="{{ route('appointments.create') }}" class="btn-dk">Đăng ký khám</a></li>
                    @elseif(Auth::user()->role == 'doctor')
                    <li><a href="{{ route('doctor.appointments.index') }}" class="btn-dk">Xem lịch hẹn</a></li>
                  @endif
                  @endif
                
                 
                 <!-- Kiểm tra người dùng đã đăng nhập chưa -->
                 @guest
                     <li><a href="/dangnhap">Đăng nhập</a></li>
    <li><a href="/dangky">Đăng ký</a></li>
                 @endguest
                   @if(Auth::check())
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
    <!-- Link logout sẽ gọi form -->
    
@else

@endif

                 
                </ul>
            </nav>
        </div>
    </header>


    <!-- PHẦN HỒ SƠ -->
    <main class="profile-container">
        <div class="profile-menu">
            <ul>
                                <li><a href="{{ route('show.profile')}}">Thông tin cá nhân</a></li>

                @if(Auth::user()->isPatient())
      <li><a href="{{ route('medicalRecord.show')}}">Hồ sơ bệnh án</a></li>
      <li><a href="{{ route('patient.payment-history') }}">Lịch sử thanh toán</a></li>

@endif

              
              
                @if(Auth::user()->isDoctor())
<li>
    <a href="{{ route('doctor.appointments.index') }}">Xem lịch hẹn</a>
</li>
@endif
@if(Auth::user()->isAccountant())
<li><a href="{{ route('invoices.index') }}">Quản lý hóa đơn</a></li>
<li><a href="{{ route('invoices.selectPatient') }}">Lập hóa đơn</a></li>
@endif
@if(Auth::user()->isPharmacist())
<li><a href="{{ route('medicines.statistics') }}">Quản lý thuốc</a></li>
<li><a href="{{ route('medicines.create') }}">Nhập thuốc mới</a></li>
<li><a href="{{ route('medicines.updateForm') }}">Nhập thuốc vào kho</a></li>
<li><a href="{{ route('prescriptions.patients') }}">Xem đơn thuốc</a></li>
@endif
@if(Auth::user()->isHR())
<li><a href="{{ route('employees.index') }}">Quản lý nhân viên</a></li>
<li><a href="{{ route('employees.create') }}">Thêm nhân viên</a></li>
@endif
  <li><a href="#">Đổi mật khẩu</a></li>
                <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a></li>
            </ul>
        </div>

        <div class="profile-info">
            <h2>Lịch làm việc trong tháng</h2>
            <div id="calendar"></div>
           <!-- Modal -->
<div id="workScheduleModal" style="display: none; position: fixed; top: 0; left: 0;
width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999;">

<div style="background: white; width: 400px; margin: 100px auto; padding: 20px;
  border-radius: 8px; position: relative;">
<span id="closeModal" style="position: absolute; top: 10px; right: 15px;
    cursor: pointer; font-size: 20px;">&times;</span>

<h3>Đăng ký lịch làm việc</h3>
<form action="{{ route('doctor.work-schedule.register') }}" method="POST">
  @csrf
  <input type="hidden" name="work_date" id="modal_work_date">

  <label for="shift">Chọn ca làm:</label>
  <select name="shift" id="shift" required>
    <option value="">-- Chọn ca --</option>
    <option value="morning">Sáng</option>
    <option value="afternoon">Chiều</option>
    <option value="evening">Tối</option>
  </select>

  <br><br>
  <button type="submit">Lưu lịch</button>
</form>

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
</div>
</div>

            
</div>

    </main>
</body>
</html>
<script>
 document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'vi',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        events: @json($workSchedules),
        eventColor: '#3c8dbc',
        eventDisplay: 'block',

        dateClick: function(info) {
    const selectedDate = info.dateStr;
    document.getElementById('modal_work_date').value = selectedDate;
    document.getElementById('workScheduleModal').style.display = 'block';
    
}


    });
    

    calendar.render();
});

// Đóng modal khi ấn dấu X
document.getElementById('closeModal').onclick = function() {
    document.getElementById('workScheduleModal').style.display = 'none';
};

// Đóng modal khi click ra ngoài vùng modal
window.onclick = function(event) {
    var modal = document.getElementById('workScheduleModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};

    </script>
    
    