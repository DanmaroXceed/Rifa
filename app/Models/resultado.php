<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class resultado extends Model
{
    protected $table = 'resultados';

    // Atributos que se pueden asignar de forma masiva
    protected $fillable = [
        'numero_emp',
        'nombre',
        'area',
        'n_premio',
        'premio',
    ];
}
