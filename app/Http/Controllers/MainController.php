<?php

namespace App\Http\Controllers;

use App\Models\empleado;
use App\Models\premio;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        $empleados = empleado::select('numero_emp', 'nombre', 'area')->get();
        $premios = premio::select('numero_premio', 'premio', 'pm')->where('pm','<>', 1)->get();
        $premiosMayores = premio::select('numero_premio', 'premio', 'pm')->where('pm','=', 1)->get();
        return view('rifa',  compact('empleados', 'premios', 'premiosMayores'));
    }
}
