@extends('layouts.public')

@section('title', 'Catálogo de Veículos - AutoHub')

@section('content')
    <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm mb-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <p class="text-primary fw-semibold text-uppercase mb-2">Encontre seu próximo carro</p>
                <h1 class="display-6 fw-bold">Portal AutoHub</h1>
                <p class="text-muted mb-4">
                    Explore diferentes marcas, modelos e cores. Cada anúncio inclui fotos, quilometragem, ano e valor para facilitar a decisão.
                </p>
            </div>
            <div class="col-lg-5">
                <form class="row g-3" method="GET">
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Marca</label>
                        <select name="brand_id" class="form-select">
                            <option value="">Todas</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @selected(($filters['brand_id'] ?? null) == $brand->id)>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Modelo</label>
                        <select name="model_id" class="form-select">
                            <option value="">Todos</option>
                            @foreach ($models as $model)
                                <option value="{{ $model->id }}" @selected(($filters['model_id'] ?? null) == $model->id)>{{ $model->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Cor</label>
                        <select name="color_id" class="form-select">
                            <option value="">Todas</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}" @selected(($filters['color_id'] ?? null) == $color->id)>{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Preço máximo (R$)</label>
                        <input type="number" name="max_price" class="form-control" value="{{ $filters['max_price'] ?? '' }}" placeholder="Ex: 120000">
                    </div>
                    <div class="col-12 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1" type="submit">
                            <i class="bi bi-search me-1"></i>Filtrar
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Limpar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse ($vehicles as $vehicle)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm overflow-hidden">
                    <div class="ratio ratio-16x9">
                        <img src="{{ $vehicle->main_photo_url }}" class="object-fit-cover" alt="{{ $vehicle->title }}">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-primary-subtle text-primary mb-2">{{ $vehicle->brand->name }} • {{ $vehicle->carModel->name }}</span>
                        <h2 class="h5">{{ $vehicle->title }}</h2>
                        <p class="text-muted small mb-3">{{ $vehicle->year }} • {{ number_format($vehicle->mileage, 0, '', '.') }} km • {{ $vehicle->colorOption->name ?? 'Cor não informada' }}</p>
                        <p class="fs-5 fw-semibold text-primary mb-4">R$ {{ number_format($vehicle->price, 2, ',', '.') }}</p>
                        <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-outline-primary mt-auto">Ver detalhes</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Nenhum veículo encontrado com os filtros selecionados.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-5">
        {{ $vehicles->links() }}
    </div>
@endsection
