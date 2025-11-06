@extends('layouts.public')

@section('title', $vehicle->title . ' - AutoHub')

@section('content')
    <a href="{{ url()->previous() === url()->current() ? route('home') : url()->previous() }}" class="text-decoration-none text-muted mb-3 d-inline-flex align-items-center">
        <i class="bi bi-arrow-left me-2"></i>Voltar
    </a>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="ratio ratio-16x9">
                    <img src="{{ $vehicle->main_photo_url }}" class="rounded-top object-fit-cover" alt="{{ $vehicle->title }}">
                </div>
            </div>
            <div class="row g-3">
                @foreach ($vehicle->photos as $photo)
                    <div class="col-md-4">
                        <div class="ratio ratio-16x9">
                            <img src="{{ $photo->image_url }}" class="rounded object-fit-cover" alt="Foto do veículo">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-uppercase text-primary fw-semibold small mb-1">{{ $vehicle->brand->name }} / {{ $vehicle->carModel->name }}</p>
                    <h1 class="h3 fw-bold">{{ $vehicle->title }}</h1>
                    <p class="text-muted">{{ $vehicle->colorOption->name ?? 'Cor não informada' }}</p>

                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div class="row text-center">
                            <div class="col-4">
                                <p class="text-muted small mb-1">Ano</p>
                                <p class="fw-semibold mb-0">{{ $vehicle->year }}</p>
                            </div>
                            <div class="col-4">
                                <p class="text-muted small mb-1">KM</p>
                                <p class="fw-semibold mb-0">{{ number_format($vehicle->mileage, 0, '', '.') }}</p>
                            </div>
                            <div class="col-4">
                                <p class="text-muted small mb-1">Combustível</p>
                                <p class="fw-semibold mb-0">{{ $vehicle->fuel_type ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    <h2 class="h3 text-primary fw-bold mb-4">R$ {{ number_format($vehicle->price, 2, ',', '.') }}</h2>

                    <div class="border-top pt-4">
                        <h3 class="h5 fw-semibold">Detalhes</h3>
                        <ul class="list-unstyled text-muted mb-4">
                            <li><i class="bi bi-check-circle text-success me-2"></i>Transmissão: {{ $vehicle->transmission ?? '—' }}</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Modelo: {{ $vehicle->carModel->name }}</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Marca: {{ $vehicle->brand->name }}</li>
                        </ul>
                        <p class="text-muted">{{ $vehicle->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($relatedVehicles->isNotEmpty())
        <div class="mt-5">
            <h2 class="h4 fw-semibold mb-3">Veja também</h2>
            <div class="row g-4">
                @foreach ($relatedVehicles as $related)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="ratio ratio-16x9">
                                <img src="{{ $related->main_photo_url }}" class="object-fit-cover" alt="{{ $related->title }}">
                            </div>
                            <div class="card-body">
                                <h3 class="h6">{{ $related->title }}</h3>
                                <p class="text-muted small mb-2">{{ $related->year }} • {{ number_format($related->mileage, 0, '', '.') }} km</p>
                                <p class="fw-semibold text-primary">R$ {{ number_format($related->price, 2, ',', '.') }}</p>
                                <a href="{{ route('vehicles.show', $related) }}" class="btn btn-outline-primary btn-sm">Detalhes</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
