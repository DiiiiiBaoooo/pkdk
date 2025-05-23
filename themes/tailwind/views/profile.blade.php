<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
           <img src="{{ asset('image/logo1.png') }}" alt="" style="mix-blend-mode:multiply">
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
      <li><a href="{{ route('appointments.my') }}">Lịch khám</a></li>
      <li><a href="{{ route('invoices.patient.unpaid') }}">Hóa đơn chưa thanh toán</a></li>


@endif

              
              
                @if(Auth::user()->isDoctor())
<li>
    <a href="{{ route('doctor.appointments.index') }}">Xem lịch hẹn</a>
</li>
<li><a href="{{ route('doctor.work-schedule') }}">Lịch làm việc</a></li>
<li><a href="{{ route('doctor.work-schedule.register') }}">Đăng ký lịch làm việc</a></li>


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
    <h2>Thông tin cá nhân</h2>
    <form action="{{ route('update') }}" method="POST">
    @csrf
   
   

    <div class="form-row">
        <div class="form-group">
            <label for="name">Họ tên:</label>
            <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
        </div>
        <div class="form-group">
            <label for="username">Tên tài khoản:</label>
            <input type="text" id="username" name="username" value="{{ Auth::user()->username }}" readonly>
        </div>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" readonly>
    </div>

    <div class="form-group">
        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" pattern="[0-9]{10,11}">
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="gender">Giới tính:</label>
            <select id="gender" name="gender">
                <option value="Nam" {{ old('gender', Auth::user()->gender) == 'Nam' ? 'selected' : '' }}>Nam</option>
                <option value="Nữ" {{ old('gender', Auth::user()->gender) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                <option value="Khác" {{ old('gender', Auth::user()->gender) == 'Khác' ? 'selected' : '' }}>Khác</option>
            </select>
        </div>
        <div class="form-group">
            <label for="date_of_birth">Ngày sinh:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', Auth::user()->date_of_birth) }}">
        </div>
    </div>

    <div class="form-group">
        <label for="address">Địa chỉ:</label>
        <input type="text" id="address" name="address" value="{{ old('address', Auth::user()->address) }}">
    </div>

    <button type="submit" class="btn-update">Cập nhật thông tin</button>
</form>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            
        </ul>
    </div>
@endif
 @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</div>

    </main>
</body>
</html>
