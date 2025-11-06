<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carros;

class CarrosController extends Controller
{
    public function index()
    {
        $carros = Carros::all();
        // var_dump($carros);
        echo "Chegou no Controller Carros";
        return view('carros.index',
                compact('carros'));
    }
}