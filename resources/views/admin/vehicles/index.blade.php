@extends('layouts.admin')

@section('title', 'Veículos - AutoHub')
@section('page-title', 'Veículos')
@section('page-description', 'Gerencie o catálogo disponível ao público.')

@section('page-actions')
    <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Novo Veículo
    </a>
@endsection

@section('content')
    <div class="row g-4">
        @forelse ($vehicles as $vehicle)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <img src="{{ $vehicle->main_photo_url }}" class="card-img-top" alt="{{ $vehicle->title }}">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="badge {{ $vehicle->is_published ? 'bg-success' : 'bg-secondary' }}">
                                {{ $vehicle->is_published ? 'Publicado' : 'Rascunho' }}
                            </span>
                            <span class="fw-semibold text-primary">R$ {{ number_format($vehicle->price, 2, ',', '.') }}</span>
                        </div>
                        <h2 class="h5 mt-2">{{ $vehicle->title }}</h2>
                        <p class="text-muted mb-2">{{ $vehicle->brand->name }} • {{ $vehicle->carModel->name }} • {{ $vehicle->year }}</p>
                        <p class="text-muted small mb-4">{{ number_format($vehicle->mileage, 0, '', '.') }} km • {{ $vehicle->fuel_type ?? '—' }}</p>
                        <div class="mt-auto d-flex justify-content-between gap-2">
                            <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-outline-secondary w-100">Editar</a>
                            <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" onsubmit="return confirm('Excluir este veículo?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger w-100">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning mb-0">
                    Nenhum veículo cadastrado ainda. Clique em "Novo Veículo" para começar.
                </div>
            </div>
        @endforelse
    </div>
    <div class="mt-4">
        {{ $vehicles->links() }}
    </div>
@endsection
