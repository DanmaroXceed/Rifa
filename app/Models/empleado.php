<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class empleado extends Model
{
    protected $fillable = [
        'numero_emp',
        'nombre',
    ];
}
