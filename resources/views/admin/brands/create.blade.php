@extends('layouts.admin')

@section('title', 'Nova Marca - AutoHub')
@section('page-title', 'Nova Marca')
@section('page-description', 'Informe os dados principais da montadora.')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.brands.store') }}" method="POST">
                @include('admin.brands.form', ['submitLabel' => 'Salvar Marca'])
            </form>
        </div>
    </div>
@endsection
