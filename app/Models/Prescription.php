<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Prescription extends Model
{use HasFactory;
    protected $primaryKey = 'prescription_id';
 protected $fillable = [
        'medical_record_id',
        'appointment_id',
        'date_issued',
        'is_confirmed',
        'confirmed_at'
    ];
    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class, 'medical_record_id');
    }
public function appointment()
{
    return $this->belongsTo(Appointment::class, 'appointment_id');
}
    public function prescriptionDetails()
    {
        return $this->hasMany(PrescriptionDetail::class, 'prescription_id');
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'prescription_id');
    }
}
