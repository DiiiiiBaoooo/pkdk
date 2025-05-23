<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Patient extends Model
{use HasFactory;
    protected $primaryKey = 'patient_id';
protected $fillable = [
    'user_id',
    'health_insurance',
];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
public function medicalRecords()
{
    return $this->hasMany(MedicalRecord::class, 'patient_id', 'patient_id');
}
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }
public function patient()
{
    return $this->hasOne(User::class, 'patient_id', 'user_id');
}
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'patient_id');
    }
}
