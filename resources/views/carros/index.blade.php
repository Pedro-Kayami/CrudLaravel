@extends('templates-admin.index')

@section('conteudo')

    <h1>Listagem de Carros</h1>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <td>Marca</td>
                <td>Modelo</td>
                <td>Cor</td>
                <td>Ano</td>
                <td>Opções</td>
            </tr>
        </thead>

    <tbody>

    @foreach($carros as $linha)
            <tr>
                <td>{{$linha->marca}}</td>
                <td>{{$linha->modelo}}</td>
                <td>{{$linha->cor}}</td>
                <td>{{$linha->ano_fabricacao}}</td>
            </tr>

    @endforeach
    </table>
    </tbody>

@endsection