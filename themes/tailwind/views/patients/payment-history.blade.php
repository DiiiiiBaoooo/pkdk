<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử thanh toán</title>
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
            margin-bottom: 20px;
        }

        .payment-history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .payment-history-table th,
        .payment-history-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .payment-history-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }

        .payment-history-table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }

        .status-pending {
            background-color: #ffc107;
            color: #000;
        }

        .status-paid {
            background-color: #28a745;
            color: #fff;
        }

        .btn-view {
            display: inline-block;
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn-view:hover {
            background-color: #0056b3;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #6c757d;
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
            <h2>Lịch sử thanh toán</h2>

            @if($invoices->isEmpty())
                <div class="empty-state">
                    <p>Chưa có lịch sử thanh toán nào.</p>
                </div>
            @else
                <table class="payment-history-table">
                    <thead>
                        <tr>
                            <th>Mã hóa đơn</th>
                            <th>Ngày khám</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Phương thức thanh toán</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>#{{ $invoice->invoice_id }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->prescription->appointment->time)->format('d/m/Y') }}</td>
                                <td>{{ number_format($invoice->total_amount) }} đ</td>
                                <td>
                                    <span class="status-badge status-{{ $invoice->status }}">
                                        {{ $invoice->status == 'pending' ? 'Chờ thanh toán' : 'Đã thanh toán' }}
                                    </span>
                                </td>
                                <td>
                                    @if($invoice->payment_method)
                                        @switch($invoice->payment_method)
                                            @case('cash')
                                                Tiền mặt
                                                @break
                                            @case('bank_transfer')
                                                Chuyển khoản
                                                @break
                                            @case('card')
                                                Thẻ tín dụng/ghi nợ
                                                @break
                                            @default
                                                {{ $invoice->payment_method }}
                                        @endswitch
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('invoices.show', $invoice->invoice_id) }}" class="btn-view">Xem chi tiết</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </main>
</body>
</html> 