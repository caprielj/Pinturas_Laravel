<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo MedioPago
 * 
 * Representa los medios de pago aceptados en la tienda.
 * 
 * Tipos de pago disponibles:
 * - Efectivo
 * - Tarjeta de Crédito
 * - Tarjeta de Débito
 * - Transferencia Bancaria
 * - Cheque
 */
class MedioPago extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'mediospago';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'activo',
    ];

    // Conversión de tipos de datos
    protected $casts = [
        'activo' => 'boolean',
    ];

    // Esta tabla no tiene timestamps
    public $timestamps = false;

    // RELACIONES

    /**
     * Un medio de pago puede estar en muchos pagos
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'medio_pago_id');
    }

    // SCOPES

    /**
     * Scope para obtener solo medios de pago activos
     * Uso: MedioPago::activos()->get()
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // MÉTODOS AUXILIARES

    /**
     * Verifica si el medio de pago está activo
     */
    public function estaActivo()
    {
        return $this->activo === true;
    }
}