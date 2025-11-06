<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(): View
    {
        return view('admin.brands.index', [
            'brands' => Brand::orderBy('name')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.brands.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:brands,name'],
            'country' => ['nullable', 'string', 'max:100'],
            'website' => ['nullable', 'url'],
            'logo_url' => ['nullable', 'url'],
        ]);

        Brand::create($data);
        $this->clearBrandCaches();

        return redirect()->route('admin.brands.index')->with('status', 'Marca cadastrada com sucesso!');
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:brands,name,' . $brand->id],
            'country' => ['nullable', 'string', 'max:100'],
            'website' => ['nullable', 'url'],
            'logo_url' => ['nullable', 'url'],
        ]);

        $brand->update($data);
        $this->clearBrandCaches();

        return redirect()->route('admin.brands.index')->with('status', 'Marca atualizada!');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();
        $this->clearBrandCaches();

        return redirect()->route('admin.brands.index')->with('status', 'Marca removida.');
    }

    private function clearBrandCaches(): void
    {
        Cache::forget('brands.options');
        Cache::forget('dashboard.metrics');
    }
}
