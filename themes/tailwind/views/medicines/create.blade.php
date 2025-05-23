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

.profile-info form {
    max-width: 800px;
    margin: 0 auto;
}

.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    flex: 1;
    margin-bottom: 0;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #333;
    font-weight: 500;
    font-size: 15px;
}

.search-input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.3s ease;
    background-color: #fff;
}

.search-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    outline: none;
}

select.search-input {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 35px;
}

.profile-info button[type="submit"] {
    width: 100%;
    padding: 14px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.profile-info button[type="submit"]:hover {
    background-color: #0056b3;
}

/* Validation States */
.search-input:invalid {
    border-color: #dc3545;
}

.search-input:valid {
    border-color: #28a745;
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
        <h3>Nhập thuốc mới</h3>
        <form action="{{ route('medicines.store') }}" method="POST" class="mb-3">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Tên thuốc:</label>
                    <input type="text" name="name" id="name" required class="search-input">
                </div>
                <div class="form-group">
                    <label for="type">Loại thuốc:</label>
                    <select name="type" id="type" required class="search-input">
                        <option value="">-- Chọn loại thuốc --</option>
                        <option value="tablet">Thuốc viên</option>
                        <option value="liquid">Thuốc nước</option>
                        <option value="capsule">Viên nang</option>
                        <option value="injection">Thuốc tiêm</option>
                        <option value="topical">Thuốc bôi ngoài da</option>
                        <option value="powder">Thuốc bột</option>
                        <option value="drops">Thuốc nhỏ</option>
                        <option value="inhaler">Thuốc hít</option>
                        <option value="other">Khác</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="quantity">Số lượng:</label>
                    <input type="number" name="quantity" id="quantity" min="1" required class="search-input">
                </div>
                <div class="form-group">
                    <label for="purchase_price">Giá nhập kho:</label>
                    <input type="number" name="purchase_price" id="purchase_price" min="1" required class="search-input">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Giá bán:</label>
                    <input type="number" name="price" id="price" min="1" required class="search-input">
                </div>
                <div class="form-group">
                    <label for="expiration_date">Hạn sử dụng:</label>
                    <input type="date" name="expiration_date" id="expiration_date" required class="search-input">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="warehouse_id">Kho:</label>
                    <select name="warehouse_id" id="warehouse_id" required class="search-input">
                        <option value="">-- Chọn kho --</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }} - {{ $warehouse->location }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit">Thêm thuốc</button>
            </div>
        </form>
      </div>
  </main>
 
</body>
</html>