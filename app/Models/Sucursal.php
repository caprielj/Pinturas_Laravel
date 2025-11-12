<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Representa las sucursales/tiendas del negocio
class Sucursal extends Model
{
    use HasFactory;

    // protected: Accesible solo dentro de la clase y clases heredadas
    // $table: Nombre de la tabla en la base de datos
    protected $table = 'sucursales';

    // protected: Control de seguridad para asignación masiva
    // $fillable: Campos permitidos al crear/actualizar con arrays
    // Ejemplo: Sucursal::create($request->all())
    protected $fillable = [
        'nombre',      // Nombre de la sucursal
        'direccion',   // Dirección física
        'gps_lat',     // Latitud GPS (coordenadas)
        'gps_lng',     // Longitud GPS (coordenadas)
        'telefono',    // Número de contacto
        'activa',      // Si la sucursal está operando
    ];

    // protected: Conversiones automáticas al leer/guardar datos
    // $casts: Transforma tipos de datos entre BD y PHP
    protected $casts = [
        'gps_lat' => 'float',    // Convierte a número decimal
        'gps_lng' => 'float',    // Convierte a número decimal
        'activa' => 'boolean',   // Convierte 0/1 a false/true
    ];

    // public: Accesible desde cualquier lugar
    // $timestamps: Desactiva created_at y updated_at automáticos
    public $timestamps = false;
}