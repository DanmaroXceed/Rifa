<?php

namespace App\Http\Controllers;

use App\Models\empleado;
use App\Models\premio;
use App\Models\resultado;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        $empleados = empleado::select('numero_emp', 'nombre', 'area')->get();
        $premios = premio::select('numero_premio', 'premio', 'pm', 'pdi')->where('pm','<>', 1)->get();
        $premiosMayores = premio::select('numero_premio', 'premio', 'pm', 'pdi')->where('pm','=', 1)->get();
        return view('rifa',  compact('empleados', 'premios', 'premiosMayores'));
    }

    public function store(Request $request)
    {
        // Valida los datos
        $validated = $request->validate([
            'numero_emp' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'n_premio' => 'required|string|max:255',
            'premio' => 'required|string|max:255',
        ]);

        // Crea el registro en la tabla "resultados"
        $resultado = resultado::create($validated);

        // Devuelve una respuesta de éxito
        return response()->json([
            'success' => true,
            'data' => $resultado,
        ]);
    }
}
