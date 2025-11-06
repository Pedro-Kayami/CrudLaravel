<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\ColorOption;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $metrics = Cache::remember('dashboard.metrics', now()->addMinutes(5), function () {
            return [
                'totalVehicles' => Vehicle::count(),
                'totalBrands' => Brand::count(),
                'totalModels' => CarModel::count(),
                'totalColors' => ColorOption::count(),
                'latestVehicles' => Vehicle::latest()
                    ->with(['brand', 'carModel'])
                    ->take(5)
                    ->get(),
            ];
        });

        return view('admin.dashboard', $metrics);
    }
}
