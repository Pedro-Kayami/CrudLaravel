@extends('layouts.admin')

@section('title', 'Cores - AutoHub')
@section('page-title', 'Cores')
@section('page-description', 'Cadastre as opções de cor utilizadas nos veículos.')

@section('page-actions')
    <a href="{{ route('admin.colors.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nova Cor
    </a>
@endsection

@section('content')
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Visual</th>
                        <th>Nome</th>
                        <th>Hex</th>
                        <th>Metálica</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($colors as $color)
                        <tr>
                            <td>
                                <span class="d-inline-block border rounded-circle" style="width:32px;height:32px;background-color: {{ $color->hex_code ?? '#f8f9fa' }}"></span>
                            </td>
                            <td class="fw-semibold">{{ $color->name }}</td>
                            <td>{{ $color->hex_code ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $color->is_metallic ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $color->is_metallic ? 'Sim' : 'Não' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.colors.edit', $color) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                    <form action="{{ route('admin.colors.destroy', $color) }}" method="POST" onsubmit="return confirm('Excluir esta cor?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Nenhuma cor cadastrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $colors->links() }}
        </div>
    </div>
@endsection
