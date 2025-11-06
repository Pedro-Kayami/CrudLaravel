@extends('layouts.admin')

@section('title', 'Nova Cor - AutoHub')
@section('page-title', 'Nova Cor')
@section('page-description', 'Defina um nome, código hexadecimal e acabamento.')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.colors.store') }}" method="POST">
                @include('admin.colors.form', ['submitLabel' => 'Salvar Cor'])
            </form>
        </div>
    </div>
@endsection
