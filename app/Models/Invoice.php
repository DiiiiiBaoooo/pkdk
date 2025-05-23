<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Invoice extends Model
{use HasFactory;
    protected $primaryKey = 'invoice_id';
    protected $fillable = [
        'patient_id',
        'prescription_id',
        'accountant_id',
        'appointment_id',
        'issue_date',
        'due_date',
        'status',
        'payment_method',
        'total_amount',
    ];

    public $timestamps = true;

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id');
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }
    public function accountant()
    {
        return $this->belongsTo(Accountant::class, 'accountant_id');
    }
}

