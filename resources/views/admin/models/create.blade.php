@extends('layouts.admin')

@section('title', 'Novo Modelo - AutoHub')
@section('page-title', 'Novo Modelo')
@section('page-description', 'Associe o modelo a uma marca e defina seus detalhes.')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.models.store') }}" method="POST">
                @include('admin.models.form', ['submitLabel' => 'Salvar Modelo'])
            </form>
        </div>
    </div>
@endsection
