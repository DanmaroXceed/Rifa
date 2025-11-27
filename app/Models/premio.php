<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class premio extends Model
{
    protected $fillable = [
        'numero_premio',
        'premio',
        'pm',
        'pdi'
    ];
}
