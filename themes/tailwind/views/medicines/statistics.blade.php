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
  max-width: 1100px;
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

.profile-info h4 {
  margin-top: 30px;
  color: #333;
}

.profile-info p {
  margin: 10px 0;
  font-size: 16px;
}

form select {
  padding: 8px 12px;
  font-size: 16px;
  margin-top: 10px;
  margin-bottom: 20px;
}

.card {
  background-color: #f1f5ff;
  padding: 15px;
  border-radius: 6px;
  margin-top: 10px;
  margin-bottom: 20px;
}

.card p {
  margin: 6px 0;
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

ul {
  padding-left: 18px;
}

ul li {
  margin-bottom: 6px;
}
.search-input {
    padding: 8px 12px;
    font-size: 16px;
    margin-top: 10px;
    margin-bottom: 20px;
    width: 200px;
    border-radius: 6px;
    border: 1px solid #ddd;
}

button {
    padding: 8px 12px;
    font-size: 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
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
          <h2>Thống kê thuốc</h2>
  
          <form method="GET" action="{{ route('medicines.statistics') }}" class="mb-3">
              <label for="warehouse">Chọn kho:</label>
              <select name="warehouse_id" id="warehouse" onchange="this.form.submit()">
                  <option value="">Tất cả</option>
                  @foreach($warehouses as $warehouse)
                      <option value="{{ $warehouse->id }}" {{ $warehouseId == $warehouse->id ? 'selected' : '' }}>
                          {{ $warehouse->name }} - {{ $warehouse->location }}
                      </option>
                  @endforeach
              </select>
          </form>
  
          <div class="card mb-3" style="padding: 15px; background-color: #f9f9f9; border-radius: 6px;">
              <p><strong>Tổng số loại thuốc:</strong> {{ $totalMedicines }}</p>
              <p><strong>Số lượng còn trong kho:</strong> {{ $totalInStock }}</p>
              <p><strong>Số lượng đã sử dụng:</strong> {{ $totalUsed }}</p>
          </div>
  
          <div style="margin-top: 20px;    
    float: right;">
            <button type="button" onclick="showTable('valid')" style="margin-right: 10px;width: fit-content;">Thuốc còn hạn</button>
            <button type="button" onclick="showTable('expired')" style="width: fit-content;">Thuốc hết hạn</button>
        </div>
        
        <div id="valid-medicines-table">
            <h4 class="mt-4">Danh sách thuốc còn hạn</h4>
            <table>
                <thead>
                    <tr>
                        <th>Tên thuốc</th>
                        <th>Số lượng tồn</th>
                        <th>Đã sử dụng</th>
                        <th>Hạn sử dụng</th>
                        <th>Kho</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medicines_conhan as $medicine)
                        <tr>
                            <td>{{ $medicine->name }}</td>
                            <td>{{ $medicine->quantity }}</td>
                            <td>{{ $medicine->quantity_used }}</td>
                            <td>{{ \Carbon\Carbon::parse($medicine->expiration_date)->format('d/m/Y') }}</td>
                            <td>{{ $medicine->warehouse->name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
          
        <div id="expired-medicines-table" style="display: none;">
            <h4>Thuốc hết hạn</h4>
            <table>
                <thead>
                    <tr>
                        <th>Tên thuốc</th>
                        <th>Số lượng tồn</th>
                        <th>Hạn sử dụng</th>
                        <th>Kho</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($nearlyExpired as $med)
                        <tr>
                            <td>{{ $med->name }}</td>
                            <td>{{ $med->quantity }}</td>
                            <td>{{ \Carbon\Carbon::parse($med->expiration_date)->format('d/m/Y') }}</td>
                            <td>{{ $med->warehouse->name ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Không có thuốc hết hạn.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
             
         
      </div>
  </main>
  <script>
    function showTable(type) {
        const validTable = document.getElementById('valid-medicines-table');
        const expiredTable = document.getElementById('expired-medicines-table');

        if (type === 'valid') {
            validTable.style.display = 'block';
            expiredTable.style.display = 'none';
        } else {
            validTable.style.display = 'none';
            expiredTable.style.display = 'block';
        }
    }
</script>

</body>
</html>