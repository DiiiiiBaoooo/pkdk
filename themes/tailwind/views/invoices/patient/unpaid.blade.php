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

      .badge {
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
      }

      .badge-warning {
        background-color: #ffc107;
        color: #000;
      }

      .badge-success {
        background-color: #28a745;
        color: #fff;
      }

      .btn {
        padding: 5px 10px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-size: 12px;
        margin-right: 5px;
      }

      .btn-info {
        background-color: #17a2b8;
        color: #fff;
      }

      .btn-success {
        background-color: #28a745;
        color: #fff;
      }

      .btn:hover {
        opacity: 0.9;
      }

      #searchInput {
        width: 100%;
        padding: 8px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
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

        <div class="profile-info">
            <h1>Danh sách hóa đơn chưa thanh toán</h1>

            <table border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bệnh nhân</th>
                        <th>Tổng tiền</th>
                        <th>Ngày tạo</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_id }}</td>
                            <td>{{ $invoice->patient->user->name ?? 'Không rõ' }}</td>
                            <td>{{ number_format($invoice->total_amount) }} đ</td>
                            <td>{{ Carbon\Carbon::parse($invoice->issue_date)->format('d/m/Y') ?? 'Không rõ' }}</td>
                            <td><a href="{{ route('invoices.patient.show', $invoice->invoice_id) }}">Xem chi tiết</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </main>
</body>
<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#patientTable tbody tr');

        rows.forEach(row => {
            const nameCell = row.cells[1].textContent.toLowerCase();
            row.style.display = nameCell.includes(searchValue) ? '' : 'none';
        });
    });
</script>

</html>