<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết hóa đơn</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <style>
        .invoice-container {
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .invoice-header h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .invoice-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .info-group {
            margin-bottom: 20px;
        }

        .info-group h3 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .info-group p {
            margin: 5px 0;
            color: #555;
        }

        .invoice-items {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }

        .total-section {
            margin-top: 30px;
            text-align: right;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }

        .total-section p {
            font-size: 18px;
            margin: 5px 0;
        }

        .total-amount {
            font-size: 24px;
            color: #2c3e50;
            font-weight: bold;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            padding: 10px 20px;
        }

        .status-pending {
            background-color: #ffc107;
            color: #000;
        }

        .status-paid {
            background-color: #28a745;
            color: #fff;
        }

        .actions {
            margin-top: 30px;
            text-align: center;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            margin: 0 5px;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .prescription-details {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            position: relative;
        }

        .close {
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #2c3e50;
        }

        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .modal-title {
            margin-top: 0;
            color: #2c3e50;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .modal-footer {
            margin-top: 20px;
            text-align: right;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <a href="{{ route('invoices.index') }}" class="back-link">← Quay lại danh sách hóa đơn</a>

        <div class="invoice-header">
            <h1>HÓA ĐƠN</h1>
            <p>Số hóa đơn: #{{ $invoice->invoice_id }}</p>
        </div>

        <div class="invoice-info">
            <div class="info-group">
                <h3>Thông tin bệnh nhân</h3>
                <p><strong>Tên bệnh nhân:</strong> {{ $invoice->patient->user->name }}</p>
                <p><strong>Ngày khám:</strong> {{ \Carbon\Carbon::parse($invoice->prescription->appointment->time)->format('d/m/Y') }}</p>
                <p><strong>Bác sĩ khám:</strong> {{ $invoice->prescription->appointment->doctor->user->name }}</p>
            </div>

            <div class="info-group">
                <h3>Thông tin hóa đơn</h3>
                <p><strong>Ngày lập:</strong> {{ \Carbon\Carbon::parse($invoice->issue_date)->format('d/m/Y') }}</p>
                <p><strong>Trạng thái:</strong> 
                    <span class="status-badge status-{{ $invoice->status }}">
                        {{ $invoice->status == 'pending' ? 'Chờ thanh toán' : 'Đã thanh toán' }}
                    </span>
                </p>
                @if($invoice->payment_method)
                    <p><strong>Phương thức thanh toán:</strong> 
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
                    </p>
                @endif
                @if($invoice->payment_date)
                    <p><strong>Ngày thanh toán:</strong> {{ \Carbon\Carbon::parse($invoice->payment_date)->format('d/m/Y') }}</p>
                @endif
            </div>
        </div>

        <div class="invoice-items">
            <h3>Chi tiết đơn thuốc</h3>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên thuốc</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->prescription->prescriptionDetails as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->medicines->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->medicines->price) }} đ</td>
                            <td>{{ number_format($detail->quantity * $detail->medicines->price) }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="invoice-items">
                <h3>Dịch vụ</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Tên dịch vụ</th>
                            <th>Đơn giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $invoice->prescription->appointment->service->name }}</td>
                            <td>{{ number_format($invoice->prescription->appointment->service->price) }} đ</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="total-section">
                <p><strong>Tổng tiền dịch vụ:</strong> {{ number_format($invoice->prescription->appointment->service->price) }} đ</p>
                <p><strong>Tổng tiền thuốc:</strong> 
                    {{ number_format($invoice->prescription->prescriptionDetails->sum(function($detail) {
                        return $detail->quantity * $detail->medicines->price;
                    })) }} đ
                </p>
                <p class="total-amount">Tổng cộng: {{ number_format($invoice->total_amount) }} đ</p>
            </div>
        </div>

        <div class="actions">
            @if($invoice->status == 'pending')
                <button type="button" class="btn btn-success" onclick="openPaymentModal()">Xác nhận thanh toán</button>
            @endif
            @if(Auth::user()->role == 'accountant')
            <a href="{{ route('invoices.index') }}" class="btn btn-primary">Quay lại danh sách</a>
            @endif
            @if(Auth::user()->role == 'patient')
            <a href="{{ route('patient.payment-history') }}" class="btn btn-primary">Quay lại danh sách</a>
            @endif
        </div>
    </div>

    <!-- Payment Confirmation Modal -->
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closePaymentModal()">&times;</span>
            <h2 class="modal-title">Xác nhận thanh toán</h2>
            
            <form action="{{ route('invoices.updateStatus', $invoice->invoice_id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="payment_status">Trạng thái thanh toán:</label>
                    <select name="status" id="payment_status" required>
                        <option value="">-- Chọn trạng thái --</option>
                        <option value="paid">Đã thanh toán</option>
                        <option value="pending">Chờ thanh toán</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="payment_method">Phương thức thanh toán:</label>
                    <select name="payment_method" id="payment_method" required>
                        <option value="">-- Chọn phương thức --</option>
                        <option value="cash">Tiền mặt</option>
                        <option value="bank_transfer">Chuyển khoản</option>
                        <option value="card">Thẻ tín dụng/ghi nợ</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="closePaymentModal()">Hủy</button>
                    <button type="submit" class="btn btn-success">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openPaymentModal() {
            document.getElementById('paymentModal').style.display = 'block';
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            var modal = document.getElementById('paymentModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>

    @if(session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif

    @if(session('error'))
        <script>
            alert('{{ session('error') }}');
        </script>
    @endif
</body>
</html> 