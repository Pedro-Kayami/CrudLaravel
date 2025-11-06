@extends('layouts.admin')

@section('title', 'Editar Cor - AutoHub')
@section('page-title', 'Editar Cor')
@section('page-description', 'Atualize a cor selecionada.')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.colors.update', $color) }}" method="POST">
                @method('PUT')
                @include('admin.colors.form', ['submitLabel' => 'Atualizar Cor'])
            </form>
        </div>
    </div>
@endsection
