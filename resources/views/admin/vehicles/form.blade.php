@php
    $vehicle = $vehicle ?? new \App\Models\Vehicle();
@endphp
@csrf
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Título do Anúncio</label>
        <input type="text" name="title" value="{{ old('title', $vehicle->title ?? '') }}" class="form-control @error('title') is-invalid @enderror" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Ano</label>
        <input type="number" min="1980" max="{{ now()->year + 1 }}" name="year" value="{{ old('year', $vehicle->year ?? now()->year) }}" class="form-control @error('year') is-invalid @enderror" required>
        @error('year')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Marca</label>
        <select name="brand_id" id="brandSelect" class="form-select @error('brand_id') is-invalid @enderror" required>
            <option value="">Selecione</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" @selected(old('brand_id', $vehicle->brand_id ?? '') == $brand->id)>{{ $brand->name }}</option>
            @endforeach
        </select>
        @error('brand_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Modelo</label>
        <select name="car_model_id" id="modelSelect" class="form-select @error('car_model_id') is-invalid @enderror" required>
            <option value="">Selecione</option>
            @foreach ($models as $model)
                <option value="{{ $model->id }}" data-brand="{{ $model->brand_id }}" @selected(old('car_model_id', $vehicle->car_model_id ?? '') == $model->id)>
                    {{ $model->brand->name }} - {{ $model->name }}
                </option>
            @endforeach
        </select>
        @error('car_model_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Cor</label>
        <select name="color_option_id" class="form-select @error('color_option_id') is-invalid @enderror">
            <option value="">Selecione</option>
            @foreach ($colors as $color)
                <option value="{{ $color->id }}" @selected(old('color_option_id', $vehicle->color_option_id ?? '') == $color->id)>
                    {{ $color->name }}
                </option>
            @endforeach
        </select>
        @error('color_option_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Quilometragem</label>
        <input type="number" min="0" name="mileage" value="{{ old('mileage', $vehicle->mileage ?? 0) }}" class="form-control @error('mileage') is-invalid @enderror" required>
        @error('mileage')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Valor</label>
        <input type="number" step="0.01" min="1000" name="price" value="{{ old('price', $vehicle->price ?? '') }}" class="form-control @error('price') is-invalid @enderror" required>
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Transmissão</label>
        <input type="text" name="transmission" value="{{ old('transmission', $vehicle->transmission ?? '') }}" class="form-control @error('transmission') is-invalid @enderror">
        @error('transmission')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Combustível</label>
        <input type="text" name="fuel_type" value="{{ old('fuel_type', $vehicle->fuel_type ?? '') }}" class="form-control @error('fuel_type') is-invalid @enderror">
        @error('fuel_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12">
        <label class="form-label">Descrição</label>
        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $vehicle->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12">
        <label class="form-label">Foto Principal (URL)</label>
        <input type="url" name="main_photo_url" value="{{ old('main_photo_url', $vehicle->main_photo_url ?? '') }}" class="form-control @error('main_photo_url') is-invalid @enderror" required>
        @error('main_photo_url')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12">
        <label class="form-label d-flex justify-content-between">
            Galeria de Fotos (mínimo 2 para totalizar 3)
            <button type="button" class="btn btn-sm btn-outline-primary" id="addPhotoField">
                <i class="bi bi-plus-circle"></i> Adicionar link
            </button>
        </label>
        @error('gallery_urls')
            <div class="text-danger small mb-2">{{ $message }}</div>
        @enderror
        <div id="galleryFields" class="vstack gap-2">
            @php
                $galleryInputs = old('gallery_urls', $gallery ?? ['', '']);
                if (count($galleryInputs) < 2) {
                    $galleryInputs = array_merge($galleryInputs, array_fill(0, 2 - count($galleryInputs), ''));
                }
            @endphp
            @foreach ($galleryInputs as $index => $value)
                <input type="url" name="gallery_urls[]" value="{{ $value }}" class="form-control @error('gallery_urls.' . $index) is-invalid @enderror" placeholder="https://exemplo.com/foto{{ $index + 1 }}.jpg" required>
                @error('gallery_urls.' . $index)
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            @endforeach
        </div>
    </div>
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" name="is_published" id="is_published" @checked(old('is_published', $vehicle->is_published ?? true))>
            <label class="form-check-label" for="is_published">
                Publicar veículo no site
            </label>
        </div>
    </div>
</div>
<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button class="btn btn-primary">{{ $submitLabel }}</button>
</div>

@push('scripts')
    <script>
        const brandSelect = document.getElementById('brandSelect');
        const modelSelect = document.getElementById('modelSelect');
        const addPhotoFieldBtn = document.getElementById('addPhotoField');
        const galleryFields = document.getElementById('galleryFields');

        function filterModels() {
            const selectedBrand = brandSelect.value;
            [...modelSelect.options].forEach(option => {
                if (!option.value) return;
                const match = !selectedBrand || option.dataset.brand === selectedBrand;
                option.hidden = !match;
                if (!match && option.selected) {
                    option.selected = false;
                }
            });
        }

        brandSelect?.addEventListener('change', filterModels);
        filterModels();

        addPhotoFieldBtn?.addEventListener('click', () => {
            const input = document.createElement('input');
            input.type = 'url';
            input.name = 'gallery_urls[]';
            input.required = true;
            input.placeholder = 'https://exemplo.com/foto.jpg';
            input.className = 'form-control';
            galleryFields.appendChild(input);
        });
    </script>
@endpush
