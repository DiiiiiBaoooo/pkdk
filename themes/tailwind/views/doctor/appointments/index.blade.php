<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ</title>
    <script type="module" src="{{ asset('js/boostrap.js') }}"></script>
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

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background-color: #ccc;
        }

        .day-header, .day-cell {
            background-color: #fff;
            min-height: 100px;
            border: 1px solid #ddd;
            padding: 6px;
        }

        .day-header {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }

        .day-number {
            font-weight: bold;
        }

        .appointment {
            background-color: #d1e7dd;
            color: #0f5132;
            margin-top: 4px;
            padding: 4px;
            border-radius: 4px;
            font-size: 0.85em;
            cursor: pointer;
        }

        .appointment:hover {
            background-color: #c3e6cb;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .modal-content h3 {
            margin-top: 0;
            color: #2c3e50;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal-content label {
            font-weight: bold;
            color: #333;
        }

        .modal-content textarea {
            width: 100%;
            min-height: 100px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
        }

        .modal-content button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .modal-content button[type="submit"] {
            background-color: #28a745;
            color: white;
        }

        .modal-content button[type="submit"]:hover {
            background-color: #218838;
        }

        .modal-content button.close {
            background-color: #dc3545;
            color: white;
        }

        .modal-content button.close:hover {
            background-color: #c82333;
        }
        .prescription-section {
    margin-top: 20px;
    border-top: 1px solid #ccc;
    padding-top: 15px;
}

.prescription-section h4 {
    margin-bottom: 10px;
    color: #2c3e50;
}

