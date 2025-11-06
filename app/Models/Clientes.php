<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'email',
        'sexo',
        'nascimento',
        'estadoCivil',
        'endereco',
        'cidade',
        'estado',
    ];

    protected $casts = [
        'nascimento' => 'date',
    ];
}
