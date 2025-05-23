<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <style>
        /* Thêm CSS nếu cần */
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
   <main>
    <div class="login-container">
        <h2>Đăng ký</h2>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-row">
                <!-- Thông tin tài khoản -->
                <div class="form-column">
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="tel" name="phone" id="phone" required value="{{ old('phone') }}">
                    </div>

                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Nhập lại mật khẩu</label>
                        <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                    </div>
                </div>

                <!-- Thông tin cá nhân -->
                <div class="form-column">
                    <h3 style="
    margin: 0;
    float: right;
">Thông tin cá nhân</h3>
                    <div class="form-group">
                        <label for="username">Tên tài khoản</label>
                        <input type="text" name="username" placeholder="Nhập tên tài khoản" required value="{{ old('username') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input type="text" name="name" placeholder="Nhập Họ và tên" required value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="gender">Giới tính</label>
                        <select name="gender" id="gender" required>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Ngày sinh</label>
                        <input type="date" name="date" id="date" required value="{{ old('date') }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input type="text" name="address" placeholder="Nhập địa chỉ" required value="{{ old('address') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="Nhập email" required value="{{ old('email') }}">
                    </div>
                </div>
            </div>

            <button type="submit">Đăng ký</button>
        </form>

        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </div>
</main>

</body>
</html>
