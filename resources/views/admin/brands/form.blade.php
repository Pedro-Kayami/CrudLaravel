@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nome</label>
        <input type="text" name="name" value="{{ old('name', $brand->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">País de Origem</label>
        <input type="text" name="country" value="{{ old('country', $brand->country ?? '') }}" class="form-control @error('country') is-invalid @enderror">
        @error('country')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Site Oficial</label>
        <input type="url" name="website" value="{{ old('website', $brand->website ?? '') }}" class="form-control @error('website') is-invalid @enderror">
        @error('website')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Logo (URL)</label>
        <input type="url" name="logo_url" value="{{ old('logo_url', $brand->logo_url ?? '') }}" class="form-control @error('logo_url') is-invalid @enderror">
        @error('logo_url')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button class="btn btn-primary">{{ $submitLabel }}</button>
</div>
