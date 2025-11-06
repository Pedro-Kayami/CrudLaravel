@extends('templates-admin.index')

@section('conteudo')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Editar Cliente</h1>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <p class="mb-2">Por favor, corrija os erros abaixo:</p>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clientes.update', $cliente) }}" method="POST" class="card card-body shadow-sm">
        @csrf
        @method('PUT')
        @include('clientes.partials.form', ['cliente' => $cliente])
    </form>
@endsection
