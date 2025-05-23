<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Medicine extends Model
{use HasFactory;
    protected $primaryKey = 'medicine_id';
    protected $fillable = [
        'name',
        'quantity',
        'purchase_price',
        'price',
        'type',
        'quantity_used',
        'expiration_date',
        'warehouse_id',
    ];
    public function prescriptionDetails()
    {
        return $this->hasMany(PrescriptionDetail::class, 'medicine_id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}

