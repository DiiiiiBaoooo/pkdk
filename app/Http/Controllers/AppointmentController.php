<?php

namespace App\Http\Controllers;
use App\Events\AppointmentCreated;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\WorkSchedule;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\Patient;
class AppointmentController extends Controller
{
   public function create()
{
     if (Auth::user()->role !== 'patient') {
        return redirect()->route('homepage')->with('error', 'Chỉ bệnh nhân mới được đặt lịch khám.');
    }
    // Lấy tất cả dịch vụ
    $services = Service::all();

    // Lấy tất cả bác sĩ
    $doctors = Doctor::all();

    // Lấy tất cả lịch khám từ ngày hiện tại trở đi
    $schedules = WorkSchedule::all();

    // Truyền dữ liệu vào view với with()
    return view('appointments.create')
        ->with('services', $services)
        ->with('doctors', $doctors)
        ->with('schedules', $schedules);
}



   public function store(Request $request)
{
    $request->validate([
        'doctor_id' => 'required|exists:doctors,doctor_id',
        'service_id' => 'required|exists:services,service_id',
         'appointment_date' => 'required|date|after_or_equal:today',
         'appointment_shift' => 'required|in:morning,afternoon,evening', // thêm dòng này
        ]);

    $user = Auth::user();
    $patient = Patient::where('user_id', $user->user_id)->first();

    if (!$patient) {
        return back()->withErrors('Không tìm thấy hồ sơ bệnh nhân.');
    }
    // kiểm tra theo lịch làm việc của bác sĩ nếu bác sĩ đó có 3 cuộc hẹn trong 1 ngày thì k đặt được
    $appointments = Appointment::where('doctor_id', $request->doctor_id)
        ->where('time', $request->appointment_date)
        ->count();
    if ($appointments >= 3) {
        return redirect()->route('appointments.create')->with('error', 'Bác sĩ đã đạt giới hạn khám trong ngày.');
    }

    $appointment = Appointment::create([
        'patient_id' => $patient->patient_id,
        'doctor_id' => $request->doctor_id,
        'service_id' => $request->service_id,
        'shift' => $request->appointment_shift,
        'status' => 'pending',
        'time' => $request->appointment_date, // hoặc lấy theo ca làm việc
        'queue_number' => 1, // xử lý logic hàng đợi riêng bằng số thứ tự trước + 1
    ]);
 broadcast(new AppointmentCreated($appointment))->toOthers();
    // Ghi vào hồ sơ bệnh án
    MedicalRecord::create([
        'appointment_id' => $appointment->appointment_id,
        'patient_id' => $patient->patient_id,
        'doctor_id' => $request->doctor_id,
        'date'=> $appointment->time,
      
    ]);

    return redirect()->route('appointments.create')->with('success', 'Đăng ký lịch hẹn thành công!');
}

public function myAppointmentsView()
{
    return view('appointments.my-calendar');
}

public function myAppointmentsApi()
{
    $user = Auth::user();
    $appointments = Appointment::with(['doctor.user', 'service'])
        ->where('patient_id', $user->patient->patient_id)
        ->get();

        $events = $appointments->map(function($a) {
            return [
                'title' => $a->service->name . ' - ' . ucfirst($a->shift),
                'start' => $a->time,
                'allDay' => true,
                'extendedProps' => [
                    'service' => $a->service->name,
                    'shift' => ucfirst($a->shift),
                    'doctor' => $a->doctor->user->name ?? '',
                    'status' => $a->status ?? 'Chưa rõ',
                ],
            ];
        });
        

    return response()->json($events);
}
}