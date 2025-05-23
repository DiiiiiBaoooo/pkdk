<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $primaryKey = 'service_id';
    protected $fillable = ['name', 'description'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'service_id');
    }
}
