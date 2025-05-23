<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
class PrescriptionController extends Controller
{
    // Hiển thị danh sách bệnh nhân có đơn thuốc
    public function listPatientsWithPrescriptions()
    {
        $appointments = Appointment::has('prescription')
            ->with(['patient.user'])
            ->where('status', 'completed')
            ->get();

        return view('prescriptions.patients', compact('appointments'));
    }

    // Hiển thị đơn thuốc theo appointment_id
    public function showByAppointment($appointmentId)
    {
        $appointment = Appointment::with(['prescription.prescriptionDetails.medicines', 'doctor.user', 'patient.user'])
                   
        ->findOrFail($appointmentId);

        if (!$appointment->prescription) {
            return back()->with('error', 'Bệnh nhân không có đơn thuốc mới.');
        }

        return view('prescriptions.show', compact('appointment'));
    }
    

public function confirm(Appointment $appointment)
{
    try {
        $prescription = $appointment->prescription;

        if (!$prescription) {
            return back()->with('error', 'Không tìm thấy đơn thuốc.');
        }

        // Nếu đã xác nhận rồi
        if ($prescription->is_confirmed) {
            return back()->with('error', 'Đơn thuốc đã được xác nhận trước đó.');
        }

        DB::beginTransaction();
        try {
            foreach ($prescription->prescriptionDetails as $detail) {
                $medicine = $detail->medicines;

                // Kiểm tra số lượng tồn kho
                if ($medicine->quantity < $detail->quantity) {
                    DB::rollBack();
                    return back()->with('error', 'Không đủ thuốc trong kho cho: ' . $medicine->name);
                }

                // Trừ thuốc trong kho và cập nhật đã sử dụng
                $medicine->quantity -= $detail->quantity;
                $medicine->quantity_used += $detail->quantity;
                
                if (!$medicine->save()) {
                    throw new \Exception('Không thể cập nhật số lượng thuốc: ' . $medicine->name);
                }
            }

            // Đánh dấu đơn thuốc đã được xác nhận
            $prescription->is_confirmed = true;
            $prescription->confirmed_at = now();
            
            if (!$prescription->save()) {
                throw new \Exception('Không thể cập nhật trạng thái đơn thuốc');
            }

            DB::commit();
            return back()->with('success', 'Cấp thuốc thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi khi cấp thuốc: ' . $e->getMessage(), [
                'appointment_id' => $appointment->appointment_id,
                'prescription_id' => $prescription->prescription_id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Có lỗi xảy ra khi cấp thuốc: ' . $e->getMessage());
        }
    } catch (\Exception $e) {
        \Log::error('Lỗi không xác định khi cấp thuốc: ' . $e->getMessage());
        return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
    }
}

}
