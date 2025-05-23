<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'user_id', 'position', 'hire_date', 'salary',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