.prescription-items {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.prescription-item {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

.prescription-item select,
.prescription-item input {
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    flex: 1;
    min-width: 150px;
}

.prescription-item input[type="number"] {
    width: 80px;
}

.prescription-item input[type="text"] {
    flex: 2;
}

.add-medicine-btn {
    background-color: #007bff;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
    font-size: 14px;
}

.add-medicine-btn:hover {
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
@if(Auth::user()->isHR())
<li><a href="{{ route('employees.index') }}">Quản lý nhân viên</a></li>
<li><a href="{{ route('employees.create') }}">Thêm nhân viên</a></li>
@endif
  <li><a href="#">Đổi mật khẩu</a></li>
                <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a></li>
            </ul>
        </div>
        <div class="profile-info">
            @php
                $prevMonth = $month - 1;
                $nextMonth = $month + 1;
                $prevYear = $year;
                $nextYear = $year;

                if ($prevMonth == 0) {
                    $prevMonth = 12;
                    $prevYear--;
                }

                if ($nextMonth == 13) {
                    $nextMonth = 1;
                    $nextYear++;
                }
            @endphp

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <a href="{{ route('doctor.appointments.index', ['month' => $prevMonth, 'year' => $prevYear]) }}">← Tháng trước</a>
                <h2>Lịch hẹn tháng {{ $month }}/{{ $year }}</h2>
                <a href="{{ route('doctor.appointments.index', ['month' => $nextMonth, 'year' => $nextYear]) }}">Tháng sau →</a>
            </div>
            <div class="calendar">
                <div class="day-header">CN</div>
                <div class="day-header">T2</div>
                <div class="day-header">T3</div>
                <div class="day-header">T4</div>
                <div class="day-header">T5</div>
                <div class="day-header">T6</div>
                <div class="day-header">T7</div>

                @for ($i = 0; $i < $startDayOfWeek; $i++)
                    <div class="day-cell"></div>
                @endfor

                @for ($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $date = \Carbon\Carbon::create($year, $month, $day)->toDateString();
                    @endphp
                    <div class="day-cell" data-day="{{ $day }}">
                        <div class="day-number">{{ $day }}</div>
                        @foreach ($appointments as $appointment)
                            @if (\Carbon\Carbon::parse($appointment->time)->toDateString() === $date)
                                <div class="appointment" data-appointment-id="{{ $appointment->appointment_id }}"
                                    data-patient-name="{{ $appointment->patient->user->name ?? 'BN' }}"
                                    data-time="{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}"
                                    data-diagnosis="{{ $appointment->medicalRecord->diagnosis ?? '' }}">
                                    {{ $appointment->patient->user->name ?? 'BN' }} <br>
                                    {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endfor
            </div>
        </div>
    </main>

    <!-- Modal for Medical Record Form -->
    <div id="medicalRecordModal" class="modal">
        <div class="modal-content">
            <h3>Cập nhật hồ sơ bệnh án</h3>
            <form id="medicalRecordForm" action="{{ route('doctor.medicalRecord.update') }}" method="POST">
                @csrf
                <input type="hidden" name="appointment_id" id="appointment_id">
                <label for="patient_name">Tên bệnh nhân:</label>
                <input type="text" id="patient_name" name="patient_name" readonly>
        
                <label for="diagnosis">Chẩn đoán:</label>
                <textarea id="diagnosis" name="diagnosis" required></textarea>
                <label for="prescription">Đơn thuốc:</label>
<div id="prescription-container">
    <div class="prescription-item">
        <select name="medicines[0][medicine_id]" required>
            @foreach($medicines as $medicine)
                <option value="{{ $medicine->medicine_id }}">{{ $medicine->name }} ({{ $medicine->type }})</option>
            @endforeach
        </select>
        <input type="number" name="medicines[0][quantity]" placeholder="Số lượng" min="1" required>
        <input type="text" name="medicines[0][instruction]" placeholder="Cách dùng" required>
    </div>
</div>
<button type="button" id="add-medicine-btn">➕ Thêm thuốc</button>
                <div style="display: flex; gap: 10px;">
                    <button type="submit">Lưu</button>
                    <button type="button" class="close">Đóng</button>
                </div>
            </form>
            @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("medicalRecordModal");
            const form = document.getElementById("medicalRecordForm");
            const closeButton = document.querySelector(".modal-content .close");

            // Handle appointment click to open modal
            document.querySelectorAll(".appointment").forEach(appointment => {
                appointment.addEventListener("click", () => {
                    const appointmentId = appointment.getAttribute("data-appointment-id");
                    const patientName = appointment.getAttribute("data-patient-name");
                    const diagnosis = appointment.getAttribute("data-diagnosis");

                    // Populate form fields
                    document.getElementById("appointment_id").value = appointmentId;
                    document.getElementById("patient_name").value = patientName;
                    document.getElementById("diagnosis").value = diagnosis;

                    // Show modal
                    modal.style.display = "flex";
                });
            });

            // Close modal
            closeButton.addEventListener("click", () => {
                modal.style.display = "none";
                form.reset();
            });

            // Close modal when clicking outside
            window.addEventListener("click", (event) => {
                if (event.target === modal) {
                    modal.style.display = "none";
                    form.reset();
                }
            });

            // Handle form submission (optional client-side validation)
            form.addEventListener("submit", (event) => {
                const diagnosis = document.getElementById("diagnosis").value.trim();
                if (!diagnosis) {
                    event.preventDefault();
                    alert("Vui lòng nhập chẩn đoán.");
                }
            });
        });
    </script>
    <script>
let medicineIndex = 1;
document.getElementById("add-medicine-btn").addEventListener("click", () => {
    const container = document.getElementById("prescription-container");
    const div = document.createElement("div");
    div.classList.add("prescription-item");
    div.innerHTML = `
        <select name="medicines[${medicineIndex}][medicine_id]" required>
            @foreach($medicines as $medicine)
                <option value="{{ $medicine->medicine_id }}">{{ $medicine->name }} ({{ $medicine->type }})</option>
            @endforeach
        </select>
        <input type="number" name="medicines[${medicineIndex}][quantity]" placeholder="Số lượng" min="1" required>
        <input type="text" name="medicines[${medicineIndex}][instruction]" placeholder="Cách dùng" required>
    `;
    container.appendChild(div);
    medicineIndex++;
});
</script>

</body>
</html>