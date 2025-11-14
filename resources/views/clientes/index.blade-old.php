@extends("templates-admin.index")

@section("conteudo")
<h2>Cadastro de Pessoa</h2>
    @if (session('success'))
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      @foreach ($errors->all() as $erro)
        <div class="alert alert-danger" role="alert">A simple danger alert—check it out!
          {{ $erro }}
        </div>
      @endforeach
    @endif

    <form method="post" action="{{ route('cliente.novo') }}">
        @csrf
        <div class="col">
            <div class="row">

                <div class="col-6">
                    <label for="nome" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite seu nome"
                    value="{{ old('nome') }}">
                </div>

                <div class="col">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite seu CPF" value="{{ old('cpf') }}">
                </div>

                <div class="col">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Digite seu telefone">
                </div>
            </div>
       </div>

       <div class="col">
        <div class="row">
            <div class="col-4">
                <label for="email" class="form-label">E-mail</label>
                <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail">
                </div>
            </div>
        </div>
        </div>

      <div class="mb-3">
        <label for="sexo" class="form-label">Sexo</label>
        <select class="form-select" id="sexo" name="sexo">
          <option selected disabled>Selecione</option>
          <option value="masculino">Masculino</option>
          <option value="feminino">Feminino</option>
          <option value="outro">Outro</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="nascimento" class="form-label">Data de Nascimento</label>
        <input type="date" class="form-control" id="nascimento" name="nascimento">
      </div>

      <div class="mb-3">
        <label for="estadoCivil" class="form-label">Estado Civil</label>
        <select class="form-select" id="estadoCivil" name="estadoCivil">
          <option selected disabled>Selecione</option>
          <option>Solteiro(a)</option>
          <option>Casado(a)</option>
          <option>Divorciado(a)</option>
          <option>Viúvo(a)</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="endereco" class="form-label">Endereço</label>
        <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Rua, número, bairro">
      </div>

      <div class="mb-3">
        <label for="cidade" class="form-label">Cidade</label>
        <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Digite sua cidade">
      </div>

      <div class="mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select class="form-select" id="estado" name="estado">
          <option selected disabled>Selecione</option>
          <option>AC</option>
          <option>AL</option>
          <option>AP</option>
          <option>AM</option>
          <option>BA</option>
          <option>CE</option>
          <option>DF</option>
          <option>ES</option>
          <option>GO</option>
          <option>MA</option>
          <option>MT</option>
          <option>MS</option>
          <option>MG</option>
          <option>PA</option>
          <option>PB</option>
          <option>PR</option>
          <option>PE</option>
          <option>PI</option>
          <option>RJ</option>
          <option>RN</option>
          <option>RS</option>
          <option>RO</option>
          <option>RR</option>
          <option>SC</option>
          <option>SP</option>
          <option>SE</option>
          <option>TO</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

@endSection