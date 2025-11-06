<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\ColorOption;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function index(): View
    {
        $vehicles = Vehicle::with(['brand', 'carModel', 'colorOption'])
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create(): View
    {
        return view('admin.vehicles.create', $this->formDependencies());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $galleryUrls = $this->extractGalleryUrls($request);

        $vehicle = Vehicle::create($data);
        $this->syncPhotos($vehicle, $galleryUrls);
        $this->forgetDashboardMetrics();

        return redirect()->route('admin.vehicles.index')->with('status', 'Veiculo cadastrado com sucesso!');
    }

    public function edit(Vehicle $vehicle): View
    {
        $vehicle->load('photos');

        return view('admin.vehicles.edit', array_merge(
            $this->formDependencies(),
            [
                'vehicle' => $vehicle,
                'gallery' => $vehicle->photos->pluck('image_url')->values()->toArray(),
            ]
        ));
    }

    public function update(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $data = $this->validateData($request);
        $galleryUrls = $this->extractGalleryUrls($request);

        $vehicle->update($data);
        $this->syncPhotos($vehicle, $galleryUrls);
        $this->forgetDashboardMetrics();

        return redirect()->route('admin.vehicles.index')->with('status', 'Veiculo atualizado!');
    }

    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        $vehicle->delete();
        $this->forgetDashboardMetrics();

        return redirect()->route('admin.vehicles.index')->with('status', 'Veiculo removido.');
    }

    private function validateData(Request $request): array
    {
        $validated = $request->validate([
            'brand_id' => ['required', 'exists:brands,id'],
            'car_model_id' => ['required', 'exists:car_models,id'],
            'color_option_id' => ['nullable', 'exists:color_options,id'],
            'title' => ['required', 'string', 'max:180'],
            'year' => ['required', 'integer', 'min:1980', 'max:' . (now()->year + 1)],
            'mileage' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:1000'],
            'main_photo_url' => ['required', 'url'],
            'transmission' => ['nullable', 'string', 'max:80'],
            'fuel_type' => ['nullable', 'string', 'max:80'],
            'description' => ['nullable', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        return $validated;
    }

    private function extractGalleryUrls(Request $request): Collection
    {
        $validated = $request->validate([
            'gallery_urls' => ['required', 'array', 'min:2'],
            'gallery_urls.*' => ['required', 'url'],
        ]);

        $urls = collect($validated['gallery_urls'] ?? [])->filter();

        if ($urls->count() + 1 < 3) {
            throw ValidationException::withMessages([
                'gallery_urls' => 'Inclua ao menos 3 fotos (contando com a principal).',
            ]);
        }

        return $urls->values();
    }

    private function formDependencies(): array
    {
        return [
            'brands' => Cache::remember('brands.options', now()->addMinutes(10), fn () => Brand::orderBy('name')->get()),
            'models' => Cache::remember('models.options', now()->addMinutes(10), fn () => CarModel::with('brand')->orderBy('name')->get()),
            'colors' => Cache::remember('colors.options', now()->addMinutes(10), fn () => ColorOption::orderBy('name')->get()),
        ];
    }

    private function syncPhotos(Vehicle $vehicle, Collection $urls): void
    {
        $vehicle->photos()->delete();

        foreach ($urls->values() as $index => $url) {
            $vehicle->photos()->create([
                'image_url' => $url,
                'display_order' => $index,
            ]);
        }
    }

    private function forgetDashboardMetrics(): void
    {
        Cache::forget('dashboard.metrics');
    }
}
