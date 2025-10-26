<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\LembagaDesa;
use App\Models\Rw;
use App\Models\Rt;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalWarga' => Warga::count(),
            'totalLembaga' => LembagaDesa::count(),
            'totalRw' => Rw::count(),
            'totalRt' => Rt::count(),
        ];

        return view('admin.dashboard', $data);
    }
}
