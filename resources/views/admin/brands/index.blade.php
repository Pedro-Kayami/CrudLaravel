@extends('layouts.admin')

@section('title', 'Marcas - AutoHub')
@section('page-title', 'Marcas')
@section('page-description', 'Cadastre e edite as marcas disponíveis no estoque.')

@section('page-actions')
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nova Marca
    </a>
@endsection

@section('content')
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Marca</th>
                        <th>País</th>
                        <th>Site</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($brands as $brand)
                        <tr>
                            <td class="fw-semibold d-flex align-items-center gap-2">
                                @if ($brand->logo_url)
                                    <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" width="32" height="32" class="rounded">
                                @endif
                                {{ $brand->name }}
                            </td>
                            <td>{{ $brand->country ?? '—' }}</td>
                            <td>
                                @if ($brand->website)
                                    <a href="{{ $brand->website }}" target="_blank">Site oficial</a>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                    <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('Remover esta marca?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Cadastre a primeira marca para começar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $brands->links() }}
        </div>
    </div>
@endsection
