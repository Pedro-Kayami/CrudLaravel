<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    private $mensagem = "Olá, seja bem-vindo ao sistema!";
    public function index()
    {
        return view('clientes.index');
    }

    public function recebeDados(Request $request)
    {
        $validator = $request->validate(
            [
                'nome' => 'required|min:3|unique:clientes,nome',
                'cpf' => 'required|min:11|max:14',
            ],
            [
                'nome.required' => "O campo nome é obrigatório.",
                'nome.min' => "O campo nome deve ter pelo menos 3 caracteres.",
                'cpf.required' => "O campo CPF é obrigatório.",
                'cpf.min' => "O campo CPF deve ter pelo menos 11 caracteres.",
                'cpf.max' => "O campo CPF deve ter no máximo 14 caracteres."
            ]
        );

        echo $request->input("nome");
        echo $request->input("cpf");

        return redirect()->route("clientes")->with('success', 'Cliente cadastrado com sucesso!');
    }
}