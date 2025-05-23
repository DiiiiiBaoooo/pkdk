<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Accountant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class HumanResourceController extends Controller
{
    //
    public function index()
    {
        if(!Auth::user()->role === 'hr')
        {
            return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }
        // hiển thị danh sách tài khoản có role : 'doctor,pharmacist,receptionist,accountant'
        $employees = User::whereIn('role', ['doctor', 'pharmacist', 'receptionist', 'accountant'])->simplePaginate(10);

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('employee')->get(); // chưa là nhân viên
        return view('employees.create', compact('users'));
    }

    public function editform($employee_id)
    {
        $employee = User::findOrFail($employee_id);
        return view('employees.updateinfo', compact('employee'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user_id . ',user_id',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:Nam,Nữ',
            'date' => 'required|date',
            'address' => 'required|string|max:255',
        ]);

        $employee = User::findOrFail($request->user_id);
        $employee->update($request->only([
            'name',
            'email',
            'date',
            'phone',
            'address',
            'gender',
         
        ]));

        return redirect()->route('employees.index')
            ->with('success', 'Cập nhật thông tin nhân viên thành công.');
    }

    public function store(Request $request)
    {
        $request->validate([
            
            'role' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
          
          
            'gender' => 'required|in:Nam,Nữ',
            'date' => 'required|date',
            'address' => 'required|string|max:255',
            
          
        ]);
$request->merge(['password' => Hash::make('123456')]);
//username được tạo tự động từ email
$request->merge(['username' => substr($request->email, 0, strpos($request->email, '@'))]);
   User::create($request->all());
   if($request->role == 'doctor')
   {
       // thêm 1  dữ liệu ở bảng doctor ứng với bảng user
      Doctor::create([
        //user_id lấy từ bảng user vừa thêm ở bảng trên
        'user_id' => User::where('email', $request->email)->first()->user_id,
       'specialty'=>['Bác sĩ khoa thần kinh','Bác sĩ khoa tim mạch','Bác sĩ khoa hô hấp','Bác sĩ khoa sư tử','Bác sĩ khoa ngoại'][rand(0,4)],
       'created_at'=>now(),
       'updated_at'=>now(),
      ]);
       
               
   }
 
   elseif($request->role == 'accountant')
   {
    // thêm 1  dữ liệu ở bảng receptionist ứng với bảng user
    Accountant::create([
        'user_id' => User::where('email', $request->email)->first()->user_id,
        'Specialization'=>['Kế toán tài chính','Kế toán quản trị','Kế toán thuế','Kế toán hàng hóa','Kế toán khác'][rand(0,4)],
        'created_at'=>now(),
        'updated_at'=>now(),
    ]);
   }
        return redirect()->route('employees.index')
            ->with('success', 'Thêm nhân viên thành công.');
    }

    public function destroy($employee_id)
    {
        $employee = User::findOrFail($employee_id);
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Xóa nhân viên thành công.');
    }
}
