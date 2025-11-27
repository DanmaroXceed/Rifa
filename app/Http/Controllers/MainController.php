<?php

namespace App\Http\Controllers;

use App\Models\empleado;
use App\Models\premio;
use App\Models\resultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Artisan;

class MainController extends Controller
{
    public function menu()
    {
        // \Log::info('Sesión actual:', session()->all());
        $isRaffleStarted = resultado::count() > 0;
        return view('menu', ['isRaffleStarted' => $isRaffleStarted]);
    }

    public function index(){
        $empleados = empleado::orderBy('nombre')->get();

        // Obtener los números de premio que ya han sido asignados
        $premiosAsignados = resultado::pluck('n_premio')->toArray();

        // Obtener solo los premios que no han sido asignados
        $premiosDisponibles = premio::whereNotIn('numero_premio', $premiosAsignados)->get();
        
        $premios = $premiosDisponibles->where('pm', '<>', 1);
        $premiosMayores = $premiosDisponibles->where('pm', '=', 1);

        // Obtener los ganadores para la persistencia
        $ganadores = resultado::all();

        return view('rifa',  compact('empleados', 'premios', 'premiosMayores', 'ganadores'));
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

    public function admin()
    {
        return view('admin');
    }

    public function uploadEmpleados(Request $request)
    {
        $request->validate([
            'empleados_csv' => 'required|file|mimes:csv,txt',
        ]);

        try {
            empleado::truncate();

            $path = $request->file('empleados_csv')->getRealPath();
            $file = fopen($path, 'r');
            
            fgetcsv($file);

            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                if (count($data) != 3) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'status' => 'El archivo de empleados tiene un formato incorrecto.']);
                }
                empleado::create([
                    'numero_emp' => $data[0],
                    'nombre' => $data[1],
                    'area' => $data[2],
                ]);
            }
            fclose($file);

            return response()->json(['success' => true, 'status' => '¡Empleados cargados con éxito!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'status' => 'Error al cargar el archivo de empleados: ' . $e->getMessage()]);
        }
    }

    public function uploadPremios(Request $request)
    {
        $request->validate([
            'prizes_csv' => 'required|file|mimes:csv,txt',
        ]);

        try {
            premio::truncate();

            $path = $request->file('prizes_csv')->getRealPath();
            $file = fopen($path, 'r');

            fgetcsv($file);

            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                if (count($data) != 4) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'status' => 'El archivo de premios tiene un formato incorrecto.']);
                }
                premio::create([
                    'numero_premio' => $data[0],
                    'premio' => $data[1],
                    'pm' => (bool)$data[2],
                    'pdi' => (bool)$data[3],
                ]);
            }
            fclose($file);

            return response()->json(['success' => true, 'status' => '¡Premios cargados con éxito!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'status' => 'Error al cargar el archivo de premios: ' . $e->getMessage()]);
        }
    }

    public function resetSystem()
    {
        try {
            Artisan::call('migrate:fresh', ['--seed' => true]);
            return response()->json(['success' => true, 'status' => '¡Sistema reiniciado con éxito!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'status' => 'Error al reiniciar el sistema: ' . $e->getMessage()]);
        }
    }
}
