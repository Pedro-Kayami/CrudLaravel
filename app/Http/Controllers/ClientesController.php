<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{
    public function index(): View
    {
        $clientes = Clientes::orderBy('nome')->get();

        return view('clientes.index', compact('clientes'));
    }

    public function create(): View
    {
        return view('clientes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        Clientes::create($data);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente cadastrado com sucesso.');
    }

    public function edit(Clientes $cliente): View
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Clientes $cliente): RedirectResponse
    {
        $data = $this->validateData($request, $cliente->id);

        $cliente->update($data);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy(Clientes $cliente): RedirectResponse
    {
        $cliente->delete();

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente excluido com sucesso.');
    }

    private function validateData(Request $request, ?int $clienteId = null): array
    {
        $input = $request->all();
        $input['cpf'] = isset($input['cpf']) ? preg_replace('/\D/', '', $input['cpf']) : null;
        $input['telefone'] = isset($input['telefone']) ? preg_replace('/\D/', '', $input['telefone']) : null;

        $validator = Validator::make(
            $input,
            [
                'nome' => ['required', 'string', 'max:45'],
                'cpf' => [
                    'required',
                    'digits:11',
                    Rule::unique('clientes', 'cpf')->ignore($clienteId),
                ],
                'telefone' => ['required', 'digits_between:10,11'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'sexo' => ['required', 'string', Rule::in(['Feminino', 'Masculino', 'Outro'])],
                'nascimento' => ['required', 'date'],
                'estadoCivil' => ['required', 'string', 'max:20'],
                'endereco' => ['required', 'string', 'max:100'],
                'cidade' => ['required', 'string', 'max:50'],
                'estado' => ['required', 'string', 'max:50'],
            ],
            [
                'cpf.digits' => 'Informe um CPF válido com 11 dígitos.',
                'telefone.digits_between' => 'Informe um telefone com 10 ou 11 dígitos.',
                'sexo.in' => 'Selecione um sexo válido.',
            ]
        );

        $data = $validator->validate();
        $data['nascimento'] = Carbon::parse($data['nascimento'])->format('Y-m-d');

        return $data;
    }
}
