<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Cliente
 * 
 * Representa a los clientes de la tienda de pinturas
 */
class Cliente extends Model
{
    use HasFactory; // Trait para crear factories (datos de prueba)

    // Nombre de la tabla en la base de datos
    protected $table = 'clientes';
    
    /**
     * $fillable
     * 
     * Define qué campos se pueden asignar masivamente
     * Esto permite usar Cliente::create($datos) de forma segura
     * Previene "Mass Assignment Vulnerability"
     */
    protected $fillable = [
        'nombre',
        'nit',
        'email',
        'password_hash',
        'opt_in_promos',
        'verificado',
        'telefono',
        'direccion',
        'gps_lat',
        'gps_lng',
    ];
    
    /**
     * $hidden
     * 
     * Campos que se ocultan al convertir el modelo a array o JSON
     * Protege información sensible como contraseñas
     */
    protected $hidden = ['password_hash'];
    
    /**
     * $casts
     * 
     * Conversión automática de tipos de datos
     * - boolean: Convierte 0/1 a false/true automáticamente
     * - float: Convierte a número decimal
     * - datetime: Convierte a objeto Carbon (manipulación de fechas)
     */
    protected $casts = [
        'opt_in_promos' => 'boolean',  // 0 = false, 1 = true
        'verificado' => 'boolean',
        'gps_lat' => 'float',  // Número decimal para coordenadas
        'gps_lng' => 'float',
        'creado_en' => 'datetime',  // Carbon object para manejo de fechas
    ];
    
    /**
     * CREATED_AT y UPDATED_AT
     * 
     * Laravel por defecto usa 'created_at' y 'updated_at'
     * Pero nuestra tabla usa 'creado_en' y no tiene 'updated_at'
     */
    const CREATED_AT = 'creado_en';  // Personalizar nombre del campo
    const UPDATED_AT = null;  // Esta tabla no tiene campo updated_at

}