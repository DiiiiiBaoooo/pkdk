<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class WorkSchedule extends Model
{use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['doctor_id', 'work_date', 'shift'];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}

