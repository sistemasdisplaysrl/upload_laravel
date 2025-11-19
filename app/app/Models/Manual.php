<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    protected $table = 'manuales';

    protected $fillable = [
        'nombre',
        'version',
        'archivo',
        'estado',
        'cargo_id'
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }
}
