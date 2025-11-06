@extends('layouts.admin')

@section('title', 'Editar Marca - AutoHub')
@section('page-title', 'Editar Marca')
@section('page-description', 'Atualize as informações da montadora selecionada.')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.brands.update', $brand) }}" method="POST">
                @method('PUT')
                @include('admin.brands.form', ['submitLabel' => 'Atualizar Marca'])
            </form>
        </div>
    </div>
@endsection
