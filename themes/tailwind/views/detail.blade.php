<!-- resources/views/homepage.blade.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phòng Khám Đa Khoa Quốc Tế Hà Nội</title>
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
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
                    <li><a href="{{ route('appointments.create') }}" class="btn-dk">Đăng ký khám</a></li>
                 <!-- Kiểm tra người dùng đã đăng nhập chưa -->
                   @if(Auth::check())
    <li><a href="/profile">Hồ sơ</a></li>

    <!-- Form logout ẩn -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Link logout sẽ gọi form -->
    <li>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Đăng xuất
        </a>
    </li>
@else
    <li><a href="/dangnhap">Đăng nhập</a></li>
    <li><a href="/dangky">Đăng ký</a></li>
@endif

                 
                </ul>
            </nav>
        </div>
    </header>
<section class="about-page">
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

  <main class="content">
    <h2>GIỚI THIỆU PHÒNG KHÁM ĐA KHOA ĐẠI HỌC Y KHOA</h2>
    <p><strong>Phòng khám Đa khoa</strong> trực thuộc hệ thống đào tạo và y tế, ra đời với mục tiêu nâng cao chất lượng khám chữa bệnh và ứng dụng công nghệ vào quản lý y tế. Phòng khám cung cấp dịch vụ đa dạng từ nội khoa, sản phụ khoa, đến xét nghiệm, chẩn đoán hình ảnh, điều trị và tư vấn sức khỏe cộng đồng.</p>

    <p>Được xây dựng trên nền tảng công nghệ mới, hệ thống quản lý của phòng khám hỗ trợ quản lý thông tin bệnh nhân, lịch hẹn, đơn thuốc, hóa đơn và hồ sơ bệnh án một cách chính xác, bảo mật và hiệu quả. Bệnh nhân có thể dễ dàng tra cứu thông tin, đặt lịch khám trực tuyến và thanh toán qua cổng điện tử nhanh chóng.</p>

    <p>Với đội ngũ bác sĩ giỏi chuyên môn, giàu kinh nghiệm và môi trường khám chữa bệnh chuyên nghiệp, Phòng khám Đa khoa Đại học Y Khoa cam kết mang đến trải nghiệm y tế toàn diện, hiện đại và thân thiện nhất cho người dân.</p>
  </main>
</section>

   


    <footer class="footer">
        <p>&copy; 2025 Phòng Khám Đa Khoa Quốc Tế Hà Nội. All rights reserved.</p>
    </footer>
</body>
</html>