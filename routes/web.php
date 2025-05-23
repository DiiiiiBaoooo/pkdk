<?php

use App\Http\Controllers\DoctorAppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenController;
use App\Http\Controllers\ServiceController;
use App\Events\PrivateNotificationEvent;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MedicineStatisticController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\HumanResourceController;
use App\Events\MessageSent;
use App\Events\NotificationSent;
use App\Http\Controllers\DoctorWorkSchedule;
use App\Models\ChatMessage;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
});

Route::get('/homepage', function () {
    return view('Homepage');
})->name('homepage');

Route::get('/gioithieu', function () {
    return view('detail');
})->name('gioithieu');

Route::get('dangnhap', [AuthenController::class, 'showLoginForm'])->name('show.login');
Route::post('dangnhap', [AuthenController::class, 'login'])->name('login');
Route::get('/dangky', [AuthenController::class, 'showRegisterForm'])->name('show.register');
Route::post('/dangky', [AuthenController::class, 'register'])->name('register');

Route::post('logout', [AuthenController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('profile', [UserController::class, 'show'])->name('show.profile');
    Route::post('profile/update', [UserController::class, 'update'])->name('update');

    Route::get('/my-appointments', [App\Http\Controllers\AppointmentController::class, 'myAppointmentsView'])->name('appointments.my');
    Route::get('/api/my-appointments', [App\Http\Controllers\AppointmentController::class, 'myAppointmentsApi'])->name('api.my-appointments');
    Route::get('/api/doctors/{doctor}/work-schedule', function ($doctorId) {
        $schedules = \App\Models\WorkSchedule::where('doctor_id', $doctorId)
            ->orderBy('work_date')
            ->get(['work_date', 'shift']);
    
        return response()->json($schedules);
    });
    
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/medical-record', [MedicalRecordController::class, 'show'])->name('medicalRecord.show');
    Route::get('/doctor/appointments', [DoctorAppointmentController::class, 'index'])->name('doctor.appointments.index');
    Route::post('/doctor/medical-record/update', [MedicalRecordController::class, 'update'])->name('doctor.medicalRecord.update');
    Route::get('/prescription/{appointmentId}', [MedicalRecordController::class, 'showPrescription'])->name('prescription.show');

    Route::get('/medicines/statistics', [MedicineStatisticController::class, 'index'])->name('medicines.statistics');
    Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
    Route::post('/medicines', [MedicineController::class, 'store'])->name('medicines.store');
    Route::get('/medicines/update-stock', [MedicineController::class, 'showUpdateForm'])->name('medicines.updateForm');
    Route::post('/medicines/update-stock', [MedicineController::class, 'updateStock'])->name('medicines.updateStock');

    Route::get('/pharmacist/patients', [PrescriptionController::class, 'listPatientsWithPrescriptions'])->name('prescriptions.patients');
    Route::get('/prescriptions/{appointment}', [PrescriptionController::class, 'showByAppointment'])->name('prescriptions.show');
    Route::post('/prescriptions/confirm/{appointment}', [PrescriptionController::class, 'confirm'])->name('prescriptions.confirm');
    Route::get('/doctor/work-schedule/register', [DoctorWorkSchedule::class, 'register'])->name('doctor.work-schedule.register');
    Route::post('/doctor/work-schedule/{doctor_id}', [DoctorWorkSchedule::class, 'store'])->name('doctor.work-schedule.store');
    Route::get('/doctor/work-schedule', [DoctorWorkSchedule::class, 'showSchedule'])->name('doctor.work-schedule');

    Route::get('/invoices/select-patient', [InvoiceController::class, 'selectPatient'])->name('invoices.selectPatient');
    Route::get('/invoices/create', [InvoiceController::class, 'createForm'])->name('invoices.createForm');
    Route::get('/invoices/fetch-patient', [InvoiceController::class, 'fetchPatientData'])->name('invoices.fetchPatientData');
    Route::post('/invoices/store', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::put('/invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus');
    Route::get('/invoices/patient/unpaid', [InvoiceController::class, 'unpaidInvoices'])->name('invoices.patient.unpaid');
    Route::post('/momo-payment', [InvoiceController::class, 'momo_payment'])->name('momo.payment');
    Route::post('/momo/ipn', [InvoiceController::class, 'momoIpn']);
Route::post('/invoices/patient/show/{invoice_id}',[InvoiceController::class, 'momoIpn'])->name('momoIpn');
    Route::get('/invoices/patient/show/{invoice_id}', [InvoiceController::class, 'showInvoice'])->name('invoices.patient.show');
    Route::get('/patient/payment-history', [PatientController::class, 'paymentHistory'])->name('patient.payment-history');
    Route::get('/employees', [HumanResourceController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [HumanResourceController::class, 'create'])->name('employees.create');
    Route::post('/employees', [HumanResourceController::class, 'store'])->name('employees.store');
    Route::get('/employees/edit/{user_id}', [HumanResourceController::class, 'editform'])->name('employees.edit');
    Route::post('/employees/update', [HumanResourceController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{user_id}', [HumanResourceController::class, 'destroy'])->name('employees.destroy');

    Route::get('/users/{user_id}', function () {
        return view('users', [
            // lọc theo từng role
            'users' => User::whereNot('user_id', Auth::user()->user_id)->get()
        ]);
    })->name('users');

    Route::get('/chat/{friend}', function (User $friend) {
        ChatMessage::where('sender_id', $friend->user_id)
            ->where('receiver_id', Auth::user()->user_id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        return view('chat', [
            'friend' => $friend
        ]);
    })->name('chat');

    Route::get('/messages/{friend}', function (User $friend) {

        return ChatMessage::query()
            ->where(function ($query) use ($friend) {
                $query->where('sender_id', Auth::user()->user_id)
                    ->where('receiver_id', $friend->user_id);
            })
            ->orWhere(function ($query) use ($friend) {
                $query->where('sender_id', $friend->user_id)
                    ->where('receiver_id', Auth::user()->user_id);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('id', 'asc')
            ->get();
    });

    Route::post('/messages/{friend}', function (User $friend) {
        $message = ChatMessage::create([
            'sender_id' => Auth::user()->user_id,
            'receiver_id' => $friend->user_id,
            'is_read' => false,
            'text' => request()->input('message')
        ]);

        $notification = Notification::create([
            'sender_id' => Auth::user()->user_id,
            'receiver_id' => $friend->user_id,
            'message' => 'Bạn có tin nhắn mới từ ' .Auth::user()->name,
        ]);
        $notification->save();
        $unread_messages = ChatMessage::where('receiver_id', $friend->user_id)
            ->where('is_read', false)
            ->count();
        broadcast(new MessageSent($message));
        broadcast(new NotificationSent($notification));
         broadcast(new PrivateNotificationEvent($friend->user_id, 'Bạn có tin nhắn mới từ ' .Auth::user()->name, $unread_messages));
        return $message->load('sender');
    });
    

    Route::get('/notifications', function () {
        $notifications = Notification::where('receiver_id', Auth::user()->user_id)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'message' => $notification->message,
                    'sender_id' => $notification->sender_id,
                    'sender_name' => $notification->sender_name,
                    'created_at' => $notification->created_at->toDateTimeString(),
                ];
            });

        $unread_count = Notification::where('receiver_id', Auth::user()->user_id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unread_count,
        ]);
    });

    Route::post('/notifications/mark-as-read', function () {
        Notification::where('receiver_id', Auth::user()->user_id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        return response()->json(['status' => 'Notifications marked as read']);
    });

    Route::post('/notifications/send', function () {
        $data = request()->validate([
            'receiver_id' => 'required|exists:users,user_id',
            'message' => 'required|string|max:255',
        ]);

        $notification = Notification::create([
            'sender_id' => Auth::user()->user_id,
            'receiver_id' => $data['receiver_id'],
            'message' => $data['message'],
        ]);

        broadcast(new NotificationSent($notification));
        return response()->json(['status' => 'Notification sent']);
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

require __DIR__ . '/auth.php';