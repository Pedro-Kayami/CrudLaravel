@extends('layouts.admin')

@section('title', 'Novo Veículo - AutoHub')
@section('page-title', 'Novo Veículo')
@section('page-description', 'Cadastre todas as informações para publicação no portal.')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.vehicles.store') }}" method="POST">
                @include('admin.vehicles.form', ['submitLabel' => 'Salvar Veículo'])
            </form>
        </div>
    </div>
@endsection
