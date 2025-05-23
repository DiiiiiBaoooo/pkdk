<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class InvoiceDetail extends Model
{use HasFactory;
    protected $primaryKey = 'invoice_detail_id';
    protected $fillable = [
        'invoice_id',
        'service_id',
        'total_price',
        'payment_date',
    ];

    public $timestamps = true;

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
