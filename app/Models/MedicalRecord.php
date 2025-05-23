<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class MedicalRecord extends Model
{use HasFactory;
    protected $primaryKey = 'medical_record_id';
protected $fillable = [
    'appointment_id',
    'patient_id',
    'diagnosis',
    'date',
    // thêm các trường khác nếu có
];
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
public function patient()
{
    return $this->belongsTo(Patient::class, 'patient_id');
}
    public function prescription()
    {
        return $this->hasOne(Prescription::class, 'medical_record_id');
    }
    
}
