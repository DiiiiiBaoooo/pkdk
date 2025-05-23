<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class PrescriptionDetail extends Model
{use HasFactory;
    protected $primaryKey = 'prescription_detail_id';
 protected $fillable = [
        'prescription_id',
        'medicine_id',
        'quantity',
        'instruction',
    ];
    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id');
    }

    public function medicines()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }
}

