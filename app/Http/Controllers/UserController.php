<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function show()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user(); // Make sure $user is initialized

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            // 'email' => 'required|email|max:255|unique:users,email,'.$user->user_id , // Fix email validation rule
            'gender' => 'nullable|in:Nam,Nữ,Khác',
            'date_of_birth' => 'nullable|date|before:today -13 years',
            'address' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'name.string' => 'Họ tên không hợp lệ.',
            'name.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'phone.string' => 'Số điện thoại không hợp lệ.',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'gender.in' => 'Giới tính phải là Nam, Nữ hoặc Khác.',
            'date_of_birth.date' => 'Ngày sinh không hợp lệ.',
            'date_of_birth.before' => 'Bạn phải ít nhất 13 tuổi.',
            'address.string' => 'Địa chỉ không hợp lệ.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
        ]);

        try {
            $user->update($request->only([
                'name',
                'phone',
                'gender',
                'date_of_birth',
                'address'
            ]));

            Log::info('Cập nhật hồ sơ người dùng', ['user_id' => $user->id]);
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công.');
        } catch (Exception $e) {
            Log::error('Cập nhật hồ sơ thất bại', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Cập nhật thông tin thất bại. Vui lòng thử lại.');
        }
    }
}
