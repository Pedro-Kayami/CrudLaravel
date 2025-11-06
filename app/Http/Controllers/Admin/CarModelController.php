<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CarModelController extends Controller
{
    public function index(): View
    {
        return view('admin.models.index', [
            'models' => CarModel::with('brand')->orderBy('name')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.models.create', [
            'brands' => $this->cachedBrands(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'brand_id' => ['required', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:120'],
            'segment' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
        ]);

        CarModel::create($data);
        $this->clearModelCaches();

        return redirect()->route('admin.models.index')->with('status', 'Modelo cadastrado com sucesso!');
    }

    public function edit(CarModel $model): View
    {
        return view('admin.models.edit', [
            'model' => $model,
            'brands' => $this->cachedBrands(),
        ]);
    }

    public function update(Request $request, CarModel $model): RedirectResponse
    {
        $data = $request->validate([
            'brand_id' => ['required', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:120'],
            'segment' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
        ]);

        $model->update($data);
        $this->clearModelCaches();

        return redirect()->route('admin.models.index')->with('status', 'Modelo atualizado!');
    }

    public function destroy(CarModel $model): RedirectResponse
    {
        $model->delete();
        $this->clearModelCaches();

        return redirect()->route('admin.models.index')->with('status', 'Modelo removido.');
    }

    private function cachedBrands()
    {
        return Cache::remember('brands.options', now()->addMinutes(10), fn () => Brand::orderBy('name')->get());
    }

    private function clearModelCaches(): void
    {
        Cache::forget('models.options');
        Cache::forget('dashboard.metrics');
    }
}
