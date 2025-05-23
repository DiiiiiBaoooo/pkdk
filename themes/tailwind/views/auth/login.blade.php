<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        
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
    




                 
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="login-container">
        <h2>Đăng nhập</h2>

       <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="phone">SDT</label>
                <input type="text" name="phone" id="phone" required value="{{ old('phone') }}">
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" name="password" id="password" required>
            </div>

            

            <button type="submit">Đăng nhập</button>
        
    @if ($errors->any() && old('_token'))

            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        </form>
    </div>
    </main>
</body>
</html>
