<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Proveedor
 * 
 * Representa a los proveedores que suministran productos a la tienda.
 * Se utiliza para el módulo de compras y órdenes de compra.
 */
class Proveedor extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'proveedores';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'razon_social',
        'nit',
        'telefono',
        'email',
        'direccion',
        'contacto_principal',
        'activo',
    ];

    // Conversión de tipos de datos
    protected $casts = [
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // RELACIONES

    /**
     * Un proveedor puede tener muchas órdenes de compra
     */
    public function ordenesCompra()
    {
        return $this->hasMany(OrdenCompra::class, 'proveedor_id');
    }

    // SCOPES (filtros reutilizables)

    /**
     * Scope para obtener solo proveedores activos
     * Uso: Proveedor::activos()->get()
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para obtener solo proveedores inactivos
     * Uso: Proveedor::inactivos()->get()
     */
    public function scopeInactivos($query)
    {
        return $query->where('activo', false);
    }

    // MÉTODOS AUXILIARES

    /**
     * Verifica si el proveedor está activo
     */
    public function estaActivo()
    {
        return $this->activo === true;
    }
}