@extends('layouts.admin')

@section('title', 'Editar Veículo - AutoHub')
@section('page-title', 'Editar Veículo')
@section('page-description', 'Atualize os dados e as imagens do veículo selecionado.')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.vehicles.update', $vehicle) }}" method="POST">
                @method('PUT')
                @include('admin.vehicles.form', ['submitLabel' => 'Atualizar Veículo'])
            </form>
        </div>
    </div>
@endsection
