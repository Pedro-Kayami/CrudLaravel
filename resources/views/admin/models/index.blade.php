@extends('layouts.admin')

@section('title', 'Modelos - AutoHub')
@section('page-title', 'Modelos')
@section('page-description', 'Organize os modelos de cada marca.')

@section('page-actions')
    <a href="{{ route('admin.models.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Novo Modelo
    </a>
@endsection

@section('content')
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Segmento</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($models as $model)
                        <tr>
                            <td class="fw-semibold">{{ $model->name }}</td>
                            <td>{{ $model->brand->name }}</td>
                            <td>{{ $model->segment ?? '—' }}</td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.models.edit', $model) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                    <form action="{{ route('admin.models.destroy', $model) }}" method="POST" onsubmit="return confirm('Deseja excluir este modelo?');">
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
                                Nenhum modelo registrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $models->links() }}
        </div>
    </div>
@endsection
