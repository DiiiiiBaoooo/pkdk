<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class MedicineStatisticController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('search');
        // Kiểm tra nếu người dùng không phải là Pharmacist
        if (!$user->isPHARMACIST()) {
            return redirect()->route('homepage')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }
        $warehouseId = $request->input('warehouse_id');

        // Lấy danh sách kho
        $warehouses = Warehouse::all();

        // Query thuốc
        $query = Medicine::query();
        if ($warehouseId) {
            $query->where('warehouse_id', $warehouseId);
        }
        $medicines = $query->with('warehouse')->get();
        $medicines_expired = $query->with('warehouse')->where('expiration_date', '>', now())->get();
        $medicines_conhan = $query->with('warehouse')
        ->where('expiration_date', '>', now()) // Thêm dòng này để lọc thuốc còn hạn
        ->get();
        // Thống kê
        $totalMedicines = $medicines->count();
        $totalInStock = $medicines->sum('quantity');
        $totalUsed = $medicines->sum('quantity_used');
        $nearlyExpired = $medicines->where('expiration_date', '<=', now()->addDays(0));

        return view('medicines.statistics', compact(
            'warehouses',
            'warehouseId',
            'totalMedicines',
            'totalInStock',
            'totalUsed',
            'nearlyExpired',
            'medicines',
            'medicines_expired',
            'medicines_conhan'
        ));
    }
}

