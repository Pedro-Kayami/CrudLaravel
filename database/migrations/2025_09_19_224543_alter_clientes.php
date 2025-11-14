<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string("nome", "45");
            $table->string("cpf");
            $table->string("telefone")->default(1);
            $table->string("email");
            $table->string("sexo");
            $table->string("nascimento");
            $table->string("estadoCivil", "20");
            $table->string("endereco", "100");
            $table->string("cidade", "50");
            $table->string("estado", "50");
        });
    }

    public function down(): void
    {

    }
};
