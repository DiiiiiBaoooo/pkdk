<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
class User extends Authenticatable
{
    use HasFactory, Notifiable; // <- Thêm HasFactory vào đây

    protected $primaryKey = 'user_id';
public function patient()
{
    return $this->hasOne(Patient::class, 'patient_id', 'user_id');
}
    protected $fillable = [
        'username',
        'password',
        'role',
        'status',
        'name',
        'gender',
        'date',
        'address',
        'email',
        'phone',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function isDoctor()
{
    return $this->role === 'doctor';
}
public function accountant()
{
    return $this->hasOne(Accountant::class);
}
public function isPatient()
{
    return $this->role === 'patient';
}
public function isPHARMACIST ()
{
    return $this->role === 'pharmacist';
}
public function isRECEPTIONIST ()
{
    return $this->role === 'receptionist';
}
public function isACCOUNTANT ()
{
    return $this->role === 'accountant';
}
public function employee()
{
    return $this->hasOne(Employee::class, 'user_id', 'user_id');
}
public function isHR ()
{
    return $this->role === 'hr';
}
public function messages()
{
    return $this->hasMany(ChatMessage::class, 'user_id');
}
public function isOnline()
{
   //kiem tra trong table session co user_id = $this->user_id thi tra ve true
   $session = DB::table('sessions')->where('user_id', $this->user_id)->first();
   if ($session) {
    return true;
   }
   return false;
}
public function unreadMessages()
{
    $unread_messages = ChatMessage::where('sender_id', $this->user_id)
        ->where('is_read', false)
        ->count();
    return $unread_messages;
}

public function sentMessages()
{
    return $this->hasMany(ChatMessage::class, 'sender_id', 'user_id');
}

public function receivedMessages()
{
    return $this->hasMany(ChatMessage::class, 'receiver_id', 'user_id');
}
public function doctors()
{
    return $this->hasOne(Doctor::class, 'user_id', 'user_id');
}
}
