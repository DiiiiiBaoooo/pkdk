<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Accountant;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    public function createForm()
    {
        return view('invoices.create');
    }
    public function selectPatient()
    {
        $user = Auth::user();
        if ($user->role === 'accountant') {
            // lấy danh sách cuộc hẹn có status = completed và có đơn thuốc đã được xác nhận
            $appointments = Appointment::where('status', 'completed')
                ->whereHas('prescription', function($query) {
                    $query->where('is_confirmed', 1);
                })
                ->get();

          
            return view('invoices.select_patient', compact('appointments'));
        }
        else{
            return redirect()->route('homepage');
        }
      
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $accountant = Accountant::where('user_id', $user->user_id)->first();
            
            if (!$accountant) {
                return redirect()->back()->with('error', 'Không tìm thấy thông tin kế toán.');
            }

            $validated = $request->validate([
                'prescription_id' => 'required|exists:prescriptions,prescription_id',
                'appointment_id' => 'required|exists:appointments,appointment_id',
                'patient_id' => 'required|exists:patients,patient_id',
                'total_amount' => 'required|numeric|min:0',
            ]);

            // Check if invoice already exists for this prescription
            $existingInvoice = Invoice::where('prescription_id', $request->prescription_id)->first();
            if ($existingInvoice) {
                return redirect()->back()->with('error', 'Hóa đơn đã tồn tại cho đơn thuốc này.');
            }

            $prescription = Prescription::with(['prescriptionDetails.medicines', 'appointment.service'])
                ->findOrFail($request->prescription_id);

            if (!$prescription) {
                return redirect()->back()->with('error', 'Không tìm thấy đơn thuốc.');
            }

            // Tính tổng tiền: thuốc + dịch vụ
            $totalAmount = 0;
            foreach ($prescription->prescriptionDetails as $detail) {
                $medicinePrice = $detail->medicines->price ?? 0;
                $quantity = $detail->quantity;
                $servicePrice = $prescription->appointment->service->price ?? 0;
                $totalAmount += ($medicinePrice * $quantity) + $servicePrice;
            }

            DB::beginTransaction();
            try {
                // Tạo hóa đơn
                $invoice = new Invoice();
                $invoice->fill([
                    'prescription_id' => $request->prescription_id,
                    'patient_id' => $request->patient_id,
                    'appointment_id' => $request->appointment_id,
                    'accountant_id' => $accountant->accountant_id,
                    'total_amount' => $totalAmount,
                    'issue_date' => now(),
                    'due_date' => now()->addDays(15),
                    'status' => 'pending',
                    'payment_method' => null
                ]);

                if (!$invoice->save()) {
                    throw new \Exception('Không thể lưu hóa đơn.');
                }

                $invoiceDetail = new InvoiceDetail();
                $invoiceDetail->fill([
                    'invoice_id' => $invoice->invoice_id,
                    'service_id' => $prescription->appointment->service_id,
                    'total_price' => $totalAmount,
                    'payment_date' => null,
                ]);
                
                if (!$invoiceDetail->save()) {
                    throw new \Exception('Không thể lưu chi tiết hóa đơn.');
                }

                $prescription->is_confirmed = '2';
                if (!$prescription->save()) {
                    throw new \Exception('Không thể cập nhật trạng thái đơn thuốc.');
                }

                DB::commit();
                return redirect()->back()->with('success', 'Hóa đơn đã được tạo thành công.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo hóa đơn: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    
    public function index()
    {
        $invoices = Invoice::with(['patient.user'])->get();
        return view('invoices.manage', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient.user', 'prescription.prescriptionDetails.medicines', 'invoiceDetails.service']);
        return view('invoices.show', compact('invoice'));
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,paid',
                'payment_method' => 'required|in:cash,bank_transfer,credit_card'
            ]);

            $invoice->status = $validated['status'];
            $invoice->payment_method = $validated['payment_method'];
            
            if (!$invoice->save()) {
                throw new \Exception('Không thể cập nhật trạng thái hóa đơn.');
            }

            return redirect()->back()->with('success', 'Cập nhật trạng thái hóa đơn thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    // xây dựng chức năng xem hóa đơn chưa thanh toán
    public function unpaidInvoices()
    {
        $invoices = Invoice::where('status', 'pending')->where('patient_id', Auth::user()->user_id)->get();
        return view('invoices.patient.unpaid', compact('invoices'));
    }
    public function showInvoice($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        return view('invoices.patient.show', compact('invoice'));
    }
    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }    
    public function momo_payment(Request $request)
  {

    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

    $partnerCode = 'MOMOBKUN20180529';
    $accessKey = 'klm05TvNBzhg7h7j';
    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

    $orderInfo = "Thanh toán qua ATM MoMo";
    $amount = $request->total_amount/100;
    $orderId = time() . "";
  $redirectUrl = "http://127.0.0.1:8000/invoices/patient/show/".$request->invoice_id;
  $ipnUrl = "http://127.0.0.1:8000/invoices/patient/show/".$request->invoice_id;

  $extraData = json_encode(['invoice_id' => $request->invoice_id]);

    $requestId = time() . "";
    $requestType = "payWithATM";
    // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
    //before sign HMAC SHA256 signature
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    $data = array(
      'partnerCode' => $partnerCode,
      'partnerName' => "Test",
      "storeId" => "MomoTestStore",
      'requestId' => $requestId,
      'amount' => $amount,
      'orderId' => $orderId,
      'orderInfo' => $orderInfo,
      'redirectUrl' => $redirectUrl,
      'ipnUrl' => $ipnUrl,
      'lang' => 'vi',
      'extraData' => $extraData,
      'requestType' => $requestType,
      'signature' => $signature
      
    );
    $result = $this->execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);  // decode json

    //Just a example, please check more in there
    

// dd($jsonResult);
    return redirect()->to($jsonResult['payUrl']);
// }

}

public function momoIpn(Request $request)
{
    Log::info('Log test OK!');
    try {
        Log::info('Momo IPN Request received:', $request->all());

        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        // Validate required fields
        $requiredFields = ['amount', 'extraData', 'ipnUrl', 'orderId', 'orderInfo', 'partnerCode', 'redirectUrl', 'requestId', 'requestType', 'signature', 'resultCode'];
        foreach ($requiredFields as $field) {
            if (!$request->has($field)) {
                Log::error('Missing required field in MoMo IPN:', ['field' => $field]);
                return response()->json(['message' => "Missing required field: $field"], 400);
            }
        }

        // Generate signature
        $rawHash = "accessKey=" . $accessKey .
            "&amount=" . $request->amount .
            "&extraData=" . $request->extraData .
            "&ipnUrl=" . $request->ipnUrl .
            "&orderId=" . $request->orderId .
            "&orderInfo=" . $request->orderInfo .
            "&partnerCode=" . $request->partnerCode .
            "&redirectUrl=" . $request->redirectUrl .
            "&requestId=" . $request->requestId .
            "&requestType=" . $request->requestType;

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        Log::info('Momo IPN Signature check:', [
            'rawHash' => $rawHash,
            'calculated_signature' => $signature,
            'received_signature' => $request->signature,
            'result_code' => $request->resultCode
        ]);

        if ($signature === $request->signature && $request->resultCode == 0) {
            // Decode extraData
            $extraData = json_decode($request->extraData, true);
            $invoiceId = $extraData['invoice_id'] ?? null;

            Log::info('Momo IPN ExtraData:', [
                'extraData' => $extraData,
                'invoice_id' => $invoiceId
            ]);

            if (!$invoiceId) {
                Log::error('Missing invoice_id in extraData', ['extraData' => $request->extraData]);
                return response()->json(['message' => 'Missing invoice_id in extraData'], 400);
            }

            // Find invoice
            $invoice = Invoice::where('invoice_id', $invoiceId)->first();
            if (!$invoice) {
                Log::error('Invoice not found:', ['invoice_id' => $invoiceId]);
                return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
            }

            // Update invoice
            DB::beginTransaction();
            try {
                // Log trạng thái trước khi cập nhật
                Log::info('Invoice before update:', [
                    'invoice_id' => $invoiceId,
                    'current_status' => $invoice->status,
                    'current_payment_method' => $invoice->payment_method
                ]);
                $invoice->status = 'paid';
                $invoice->payment_method = 'bank_transfer';
                // Cập nhật hóa đơn

                $invoice->save();
                $invoiceDetail = InvoiceDetail::where('invoice_id', $invoiceId)->first();
                $invoiceDetail->payment_date = now();
                $invoiceDetail->save();
            
            
                
                if (!$invoice->save()) {
                    throw new \Exception('Không thể lưu hóa đơn');
                }

                // Log trạng thái sau khi cập nhật
                Log::info('Invoice after update:', [
                    'invoice_id' => $invoiceId,
                    'new_status' => $invoice->status,
                    'new_payment_method' => $invoice->payment_method,
                 
                ]);

                DB::commit();
                return response()->json(['message' => 'Thanh toán thành công'], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error updating invoice:', [
                    'invoice_id' => $invoiceId,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]);
                return response()->json(['message' => 'Lỗi cập nhật hóa đơn'], 500);
            }
        }

        Log::error('Invalid signature or result code:', [
            'signature_match' => $signature === $request->signature,
            'result_code' => $request->resultCode
        ]);
        return response()->json(['message' => 'Xác thực không thành công'], 400);

    } catch (\Exception $e) {
        Log::error('Error in momoIpn:', [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['message' => 'Lỗi xử lý thanh toán'], 500);
    }
}

}