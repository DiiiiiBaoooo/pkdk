<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\PrescriptionDetail;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class MedicalRecordController extends Controller
{
 public function show($patientId = null)
{
    // Lấy user hiện tại
    $user = Auth::user();

    // Lấy đối tượng Patient từ user (nếu có)
 $patient = Patient::where('user_id', $user->user_id)->first();

    // Nếu không tìm thấy bệnh nhân
    if (!$patient) {
        return view('medical-record.show', ['message' => 'Không tìm thấy thông tin bệnh nhân.']);
    }

    // Nếu có `patientId` được truyền vào, tìm kiếm theo `patient_id`
    if ($patientId) {
        // Tìm hồ sơ bệnh án của bệnh nhân có patient_id = $patientId
        $medicalRecords = MedicalRecord::with('appointment') // Nạp thông tin appointment vào
            ->where('patient_id', $patientId)
            ->get();
    } else {
        // Nếu không có `patientId`, lấy tất cả hồ sơ bệnh án của bệnh nhân
        $medicalRecords = $patient->medicalRecords()->with('appointment')->get(); // Nạp thông tin appointment cho mỗi medical record
    }

    // Kiểm tra nếu không có hồ sơ bệnh án
    if ($medicalRecords->isEmpty()) {
        return view('medical-record.show', ['message' => 'Chưa có hồ sơ bệnh án.', 'medicalRecords' => $medicalRecords]);
    }

    // Trả về view với danh sách hồ sơ bệnh án và appointment
    return view('medical-record.show', [
        'medicalRecords' => $medicalRecords,
        'appointments' => $medicalRecords->pluck('appointment') // Lấy danh sách appointment liên quan
    ]);
}


public function update(Request $request)
{
    $request->validate([
        'appointment_id' => 'required|exists:appointments,appointment_id',
        'diagnosis' => 'required|string',
        'medicines' => 'required|array|min:1',
        'medicines.*.medicine_id' => 'required|exists:medicines,medicine_id',
        'medicines.*.quantity' => 'required|integer|min:1',
        'medicines.*.instruction' => 'required|string',
    ]);

    $appointment = Appointment::findOrFail($request->appointment_id);

    if (!$appointment->patient_id) {
        return redirect()->back()->with('error', 'Lịch hẹn không có thông tin bệnh nhân.');
    }

    DB::beginTransaction();

    try {
        // Kiểm tra hồ sơ bệnh án
        $medicalRecord = $appointment->medicalRecord;

        if (!$medicalRecord) {
            $medicalRecord = MedicalRecord::create([
                'appointment_id' => $appointment->appointment_id,
                'patient_id' => $appointment->patient_id,
                'diagnosis' => $request->diagnosis,
            ]);
        } else {
            $medicalRecord->update([
                'diagnosis' => $request->diagnosis,
            ]);
        }

        // Cập nhật trạng thái lịch hẹn
        $appointment->status = 'completed';
        $appointment->save();

        // Xóa đơn thuốc cũ nếu có
        if ($medicalRecord->prescription) {
            PrescriptionDetail::where('prescription_id', $medicalRecord->prescription->prescription_id)->delete();
            $medicalRecord->prescription->delete();
        }

        // Tạo đơn thuốc mới
        $prescription = Prescription::create([
            'medical_record_id' => $medicalRecord->medical_record_id,
            'appointment_id' => $medicalRecord->appointment_id,
            'date_issued' => now(),
        ]);

        // Kiểm tra prescription_id
        if (!$prescription->prescription_id) {
            throw new \Exception('Không thể tạo đơn thuốc: prescription_id không hợp lệ.');
        }

        // Tạo chi tiết đơn thuốc
        foreach ($request->medicines as $medicine) {
            PrescriptionDetail::create([
                'prescription_id' => $prescription->prescription_id,
                'medicine_id' => $medicine['medicine_id'],
                'quantity' => $medicine['quantity'],
                'instruction' => $medicine['instruction'],
            ]);
        }

        DB::commit();
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Lỗi cập nhật hồ sơ bệnh án: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Cập nhật thông tin thất bại: ' . $e->getMessage());
    }
}
public function showPrescription($appointmentId)
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->user_id)->first();


        if (!$patient) {
            return view('prescription.show', [
                'message' => 'Không tìm thấy thông tin bệnh nhân.',
                'appointment' => null
            ]);
        }

       $appointment = Appointment::with([
    'doctor',
    'service',
    'medicalRecord',
    'prescription.prescriptionDetails.medicines'
])
->where('patient_id', $patient->patient_id)
->where('appointment_id', $appointmentId)
->first();

        // Ghi log để debug
        Log::info('Truy vấn Appointment', [
            'appointment_id' => $appointmentId,
            'patient_id' => $patient->user->user_id,
            'found' => $appointment ? 'Có' : 'Không'
        ]);

        return view('prescription.show', [
            'appointment' => $appointment,
            'message' => $appointment ? null : 'Không tìm thấy thông tin lịch hẹn.'
        ]);
    }
}