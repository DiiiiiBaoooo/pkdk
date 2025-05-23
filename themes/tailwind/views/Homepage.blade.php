<!-- resources/views/homepage.blade.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phòng Khám Đa Khoa Quốc Tế Hà Nội</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        *{
            margin:0 auto;
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
        <a href="/users/{{ Auth::user()->user_id }}">Chat box</a>
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

    <section class="hero">
        <img src="/image/slider1.png" alt="Banner chính" width="100%">
        <h2>Chung tay cùng cộng đồng đẩy lồi dịch Sars-CoV-2</h2>
    </section>

    <section class="services">
  <h2>Dịch vụ của chúng tôi</h2>
  <p>Phòng tiêm của chúng tôi cung cấp tất cả các loại dịch vụ</p>
  <div class="service-cards">
    <div class="card">
      <img src="/image/img1.jpg" alt="Vaccine cho trẻ 4-6 tuổi" />
      <h3>Gói vắc xin cho trẻ trước khi đi học (4-6 tuổi)</h3>
      <a href="#">Xem ngay <span>➜</span></a>
    </div>
    <div class="card">
      <img src="/image/img2.jpg" alt="Vaccine cho trẻ 9-18 tuổi" />
      <h3>Gói vắc xin cho trẻ vị thành niên (9-18 tuổi)</h3>
      <a href="#">Xem ngay <span>➜</span></a>
    </div>
    <div class="card">
      <img src="/image/img3.png" alt="Vaccine cho trẻ sơ sinh" />
      <h3>Gói vắc xin cho trẻ sơ sinh</h3>
      <a href="#">Xem ngay <span>➜</span></a>
    </div>
    <div class="card">
      <img src="/image/img4.png" alt="Vaccine cho phụ nữ mang thai" />
      <h3>Gói vắc xin cho phụ nữ sắp & trong khi mang thai</h3>
      <a href="#">Xem ngay <span>➜</span></a>
    </div>
  </div>
</section>

<section class="about-section">
  <div class="about-text">
    <h2>Giới thiệu về chúng tôi</h2>
    <p>
      Phòng khám đa khoa chúng tôi cung cấp dịch vụ chăm sóc sức khỏe chất lượng cao, hiện đại,
      với hệ thống quản lý bằng phần mềm tiên tiến, giúp bệnh nhân trải nghiệm quy trình khám chữa bệnh nhanh chóng và thuận tiện.
    </p>
    <img src="/image/about.png" alt="Vaccine cho phụ nữ mang thai" />
  </div>
  <div class="about-stats">
  
    <div class="stat-box stat-green"><i class="fas fa-users"></i>05+<br>Đa dạng độ tuổi, đối tượng</div>
    <div class="stat-box stat-orange"><i class="fas fa-certificate"></i>100%<br>Chứng nhận quốc tế</div>
    <div class="stat-box stat-red"><i class="fas fa-laptop-medical"></i>100%<br>Quản lý bằng phần mềm</div>
  </div>

</section>

<section class="doctors-section">
  <h2>Đội ngũ bác sĩ chuyên khoa</h2>
  <p>
    Phòng khám Đa khoa Quốc tế quy tụ đội ngũ bác sĩ Sản Phụ khoa hùng hậu, có trên 20 năm kinh nghiệm,
    từng công tác tại các bệnh viện chuyên khoa lớn như Phụ sản Trung ương, Phụ sản Hà Nội, Thanh Nhàn...
  </p>

  <div class="doctor-cards">
    <div class="doctor-card">
      <img src="/image/bs1.png" alt="BS. Trần Thúy Vân" />
      <div class="info">
        <h3>BS. TRẦN THÚY VÂN</h3>
        <p>CK I - SẢN PHỤ KHOA</p>
        <button>ĐẶT LỊCH HẸN</button>
      </div>
    </div>
    <div class="doctor-card">
      <img src="/image/bs2.png" alt="BS. Tạ Thị Hồng Duyên" />
      <div class="info">
        <h3>BS. TẠ THỊ HỒNG DUYÊN</h3>
        <p>CK I - SẢN PHỤ KHOA</p>
        <button>ĐẶT LỊCH HẸN</button>
      </div>
    </div>
    <div class="doctor-card">
      <img src="/image/bs3.png" alt="BS. Nguyễn Thị Thu Hiền" />
      <div class="info">
        <h3>BS. NGUYỄN THỊ THU HIỀN</h3>
        <p>CK I - SẢN PHỤ KHOA</p>
        <button>ĐẶT LỊCH HẸN</button>
      </div>
    </div>
  </div>
</section>


    <footer class="footer">
        <p>&copy; 2025 Phòng Khám Đa Khoa Quốc Tế Hà Nội. All rights reserved.</p>
    </footer>
</body>
</html>