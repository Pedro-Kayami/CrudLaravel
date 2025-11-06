@extends('layouts.admin')

@section('title', 'Editar Modelo - AutoHub')
@section('page-title', 'Editar Modelo')
@section('page-description', 'Atualize as informações do modelo selecionado.')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.models.update', $model) }}" method="POST">
                @method('PUT')
                @include('admin.models.form', ['submitLabel' => 'Atualizar Modelo'])
            </form>
        </div>
    </div>
@endsection
