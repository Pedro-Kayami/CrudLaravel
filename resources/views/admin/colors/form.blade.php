@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nome</label>
        <input type="text" name="name" value="{{ old('name', $color->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Hex (ex: #FFFFFF)</label>
        <input type="text" name="hex_code" value="{{ old('hex_code', $color->hex_code ?? '') }}" class="form-control @error('hex_code') is-invalid @enderror">
        @error('hex_code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" name="is_metallic" id="is_metallic" @checked(old('is_metallic', $color->is_metallic ?? false))>
            <label class="form-check-label" for="is_metallic">
                Esta cor possui acabamento metálico
            </label>
        </div>
    </div>
</div>
<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.colors.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button class="btn btn-primary">{{ $submitLabel }}</button>
</div>
