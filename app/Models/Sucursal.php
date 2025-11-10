<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales';

    protected $fillable = [
        'nombre',
        'direccion',
        'gps_lat',
        'gps_lng',
        'telefono',
        'activa',
    ];

    protected $casts = [
        'gps_lat' => 'float',
        'gps_lng' => 'float',
        'activa' => 'boolean',
    ];

    public $timestamps = false;
}