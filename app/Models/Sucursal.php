<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Sucursal
 * 
 * Representa las diferentes sucursales de la cadena de pinturas "Paints".
 * Cada sucursal tiene su propio inventario y puede estar en diferentes ubicaciones.
 * 
 * Sucursales:
 * - Pradera Chimaltenango
 * - Pradera Escuintla
 * - Las Américas en Mazatenango
 * - La Trinidad en Coatepeque
 * - Pradera Xela en Quetzaltenango
 * - Centro Comercial Miraflores en Ciudad de Guatemala
 */
class Sucursal extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'sucursales';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'direccion',
        'gps_lat',
        'gps_lng',
        'telefono',
        'activa',
    ];

    // Conversión de tipos de datos
    protected $casts = [
        'gps_lat' => 'float',
        'gps_lng' => 'float',
        'activa' => 'boolean',
    ];

    // Laravel por defecto no tiene timestamps en esta tabla
    public $timestamps = false;

    // RELACIONES

    /**
     * Una sucursal puede tener muchos usuarios asignados
     */
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'sucursal_id');
    }

    /**
     * Una sucursal puede tener muchas facturas
     */
    public function facturas()
    {
        return $this->hasMany(Factura::class, 'sucursal_id');
    }

    /**
     * Una sucursal puede tener muchos registros de inventario
     */
    public function inventarios()
    {
        return $this->hasMany(InventarioSucursal::class, 'sucursal_id');
    }

    /**
     * Una sucursal puede tener muchas cotizaciones
     */
    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class, 'sucursal_id');
    }

    /**
     * Una sucursal puede tener muchas órdenes de compra
     */
    public function ordenesCompra()
    {
        return $this->hasMany(OrdenCompra::class, 'sucursal_id');
    }

    // SCOPES

    /**
     * Scope para obtener solo sucursales activas
     * Uso: Sucursal::activas()->get()
     */
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    // MÉTODOS AUXILIARES

    /**
     * Verifica si la sucursal está activa
     */
    public function estaActiva()
    {
        return $this->activa === true;
    }

    /**
     * Obtiene las coordenadas GPS como array
     * Útil para mostrar en mapas
     */
    public function getCoordenadas()
    {
        if ($this->gps_lat && $this->gps_lng) {
            return [
                'lat' => $this->gps_lat,
                'lng' => $this->gps_lng,
            ];
        }
        return null;
    }
}