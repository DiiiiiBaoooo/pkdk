<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function paymentHistory()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->user_id)->first();
        
        if (!$patient) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin bệnh nhân.');
        }

        $invoices = Invoice::with(['prescription.appointment'])
            ->where('patient_id', $patient->patient_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('patients.payment-history', compact('invoices'));
    }
} 