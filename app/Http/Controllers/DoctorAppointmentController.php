<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Medicine;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DoctorAppointmentController extends Controller
{
    //
    public function index(Request $request)
{
    $doctor = Doctor::where('user_id', Auth::id())->with('user')->first();
    if (!$doctor) {
        return redirect()->back()->with('error', 'Không tìm thấy bác sĩ.');
    }
 $medicines = Medicine::all();
    // Lấy tháng và năm từ query hoặc mặc định là hiện tại
    $month = $request->query('month', now()->month);
    $year = $request->query('year', now()->year);

    $startOfMonth = Carbon::create($year, $month, 1);
    $daysInMonth = $startOfMonth->daysInMonth;
    $startDayOfWeek = $startOfMonth->dayOfWeek;

    $appointments = $doctor->appointments()
        ->whereMonth('time', $month)
        ->whereYear('time', $year)
        ->with('patient.user')
        ->get();

    return view('doctor.appointments.index', compact('medicines','doctor',
        'appointments', 'month', 'year', 'daysInMonth', 'startDayOfWeek'
    ));
}
}
