<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CarModel;
use App\Models\ColorOption;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PublicVehicleController extends Controller
{
    public function index(Request $request): View
    {
        $vehiclesQuery = Vehicle::with(['brand', 'carModel', 'colorOption'])
            ->where('is_published', true)
            ->latest();

        if ($request->filled('brand_id')) {
            $vehiclesQuery->where('brand_id', (int) $request->input('brand_id'));
        }

        if ($request->filled('model_id')) {
            $vehiclesQuery->where('car_model_id', (int) $request->input('model_id'));
        }

        if ($request->filled('color_id')) {
            $vehiclesQuery->where('color_option_id', (int) $request->input('color_id'));
        }

        if ($request->filled('max_price')) {
            $vehiclesQuery->where('price', '<=', (float) $request->input('max_price'));
        }

        $vehicles = $vehiclesQuery->paginate(9)->withQueryString();

        return view('public.vehicles.index', [
            'vehicles' => $vehicles,
            'brands' => $this->cachedBrands(),
            'models' => $this->cachedModels(),
            'colors' => $this->cachedColors(),
            'filters' => $request->only(['brand_id', 'model_id', 'color_id', 'max_price']),
        ]);
    }

    public function show(Vehicle $vehicle): View
    {
        if (!$vehicle->is_published && !auth()->check()) {
            abort(404);
        }

        $vehicle->load(['brand', 'carModel', 'colorOption', 'photos']);
        $relatedVehicles = Vehicle::with(['brand', 'carModel'])
            ->where('id', '!=', $vehicle->id)
            ->where('brand_id', $vehicle->brand_id)
            ->where('is_published', true)
            ->take(3)
            ->get();

        return view('public.vehicles.show', [
            'vehicle' => $vehicle,
            'relatedVehicles' => $relatedVehicles,
        ]);
    }

    private function cachedBrands()
    {
        return Cache::remember('brands.options', now()->addMinutes(10), fn () => Brand::orderBy('name')->get());
    }

    private function cachedModels()
    {
        return Cache::remember('models.options', now()->addMinutes(10), fn () => CarModel::orderBy('name')->get());
    }

    private function cachedColors()
    {
        return Cache::remember('colors.options', now()->addMinutes(10), fn () => ColorOption::orderBy('name')->get());
    }
}
