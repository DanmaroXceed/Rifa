<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ganador extends Model
{
    protected $fillable = [
        'numero_emp',
        'nombre',
        'area',
        'n_premio',
        'premio',
    ];
}
