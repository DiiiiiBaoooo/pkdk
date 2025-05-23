<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <style>
  /* Reset default margins and padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Header Styling */
.header {
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.top-bar {
    display: flex;
    justify-content: space-between;
    padding: 10px 20px;
    background-color: #f8f9fa;
    font-size: 14px;
    color: #333;
}

.logo-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px;
}

.logo-nav img {
    max-height: 50px;
}

.logo-nav nav ul {
    display: flex;
    list-style: none;
    gap: 20px;
}

.logo-nav nav ul li a {
    text-decoration: none;
    color: #333;
    font-size: 16px;
}

.logo-nav nav ul li a:hover {
    color: #007bff;
}

.logo-nav .btn-dk {
    background-color: #dc3545;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    transition: background-color 0.3s;
}

.logo-nav .btn-dk:hover {
    background-color: #c82333;
}

.dropdown {
    position: relative;
}

.dropbtn {
    text-decoration: none;
    color: #333;
    font-size: 16px;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 6px;
    min-width: 150px;
    z-index: 1;
}

.dropdown-content a {
    display: block;
    padding: 10px 14px;
    color: #333;
    text-decoration: none;
}

.dropdown-content a:hover {
    background-color: #f0f0f5;
}

.dropdown:hover .dropdown-content {
    display: block;
}

/* Profile Container */
.profile-container {
    display: flex;
    justify-content: center;
    margin: 40px auto;
    max-width: 1100px;
    background-color: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

/* Profile Menu */
.profile-menu {
    width: 250px;
    background-color: #f0f0f5;
    padding: 20px;
    box-sizing: border-box;
    border-right: 1px solid #ddd;
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
    background-color: #e0e0e0;
}

/* Profile Info Styling */
.profile-info {
    flex: 1;
    padding: 30px;
    background-color: #ffffff;
}

.profile-info h2 {
    margin-bottom: 20px;
    color: #2c3e50;
    font-size: 24px;
}

.profile-info p {
    margin: 10px 0;
    color: #333;
    font-size: 16px;
    line-height: 1.5;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

thead {
    background-color: #f8f9fa;
}

th, td {
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid #dee2e6;
}

th {
    font-weight: 600;
    color: #495057;
}

tr:hover {
    background-color: #f8f9fa;
}

/* Button Styling */
button[type="submit"] {
    display: inline-block;
    padding: 12px 24px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 20px;
}

button[type="submit"]:hover {
    background-color: #218838;
}

/* Alert Messages */
.alert {
    padding: 12px 16px;
    margin: 10px 0;
    border-radius: 4px;
    font-size: 14px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Responsive Design */
@media (max-width: 768px) {
    .profile-container {
        flex-direction: column;
        margin: 20px;
    }

    .profile-menu {
        width: 100%;
        border-right: none;
        border-bottom: 1px solid #ddd;
    }

    .profile-info {
        padding: 20px;
    }

    .form-row {
        flex-direction: column;
        gap: 15px;
    }
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
        <h2>Đơn thuốc của bệnh nhân: {{ $appointment->patient->user->name }}</h2>
        <p>Bác sĩ kê đơn: {{ $appointment->doctor->user->name }}</p>
        <p>Ngày khám: {{ \Carbon\Carbon::parse($appointment->time)->format('d/m/Y') }}</p>
        
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Tên thuốc</th>
                 
                    <th>Số lượng</th>
                  
                </tr>
            </thead>
            <tbody>
            @foreach($appointment->prescription->prescriptionDetails as $detail)
                <tr>
                    <td>{{ $detail->medicines->name }}</td>
               
                    <td>{{ $detail->quantity }}</td>
                  
                </tr>
            @endforeach
            </tbody>
        </table>
        <form action="{{ route('prescriptions.confirm', ['appointment' => $appointment->appointment_id]) }}" method="POST" style="margin-top: 20px;">
            @csrf
            <button type="submit" style="
                padding: 12px 24px;
                background-color: #28a745;
                color: white;
                border: none;
                border-radius: 6px;
                font-size: 16px;
                cursor: pointer;
            ">
                Xác nhận cấp thuốc
            </button>
        </form>
        @if(session('success'))
    <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div style="color: red; margin-bottom: 10px;">{{ session('error') }}</div>
@endif

      </div>
  </main>
 
</body>
</html>