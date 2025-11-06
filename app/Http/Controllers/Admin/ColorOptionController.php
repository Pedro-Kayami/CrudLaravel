<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ColorOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ColorOptionController extends Controller
{
    public function index(): View
    {
        return view('admin.colors.index', [
            'colors' => ColorOption::orderBy('name')->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.colors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80', 'unique:color_options,name'],
            'hex_code' => ['nullable', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'is_metallic' => ['nullable', 'boolean'],
        ]);

        $data['hex_code'] = $this->normalizeHex($data['hex_code'] ?? null);
        $data['is_metallic'] = (bool) ($data['is_metallic'] ?? false);

        ColorOption::create($data);
        $this->clearColorCaches();

        return redirect()->route('admin.colors.index')->with('status', 'Cor cadastrada com sucesso!');
    }

    public function edit(ColorOption $color): View
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(Request $request, ColorOption $color): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80', 'unique:color_options,name,' . $color->id],
            'hex_code' => ['nullable', 'regex:/^#?[0-9A-Fa-f]{6}$/'],
            'is_metallic' => ['nullable', 'boolean'],
        ]);

        $color->update([
            'name' => $data['name'],
            'hex_code' => $this->normalizeHex($data['hex_code'] ?? null),
            'is_metallic' => (bool) ($data['is_metallic'] ?? false),
        ]);

        $this->clearColorCaches();

        return redirect()->route('admin.colors.index')->with('status', 'Cor atualizada!');
    }

    public function destroy(ColorOption $color): RedirectResponse
    {
        $color->delete();
        $this->clearColorCaches();

        return redirect()->route('admin.colors.index')->with('status', 'Cor removida.');
    }

    private function normalizeHex(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        return str_starts_with($value, '#') ? $value : '#' . $value;
    }

    private function clearColorCaches(): void
    {
        Cache::forget('colors.options');
        Cache::forget('dashboard.metrics');
    }
}
