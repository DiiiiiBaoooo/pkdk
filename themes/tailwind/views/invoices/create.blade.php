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
        justify-content: center;
        margin: 40px auto;
        max-width: 1000px;
        background-color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
      }

      .profile-menu {
        width: 250px;
        background-color: #f0f0f5;
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
        background-color: #dbe4ff;
      }

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

      table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        border: 1px solid #ddd;
      }

      th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
      }

      th {
        background-color: #f4f4f4;
      }

      tr:hover {
        background-color: #f9f9f9;
      }

      .view-prescription-link {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
      }

      .view-prescription-link:hover {
        text-decoration: underline;
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
<li><a href="#">Đổi mật khẩu</a></li>
            <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a></li>
        </ul>
    </div>

        
    </main>
</body>
</html>