<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Representa los proveedores que suministran productos al negocio
class Proveedor extends Model
{
    use HasFactory;

    // protected: Propiedad accesible dentro de la clase y sus hijos (herencia)
    // $table: Especifica el nombre de la tabla en la base de datos
    protected $table = 'proveedores';

    // protected: Solo esta clase puede modificar estos campos internamente
    // $fillable: Lista blanca de campos permitidos para asignación masiva
    // Ejemplo: Proveedor::create($request->all())
    protected $fillable = [
        'nombre',              // Nombre comercial del proveedor
        'razon_social',        // Razón social legal
        'nit',                 // NIT o identificación fiscal
        'telefono',            // Número de contacto
        'email',               // Correo electrónico
        'direccion',           // Dirección física
        'contacto_principal',  // Nombre de persona de contacto
        'activo',              // Si el proveedor está habilitado
    ];

    // protected: Estas conversiones se aplican automáticamente al leer/escribir
    // $casts: Define transformaciones de tipos de datos
    // Convierte 0/1 de BD a false/true en PHP automáticamente
    protected $casts = [
        'activo' => 'boolean',
    ];
}