@extends('layouts.admin')

@section('title', 'Dashboard - AutoHub')
@section('page-title', 'Painel de Controle')
@section('page-description', 'Resumo rápido do estoque e cadastros.')

@section('content')
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-1">Veículos</p>
                    <h2 class="h4 fw-semibold">{{ $totalVehicles }}</h2>
                    <small class="text-success">+ Disponíveis para venda</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-1">Marcas</p>
                    <h2 class="h4 fw-semibold">{{ $totalBrands }}</h2>
                    <small class="text-muted">com estoque ativo</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-1">Modelos</p>
                    <h2 class="h4 fw-semibold">{{ $totalModels }}</h2>
                    <small class="text-muted">registrados</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-1">Cores</p>
                    <h2 class="h4 fw-semibold">{{ $totalColors }}</h2>
                    <small class="text-muted">opções disponíveis</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0">Últimos veículos cadastrados</h2>
            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Veículo</th>
                        <th>Marca/Modelo</th>
                        <th>Ano</th>
                        <th>Preço</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestVehicles as $vehicle)
                        <tr>
                            <td class="fw-semibold">{{ $vehicle->title }}</td>
                            <td>{{ $vehicle->brand->name }} / {{ $vehicle->carModel->name }}</td>
                            <td>{{ $vehicle->year }}</td>
                            <td>R$ {{ number_format($vehicle->price, 2, ',', '.') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-sm btn-outline-secondary">
                                    Gerenciar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Nenhum veículo cadastrado ainda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
