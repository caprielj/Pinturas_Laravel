<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Marca
 * 
 * Representa las marcas de productos disponibles.
 * 
 * Ejemplos:
 * - Sherwin Williams
 * - Comex
 * - Berel
 * - Pintuco
 */
class Marca extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'marcas';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'activa',
    ];

    // Conversión de tipos de datos
    protected $casts = [
        'activa' => 'boolean',
    ];

    // Esta tabla no tiene timestamps
    public $timestamps = false;

    // RELACIONES

    /**
     * Una marca puede tener muchos productos
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'marca_id');
    }

    // SCOPES

    /**
     * Scope para obtener solo marcas activas
     * Uso: Marca::activas()->get()
     */
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    // MÉTODOS AUXILIARES

    /**
     * Verifica si la marca está activa
     */
    public function estaActiva()
    {
        return $this->activa === true;
    }

    /**
     * Cuenta cuántos productos tiene esta marca
     */
    public function cantidadProductos()
    {
        return $this->productos()->count();
    }
}