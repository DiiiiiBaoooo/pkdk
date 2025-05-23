<?php

namespace App\Http\Controllers;
use App\Models\Service; 

// Đảm bảo import model Service
use Illuminate\Http\Request;

class Servicecontroller extends Controller
{
    // Hiển thị danh sách dịch vụ
    public function index()
    {
        $services = Service::all(); // Lấy tất cả dịch vụ
        return view('services.index', compact('services')); // Trả về view danh sách dịch vụ
    }

    // Hiển thị form tạo dịch vụ mới
    public function create()
    {
        return view('services.create'); // Form tạo dịch vụ
    }

    // Lưu dịch vụ mới vào CSDL
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Service::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('services.index')->with('success', 'Dịch vụ đã được thêm thành công!');
    }

    // Hiển thị form chỉnh sửa dịch vụ
    public function edit($id)
    {
        $service = Service::findOrFail($id); // Tìm dịch vụ theo ID
        return view('services.edit', compact('service')); // Form chỉnh sửa dịch vụ
    }

    // Cập nhật dịch vụ
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id); // Tìm dịch vụ theo ID

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('services.index')->with('success', 'Dịch vụ đã được cập nhật thành công!');
    }

    // Xóa dịch vụ
    public function destroy($id)
    {
        $service = Service::findOrFail($id); // Tìm dịch vụ theo ID
        $service->delete(); // Xóa dịch vụ

        return redirect()->route('services.index')->with('success', 'Dịch vụ đã được xóa thành công!');
    }
}
