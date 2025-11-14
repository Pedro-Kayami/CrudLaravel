@extends('template_admin.index')

@section("conteudo")

<h2>Cadastrar novo carro</h2>

<div class="container">

    <form method="POST" action="">
        @crsf
        <div class="row">
            <span>Marca</span>
            <input type="text" name="marca"/>
        </div>
        <div class="row">
            <span>Modelo</span>
            <input type="text" name="modelo"/>
        </div>
        <div class="row">
            <span>Cor</span>
            <input type="text" name="cor"/>
        </div>
        <div class="row">
            <span>Ano de Fabricação</span>
            <input type="text" name="ano_fabricacao"/>
        </div>
        <div class="row">
            <input type="submit" title="salvar" class="btn btn-success"/>
        </div>
    </form>

</div>

@endsection