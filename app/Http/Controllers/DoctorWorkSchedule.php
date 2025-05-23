<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkSchedule;
class DoctorWorkSchedule extends Controller
{
    //
    public function register()
    {
        $doctor = Doctor::where('user_id', Auth::user()->user_id)->with('user')->first();
        if (!$doctor) {
            return redirect()->back()->with('error', 'Không tìm thấy bác sĩ.');
        }
        return view('doctor.Work_schedule.register', compact('doctor'));
    }
    public function store(Request $request)
{
    $request->validate([
        'work_date' => 'required|date',
        'shift' => 'required|in:morning,afternoon,evening',
    ]);

    // Lấy doctor_id từ user đăng nhập
    $doctor = Doctor::where('user_id', Auth::user()->user_id)->with('user')->first();

    if (!$doctor) {
        return back()->with('error', 'Không tìm thấy thông tin bác sĩ.');
    }

    $exists = WorkSchedule::where('doctor_id', $doctor->doctor_id)
        ->where('work_date', $request->work_date)
        ->where('shift', $request->shift)
        ->exists();

    if ($exists) {
        return back()->with('error', 'Lịch làm việc đã tồn tại.');
    }
    //kiểm tra đăng ký làm việc trước ngày hiện tại thì không được
    $currentDate = now()->toDateString();
    if ($request->work_date < $currentDate) {
        return back()->with('error', 'Ngày làm việc không được nhỏ hơn ngày hiện tại.');
    }

    $checkworkdate = WorkSchedule::where('work_date', $request->work_date)->count();
    if ($checkworkdate >= 5) {
        return back()->with('error', 'Ngày này đã có 5 bác sĩ làm việc.');
    }

    WorkSchedule::create([
        'doctor_id' => $doctor->doctor_id,
        'work_date' => $request->work_date,
        'shift' => $request->shift,
    ]);
    // trở về trang xem lịch làm việc
    return redirect()->route('doctor.work-schedule')->with('success', 'Đăng ký lịch làm việc thành công!');
}
public function showSchedule()
{
    $doctor = Doctor::where('user_id', Auth::user()->user_id)->with('user')->first();
    $doctor_id = $doctor->doctor_id;
    $schedules = WorkSchedule::where('doctor_id', $doctor_id)->get();

    // Chuyển đổi về định dạng mà FullCalendar yêu cầu
    $events = $schedules->map(function ($schedule) {
        return [
            'title' => ucfirst($schedule->shift), // ca trực
            'start' => $schedule->work_date,
        ];
    });

    return view('doctor.Work_schedule.index', [
        'workSchedules' => $events
    ]);
}


}
