@extends('templates-admin.index')

@section('conteudo')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Listagem de Clientes</h1>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">Novo Cliente</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @php
        $formatCpf = static function ($value) {
            $digits = preg_replace('/\D/', '', (string) $value);
            if (strlen($digits) !== 11) {
                return $value;
            }

            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $digits);
        };
        $formatPhone = static function ($value) {
            $digits = preg_replace('/\D/', '', (string) $value);

            if (strlen($digits) === 11) {
                return preg_replace('/(\d{2})(\d)(\d{4})(\d{4})/', '($1) $2$3-$4', $digits);
            }
            if (strlen($digits) === 10) {
                return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $digits);
            }

            return $value;
        };
    @endphp

    @if ($clientes->isEmpty())
        <div class="alert alert-info">
            Nenhum cliente cadastrado no momento.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Data de Nascimento</th>
                        <th>Cidade</th>
                        <th>Acoes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $linha)
                        <tr>
                            <td>{{ $linha->nome }}</td>
                            <td>{{ $formatCpf($linha->cpf) }}</td>
                            <td>{{ $formatPhone($linha->telefone) }}</td>
                            <td>{{ $linha->email }}</td>
                            <td>
                                {{ optional($linha->nascimento)->format('d/m/Y') }}
                            </td>
                            <td>{{ $linha->cidade }}/{{ $linha->estado }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('clientes.edit', $linha) }}" class="btn btn-sm btn-warning mr-2">
                                    Editar
                                </a>
                                <form action="{{ route('clientes.destroy', $linha) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Deseja realmente excluir este cliente?')">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
