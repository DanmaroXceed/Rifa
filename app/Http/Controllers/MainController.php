<?php

namespace App\Http\Controllers;

use App\Models\empleado;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        $empleados = empleado::select('numero_emp', 'nombre')->get();
        return view('rifa',  compact('empleados'));
    }
}
