<?php
// app/Models/Accountant.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accountant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_code',
        'Specialization',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }   
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
