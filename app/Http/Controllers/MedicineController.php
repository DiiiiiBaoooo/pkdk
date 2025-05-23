<?php
namespace App\Http\Controllers;
use App\Models\Medicine;
use App\Models\Warehouse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class MedicineController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        if (!$user->isPHARMACIST()) {
            return redirect()->route('homepage')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }
      
        $warehouses = Warehouse::all();
        return view('medicines.create', compact('warehouses'));
    }
    public function showUpdateForm()
    {
        $medicines = Medicine::all();
        $warehouses = Warehouse::all();
    
        return view('medicines.update', compact('medicines', 'warehouses'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'expiration_date' => 'required|date|after:today',
            'warehouse_id' => 'required|exists:warehouses,id',
            'purchase_price' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
            'type' => 'required|string|max:255',
        ]);
    
        Medicine::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'expiration_date' => $request->expiration_date,
            'warehouse_id' => $request->warehouse_id,
            'quantity_used' => 0,
            'purchase_price' => $request->purchase_price,
            'price' => $request->price,
            'type' => $request->type,
        ]);
    
        return redirect()->route('medicines.statistics')->with('success', 'Thêm thuốc thành công.');
    }
    public function updateStock(Request $request)
{
    $request->validate([
        'medicine_id' => 'required|exists:medicines,medicine_id',
        'quantity' => 'required|integer|min:1',
        'purchase_price' => 'required|numeric|min:0',
        'price' => 'required|numeric|min:0',
        'expiration_date' => 'required|date',
        'warehouse_id' => 'required|exists:warehouses,id',
    ]);

    $medicine = Medicine::find($request->medicine_id);

    // Cộng thêm số lượng
    $medicine->quantity += $request->quantity;

    // Cập nhật thông tin mới
    $medicine->purchase_price = $request->purchase_price;
    $medicine->price = $request->price;
    $medicine->expiration_date = $request->expiration_date;
    $medicine->warehouse_id = $request->warehouse_id;

    $medicine->save();

    return redirect()->route('medicines.statistics')->with('success', 'Cập nhật thuốc thành công!');
}
}
