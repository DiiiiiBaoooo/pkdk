<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
class Appointment extends Model
{
    use HasFactory;
    protected $primaryKey = 'appointment_id';
protected $fillable = ['patient_id', 'doctor_id', 'service_id', 'time', 'status','queue_number'];
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
public function service() {
    return $this->belongsTo(Service::class, 'service_id', 'service_id');
}
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class, 'appointment_id');
    }
public function prescription()
{
    return $this->hasOne(Prescription::class, 'appointment_id');
}
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'appointment_id');
    }
}

