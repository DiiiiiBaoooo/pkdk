<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\ValidationException; 

    class AuthenController extends Controller
{
    //
    public function showRegisterForm(){
        if (Auth::check()) {
        return redirect()->route('homepage'); // Hoặc route bạn muốn
    }
        return view('auth.register');
    }
     public function showLoginForm(){
        if (Auth::check()) {
        return redirect()->route('homepage'); // Hoặc route bạn muốn
    }
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $validate = $request->validate([
           'phone' => 'required|string',
        'password' => 'required|string|min:6'
        ]);
        if( Auth::attempt($validate))
        {
            $request->session()->regenerate();
            return redirect()->route('homepage');
        }
        throw ValidationException::withMessages([
            'credentials' => 'sorry, khong dung'
        ]);
       
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('homepage');
    }
    public function register(Request $request)
{
    // ✅ Bước 1: Validate dữ liệu đầu vào
    $request->validate([
        'phone' => 'required|unique:users,phone|digits_between:9,11',
        'password' => 'required|min:6|confirmed',
        'username' => 'required|unique:users,username',
        'name' => 'required',
        'gender' => 'required',
        'date' => 'required|date',
        'address' => 'required',
        'email' => 'required|email|unique:users,email',
    ]);

    // ✅ Bước 2: Tạo user mới và lưu thông tin cá nhân
    $user = User::create([
        'phone' => $request->phone,
        'password' =>Hash::make($request->password), // mã hóa mật khẩu
        'username' => $request->username,
        'role'=>'patient',
        'status'=>'active',
        'name' => $request->name,
        'gender' => $request->gender,
        'date' => $request->date,
        'address' => $request->address,
        'email' => $request->email,
        'creat_at'=> now(),
    ]);

 Patient::create([
        'user_id' => $user->user_id, // chú ý đúng tên cột
        'health_insurance' => null, // hoặc mặc định
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    // ✅ Bước 3: Tự động đăng nhập sau khi đăng ký
    Auth::login($user);

    // ✅ Bước 4: Chuyển hướng người dùng
    return redirect()->route('homepage'); // hoặc bất kỳ route nào bạn muốn
}
}
?>